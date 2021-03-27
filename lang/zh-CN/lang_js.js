var LNG = {
//---------------------------
//admin/views/js/common.js
 'twitter_del_sure'	: '你确定要删除该条微语吗？',//'Are you sure you want to delete this twitt?',
 'comment_del_sure'	: '你确定要删除该评论吗？',//'Are you sure you want to delete this comment?',
 'comment_ip_del_sure'	: '你确定要删除来自该IP的所有评论吗？',//'Are you sure you want to delete all comments from that IP?',
 'link_del_sure'	: '你确定要删除该链接吗？',//'Are you sure you want to delete this link?',
 'navi_del_sure'	: '你确定要删除该导航吗？',//'Are you sure you want to delete this navigation?',
 'backup_import_sure'	: '你确定要导入该备份文件吗？',//'Are you sure you want to import the backup files?',
 'attach_del_sure'	: '你确定要删除该附件吗？',//'Are you sure you want to delete this attachment?',
 'avatar_del_sure'	: '你确定要删除头像吗？',//'Are you sure you want to delete this avatar?',
 'category_del_sure'	: '你确定要删除该分类吗？',//'Are you sure you want to delete this category?',
 'page_del_sure'	: '你确定要删除该页面吗？',//'Are you sure you want to delete this page?',
 'user_del_sure'	: '你确定要删除该用户吗？',//'Are you sure you want to delete this user?',
 'template_del_sure'	: '你确定要删除该模板吗？',//'Are you sure you want to delete default template?',
 'plugin_reset_sure'	: '你确定要恢复组件设置到初始状态吗？这样会丢失你自定义的组件。',//'Are you sure you want to restore default plugin settings? This operation will lose your custom plugin configuration.',
 'plugin_del_sure'	: '你确定要删除该插件吗？',//'Are you sure you want to delete this plugin?',
 'title_empty'		: '标题不能为空',//'Title can not be empty',
 'alis_link_error'	: '链接别名错误',//'Link Alias error',
 'alias_invalid_chars'	: '别名错误，应由字母、数字、下划线、短横线组成',//'Alias should contain only latin letters, numbers, underscores and dashes',
 'alias_digital'	: '别名错误，不能为纯数字',//'Alias cannot contain numbers only',
 'alias_format_must_be'	: '别名错误，不能为\'post\'或\'post-数字\'',//'Invalid alias. It can not contain \'post\' or \'post-digits\'',
 'alias_system_conflict'	: '别名错误，与系统链接冲突',//'Alias error (system conflict)',
 'wysiwyg_switch'		: '请先切换到所见所得模式',//'Please, switch to WYSIWYG mode',
 'click_view_fullsize'		: '点击查看原图',//'Click to view full size',
// 'wysiwyg_switch'		: '请先切换到所见所得模式',//'Please, switch to WYSIWYG mode',
 'alis_link_error_not_saved'	: '链接别名错误，自动保存失败',//'Invalid Link Alias. Can not be saved automatically.',
 'saving'		: '正在保存',//'Saving',
// 'saving'		: '正在保存',//'Saving',
 'saved_ok_time'	: '成功保存于',//'Successfully saved at ',
 'save_system_error'	: '网络或系统出现异常...保存可能失败',//'Error while saving... Unable to save.',

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
