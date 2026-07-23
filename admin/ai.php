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

    $chatModelInfo = Ai::getCurrentModelInfo();
    if (!$chatModelInfo) {
        $data = json_encode([
            'need_config' => true,
            'message' => '未配置文本对话模型，请先前往 [系统->AI] 页面配置文本对话模型。'
        ]);
        echo "data: {$data}\n\n";
        echo "data: [DONE]\n\n";
        exit;
    }

    $blogname = Option::get('blogname');
    $bloginfo = Option::get('bloginfo');

    $system_prompt = "你是一个专业的 Emlog 博客助手。你不仅能回答用户的问题，还可以通过输出特定的 `<tool_call>` XML 标签来操作博客数据库或修改系统配置文件 config.php。
当用户让你查询、修改、更新、插入或删除数据库数据，或者让你调整系统安全、性能、环境、上传大小及路径等 config.php 配置时，请在生成给用户的友好回复后，使用特定的工具标签来触发操作。
注意：
1. 所有的 `<tool_call>` 标记必须包含 `name` 属性，内部是一个标准的 JSON 字符串。
2. 必须且只能在完成给用户的回答后输出工具标签。一次对话中只能输出一个工具标签。
3. 参数中的字符串请注意不要包含截断 JSON 语法的特殊字符，尽量写出正确的 JSON，尤其是双引号。
4. 在构建写操作（如 INSERT）的 SQL 语句时，请务必注意目标表结构的必填字段（没有默认值且不允许为 NULL 的字段，例如 description 字段）。你在构建 SQL 语句时，必须显式为此类字段赋予合适的值或默认空值（如空字符串），或者先通过只读操作（如执行 DESCRIBE 表名）查询该表的详细字段信息后再构建 SQL，以避免出现类似 Field 'xxx' doesn't have a default value 的执行错误。
5. 禁止直接通过 SQL 语句（即 `query_database` 工具）写入、修改或删除文章表 `emlog_blog`（或 `blog`）。如果需要发表文章、撰写博客等写文章操作，请务必使用 `write_article` 专用工具。

当前博客的状态信息：
- 博客名称: $blogname
- 博客副标题: $bloginfo

可用工具列表：

1. 执行数据库查询、插入、修改或删除操作
- 工具名称: query_database
- 说明: 编写 SQL 语句对数据库中的任何表进行操作。
- 核心表结构及常用表说明：
  - `emlog_blog` (文章/页面表): `gid` (文章ID), `title` (标题), `date` (时间戳), `content` (内容), `excerpt` (摘要), `cover` (封面图), `alias` (别名), `author` (作者UID，通常为 1), `sortid` (分类ID，默认为 -1), `type` (文章OR页面: 'blog'/'page'), `views` (点击数), `comnum` (评论数), `like_count` (点赞数), `dislike_count` (点踩数), `collect_count` (收藏数), `top` (置顶 'n'/'y'), `sortop` (分类置顶 'n'/'y'), `hide` (草稿/隐藏 'n'/'y'), `checked` (已审核 'n'/'y'), `allow_remark` (允许评论 'n'/'y'), `password` (密码), `template` (模板), `tags` (逗号分隔的标签ID，如：1,2,3), `link` (外部链接), `parent_id` (父级文章ID)
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
  注意：在编写 SQL时，可以直接使用没有前缀的表名（如 blog, user, comment, options, link, sort, twitter, attachment, navi, tag, reply, like），后端会自动为您替换为带真实前缀 of表名（如 emlog_blog）。
  注意：禁止对 `emlog_blog` (或 `blog`) 执行任何 non-SELECT 写操作 SQL，若需发表文章请使用 write_article 工具。
- 参数格式 (JSON):
  {
    \"sql\": \"标准的 SQL 语句。\"
  }
- 示例：`<tool_call name=\"query_database\">{\"sql\":\"UPDATE options SET option_value='新站点名称' WHERE option_name='blogname'\"}</tool_call>`

2. 增加、删除、修改特定系统配置文件 (config.php)
- 工具名称: update_config
- 说明: 只能增加、删除、修改特定的配置项目，这些配置项目包括：
  - `ENVIRONMENT`: 开启开发者模式。通常值为 'develop'。
  - `EMLOG_LANG`: 切换系统语言。简体中文为 'zh_CN'，英文为 'en_US'。
- 参数格式 (JSON):
  {
    \"key\": \"配置常量键名（必须是上述列表之一）\",
    \"action\": \"操作类型：add (新增)、update (修改) 或 delete (删除)\",
    \"value\": \"新增或修改时的配置值，布尔、整数或字符串类型\"
  }
- 示例 1 (隐藏后台登录页面): `<tool_call name=\"update_config\">{\"key\":\"ADMIN_PATH_CODE\", \"action\":\"add\", \"value\":\"myadminpath123\"}</tool_call>`
- 示例 2 (关闭自动保存): `<tool_call name=\"update_config\">{\"key\":\"ARTICLE_AUTOSAVE_OFF\", \"action\":\"add\", \"value\":true}</tool_call>`
- 示例 3 (删除自动保存配置以恢复默认): `<tool_call name=\"update_config\">{\"key\":\"ARTICLE_AUTOSAVE_OFF\", \"action\":\"delete\"}</tool_call>`

3. 写文章、发布文章或更新修改已存在文章的操作
- 工具名称: write_article
- 说明: 当用户需要发表新文章或修改/更新已有文章（如设置/更新文章封面图、修改标题或内容等）时，必须使用此专用工具（禁止使用 query_database 直接 UPDATE/INSERT/DELETE 文章表 emlog_blog）。
- 参数格式 (JSON):
  {
    \"gid\": 文章ID（可选，整数。如果传入了 gid，则表示【更新修改已有文章】；不传或为0表示【新建发表新文章】）,
    \"title\": \"文章标题（新建时必填；更新时可选，不填则保持原标题）\",
    \"content\": \"文章内容（新建时必填；更新时可选，不填则保持原内容，可包含 HTML/Markdown 图片标签）\",
    \"excerpt\": \"文章摘要（可选）\",
    \"cover\": \"文章封面图路径/URL（可选，生成封面图后更新已有文章封面时填入此处）\",
    \"sortid\": 分类ID（可选，整数，默认为 -1）,
    \"tag\": \"文章标签（可选，多个标签用英文逗号隔开）\"
  }
- 示例 1 (新建文章): `<tool_call name=\"write_article\">{\"title\":\"我的第一篇AI博客\",\"content\":\"这是通过AI助手自动撰写的博客内容。\",\"sortid\":-1,\"tag\":\"AI,科技,博客\"}</tool_call>`
- 示例 2 (更新已知文章封面图): `<tool_call name=\"write_article\">{\"gid\":1,\"cover\":\"http://example.com/cover.jpg\"}</tool_call>`

4. 生成图片、制作封面图、给文章配图等图像生成操作
- 工具名称: generate_image
- 说明: 当用户在对话中明确要求生成图片、制作封面图、给文章配图、画一张图、设计插图等图像生成需求时，必须调用此工具。
- 参数格式 (JSON):
  {
    \"prompt\": \"详细的英文或中文图片生成提示词（必填，请根据用户需求丰富和优化提示词描述）\",
    \"size\": \"图片尺寸（可选，默认 '1024x1024'，如 '1024x1024'、'512x512' 等）\",
    \"quality\": \"图片质量（可选，默认 'standard'）\"
  }
- 示例：`<tool_call name=\"generate_image\">{\"prompt\":\"一位在星空下写作的程序员，赛博朋克风格，高清\",\"size\":\"1024x1024\"}</tool_call>`

核心规则与流程自动化规范：
1. 一次对话只能输出一个 `<tool_call>` 标签。
2. 涉及多步骤需求（例如：“给第一篇文章生成封面图并设置”、“生成配图并发表/更新文章”等）：
   - 如果已知文章ID或目标信息，直接调用 `generate_image` 生成图片。
   - 当 `generate_image` 执行成功并收到系统反馈的图片URL（如 `[工具执行结果] 成功... 图片访问URL: http://...`）后，你必须【立即自动调用】下一步的工具（例如调用 `write_article` 工具，传入 `{\"gid\": 1, \"cover\": \"图片访问URL\"}` 更新文章封面），绝对不能使用 SQL 或仅回答“生成成功”就停止！
   - 收到工具执行结果反馈后，直接继续输出包含下一个 `<tool_call>` 标签的回复，实现无缝连贯自动操作。";

    Ai::chatStream($message, $system_prompt, true);
    exit;
}

if ($action == 'execute_tool') {
    if (!User::isAdmin()) {
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

        case 'write_article':
            try {
                $gid = isset($params['gid']) ? (int)$params['gid'] : (isset($params['blog_id']) ? (int)$params['blog_id'] : 0);
                $title = isset($params['title']) ? $params['title'] : '';
                $content = isset($params['content']) ? $params['content'] : '';
                $excerpt = isset($params['excerpt']) ? $params['excerpt'] : '';
                $cover = isset($params['cover']) ? $params['cover'] : '';
                $sortid = isset($params['sortid']) ? (int)$params['sortid'] : -1;
                $tag = isset($params['tag']) ? $params['tag'] : (isset($params['tags']) ? $params['tags'] : '');
                $confirm_code = isset($_POST['confirm_code']) ? $_POST['confirm_code'] : '';

                if (trim($confirm_code) !== 'confirm') {
                    $opName = $gid > 0 ? '更新文章' : '写文章';
                    throw new Exception("敏感操作拦截：" . $opName . "操作需要确认");
                }

                $articleData = [];
                if (isset($params['title'])) $articleData['title'] = $params['title'];
                if (isset($params['content'])) $articleData['content'] = $params['content'];
                if (isset($params['excerpt'])) $articleData['excerpt'] = $params['excerpt'];
                if (isset($params['cover'])) $articleData['cover'] = $params['cover'];
                if (isset($params['sortid'])) $articleData['sortid'] = (int)$params['sortid'];
                if (isset($params['tag'])) $articleData['tag'] = $params['tag'];
                if (isset($params['tags'])) $articleData['tags'] = $params['tags'];

                if ($gid > 0) {
                    $articleData['gid'] = $gid;
                    $articleData['action'] = 'update';
                }

                $blogId = Article::writeArticle($articleData);

                $msg = $gid > 0 ? "文章(ID: {$blogId})更新成功" : "文章发表成功，文章ID: {$blogId}";

                Output::ok([
                    'message' => $msg,
                    'blog_id' => $blogId
                ]);
            } catch (Exception $e) {
                Output::error($e->getMessage());
            }
            break;

        case 'update_config':
            try {
                $key = isset($params['key']) ? $params['key'] : '';
                $configAction = isset($params['action']) ? $params['action'] : '';
                $value = isset($params['value']) ? $params['value'] : null;
                $confirm_code = isset($_POST['confirm_code']) ? $_POST['confirm_code'] : '';

                if (empty($key) || empty($configAction)) {
                    throw new Exception('参数错误，key 和 action 不能为空');
                }

                if (trim($confirm_code) !== 'confirm') {
                    throw new Exception("敏感操作拦截：修改系统配置需要确认");
                }

                $result = Ai::updateConfig($key, $configAction, $value);

                Output::ok([
                    'message' => '配置文件 config.php 修改成功'
                ]);
            } catch (Exception $e) {
                Output::error($e->getMessage());
            }
            break;

        case 'generate_image':
            try {
                $prompt = isset($params['prompt']) ? trim($params['prompt']) : '';
                $size = isset($params['size']) ? $params['size'] : '1024x1024';
                $quality = isset($params['quality']) ? $params['quality'] : 'standard';

                if (empty($prompt)) {
                    throw new Exception('提示词不能为空');
                }

                $imageModelInfo = Ai::getCurrentImageModelInfo();
                if (!$imageModelInfo) {
                    Output::ok([
                        'need_config' => true,
                        'message' => '未配置图像生成模型，请先前往 [系统->AI] 页面配置图像生成模型。'
                    ]);
                }

                $result = Ai::generateImageAndSave($prompt, ['size' => $size, 'quality' => $quality]);
                if (isset($result['error'])) {
                    throw new Exception($result['error']);
                }

                Output::ok([
                    'message' => '图像生成成功！',
                    'image_url' => isset($result['file_url']) ? $result['file_url'] : '',
                    'media_id' => isset($result['media_id']) ? $result['media_id'] : 0,
                    'prompt' => $prompt
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
