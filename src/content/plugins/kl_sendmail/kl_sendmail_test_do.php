<?php
/**
 * kl_sendmail_test_do.php
 * design by KLLER
 */
require_once('../../../init.php');
!(ISLOGIN === true && $value['author'] == UID || ROLE == 'admin') && exit('access deined!');
include_once('kl_sendmail_config.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_sendmail/class/class.smtp.php');
require_once(EMLOG_ROOT.'/content/plugins/kl_sendmail/class/class.phpmailer.php');
$blogname = Option::get('blogname');
$subject = $content = '这是一封测试邮件';
if(kl_sendmail_do(KL_MAIL_SMTP, KL_MAIL_PORT, KL_MAIL_SENDEMAIL, KL_MAIL_PASSWORD, KL_MAIL_TOEMAIL, $subject, $content, $blogname))
{
	echo '<font color="green">发送成功！请到相应邮箱查收！：）</font>';
}