<?php
/**
 * homepage & article detail
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Log_Controller {
    function display($params) {
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

    function displayContent($params) {
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
        if (($logData['hide'] === 'y' || $logData['checked'] === 'n') && $logData['author'] != UID && !User::haveEditPermission()) {
            show_404_page();
        }

        doMultiAction('article_content_echo', $logData, $logData);

        extract($logData);

        // password
        if (!empty($password)) {
            $postpwd = isset($_POST['logpwd']) ? addslashes(trim($_POST['logpwd'])) : '';
            $cookiepwd = isset($_COOKIE['em_logpwd_' . $logid]) ? addslashes(trim($_COOKIE['em_logpwd_' . $logid])) : '';
            $Log_Model->AuthPassword($postpwd, $cookiepwd, $password, $logid);
        }
        // tdk
        $site_title = $this->setSiteTitle($log_title_style, $log_title, $blogname, $site_title, $logid);
        $site_description = $this->setSiteDes($site_description, $log_content, $logid);
        $site_key = $this->setSiteKey($tags, $site_key, $logid);

        //comments
        $Comment_Model = new Comment_Model();
        $verifyCode = ISLOGIN == false && $comment_code == 'y' ? "<img src=\"" . BLOG_URL . "include/lib/checkcode.php\" id=\"captcha\" /><input name=\"imgcode\" type=\"text\" class=\"input\" size=\"5\" tabindex=\"5\" />" : '';
        $ckname = isset($_COOKIE['commentposter']) ? htmlspecialchars(stripslashes($_COOKIE['commentposter'])) : '';
        $ckmail = isset($_COOKIE['postermail']) ? htmlspecialchars($_COOKIE['postermail']) : '';
        $ckurl = isset($_COOKIE['posterurl']) ? htmlspecialchars($_COOKIE['posterurl']) : '';
        $comments = $Comment_Model->getComments($logid, 'n', $comment_page);

        $Log_Model->updateViewCount($logid);

        if (filter_var($link, FILTER_VALIDATE_URL)) {
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

    private function setSiteDes($siteDescription, $logContent, $logId) {
        if ($this->isHomePage($logId)) {
            return $siteDescription;
        }

        return extractHtmlData($logContent, 90);
    }

    private function setSiteKey($tagIdStr, $siteKey, $logId) {
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

    private function setSiteTitle($logTitleStyle, $logTitle, $blogName, $siteTitle, $logId) {
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

    private function isHomePage($logId) {
        $homePageId = Option::get('home_page_id');
        if ($homePageId && $homePageId == $logId) {
            return true;
        }
        return false;
    }

}
