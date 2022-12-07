var LNG = {
//---------------------------
//admin/views/article_write.php
 'leave_prompt'		: 'Leave page prompt',//'离开页面提示',
 'already_edited'	: '[already edited] ',//'[已修改] ',

//---------------------------
//admin/views/js/common.js
 'twitter_del_sure'	: 'Are you sure you want to delete this note?',//'确定要删除该笔记吗？',
 'comment_del_sure'	: 'Are you sure you want to delete this comment?',//'确定要删除该评论吗？',
 'comment_ip_del_sure'	: 'Are you sure you want to delete all comments from that IP?',//'确定要删除来自该IP的所有评论吗？',
 'link_del_sure'	: 'Are you sure you want to delete this link?',//'确定要删除该链接吗？',
 'navi_del_sure'	: 'Are you sure you want to delete this navigation?',//'确定要删除该导航吗？',
 'attach_del_sure'	: 'Are you sure you want to delete this media file?',//'确定要删除该媒体文件吗？',
 'avatar_del_sure'	: 'Are you sure you want to delete this avatar?',//'确定要删除头像吗？',
 'category_del_sure'	: 'Are you sure you want to delete this category?',//'确定要删除该分类吗？',
 'user_del_sure'	: 'Are you sure you want to delete this user?',//'确定要删除该用户吗？',
 'template_del_sure'	: 'Are you sure you want to delete default template?',//'确定要删除该模板吗？'
 'plugin_reset_sure'	: 'Are you sure you want to restore default plugin settings? This operation will lose your custom plugin configuration.',//'确定要恢复组件设置到初始状态吗？这样会丢失你自定义的组件。',
 'plugin_del_sure'	: 'Are you sure you want to delete this plugin?',//'确定要删除该插件吗？',
 'alias_link_error'	: 'Link Alias error',//'链接别名错误',
 'alias_invalid_chars'	: 'Alias should contain only latin letters, numbers, underscores and dashes',//'别名错误，应由字母、数字、下划线、短横线组成',
 'alias_digital'	: 'Alias cannot contain numbers only',//'别名错误，不能为纯数字',
 'alias_format_must_be'	: 'Invalid alias. It can not contain \'post\' or \'post-digits\'',//'别名错误，不能为\'post\'或\'post-数字\'',
 'alias_system_conflict'	: 'Alias error (system conflict)',//'别名错误，与系统链接冲突',
 'alias_link_error_not_saved'	: 'Invalid Link Alias. Can not be saved automatically.',//'链接别名错误，自动保存失败',
// 'saving'		: 'Saving',//'正在保存',
 'saving'		: 'Saving...',//'正在保存中...',
 'saved_ok_time'	: 'Saved at ',//'保存于：',
 'save_system_error'	: 'Error while saving... Unable to save.',//'网络或系统出现异常...保存可能失败',
 'too_quick'		: 'Do not operate frequently!',//'请勿频繁操作！',
 'saving_in'		: '[Saving] ',//'[保存中] ',
 'saved_ok'		: '[Saved successfully]: ',//'[保存成功] ',
 'save_failed'		: '[Save failed]: ',//'[保存失败] ',
 'save_failed!'		: 'Save failed!',//'保存失败！',
 'save_failed_prompt'	: 'Failed to save, please backup content, refresh the page and try again!',//'保存失败，请备份内容和刷新页面后重试！',
 'paste_upload'		: 'Paste upload ',//'粘贴上传 ',
 'uploading'		: 'Uploading...',//'上传中...',
 'progress'		: 'Progress (bytes): ',//'进度(bytes): ',
 'upload_ok_get_result'	: 'Upload successful! Getting results...',//'上传成功！正在获取结果...',
 'result_ok'		: 'Get the result successfully!',//'获取结果成功！',
 'unknown_error'	: 'Unknown error',//'未知错误',
 'upload_failed_error'	: 'Upload failed, wrong image type or network error',//'上传失败,图片类型错误或网络错误',

//----
 'backup_import_sure'	: 'Are you sure you want to import the backup files?',//'你确定要导入该备份文件吗？',
 'page_del_sure'	: 'Are you sure you want to delete this page?',//'你确定要删除该页面吗？',
 'title_empty'		: 'Title can not be empty',//'标题不能为空',
 'wysiwyg_switch'	: 'Please, switch to WYSIWYG mode',//'请先切换到所见所得模式',
 'click_view_fullsize'	: 'Click to view full size',//'点击查看原图',
 'user_disable_sure'	: 'Are you sure you want to disable this user?',//'确定要禁用该用户吗？',
 'article_del_sure'	: 'Are you sure you want to delete this article?',//'确定要删除该篇文章吗？',
 'draft_del_sure'	: 'Are you sure you want to delete this draft? ',//'确定要删除该篇草稿吗？',
 'media_category_del_sure' : 'Are you sure you want to delete this resource category (resource files will not be deleted)?',//'确定要删除该资源分类吗（不会删除资源文件）？',
 'media_select'		: 'Please select a media file to move',//'请选择要移动的资源',

//---------------------------
//include/lib/js/common_tpl.js
 'loading'		: 'Loading...',//'加载中...',
// 'loading'		: 'Loading...',//'加载中...',
 'max_140_bytes'	: '(Up to 140 characters)',//'(回复长度需在140个字内)',
 'nickname_empty'	: '(Nickname cannot be empty)',//'(昵称不能为空)',
 'captcha_error'	: '(Verification code error)',//'(验证码错误)',
 'nickname_disabled'	: '(This nickname is not allowed)',//'(不允许使用该昵称)',
 'nickname_exists'	: '(This nickname already exists)',//'(已存在该回复)',
 'comments_disabled'	: '(Comments disabled)',//'(禁止回复)',
 'comment_ok_moderation'	: '(Your comment saved successfully and is awaiting for moderation.)',//'(回复成功，等待管理员审核)',
 'chinese_must_have'	: 'The comment content must contain Chinese characters!',//'评论内容需要包含中文！',
 'email_invalid'	: 'The email format is wrong!',//'邮箱格式错误！',
 'url_invalid'		: 'URL format is wrong!',//'网址格式错误！',
 'toc'			: 'Table of contents',//'目录',

//---------------------------
//admin/views/js/dropzone.min.js
 'drag_message'		: 'Drag the file here, or click to upload',//'拖动文件到这里，或者点击后选择上传',

//----------------
// The LAST key. DO NOT EDIT!!!
  '@' : '@'
};

//------------------------------
// Return the language var value
function lang(key) {
  if(LNG[key]) {
    val = LNG[key];
  } else {
    val = '{'+key+'}';
  }
  return val;
}
