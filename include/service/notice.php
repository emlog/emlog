<?php

/**
 * Service: Notice
 *
 * @package EMLOG
 * 
 */

class Notice
{

    /**
     * 发送用户注册邮件验证码，部分主题依赖该函数。
     *
     * @param string $mail 邮箱地址
     * @return bool
     */
    public static function sendRegMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = _lang('notice_reg_mail_code_title');
        $content = self::buildMailCodeContent($randCode);
        return self::sendMail($mail, $title, $content);
    }

    /**
     * 发送通用邮件验证码。
     *
     * @param string $mail 邮箱地址
     * @return bool
     */
    public static function sendVerifyMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = _lang('notice_verify_mail_code_title');
        $content = self::buildMailCodeContent($randCode);
        return self::sendMail($mail, $title, $content);
    }

    /**
     * 发送找回密码邮件验证码。
     *
     * @param string $mail 邮箱地址
     * @return bool
     */
    public static function sendResetMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = _lang('notice_reset_mail_code_title');
        $content = self::buildMailCodeContent($randCode);
        return self::sendMail($mail, $title, $content);
    }

    /**
     * 发送登录邮件验证码。
     *
     * @param string $mail 邮箱地址
     * @return bool
     */
    public static function sendLoginMailCode($mail)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['login_mail_code'] = $randCode;
        $_SESSION['login_mail'] = $mail;
        $_SESSION['login_mail_time'] = time();

        $title = _lang('notice_login_mail_code_title');
        $content = self::buildMailCodeContent($randCode);
        return self::sendMail($mail, $title, $content);
    }

    /**
     * 发送新投稿通知邮件。
     *
     * @param string $postTitle 文章标题
     * @param int $gid 文章ID
     * @return bool
     */
    public static function sendNewPostMail($postTitle, $gid)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (Option::get('mail_notice_post') === 'n') {
            return false;
        }
        $mail = self::getFounderEmail();
        if (!$mail) {
            return false;
        }

        $siteName = self::getSiteName();
        $safeSiteName = htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8');
        $title = sprintf(_lang('notice_new_post_subject'), $safeSiteName);
        $url = Url::log($gid);
        $safePostTitle = htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8');

        // 获取管理员（创始人）昵称
        $User_Model = new User_Model();
        $founder = $User_Model->getOneUser(1);
        $adminName = !empty($founder['nickname']) ? $founder['nickname'] : _lang('admin');
        $safeAdminName = htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8');

        // 获取投稿文章详情与作者信息
        $Log_Model = new Log_Model();
        $logInfo = $Log_Model->getDetail($gid);
        $authorName = '';
        $postDate = '';
        if (!empty($logInfo)) {
            if (!empty($logInfo['author'])) {
                $author = $User_Model->getOneUser($logInfo['author']);
                $authorName = isset($author['nickname']) ? $author['nickname'] : '';
            }
            if (!empty($logInfo['date'])) {
                $postDate = smartDate($logInfo['date']);
            }
        }
        if (empty($authorName)) {
            if (User::isLogin()) {
                $curr = $User_Model->getOneUser(UID);
                $authorName = isset($curr['nickname']) ? $curr['nickname'] : '';
            }
        }
        if (empty($authorName)) {
            $authorName = _lang('guest');
        }
        $safeAuthorName = htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8');

        $dateHtml = '';
        if (!empty($postDate)) {
            $dateHtml = '<div style="color: #64748b; font-size: 13px; margin-top: 6px;">' . _lang('notice_post_time') . '：' . htmlspecialchars($postDate, ENT_QUOTES, 'UTF-8') . '</div>';
        }

        $content = '<div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">' . $safeAdminName . ' <span style="font-weight: normal; font-size: 14px; color: #64748b;">' . _lang('notice_hello') . '</span></div>';
        $content .= '<div style="font-size: 14px; color: #475569; margin-bottom: 16px; line-height: 1.6;">' . sprintf(_lang('notice_new_post_intro'), $safeSiteName) . '</div>';
        $content .= '<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px 22px; margin: 16px 0 24px;">';
        $content .= '<div style="font-size: 16px; font-weight: 600; margin-bottom: 8px; line-height: 1.4;"><a href="' . $url . '" target="_blank" style="color: #0f172a; text-decoration: none;">' . $safePostTitle . '</a></div>';
        $content .= '<div style="color: #475569; font-size: 13px;">' . _lang('notice_post_author') . '：<strong style="color: #1e293b;">' . $safeAuthorName . '</strong></div>';
        $content .= $dateHtml;
        $content .= '<div style="margin-top: 16px;"><a href="' . $url . '" target="_blank" style="display: inline-block; padding: 8px 18px; background-color: #2563eb; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: 500;">' . _lang('notice_view_article') . '</a></div>';
        $content .= '</div>';

        return self::sendMail($mail, $title, $content);
    }

    /**
     * 发送新评论通知邮件
     *
     * @param string $comment 评论内容
     * @param int $gid 文章ID
     * @param int $pid 父评论ID
     * @param string $poster 评论/回复提交者昵称
     * @return bool
     */
    public static function sendNewCommentMail($comment, $gid, $pid = 0, $poster = '')
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (Option::get('mail_notice_comment') === 'n') {
            return false;
        }

        $article = self::getArticleInfo($gid);
        if (empty($article)) {
            return false;
        }

        $siteName = self::getSiteName();
        $safeSiteName = htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8');
        $articleUrl = Url::log($article['logid']);
        $safeArticleTitle = htmlspecialchars($article['log_title'], ENT_QUOTES, 'UTF-8');

        // 整理当前评论/回复者昵称
        if (empty($poster)) {
            if (User::isLogin()) {
                $userModel = new User_Model();
                $currUser = $userModel->getOneUser(UID);
                $poster = isset($currUser['nickname']) ? $currUser['nickname'] : '';
            }
        }
        if (empty($poster)) {
            $poster = _lang('guest');
        }
        $safePoster = htmlspecialchars($poster, ENT_QUOTES, 'UTF-8');
        $safeComment = nl2br(htmlClean(trim($comment)));

        if ($pid) {
            $Comment_Model = new Comment_Model();
            $c = $Comment_Model->getOneComment($pid);
            if (empty($c)) {
                return false;
            }

            $parentPoster = !empty($c['poster_raw']) ? $c['poster_raw'] : (!empty($c['poster']) ? $c['poster'] : _lang('guest'));
            $safeParentPoster = htmlspecialchars($parentPoster, ENT_QUOTES, 'UTF-8');
            $rawParentComment = isset($c['comment_text']) ? $c['comment_text'] : (isset($c['comment']) ? $c['comment'] : '');
            $safeParentComment = nl2br(htmlClean(trim($rawParentComment)));

            $title = sprintf(_lang('notice_comment_reply_subject'), $safeSiteName);

            // 1. 原评论人问候
            $content = '<div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">' . $safeParentPoster . ' <span style="font-weight: normal; font-size: 14px; color: #64748b;">' . _lang('notice_hello') . '</span></div>';
            // 2. 您在「文章」发表评论：
            $articleLink = '<a href="' . $articleUrl . '" target="_blank" style="color: #2563eb; text-decoration: none; font-weight: 500;">' . $safeArticleTitle . '</a>';
            $content .= '<div style="font-size: 14px; color: #475569; margin-bottom: 10px; line-height: 1.6;">' . sprintf(_lang('notice_comment_on'), $articleLink) . '</div>';
            // 3. 原评论内容卡片（次级引用：柔和冷灰边框）
            $content .= '<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px; font-size: 14px; line-height: 1.6; color: #475569; word-break: break-all;">' . $safeParentComment . '</div>';
            // 4. 回复人 给您的回复如下：
            $content .= '<div style="font-size: 14px; color: #475569; margin-bottom: 10px; line-height: 1.6;"><strong style="font-size: 15px; color: #0f172a;">' . $safePoster . '</strong> ' . _lang('notice_reply_content_prefix') . '</div>';
            // 5. 回复内容卡片（核心焦点：全包围柔和边框）
            $content .= '<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; font-size: 15px; line-height: 1.65; color: #1e293b; word-break: break-all;">' . $safeComment . '</div>';

            $mail = self::getCommentAuthorEmail($pid);
        } else {
            // 新评论通知文章作者
            $userModel = new User_Model();
            $author = $userModel->getOneUser($article['author']);
            $authorName = !empty($author['nickname']) ? $author['nickname'] : _lang('author');
            $safeAuthorName = htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8');

            $title = sprintf(_lang('notice_new_comment_subject'), $safeSiteName);

            // 1. 文章作者问候
            $content = '<div style="font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">' . $safeAuthorName . ' <span style="font-weight: normal; font-size: 14px; color: #64748b;">' . _lang('notice_hello') . '</span></div>';
            // 2. 您的文章「文章」收到了新的评论：
            $articleLink = '<a href="' . $articleUrl . '" target="_blank" style="color: #2563eb; text-decoration: none; font-weight: 500;">' . $safeArticleTitle . '</a>';
            $content .= '<div style="font-size: 14px; color: #475569; margin-bottom: 12px; line-height: 1.6;">' . sprintf(_lang('notice_comment_received'), $articleLink) . '</div>';
            // 3. 评论人 发表评论如下：
            $content .= '<div style="font-size: 14px; color: #475569; margin-bottom: 10px; line-height: 1.6;"><strong style="font-size: 15px; color: #0f172a;">' . $safePoster . '</strong> ' . _lang('notice_comment_post_prefix') . '</div>';
            // 4. 评论内容卡片（全包围柔和边框）
            $content .= '<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 16px 20px; margin-bottom: 24px; font-size: 15px; line-height: 1.65; color: #1e293b; word-break: break-all;">' . $safeComment . '</div>';

            $mail = self::getArticleAuthorEmail($article['author']);
        }

        if (!$mail) {
            return false;
        }
        return self::sendMail($mail, $title, $content);
    }

    public static function getFounderEmail()
    {
        $User_Model = new User_Model();
        $r = $User_Model->getOneUser(1);
        if (isset($r['email']) && checkMail($r['email'])) {
            return $r['email'];
        }
        return false;
    }

    public static function getArticleAuthorEmail($uid)
    {
        $User_Model = new User_Model();
        $r = $User_Model->getOneUser($uid);
        if (isset($r['email']) && checkMail($r['email'])) {
            return $r['email'];
        }
        return false;
    }

    public static function getCommentAuthorEmail($cid)
    {
        $Comment_Model = new Comment_Model();
        $r = $Comment_Model->getOneComment($cid);
        if (isset($r['mail']) && checkMail($r['mail'])) {
            return $r['mail'];
        }
        return false;
    }

    /**
     * 发送邮件
     *
     * @param string|array $mail 收件人邮箱
     * @param string $title 邮件标题
     * @param string $content 邮件内容
     * @return bool
     */
    public static function sendMail($mail, $title, $content)
    {
        $content = self::getMailTemplate($content, $mail);
        $sendmail = new SendMail();
        $ret = $sendmail->send($mail, $title, $content);
        if ($ret) {
            return true;
        }
        return false;
    }

    /**
     * 发送邮件给创始人
     *
     * @param string $title 邮件标题
     * @param string $content 邮件内容
     * @return bool
     */
    public static function sendMail2Founder($title, $content)
    {
        $mail = self::getFounderEmail();
        if (!$mail) {
            return false;
        }
        $content = self::getMailTemplate($content, $mail);
        $sendmail = new SendMail();
        $ret = $sendmail->send($mail, $title, $content);
        if ($ret) {
            return true;
        }
        return false;
    }

    /**
     * 获取经过模板渲染后的邮件内容
     *
     * @param string $content 邮件原始内容
     * @param string|array $toMail 收件人邮箱
     * @return string
     */
    public static function getMailTemplate($content, $toMail = '')
    {
        $mailTemplate = Option::get('mail_template');
        if (!empty(trim($mailTemplate))) {
            $email = is_array($toMail) ? (isset($toMail[0]) ? $toMail[0] : '') : $toMail;
            $nickname = '';
            if (!empty($email) && checkMail($email)) {
                $userModel = new User_Model();
                $userData = $userModel->getUserDataByLogin($email);
                if (!empty($userData) && !empty($userData['nickname'])) {
                    $nickname = $userData['nickname'];
                }
            }
            return str_replace(
                ['{{mail_content}}', '{{mail_site_title}}', '{{mail_user_name}}'],
                [$content, Option::get('blogname'), $nickname],
                $mailTemplate
            );
        }
        return self::wrapDefaultMailContainer($content);
    }

    /**
     * 获取站点名称
     *
     * @return string
     */
    private static function getSiteName()
    {
        $siteName = Option::get('blogname');
        if (empty($siteName)) {
            $siteName = Option::get('site_title');
        }
        return !empty($siteName) ? $siteName : 'EMLOG';
    }

    /**
     * 包装默认邮件外层容器（在未配置自定义全局模板时使用）
     *
     * @param string $content 邮件内部内容
     * @return string
     */
    private static function wrapDefaultMailContainer($content)
    {
        return '<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #f8fafc; padding: 32px 16px; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'PingFang SC\', \'Hiragino Sans GB\', \'Microsoft YaHei\', sans-serif;"><tr><td align="center"><div style="max-width: 600px; width: 100%; margin: 0 auto; padding: 28px 24px; line-height: 1.7; color: #334155; background-color: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); text-align: left; box-sizing: border-box;">' . $content . '</div></td></tr></table>';
    }

    private static function smtpServerReady()
    {
        if (empty(Option::get('smtp_pw')) || empty(Option::get('smtp_mail'))) {
            return false;
        }
        return true;
    }

    /**
     * 构建验证码邮件内容
     *
     * @param string $randCode 随机验证码
     * @return string
     */
    private static function buildMailCodeContent($randCode)
    {
        $randCodeSafe = htmlspecialchars($randCode, ENT_QUOTES, 'UTF-8');

        $html = '<div style="margin-bottom: 12px; font-size: 15px; color: #0f172a;">' . _lang('notice_hello') . '</div>';
        $html .= '<div style="font-size: 14px; color: #475569; margin-bottom: 16px; line-height: 1.6;">' . _lang('notice_verify_code_tip') . '</div>';
        $html .= '<div style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; padding: 18px 24px; text-align: center; margin: 18px 0;">';
        $html .= '<div style="font-size: 12px; color: #64748b; margin-bottom: 6px; letter-spacing: 0.5px;">' . _lang('email_code') . '</div>';
        $html .= '<div style="font-size: 32px; font-weight: 700; letter-spacing: 6px; color: #0f172a; font-family: monospace, -apple-system, sans-serif;">' . $randCodeSafe . '</div>';
        $html .= '</div>';
        $html .= '<div style="font-size: 13px; color: #94a3b8; margin-top: 14px; line-height: 1.5;">' . _lang('notice_code_security_tip') . '</div>';
        return $html;
    }

    private static function getArticleInfo($gid)
    {
        $Log_Model = new Log_Model();
        $r = $Log_Model->getOneLogForHome($gid);
        if (isset($r['author'])) {
            return $r;
        }
        return false;
    }
}
