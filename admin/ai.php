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
- 说明: 编写 SQL 语句对数据库中的任何表进行操作。
- 核心表结构及常用表说明：
  - `emlog_blog` (文章/页面表): `gid` (文章ID), `title` (标题), `date` (时间戳), `content` (内容), `excerpt` (摘要), `cover` (封面图), `alias` (别名), `author` (作者UID，通常为 1), `sortid` (分类ID，默认为 -1), `type` (文章OR页面: 'blog'/'page'), `views` (点击数), `comnum` (评论数), `like_count` (点赞数), `dislike_count` (点踩数), `collect_count` (收藏数), `top` (置顶 'n'/'y'), `sortop` (分类置顶 'n'/'y'), `hide` (草稿/隐藏 'n'/'y'), `checked` (已审核 'n'/'y'), `allow_remark` (允许评论 'n'/'y'), `password` (密码), `template` (模板), `tags` (标签), `link` (外部链接), `parent_id` (父级文章ID)
  - `emlog_comment` (评论表): `cid` (评论ID), `gid` (对应文章ID), `pid` (父评论ID), `top` (置顶 'n'/'y'), `poster` (昵称), `avatar` (头像URL), `uid` (发布人UID，游客为 0), `comment` (内容), `mail` (邮箱), `url` (主页网址), `ip` (IP), `agent` (UserAgent), `hide` (是否审核/隐藏 'n'/'y'), `like_count` (点赞数), `date` (发布时间戳)
  - `emlog_options` (站点配置表): `option_id` (主键), `option_name` (配置项名), `option_value` (配置项值)。常用 `option_name` 如 `blogname` (站点名称), `bloginfo` (站点副标题), `blogurl` (站点地址), `footer_info` (底部版权信息), `icp` (备案号), `active_plugins` (启用的插件序列化串), `widgets1` (启用的侧边栏组件序列化串)
  - `emlog_user` (用户表): `uid` (用户ID), `username` (登录账号), `password` (密码hash), `nickname` (昵称), `role` (角色 admin/writer/member), `ischeck` (投稿免审核 'n'/'y'), `photo` (头像), `email` (邮箱), `description` (简介), `ip` (注册或最后登录IP), `state` (状态 0正常 1禁用), `credits` (积分), `create_time` (创建时间戳), `update_time` (更新时间戳)
  - `emlog_sort` (文章分类表): `sid` (分类ID), `sortname` (分类名), `alias` (别名), `taxis` (排序号), `pid` (父分类ID), `description` (分类备注), `kw` (分类SEO关键词), `title` (分类页面SEO标题), `template` (分类模板名), `sortimg` (分类图片), `page_count` (每页文章数), `allow_user_post` (接受用户投稿 'y'/'n')
  - `emlog_link` (友情链接表): `id` (链接ID), `sitename` (链接名称), `siteurl` (链接地址), `icon` (图标URL), `description` (链接描述), `hide` (是否隐藏 'n'/'y'), `taxis` (排序号)
  - `emlog_twitter` (微语笔记表): `id` (微语ID), `content` (微语内容), `img` (图片URL), `author` (作者UID，通常为 1), `date` (创建时间戳), `replynum` (回复数), `like_count` (点赞数), `private` (是否私密 'y'/'n'), `top` (是否置顶 'y'/'n'), `ip` (发布者IP)
  - `emlog_attachment` (资源文件/附件表): `aid` (资源ID), `alias` (别名), `author` (上传者UID), `sortid` (附件分类ID), `filename` (文件名), `filesize` (大小字节), `filepath` (路径), `addtime` (时间戳), `width` (宽), `height` (高), `mimetype` (MIME类型), `download_count` (下载次数)
  - `emlog_navi` (导航表): `id` (导航ID), `naviname` (导航名), `url` (跳转地址), `newtab` (新窗口打开 'n'/'y'), `hide` (隐藏 'n'/'y'), `taxis` (排序), `pid` (父ID), `isdefault` (默认 'n'/'y'), `type` (类型: 0自定义 1首页 2微语 3后台 4分类 5页面), `type_id` (关联ID)
  - `emlog_tag` (文章标签表): `tid` (标签ID), `tagname` (标签名), `title` (SEO标题), `kw` (SEO关键词), `description` (SEO描述), `gid` (关联文章ID列表，以半角逗号前后包围的字符串，如 `,1,2,`)
  - `emlog_reply` (微语回复表): `id` (回复ID), `uid` (回复人UID), `tid` (对应微语ID), `date` (回复时间戳), `name` (回复人昵称), `content` (回复内容), `hide` (隐藏 'y'/'n'), `islike` (点赞 'y'/'n'), `ip` (IP)
  - `emlog_like` (点赞记录表): `id` (记录ID), `gid` (文章ID), `vote_type` (类型 'like'/'dislike'/'collect'), `poster` (游客昵称), `avatar` (头像URL), `uid` (用户UID), `ip` (IP), `agent` (UserAgent), `date` (时间戳)
  注意：在编写 SQL时，可以直接使用没有前缀的表名（如 blog, user, comment, options, link, sort, twitter, attachment, navi, tag, reply, like），后端会自动为您替换为带真实前缀的表名（如 emlog_blog）。
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
