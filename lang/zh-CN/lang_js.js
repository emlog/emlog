var LNG = {
//---------------------------
//admin/views/article_write.php
 'leave_prompt'		: '离开页面提示',//'Leave page prompt',
 'already_edited'	: '[已修改] ',//'[already edited] ',

//---------------------------
//admin/views/js/common.js
 'twitter_del_sure'	: '确定要删除该笔记吗？',//'Are you sure you want to delete this note?',
 'comment_del_sure'	: '确定要删除该评论吗？',//'Are you sure you want to delete this comment?',
 'comment_ip_del_sure'	: '确定要删除来自该IP的所有评论吗？',//'Are you sure you want to delete all comments from that IP?',
 'link_del_sure'	: '确定要删除该链接吗？',//'Are you sure you want to delete this link?',
 'navi_del_sure'	: '确定要删除该导航吗？',//'Are you sure you want to delete this navigation?',
 'attach_del_sure'	: '确定要删除该媒体文件吗？',//'Are you sure you want to delete this media file?',
 'avatar_del_sure'	: '确定要删除头像吗？',//'Are you sure you want to delete this avatar?',
 'category_del_sure'	: '确定要删除该分类吗？',//'Are you sure you want to delete this category?',
 'user_del_sure'	: '确定要删除该用户吗？',//'Are you sure you want to delete this user?',
 'template_del_sure'	: '确定要删除该模板吗？',//'Are you sure you want to delete default template?',
 'plugin_reset_sure'	: '确定要恢复组件设置到初始状态吗？这样会丢失你自定义的组件。',//'Are you sure you want to restore default plugin settings? This operation will lose your custom plugin configuration.',
 'plugin_del_sure'	: '确定要删除该插件吗？',//'Are you sure you want to delete this plugin?',
 'alias_link_error'	: '链接别名错误',//'Link Alias error',
 'alias_invalid_chars'	: '别名错误，应由字母、数字、下划线、短横线组成',//'Alias should contain only latin letters, numbers, underscores and dashes',
 'alias_digital'	: '别名错误，不能为纯数字',//'Alias cannot contain numbers only',
 'alias_format_must_be'	: '别名错误，不能为\'post\'或\'post-数字\'',//'Invalid alias. It can not contain \'post\' or \'post-digits\'',
 'alias_system_conflict'	: '别名错误，与系统链接冲突',//'Alias error (system conflict)',
 'alias_link_error_not_saved'	: '链接别名错误，自动保存失败',//'Invalid Link Alias. Can not be saved automatically.',
// 'saving'		: '正在保存',//'Saving',
 'saving'		: '正在保存中...',//'Saving...',
 'saved_ok_time'	: '保存于：',//'Saved at: ',
 'save_system_error'	: '网络或系统出现异常...保存可能失败',//'Error while saving... Unable to save.',
 'too_quick'		: '请勿频繁操作！',//'Do not operate frequently!',
 'saving_in'		: '[保存中] ',//'[Saving] ',
 'saved_ok'		: '[保存成功] ',//'[Saved successfully] ',
 'save_failed'		: '[保存失败] ',//'[Save failed] ',
 'paste_upload'		: '粘贴上传 ',//'Paste upload ',
 'uploading'		: '上传中...',//'Uploading...',
 'progress'		: '进度(bytes): ',//'Progress (bytes): ',
 'upload_ok_get_result'	: '上传成功！正在获取结果...',//'Upload successful! Getting results...',
 'result_ok'		: '获取结果成功！',//'Get the result successfully!',
 'unknown_error'	: '未知错误',//'Unknown error',
 'upload_failed_error'	: '上传失败,图片类型错误或网络错误',//'Upload failed, wrong image type or network error',

//----
 'backup_import_sure'	: '你确定要导入该备份文件吗？',//'Are you sure you want to import the backup files?',
 'page_del_sure'	: '你确定要删除该页面吗？',//'Are you sure you want to delete this page?',
 'title_empty'		: '标题不能为空',//'Title can not be empty',
 'wysiwyg_switch'	: '请先切换到所见所得模式',//'Please, switch to WYSIWYG mode',
 'click_view_fullsize'	: '点击查看原图',//'Click to view full size',
 'user_disable_sure'	: '确定要禁用该用户吗？',//'Are you sure you want to disable this user?',
 'article_del_sure'	: '确定要删除该篇文章吗？',//'Are you sure you want to delete this article?',
 'draft_del_sure'	: '确定要删除该篇草稿吗？',//'Are you sure you want to delete this draft? ',

//---------------------------
//include/lib/js/common_tpl.js
 'loading'		: '加载中...',//'Loading...',
// 'loading'		: '加载中...',//'Loading...',
 'max_140_bytes'	: '(回复长度需在140个字内)',//'(Up to 140 characters)',
 'nickname_empty'	: '(昵称不能为空)',//'(Nickname cannot be empty)',
 'captcha_error'	: '(验证码错误)',//'(Verification code error)',
 'nickname_disabled'	: '(不允许使用该昵称)',//'(This nickname is not allowed)',
 'nickname_exists'	: '(已存在该回复)',//'(This nickname already exists)',
 'comments_disabled'	: '(禁止回复)',//'(Comments disabled)',
 'comment_ok_moderation'	: '(回复成功，等待管理员审核)',//'(Your comment saved successfully and is awaiting for moderation.)',
 'chinese_must_have'	: '评论内容需要包含中文！',//'The comment content must contain Chinese characters!',
 'email_invalid'	: '邮箱格式错误！',//'The email format is wrong!',
 'url_invalid'		: '网址格式错误！',//'URL format is wrong!',

//---------------------------
//admin/views/js/dropzone.min.js
 'drag_message'		: '拖动文件到这里，或者点击后选择上传',//'Drag the file here, or click to upload',

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
