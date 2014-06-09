<?php
//File: LANG_COMMENT

$lang = array(

//---------------------------
//include/controller/comment_controller.php
 'comment_error_comment_disabled'	=> 'Comment error: The comments for this entry has been closed.',//'评论失败：该文章已关闭评论',
 'comment_error_content_exists'		=> 'Comment error: The same content already exists.',//'评论失败：已存在相同内容评论',
 'comment_error_flood_control'		=> 'Comment error: You must wait before sending another comment.',//'评论失败：您提交评论的速度太快了，请稍后再发表评论',
 'comment_error_name_enter'		=> 'Comment error: Please, enter your name.',//'评论失败：请填写姓名',
 'comment_error_name_invalid'		=> 'Comment error: Name does not meet requirements.',//'评论失败：姓名不符合规范',
 'comment_error_email_invalid'		=> 'Comment error: E-mail address does not meet requirements.',//'评论失败：邮件地址不符合规范',
 'comment_error_other_user'		=> 'Comment error: User data cannot be the same as administrator or other users.',//'评论失败：禁止使用管理员昵称或邮箱评论',
 'comment_error_url_invalid'		=> 'Comment error: Homepage URL is invalid.',//'评论失败：主页地址不符合规范',
 'comment_error_empty'			=> 'Comment error: Please, enter some content.',//'评论失败：请填写评论内容',
 'comment_error_content_invalid'	=> 'Comment error: Content does not meet requirements.',//'评论失败：内容不符合规范',
 'comment_error_national_chars'		=> 'Comment error: Content must contain Chinese characters.',//'评论失败：评论内容需包含中文',
 'comment_error_captcha_invalid'	=> 'Comment error: Invalid captcha.',//'评论失败：验证码错误',

//---------------------------
//include/model/comment_model.php
 'comment_wait_approve'	=> 'Thank you. Your comment is waiting for approval',//'评论发表成功，请等待管理员审核',
// 'no_permission'	=> 'Insufficient permissions!',//'权限不足！',

//---------------------------
//REMOVED: m/view/comment.php
// 'pending'		=> 'Pending',//'待审',
// 'delete'		=> 'Delete',//'删除',
// 'belongs_to_post'	=> 'belongs to post',//'所属文章',
// 'hide'		=> 'Hide',//'隐藏',
// 'approve'		=> 'Approve',//'审核',
// 'reply'		=> 'Reply',//'回复',

//---------------------------
//m/view/reply.php
 'reply'		=> 'Reply',//'回复',
 'logged_as'		=> 'You are currently logged in as',//'当前已登录为',
// 'nickname'		=> 'Nicname',//'昵称',
 'email_optional'	=> 'E-Mail adress (optional)',//'邮件地址 (选填)',
 'homepage_optional'	=> 'Homepage (optional)',//'个人主页 (选填)',
 'content'		=> 'Content',//'内容',
 'comment_leave'	=> 'Leave a comment',//'发表评论',

);

