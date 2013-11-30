<?php
/*
Plugin Name: Sendmail
Version: 3.7
Plugin URL: http://kller.cn/?post=61
Description: 发送博客留言至E-mail。
Author: KLLER
Author Email: kller@foxmail.com
Author URL: http://kller.cn
*/

!defined('EMLOG_ROOT') && exit('access deined!');
require_once(EMLOG_ROOT.'/content/plugins/kl_sendmail/class/class.smtp.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_sendmail/class/class.phpmailer.php');
function kl_sendmail_do($mailserver, $port, $mailuser, $mailpass, $mailto, $subject,  $content, $fromname)
{
	$mail = new KL_SENDMAIL_PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";
	$mail->Port = $port;

	if(KL_MAIL_SENDTYPE == 1)
	{
		$mail->IsSMTP();
	}else{
		$mail->IsMail();
	}
	$mail->Host = $mailserver;
	$mail->SMTPAuth = true;
	$mail->Username = $mailuser;
	$mail->Password = $mailpass;

	$mail->From = $mailuser;
	$mail->FromName = $fromname;

	$mail->AddAddress($mailto);
	$mail->WordWrap = 500;
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $content;
	$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
	if($mail->Host == 'smtp.gmail.com') $mail->SMTPSecure = "ssl";
	if(!$mail->Send())
	{
		echo $mail->ErrorInfo;
		return false;
	}else{
		return true;
	}
}
function kl_sendmail_get_comment_mail()
{
	include(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php');
	if(KL_IS_SEND_MAIL == 'Y' || KL_IS_REPLY_MAIL == 'Y')
	{
		$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
		$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
		$commail = isset($_POST['commail']) ? addslashes(trim($_POST['commail'])) : '';
		$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
		$gid = isset($_POST['gid']) ? intval($_POST['gid']) : -1;
		$pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;

		$blogname = Option::get('blogname');
		$Log_Model = new Log_Model();
		$logData = $Log_Model->getOneLogForHome($gid);
		$log_title = $logData['log_title'];
		$subject = "日志《{$log_title}》收到了新的评论";
		if(strpos(KL_MAIL_TOEMAIL, '@139.com') === false)
		{
			$content = "评论内容：{$comment}<br /><br />发件人:".$comname."<br />";
			if(!empty($commail)) $content .= "Email：{$commail}<br />";
			if(!empty($comurl)) $content .= "主页：{$comurl}<br />";
			$content .= "<br /><strong>=> 现在就前往<a href=\"{$_SERVER['HTTP_REFERER']}\" target=\"_blank\">日志页面</a>进行查看</strong><br />";
		}else{
			$content = $comment;
		}
		if(KL_IS_SEND_MAIL == 'Y')
		{
			if(ROLE == 'visitor') kl_sendmail_do(KL_MAIL_SMTP, KL_MAIL_PORT, KL_MAIL_SENDEMAIL, KL_MAIL_PASSWORD, KL_MAIL_TOEMAIL, $subject, $content, $blogname);
		}
		if(KL_IS_REPLY_MAIL == 'Y')
		{
			if($pid > 0)
			{
				$DB = mysql::getInstance();
				$Comment_Model = new Comment_Model();
				$pinfo = $Comment_Model->getOneComment($pid);
				if(!empty($pinfo['mail']) && $pinfo['poster'] != '奇遇')
				{
					$subject = "您在【{$blogname}】发表的评论收到了回复";
					$content = "{$pinfo['poster']},您好:<br /><br />您之前在《{$log_title}》发表的的评论：<br />{$pinfo['comment']}<br /><br />{$comname}给您的回复：<br />{$comment}<br /><br /><strong>您可以点击<a href=\"".Url::log($gid)."#{$pid}\" target=\"_blank\">查看该日志</a></strong><br /><br /><strong>感谢您对<a href=\"".BLOG_URL."\" target=\"_blank\">{$blogname}</a>的关注，欢迎<a href=\"".BLOG_URL."rss.php\">订阅本站</a></strong><br /><br />";
					kl_sendmail_do(KL_MAIL_SMTP, KL_MAIL_PORT, KL_MAIL_SENDEMAIL, KL_MAIL_PASSWORD, $pinfo['mail'], $subject, $content, $blogname);
				}
			}
		}
	}else{
		return;
	}
}
addAction('comment_saved', 'kl_sendmail_get_comment_mail');

function kl_sendmail_get_twitter_mail($r, $name, $date, $tid)
{
	include(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php');
	if(KL_IS_TWITTER_MAIL == 'Y')
	{
		$DB = Mysql::getInstance();
		$blogname = Option::get('blogname');
		$sql = "select a.content, b.username from ".DB_PREFIX."twitter a left join ".DB_PREFIX."user b on b.uid=a.author where a.id={$tid}";
		$res = $DB->query($sql);
		$row = $DB->fetch_array($res);
		$author = $row['username'];
		$twitter = $row['content'];
		$subject = "{$author}发布的碎语收到了新的回复";
		if(strpos(KL_MAIL_TOEMAIL, '@139.com') === false)
		{
			$content = "{$author}发布的碎语：{$twitter}<br /><br />{$name}对碎语的回复：{$r}<br /><br /><strong>=> 现在就前往<a href=\"{$_SERVER['HTTP_REFERER']}\" target=\"_blank\">碎语页面</a>进行查看</strong><br />";
		}else{
			$content = $r;
		}
		if(ROLE == 'visitor') kl_sendmail_do(KL_MAIL_SMTP, KL_MAIL_PORT, KL_MAIL_SENDEMAIL, KL_MAIL_PASSWORD, KL_MAIL_TOEMAIL, $subject, $content, $blogname);
	}
}
addAction('reply_twitter', 'kl_sendmail_get_twitter_mail');

function kl_sendmail_put_reply_mail($commentId, $reply)
{
	global $userData;
	include(EMLOG_ROOT.'/content/plugins/kl_sendmail/kl_sendmail_config.php');
	if(KL_IS_REPLY_MAIL == 'Y')
	{
		$DB = mysql::getInstance();
		$blogname = Option::get('blogname');
		$Comment_Model = new Comment_Model();
		$commentArray = $Comment_Model->getOneComment($commentId);
		extract($commentArray);
		$subject="您在【{$blogname}】发表的评论收到了回复";
		if(strpos($mail, '@139.com') === false)
		{
			$emBlog = new Log_Model();
			$logData = $emBlog->getOneLogForHome($gid);
			$log_title = $logData['log_title'];
			$content =  "{$poster},您好:<br /><br />您之前在《{$log_title}》发表的的评论：<br />{$comment}<br /><br />{$userData['username']}给您的回复：<br />{$reply}<br /><br /><strong>您可以点击<a href=\"".Url::log($gid)."#{$cid}\" target=\"_blank\">查看该日志</a></strong><br /><br /><strong>感谢您对<a href=\"".BLOG_URL."\" target=\"_blank\">{$blogname}</a>的关注，欢迎<a href=\"".BLOG_URL."rss.php\">订阅本站</a></strong><br /><br />";
		}else{
			$content = $reply;
		}
		if($mail != '')	kl_sendmail_do(KL_MAIL_SMTP, KL_MAIL_PORT, KL_MAIL_SENDEMAIL, KL_MAIL_PASSWORD, $mail, $subject, $content, $blogname);
	}else{
		return;
	}
}
addAction('comment_reply', 'kl_sendmail_put_reply_mail');

function kl_sendmail_menu()
{
	echo '<div class="sidebarsubmenu" id="kl_sendmail"><a href="./plugin.php?plugin=kl_sendmail">sendmail</a></div>';
}
addAction('adm_sidebar_ext', 'kl_sendmail_menu');
?>