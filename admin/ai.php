<?php

/**
 * media
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action == 'chat') {
    $message = Input::postStrVar('message');
    $r = Ai::chat($message, '你是一个有用的助手', true);
    Output::ok($r);
}

if ($action == 'get_history') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $history = isset($_SESSION['ai_chat_history']) && is_array($_SESSION['ai_chat_history']) ? $_SESSION['ai_chat_history'] : [];
    Output::ok($history);
}

if ($action == 'clear_history') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['ai_chat_history'] = [];
    Output::ok();
}

if ($action == 'chat_stream') {
    $message = Input::getStrVar('message');

    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');

    $blogname = Option::get('blogname');
    $bloginfo = Option::get('bloginfo');

    $system_prompt = "你是一个专业的 Emlog 博客助手。你不仅能回答用户的问题，还可以通过输出特定的 `<tool_call>` XML 标签来操作博客数据库的所有表，包含读取、删除、插入及修改数据。
当用户让你查询、修改、更新、插入或删除数据库数据时（例如：查询最近最受欢迎文章、把某个系统配置修改、添加一个友情链接、删除某个评论等），请在生成给用户的友好回复后，使用特定的工具标签来触发操作。
注意：
1. 所有的 `<tool_call>` 标记必须包含 `name` 属性，内部是一个标准的 JSON 字符串。
2. 必须且只能在完成给用户的回答后输出工具标签。一次对话中只能输出一个工具标签。
3. 参数中的字符串请注意不要包含截断 JSON 语法的特殊字符，尽量写出正确的 JSON，尤其是双引号。
4. 在构建写操作（如 INSERT）的 SQL 语句时，请务必注意目标表结构的必填字段（没有默认值且不允许为 NULL 的字段，例如 description 字段）。你在构建 SQL 语句时，必须显式为此类字段赋予合适的值或默认空值（如空字符串），或者先通过只读操作（如执行 DESCRIBE 表名）查询该表的详细字段信息后再构建 SQL，以避免出现类似 Field 'xxx' doesn't have a default value 的执行错误。

当前博客的状态信息：
- 博客名称: $blogname
- 博客副标题: $bloginfo

可用工具列表：

1. 执行数据库查询、插入、修改或删除操作
- 工具名称: query_database
- 说明: 编写 SQL 语句对数据库中的任何表进行操作。你拥有对所有数据库表的完全操作权限。只读查询操作（如 SELECT, SHOW, DESCRIBE）会直接执行并输出；凡是涉及到数据或表结构变更的操作（如 INSERT, UPDATE, DELETE, TRUNCATE, ALTER 等写操作）均需要用户二次输入“确定操作”进行确认，执行成功后会自动刷新缓存。
- 核心表结构及常用表说明：
  - `emlog_blog` (文章/页面表): `gid` (ID), `title` (标题), `content` (内容), `views` (点击数), `comnum` (评论数), `hide` (是否草稿 'y'/'n'), `type` (类型 'blog'/'page'), `author` (作者ID，通常为 1), `date` (发布时间戳，请使用 UNIX_TIMESTAMP()), `excerpt` (摘要，如设为空字符串 ''), `alias` (别名，如设为空字符串 '')
  - `emlog_comment` (评论表): `cid` (评论ID), `gid` (文章ID), `poster` (评论人), `comment` (评论内容), `hide` (是否审核 'y'/'n')
  - `emlog_options` (配置表): `option_name` (配置项名), `option_value` (配置项值)
  - `emlog_user` (用户表): `uid` (用户ID), `username` (账号), `nickname` (昵称), `role` (角色 admin/member/writer)
  - `emlog_sort` (分类表): `sid` (分类ID), `sortname` (分类名称)
  - `emlog_link` (友情链接表): `id`, `linkname` (链接名), `siteurl` (网址)
  注意：在编写 SQL时，可以直接使用没有前缀的表名（如 blog, user, comment, options），后端会自动为您替换为带真实前缀的表名（如 emlog_blog）。
- 参数格式 (JSON):
  {
    \"sql\": \"标准的 SQL 语句。示例 1 (查询): SELECT nickname FROM user WHERE role='admin'。示例 2 (更新配置): UPDATE options SET option_value='新的站点标题' WHERE option_name='blogname'。示例 3 (删除友情链接): DELETE FROM link WHERE id=2\"
  }
- 示例：`<tool_call name=\"query_database\">{\"sql\":\"UPDATE options SET option_value='新站点名称' WHERE option_name='blogname'\"}</tool_call>`";

    Ai::chatStream($message, $system_prompt, true);
    exit;
}

if ($action == 'execute_tool') {
    // 权限校验：只允许管理员或有权限的用户执行博客操作
    if (!User::haveEditPermission()) {
        Output::error('权限不足');
    }

    $toolName = Input::postStrVar('name');
    $paramsJson = isset($_POST['params']) ? $_POST['params'] : '{}';
    $params = json_decode($paramsJson, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        Output::error('参数解析失败: ' . json_last_error_msg());
    }

    switch ($toolName) {
        case 'query_database':
            try {
                $sql = isset($params['sql']) ? $params['sql'] : '';
                $confirm_code = isset($_POST['confirm_code']) ? $_POST['confirm_code'] : '';
                if (empty($sql)) {
                    throw new Exception('SQL语句不能为空');
                }

                $result = Ai::queryDatabase($sql, $confirm_code);

                Output::ok([
                    'results' => $result
                ]);
            } catch (Exception $e) {
                Output::error($e->getMessage());
            }
            break;

        default:
            Output::error('未知工具命令');
            break;
    }
}

if ($action == 'genBio') {
    $prompt = '从名言、歌词、电影台词、小说、诗词、名人名言中找出一句话，作为你的个性签名，避免输出引号、冒号等任何提示性内容。';
    $r = Ai::chat($prompt);
    Output::ok($r);
}

if ($action == 'genReply') {
    $comment = Input::postStrVar('comment');
    $prompt = $comment . '。=== 请礼貌而专业的回复 === 前面这段用户评论，避免输出任何提示性内容。';
    $r = Ai::chat($prompt);
    Output::ok($r);
}

/**
 * AI图像生成功能
 * 生成图像并保存到媒体库（兼容云存储插件）
 */
if ($action == 'generate_image') {
    $prompt = Input::postStrVar('prompt');
    $size = Input::postStrVar('size', '1024x1024');
    $quality = Input::postStrVar('quality', 'standard');

    // 调用封装的AI图像生成和保存方法
    $options = array(
        'size' => $size,
        'quality' => $quality
    );

    $result = Ai::generateImageAndSave($prompt, $options);

    // 检查结果并返回
    if (isset($result['error'])) {
        Output::error($result['error']);
    }

    Output::ok($result);
}
