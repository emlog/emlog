<?php

/**
 * homepage & article detail
 *
 * @package EMLOG
 * 
 */

class Log_Controller
{
    function index()
    {
        $action = Input::getStrVar('action');

        if ($action == 'addlike') {
            $this->addLike();
        } elseif ($action == 'unlike') {
            $this->unLike();
        } elseif ($action == 'addcom') {
            $this->addComment();
        } elseif ($action == 'likecom') {
            $this->likeComment();
        }
    }

    function display($params)
    {
        $Log_Model = new Log_Model();
        $CACHE = Cache::getInstance();

        $options_cache = Option::getAll();
        extract($options_cache);

        $page = isset($params[1]) && $params[1] == 'page' ? abs((int)$params[2]) : 1;

        $pageurl = '';
        $sqlSegment = 'ORDER BY top DESC ,date DESC';
        $sta_cache = $CACHE->readCache('sta');
        $lognum = $sta_cache['lognum'];
        $pageurl .= Url::logPage();
        $total_pages = $lognum > 0 ? ceil($lognum / $index_lognum) : 1;
        if ($page > $total_pages) {
            show_404_page();
        }
        $logs = $Log_Model->getLogsForHome($sqlSegment, $page, $index_lognum);
        $page_url = pagination($lognum, $index_lognum, $page, $pageurl);

        include View::getView('header');
        include View::getView('log_list');
    }

    function displayContent($params)
    {
        $comment_page = isset($params[4]) && $params[4] == 'comment-page' ? (int)$params[5] : 1;

        $Log_Model = new Log_Model();
        $CACHE = Cache::getInstance();

        $options_cache = $CACHE->readCache('options');
        extract($options_cache);

        $logid = 0;
        if (isset($params[1])) {
            if ($params[1] == 'post') {
                $logid = isset($params[2]) ? (int)$params[2] : 0;
            } elseif (is_numeric($params[1])) {
                $logid = (int)$params[1];
            } else {
                $logalias_cache = $CACHE->readCache('logalias');
                if (!empty($logalias_cache)) {
                    $alias = addslashes(urldecode(trim($params[1])));
                    $logid = array_search($alias, $logalias_cache);
                    if (!$logid) {
                        show_404_page();
                    }
                }
            }
        }

        $logData = $Log_Model->getOneLogForHome($logid, true, true);
        if (!$logData) {
            show_404_page();
        }

        // 作者和管理可以预览草稿及待审核文章
        if (($logData['hide'] === 'y' || $logData['checked'] === 'n' || $logData['timestamp'] > time()) && $logData['author'] != UID && !User::haveEditPermission()) {
            show_404_page();
        }

        // tdk
        $logData['site_title'] = $this->setSiteTitle($log_title_style, $logData['log_title'], $blogname, $site_title, $logid);
        $logData['site_description'] = $this->setSiteDes($site_description, $logData['log_content'], $logData['excerpt'], $logid);
        $logData['site_key'] = $this->setSiteKey($logData['tags'], $site_key, $logid);

        doMultiAction('article_content_echo', $logData, $logData);

        extract($logData);

        // password
        if (!empty($password)) {
            $postpwd = Input::postStrVar('logpwd');
            $cookiepwd = isset($_COOKIE['em_logpwd_' . $logid]) ? addslashes(trim($_COOKIE['em_logpwd_' . $logid])) : '';
            $Log_Model->AuthPassword($postpwd, $cookiepwd, $password, $logid);
        }

        //comments
        $Comment_Model = new Comment_Model();
        $verifyCode = ISLOGIN == false && $comment_code == 'y' ? "<img src=\"" . BLOG_URL . "include/lib/checkcode.php\" id=\"captcha\" class=\"captcha\" /><input name=\"imgcode\" type=\"text\" class=\"captcha_input\" size=\"5\" tabindex=\"5\" />" : '';
        $ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
        $ckmail = isset($_COOKIE['postermail']) ? htmlspecialchars($_COOKIE['postermail']) : '';
        $ckurl = isset($_COOKIE['posterurl']) ? htmlspecialchars($_COOKIE['posterurl']) : '';
        $comments = $Comment_Model->getComments($logid, 'n', $comment_page);

        $Log_Model->updateViewCount($logid);

        if (filter_var($link, FILTER_VALIDATE_URL)) {
            doAction('log_direct_link', $link);
            emDirect($link);
        }

        include View::getView('header');
        if ($type === 'blog') {
            $neighborLog = $Log_Model->neighborLog($timestamp);
            $template = !empty($template) && file_exists(TEMPLATE_PATH . $template . '.php') ? $template : 'echo_log';
            include View::getView($template);
        } elseif ($type === 'page') {
            $template = !empty($template) && file_exists(TEMPLATE_PATH . $template . '.php') ? $template : 'page';
            include View::getView($template);
        }
    }

    function addComment()
    {
        $name = Input::postStrVar('comname');
        $content = Input::postStrVar('comment');
        $mail = Input::postStrVar('commail');
        $url = Input::postStrVar('comurl');
        $avatar = Input::postStrVar('avatar');
        $imgcode = strtoupper(Input::postStrVar('imgcode'));
        $blogId = Input::postIntVar('gid', -1);
        $pid = Input::postIntVar('pid');
        $resp = Input::postStrVar('resp'); // eg: json (only support json now)
        $uid = 0;
        $ua = getUA();

        if (ISLOGIN === true) {
            $User_Model = new User_Model();
            $user_info = $User_Model->getOneUser(UID);
            $name = addslashes($user_info['name_orig']);
            $mail = addslashes($user_info['email']);
            $url = addslashes(BLOG_URL);
            $uid = UID;
        }

        if ($url && strncasecmp($url, 'http', 4)) {
            $url = 'https://' . $url;
        }

        doAction('comment_post');

        $Comment_Model = new Comment_Model();
        $Log_Model = new Log_Model();

        $log = $Log_Model->getDetail($blogId);
        $Comment_Model->setCommentCookie($name, $mail, $url);
        $err = '';

        if (!ISLOGIN && Option::get('login_comment') === 'y') {
            $err = _lang('login_to_comment');
        } elseif ($blogId <= 0 || empty($log)) {
            $err = _lang('article_not_found');
        } elseif (Option::get('iscomment') == 'n' || $log['allow_remark'] == 'n') {
            $err = _lang('comment_not_allowed');
        } elseif (!User::haveEditPermission() && $Comment_Model->isCommentTooFast() === true) {
            $err = _lang('comment_too_fast');
        } elseif (empty($name)) {
            $err = _lang('fill_nickname');
        } elseif (strlen($name) > 100) {
            $err = _lang('nickname_too_long');
        } elseif ($mail !== '' && !checkMail($mail)) {
            $err = _lang('email_invalid');
        } elseif (empty($content)) {
            $err = _lang('comment_empty_error');
        } elseif (strlen($content) > 60000) {
            $err = _lang('comment_content_too_long');
        } elseif (ISLOGIN === false && Option::get('comment_code') == 'y' && session_start() && (empty($imgcode) || $imgcode !== $_SESSION['code'])) {
            $err = _lang('captcha_error');
        } elseif (empty($ua) || preg_match('/bot|crawler|spider|robot|crawling/i', $ua)) {
            $err = _lang('abnormal_request');
        }

        if ($err) {
            $resp === 'json' ? Output::error($err) : emMsg($err);
        }
        $r = $Comment_Model->addComment($uid, $name, $content, $mail, $url, $avatar, $blogId, $pid);
        $cid = isset($r['cid']) ? $r['cid'] : 0;
        $hide = isset($r['hide']) ? $r['hide'] : '';

        $_SESSION['code'] = null;
        notice::sendNewCommentMail($content, $blogId, $pid);

        if ($hide === 'y') {
            $msg = _lang('comment_success_audit');
            $resp === 'json' ? Output::ok($msg) : emMsg($msg);
        }
        if ($resp === 'json') {
            Output::ok(['cid' => $cid]);
        } else {
            emDirect(Url::log($blogId) . '#' . $cid);
        }
    }

    function likeComment()
    {
        $cid = Input::postIntVar('cid');
        $ua = getUA();
        $ip = getIp();

        $Comment_Model = new Comment_Model();
        $c = $Comment_Model->getOneComment($cid);

        $err = '';

        if (empty($c)) {
            $err = _lang('comment_not_found');
        } elseif (empty($ip) || empty($ua) || preg_match('/bot|crawler|spider|robot|crawling/i', $ua)) {
            $err = _lang('abnormal_request');
        }

        if ($err) {
            Output::error($err);
        }
        $Comment_Model->likeComment($cid);

        Output::ok();
    }

    function addLike()
    {
        $name = Input::postStrVar('name');
        $avatar = Input::postStrVar('avatar');
        $blogId = Input::postIntVar('gid', -1);
        $ua = getUA();
        $ip = getIp();
        $uid = 0;

        if (ISLOGIN === true) {
            $User_Model = new User_Model();
            $user_info = $User_Model->getOneUser(UID);
            $name = addslashes($user_info['name_orig']);
            $uid = UID;
        }

        doAction('like_post');

        $Like_Model = new Like_Model();
        $Log_Model = new Log_Model();

        $log = $Log_Model->getDetail($blogId);
        $err = '';

        if ($blogId <= 0 || empty($log)) {
            $err = _lang('article_not_found');
        } elseif ($Like_Model->isLiked($blogId, $uid, $ip) === true) {
            $err = _lang('already_liked');
        } elseif (!User::haveEditPermission() && $Like_Model->isTooFast() === true) {
            $err = _lang('operate_too_fast');
        } elseif (strlen($name) > 100) {
            $err = _lang('nickname_too_long');
        } elseif (empty($ip) || empty($ua) || preg_match('/bot|crawler|spider|robot|crawling/i', $ua)) {
            $err = _lang('abnormal_request');
        }

        if ($err) {
            Output::error($err);
        }
        $r = $Like_Model->addLike($uid, $name, $avatar, $blogId, $ip, $ua);
        $id = isset($r['id']) ? $r['id'] : 0;

        Output::ok(['id' => $id]);
    }

    function unLike()
    {
        $uid = 0;

        if (ISLOGIN === true) {
            $User_Model = new User_Model();
            $user_info = $User_Model->getOneUser(UID);
            $uid = UID;
        }

        $blogId = Input::postIntVar('gid');
        $Like_Model = new Like_Model();
        $r = $Like_Model->unLike($uid, $blogId);

        if ($r === false) {
            Output::error(_lang('cancel_failed'));
        }

        Output::ok();
    }

    private function setSiteDes($siteDescription, $logContent, $excerpt, $logId)
    {
        if ($this->isHomePage($logId)) {
            return $siteDescription;
        }

        if ($excerpt) {
            return extractHtmlData($excerpt, 200);
        }

        return extractHtmlData($logContent, 200);
    }

    private function setSiteKey($tagIdStr, $siteKey, $logId)
    {
        if ($this->isHomePage($logId)) {
            return $siteKey;
        }

        if (empty($tagIdStr)) {
            return $siteKey;
        }

        $tagNames = '';
        $tagModel = new Tag_Model();
        $ids = explode(',', $tagIdStr);

        if ($ids) {
            $tags = $tagModel->getNamesFromIds($ids);
            $tagNames = implode(',', $tags);
        }

        return $tagNames;
    }

    private function setSiteTitle($logTitleStyle, $logTitle, $blogName, $siteTitle, $logId)
    {
        if ($this->isHomePage($logId)) {
            return $siteTitle ?: $blogName;
        }

        switch ($logTitleStyle) {
            case '0':
                $articleSeoTitle = $logTitle;
                break;
            case '1':
                $articleSeoTitle = $logTitle . ' - ' . $blogName;
                break;
            case '2':
            default:
                $articleSeoTitle = $logTitle . ' - ' . $siteTitle;
                break;
        }

        return $articleSeoTitle;
    }

    private function isHomePage($logId)
    {
        $homePageId = Option::get('home_page_id');
        if ($homePageId && $homePageId == $logId) {
            return true;
        }
        return false;
    }
}
