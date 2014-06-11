<?php
//File: LANG_COMMENT

$lang = array(

//---------------------------
//admin/comment.php
[107] 'comment_not_exist'	=> 'This comment does not exist!',//'不存在该评论！',

//---------------------------
//admin/views/comment.php
[2] 'comment_management'	=> 'Comments Management',//'评论管理',
[3] 'comment_delete_ok'	=> 'Comment deleted successfully',//'删除评论成功',
[4] 'comment_audit_ok'	=> 'Comment audited successfully',//'审核评论成功',
[5] 'comment_hide_ok'	=> 'Comments hided successfully',//'隐藏评论成功',
[6] 'comment_edit_ok'	=> 'Comment modified successfully',//'修改评论成功',
[7] 'comment_reply_ok'	=> 'Comment replied successfully',//'回复评论成功',
[8] 'comment_choose_operation'	=> 'Please choose the operation to perform with comments',//'请选择要执行操作的评论',
[9]// 'select_action_to_perform'	=> 'Please, select an action to perform',//'请选择要执行的操作',
[10] 'reply_is_empty'	=> 'Reply can not be empty',//'回复内容不能为空',
[11] 'is_too_long'	=> 'is too long',//'内容过长',
[12] 'comment_is_empty'	=> 'Comment can not be empty',//'评论内容不能为空',
[21]// 'all'		=> 'All',//'全部',
[22]// 'pending'	=> 'Pending',//'待审',
[28] 'audited'		=> 'Audited',//'已审',
[35]// 'content'		=> 'Content',//'内容',
[36] 'commentator'	=> 'Commentators',//'评论者',
[37] 'belongs_to_post'	=> 'belongs to post',//'所属文章',
[44]// 'pending'	=> 'Pending',//'待审',
[46] 'from'		=> 'From',//'来自',
[58]// 'delete'		=> 'Delete',//'删除',
[60]// 'approve'	=> 'Approve',//'审核',
[62]// 'hide'		=> 'Hide',//'隐藏',
[64]// 'reply'		=> 'Reply',//'回复',
[65] 'edit'		=> 'Edit',//'编辑',
[69] 'delete_comments_from_ip'	=> 'Delete all comments from that IP',//'删除来自该IP的所有评论',
[70] 'show_post'	=> 'See the post',//'查看该文章',
[73] 'no_comments_yet'	=> 'Have not yet received comments',//'还没有收到评论',
[78]// 'select'		=> 'Select',//'全选',
[78]// 'selected_items'	=> 'Selected items',//'选中项',
[79]// 'delete'		=> 'Delete',//'删除',
[80]// 'hide'		=> 'Hide',//'隐藏',
[81]// 'approve'	=> 'Approve',//'审核',
[84]// 'have'		=> 'Have',//'有',
[84] '_comments'	=> 'comments',//'条评论',
[97] 'comment_operation_select'		=> 'Please select the operation for comments',//'请选择要操作的评论',
[100] 'comment_selected_delete_sure'	=> 'Are you sure you want to delete selected comments?',//'你确定要删除所选评论吗？',

//---------------------------
//admin/views/comment_edit.php
[2] 'comment_edit'	=> 'Edit comment',//'编辑评论',
[7] 'commentators'	=> 'commentators',//'评论人',
[8] 'email'		=> 'E-mail',//'电子邮件',
[9]// 'home'		=> 'Home',//'主页',
[10] 'comment_content'	=> 'Comment content',//'评论内容',
[12] 'save'		=> 'Save',//'保 存',
[13] 'cancel'		=> 'Cancel',//'取 消',

//---------------------------
//admin/views/comment_reply.php
[2] 'comment_reply'	=> 'Reply the comment',//'回复评论',
[7]// 'commentators'	=> 'commentators',//'评论人',
[8]// 'time'		=> 'Date',//'时间',
[9]// 'content'		=> 'Content',//'内容',
[15]// 'reply'		=> 'Reply',//'回复',
[17] 'reply_and_audit'	=> 'Reply and audit',//'回复并审核',
[19]// 'cancel'		=> 'Cancel',//'取 消',

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

);

