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
        $title = _lang('notice_new_post_mail_title');
        $url = Url::log($gid);
        $content = sprintf('%s：<a href="%s">%s</a>', _lang('title'), $url, $postTitle);
        return self::sendMail($mail, $title, $content);
    }

    /**
     * 发送新评论通知邮件
     *
     * @param string $comment 评论内容
     * @param int $gid 文章ID
     * @param int $pid 父评论ID
     * @param string $pcomment 父评论内容，原始评论内容
     * @return bool
     */
    public static function sendNewCommentMail($comment, $gid, $pid = 0)
    {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (Option::get('mail_notice_comment') === 'n') {
            return false;
        }

        $content = "";
        $article = self::getArticleInfo($gid);

        if (empty($article)) {
            return false;
        }

        if ($pid) {
            $Comment_Model = new Comment_Model();
            $c = $Comment_Model->getOneComment($pid);
            $pcomment = isset($c['comment']) ? $c['comment'] : '';

            $title = _lang('notice_comment_reply_mail_title');
            $content = '<b>' . _lang('notice_my_comment_label') . '：</b>' . $pcomment . '<br><br>';
            $content .= '<b>' . _lang('notice_reply_received_label') . '：</b>' . $comment . '<br>';
            $content .= '<hr>' . _lang('from_article') . '：<a href="' . Url::log($article['logid']) . '" target="_blank">' . $article['log_title'] . '</a>';
            $mail = self::getCommentAuthorEmail($pid);
        } else {
            $title = _lang('notice_new_comment_mail_title');
            $content = '<b>' . _lang('comment') . '：</b>' . $comment . '<br>';
            $content .= '<hr>' . _lang('from_article') . '：<a href="' . Url::log($article['logid']) . '" target="_blank">' . $article['log_title'] . '</a>';
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
        return $content;
    }

    private static function smtpServerReady()
    {
        if (empty(Option::get('smtp_pw')) || empty(Option::get('smtp_mail'))) {
            return false;
        }
        return true;
    }

    /**
     * 构建验证码邮件内容，包含验证码与来源站点提示。
     *
     * @param string $randCode 随机验证码
     * @return string
     */
    private static function buildMailCodeContent($randCode)
    {
        $siteName = Option::get('blogname');
        if (empty($siteName)) {
            $siteName = Option::get('site_title');
        }
        $siteName = htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8');
        $siteUrl = defined('BLOG_URL') ? BLOG_URL : './';
        $codeHtml = sprintf('<b style="color: orange; font-size: 18px;">%s</b>', $randCode);
        return sprintf(
            '<div id="email_code">%s：%s</div><div id="email_site" style="margin-top: 10px; color: #666; font-size: 13px;">%s：<a href="%s" target="_blank" style="color: #666; text-decoration: underline;">%s</a></div>',
            _lang('email_code'),
            $codeHtml,
            _lang('mail_from_site'),
            $siteUrl,
            $siteName
        );
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
