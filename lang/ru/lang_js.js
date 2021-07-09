var LNG = {
//---------------------------
//admin/views/js/common.js
 'twitter_del_sure'	: 'Are you sure you want to delete this twitt?',//'你确定要删除该条微语吗？',
 'comment_del_sure'	: 'Are you sure you want to delete this comment?',//'你确定要删除该评论吗？',
 'comment_ip_del_sure'	: 'Are you sure you want to delete all comments from that IP?',//'你确定要删除来自该IP的所有评论吗？',
 'link_del_sure'	: 'Are you sure you want to delete this link?',//'你确定要删除该链接吗？',
 'navi_del_sure'	: 'Are you sure you want to delete this navigation?',//'你确定要删除该导航吗？',
 'backup_import_sure'	: 'Are you sure you want to import the backup files?',//'你确定要导入该备份文件吗？',
 'attach_del_sure'	: 'Are you sure you want to delete this attachment?',//'你确定要删除该附件吗？',
 'avatar_del_sure'	: 'Are you sure you want to delete this avatar?',//'你确定要删除头像吗？',
 'category_del_sure'	: 'Are you sure you want to delete this category?',//'你确定要删除该分类吗？',
 'page_del_sure'	: 'Are you sure you want to delete this page?',//'你确定要删除该页面吗？',
 'user_del_sure'	: 'Are you sure you want to delete this user?',//'你确定要删除该用户吗？',
 'template_del_sure'	: 'Are you sure you want to delete default template?',//'你确定要删除该模板吗？',
 'plugin_reset_sure'	: 'Are you sure you want to restore default plugin settings? This operation will lose your custom plugin configuration.',//'你确定要恢复组件设置到初始状态吗？这样会丢失你自定义的组件。',
 'plugin_del_sure'	: 'Are you sure you want to delete this plugin?',//'你确定要删除该插件吗？',
 'title_empty'		: 'Title can not be empty',//'标题不能为空',
 'alias_link_error'	: 'Link Alias error',//'链接别名错误',
 'alias_invalid_chars'	: 'Alias should contain only latin letters, numbers, underscores and dashes',//'别名错误，应由字母、数字、下划线、短横线组成',
 'alias_digital'	: 'Alias cannot contain numbers only',//'别名错误，不能为纯数字',
 'alias_format_must_be'	: 'Invalid alias. It can not contain \'post\' or \'post-digits\'',//'别名错误，不能为\'post\'或\'post-数字\'',
 'alias_system_conflict'	: 'Alias error (system conflict)',//'别名错误，与系统链接冲突',
 'wysiwyg_switch'		: 'Please, switch to WYSIWYG mode',//'请先切换到所见所得模式',
 'click_view_fullsize'		: 'Click to view full size',//'点击查看原图',
// 'wysiwyg_switch'		: 'Please, switch to WYSIWYG mode',//'请先切换到所见所得模式',
 'alias_link_error_not_saved'	: 'Invalid Link Alias. Can not be saved automatically.',//'链接别名错误，自动保存失败',
// 'saving'		: 'Saving',//'正在保存',
 'saving'		: 'Saving...',//'正在保存中...',
 'saved_ok_time'	: 'Saved at ',//'保存于：',
 'save_system_error'	: 'Error while saving... Unable to save.',//'网络或系统出现异常...保存可能失败',

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
