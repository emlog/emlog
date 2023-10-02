<?php

/**
 * Service: Notice
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Notice {

    // Send user registration verification code email
    public static function sendRegMailCode($mail) {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = "注册用户邮件验证码";
        $content = sprintf('<div id="email_code">邮件验证码：<span>%s</span></div>', $randCode);
        return self::sendMail($mail, $title, $content);
    }

    public static function sendResetMailCode($mail) {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (!isset($_SESSION)) {
            session_start();
        }
        $randCode = getRandStr(6, false, true);
        $_SESSION['mail_code'] = $randCode;
        $_SESSION['mail'] = $mail;

        $title = "找回密码邮件验证码";
        $content = sprintf('<div id="email_code">邮件验证码：<span>%s</span></div>', $randCode);
        return self::sendMail($mail, $title, $content);
    }

    public static function sendNewPostMail($postTitle) {
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
        $title = "你的站点收到新的文章投稿";
        $content = sprintf('文章标题是：%s', $postTitle);
        return self::sendMail($mail, $title, $content);
    }

    public static function sendNewCommentMail($comment, $gid, $pid) {
        if (!self::smtpServerReady()) {
            return false;
        }
        if (Option::get('mail_notice_comment') === 'n') {
            return false;
        }

        $content = "评论内容：" . $comment;
        $article = self::getArticleInfo($gid);

        if (empty($article)) {
            return false;
        }

        if ($pid) {
            $title = "你的评论收到一条回复";
            $content .= '<hr>来自文章：<a href="' . Url::log($article['logid']) . '" target="_blank">' . $article['log_title'] . '</a>';
            $mail = self::getCommentAuthorEmail($pid);
        } else {
            $title = "你的文章收到新的评论";
            $content .= '<hr>来自文章：<a href="' . Url::log($article['logid']) . '" target="_blank">' . $article['log_title'] . '</a>';
            $mail = self::getArticleAuthorEmail($article['author']);
        }
        if (!$mail) {
            return false;
        }
        return self::sendMail($mail, $title, $content);
    }

    private static function smtpServerReady() {
        if (empty(Option::get('smtp_pw')) || empty(Option::get('smtp_mail'))) {
            return false;
        }
        return true;
    }

    private static function getArticleInfo($gid) {
        $Log_Model = new Log_Model();
        $r = $Log_Model->getOneLogForHome($gid);
        if (isset($r['author'])) {
            return $r;
        }
        return false;
    }

    private static function getFounderEmail() {
        $User_Model = new User_Model();
        $r = $User_Model->getOneUser(1);
        if (isset($r['email']) && checkMail($r['email'])) {
            return $r['email'];
        }
        return false;
    }

    private static function getArticleAuthorEmail($uid) {
        $User_Model = new User_Model();
        $r = $User_Model->getOneUser($uid);
        if (isset($r['email']) && checkMail($r['email'])) {
            return $r['email'];
        }
        return false;
    }

    private static function getCommentAuthorEmail($cid) {
        $Comment_Model = new Comment_Model();
        $r = $Comment_Model->getOneComment($cid);
        if (isset($r['mail']) && checkMail($r['mail'])) {
            return $r['mail'];
        }
        return false;
    }

    public static function sendMail($mail, $title, $content) {
        $content = self::getMailTemplate($content);
        $sendmail = new SendMail();
        $ret = $sendmail->send($mail, $title, $content);
        if ($ret) {
            return true;
        }
        return false;
    }

    public static function getMailTemplate($content) {
        $mailTemplate = Option::get('mail_template');
        if (!empty(trim($mailTemplate))) {
            return str_replace('{{mail_content}}', $content, $mailTemplate);
        }
        return $content;
    }
}
