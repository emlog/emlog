<?php

/**
 * Service: Article
 *
 * @package EMLOG
 * 
 */

class Article
{
    /**
     * 检查用户是否超过发文限制
     *
     * @return bool 如果超过发文限制返回true，否则返回false
     */
    public static function hasReachedDailyPostLimit()
    {
        $Log_Model = new Log_Model();
        if (!User::isWriter()) {
            return false;
        }

        $count = $Log_Model->getPostCountByUid(UID, time() - 3600 * 24);
        $post_per_day = Option::get('posts_per_day');
        if ($count >= $post_per_day) {
            return true;
        }
        return false;
    }

    /**
     * 检查是否禁止用户发文
     *
     * @return bool 如果禁止发文返回true，否则返回false
     */
    public static function hasForbidPost()
    {
        $post_per_day = Option::get('posts_per_day');
        if (0 === (int)$post_per_day) {
            return true;
        }
        return false;
    }

    /**
     * 封装写文章的业务逻辑
     * 
     * @param array $articleData 传入的文章相关数据
     * @return int 成功返回发表的文章 gid
     * @throws Exception 校验不通过或失败时抛出异常
     */
    public static function writeArticle($articleData)
    {
        // 1. 检查是否限制/禁止发文（更新文章不受发文配额限制）
        $actionType = isset($articleData['action']) ? $articleData['action'] : 'create';
        $gid = isset($articleData['gid']) ? (int)$articleData['gid'] : (isset($articleData['blog_id']) ? (int)$articleData['blog_id'] : 0);
        if ($gid > 0) {
            $actionType = 'update';
        }

        if ($actionType === 'create') {
            if (self::hasForbidPost()) {
                throw new Exception("系统当前禁止发文");
            }
            if (self::hasReachedDailyPostLimit()) {
                throw new Exception("已达到今日每日发文限制，无法发文");
            }
        }

        $Log_Model = new Log_Model();
        $Tag_Model = new Tag_Model();
        $db = Database::getInstance();

        // 针对 update 操作，如果部分字段未传，可保留原文原值或按需更新
        $existingLog = null;
        if ($actionType === 'update') {
            $existingLog = $Log_Model->getOneLogForAdmin($gid);
            if (empty($existingLog)) {
                throw new Exception("文章不存在(gid: {$gid})");
            }
        }

        // 2. 字段检验与预处理
        $title = (isset($articleData['title']) && trim($articleData['title']) !== '') ? trim($articleData['title']) : ($existingLog ? $existingLog['title'] : '');
        if (empty($title)) {
            throw new Exception("文章标题不能为空");
        }

        $content = (isset($articleData['content']) && $articleData['content'] !== '') ? $articleData['content'] : (isset($articleData['logcontent']) && $articleData['logcontent'] !== '' ? $articleData['logcontent'] : ($existingLog ? $existingLog['content'] : ''));
        if (empty($content)) {
            throw new Exception("文章内容不能为空");
        }

        // 日期处理
        $postDate = isset($articleData['postdate']) ? trim($articleData['postdate']) : '';
        $postTime = $postDate ? strtotime($postDate) : ($existingLog ? $existingLog['date'] : time());
        if ($postTime === false) {
            $postTime = time();
        }

        $sort = isset($articleData['sort']) ? (int)$articleData['sort'] : (isset($articleData['sortid']) ? (int)$articleData['sortid'] : ($existingLog ? (int)$existingLog['sortid'] : -1));
        $tagstring = isset($articleData['tag']) ? strip_tags(trim($articleData['tag'])) : (isset($articleData['tags']) ? strip_tags(trim($articleData['tags'])) : '');
        $excerpt = isset($articleData['excerpt']) ? trim($articleData['excerpt']) : (isset($articleData['logexcerpt']) ? trim($articleData['logexcerpt']) : ($existingLog ? $existingLog['excerpt'] : ''));
        $alias = isset($articleData['alias']) ? trim($articleData['alias']) : ($existingLog ? $existingLog['alias'] : '');
        $top = isset($articleData['top']) ? trim($articleData['top']) : ($existingLog ? $existingLog['top'] : 'n');
        $sortop = isset($articleData['sortop']) ? trim($articleData['sortop']) : ($existingLog ? $existingLog['sortop'] : 'n');
        $allow_remark = isset($articleData['allow_remark']) ? trim($articleData['allow_remark']) : ($existingLog ? $existingLog['allow_remark'] : 'y');
        $password = isset($articleData['password']) ? trim($articleData['password']) : ($existingLog ? $existingLog['password'] : '');
        $template = isset($articleData['template']) ? trim($articleData['template']) : ($existingLog ? $existingLog['template'] : '');
        $cover = isset($articleData['cover']) ? trim($articleData['cover']) : ($existingLog ? $existingLog['cover'] : '');
        $link = isset($articleData['link']) ? trim($articleData['link']) : ($existingLog ? $existingLog['link'] : '');

        // 作者
        $author = isset($articleData['author']) ? (int)$articleData['author'] : 0;
        $author = $author && User::haveEditPermission() ? $author : ($existingLog ? $existingLog['author'] : (defined('UID') ? UID : 1));

        $ishide = isset($articleData['ishide']) ? trim($articleData['ishide']) : ($existingLog ? $existingLog['hide'] : 'n');
        $pubPost = isset($articleData['pubPost']) ? trim($articleData['pubPost']) : '';
        $auto_excerpt = isset($articleData['auto_excerpt']) ? trim($articleData['auto_excerpt']) : 'n';
        $auto_cover = isset($articleData['auto_cover']) ? trim($articleData['auto_cover']) : 'n';

        // 自动截取摘要
        if (empty($excerpt) && $auto_excerpt === 'y') {
            $parseDown = new Parsedown();
            $excerpt = $parseDown->text($content);
            $excerpt = extractHtmlData($excerpt, 180);
            $excerpt = str_replace(["\r", "\n", "'", '"'], ' ', $excerpt);
            $excerpt = addslashes($excerpt);
        }

        // 自动提取封面
        if ($content && empty($cover) && $auto_cover === 'y') {
            $cover = getFirstImage($content);
        }

        if ($pubPost === 'y' || $pubPost === 'yes') {
            $ishide = 'n';
        }

        // 检查文章别名
        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $alias)) {
            $alias = '';
        }
        if (!empty($alias)) {
            $CACHE = Cache::getInstance();
            $logalias_cache = $CACHE->readCache('logalias');
            $alias = $Log_Model->checkAlias($alias, $logalias_cache, $gid ? $gid : -1);
        }

        // 审核机制
        $checked = Option::get('ischkarticle') == 'y' && !User::haveEditPermission() ? 'n' : ($existingLog ? $existingLog['checked'] : 'y');

        $logData = [
            'title'        => $db->escape_string($title),
            'alias'        => $db->escape_string($alias),
            'content'      => $db->escape_string($content),
            'excerpt'      => $db->escape_string($excerpt),
            'cover'        => $db->escape_string($cover),
            'author'       => $author,
            'sortid'       => $sort,
            'date'         => $postTime,
            'top'          => $db->escape_string($top),
            'sortop'       => $db->escape_string($sortop),
            'allow_remark' => $db->escape_string($allow_remark),
            'hide'         => $db->escape_string($ishide),
            'checked'      => $db->escape_string($checked),
            'password'     => $db->escape_string($password),
            'link'         => $db->escape_string($link),
            'template'     => $db->escape_string($template),
        ];

        // 钩子
        doMultiAction('pre_save_log', $logData, $logData);

        if ($actionType === 'update') {
            $Log_Model->updateLog($logData, $gid);
            $blogid = $gid;
        } else {
            // 保存文章
            $blogid = $Log_Model->addlog($logData);
            if (!$blogid) {
                throw new Exception("写入数据库失败");
            }
        }

        // 保存标签
        if (isset($articleData['tag']) || isset($articleData['tags'])) {
            $Tag_Model->addTag($tagstring, $blogid);
        }

        // 缓存刷新
        $CACHE = Cache::getInstance();
        $CACHE->updateCache();
        $CACHE->updateArticleCache();

        // 附加字段逻辑
        $field_keys = isset($articleData['field_keys']) ? $articleData['field_keys'] : [];
        $field_values = isset($articleData['field_values']) ? $articleData['field_values'] : [];
        if (!empty($field_keys) && is_array($field_keys)) {
            Field::updateField($blogid, $field_keys, $field_values);
        }

        // 钩子与邮件发送
        $isPub = $ishide === 'n';
        doAction('save_log', $blogid, $isPub, $logData);

        if ($actionType === 'create' && $isPub && !User::haveEditPermission()) {
            Notice::sendNewPostMail($title, $blogid);
        }

        return $blogid;
    }
}
