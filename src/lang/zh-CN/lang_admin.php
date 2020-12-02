<?php

$lang = array(

//---------------------------
//admin/admin_log.php
 'drafts'		=> '草稿箱',
 '_drafts'		=> '草稿箱',
 'post_manage'		=> '文章管理',
 'draft_manage'		=> '草稿管理',
 'no_permission'	=> '权限不足！',

//---------------------------
//admin/attachment.php
 'attachment_delete_error'	=> '删除附件失败!',

//---------------------------
//admin/blogger.php
 'photo_delete'	=> '删除头像',

//---------------------------
//admin/configure.php
 'site_address'	=> '站点地址：',//'Site address',
 'verification_code_not_supported' => '开启登录验证码失败!服务器空间不支持GD图形库',
 'verification_code_comment_not_supported' =>'开启评论验证码失败!服务器空间不支持GD图形库',
 'detect_url' => '自动检测站点地址 (用于支持多域名/HTTPS，少数空间商可能不支持)',

//---------------------------
//admin/data.php
 'backup_directory_not_writable'	=> '备份失败。备份目录(content/backup)不可写',
 'backup_create_file_error'	=> '创建备份文件失败。备份目录(content/backup)不可写',
 'backup_empty' 		=> '数据表没有任何内容',
 'file_not_exists'		=> '文件不存在',//'File does not exist',
 'import_only_emlog'		=> '只能导入emlog备份的SQL文件',//'You can import only emlog SQL backup file',
 'info_illegal'			=> '非法提交的信息',//'Submitted information is illegal',
 'attachment_exceed_system_limit'	=> '附件大小超过系统 ',//'Attachment size exceeds the system limit ',
 'upload_failed_code'		=> '上传文件失败,错误码: ',//'Upload failed. Error code: ',
 'import_only_emlog_no_change'	=> '只能导入emlog备份的压缩包，且不能修改压缩包文件名！',//'You can only import emlog backup archive, and the archive file name can not be changed!',
 'import_failed_not_read'	=> '导入失败！读取文件失败',//'Import failed! Can not read the file',
 'import_failed_not_emlog'	=> '导入失败！该备份文件不是 emlog的备份文件!',//'Import failed! The backup file is not the emlog backup file!',
 'import_failed_not_emlog_ver'	=> '导入失败！该备份文件不是emlog ' . EMLOG_VERSION . '  生成的备份!',//'Import failed! The backup file is not the emlog ' . EMLOG_VERSION . ' backup file!',
 'import_failed_bad_prefix'	=> '导入失败！备份文件中的数据库前缀与当前系统数据库前缀不匹配 ',//'Import failed! The database backup file prefix does not match the current system database prefix ',

//---------------------------
//admin/globals.php
// 'no_permission'	=> '权限不足！',//'Insufficient permissions!',

//---------------------------
//admin/index.php
 'supported'		=> '支持',//'Supported',
 'not_supported'	=> '不支持',//'NOT supported',
 'phpinfo_disabled'	=> 'phpinfo函数被禁用!',//'phpinfo function is disabled!',
 'released'		=> ' released',

//---------------------------
//admin/plugin.php
 'plugin_upload_error'	=> '插件上传失败',//'Plugin upload failed',

//---------------------------
//admin/store.php
 'template'		=> '模板',//'Template',
 'template_view'	=> '查看模板',//'View template',
 'plugin'		=> '插件',//'Plugin',
 'plugins'		=> '插件',//'Plug-ins',
 'plugin_view'		=> '查看插件',//'View Plugin',

//---------------------------
//admin/style.php
 'user'		=> '作者',//'User',
 'users'	=> '作者',//'Users',

//---------------------------
//admin/template.php
 'ok_for_emlog'		=> '适用于emlog: ',//'Suitable for Emlog: ',
 'template_upload_failed'	=> '模板上传失败',//'Template upload failed',
 'template_used'	=> '您不能删除正在使用的模板',//'You can not delete a template being used',

//---------------------------
//admin/views/add_log.php
 'post_write'		=> '写文章',//'Write post',
 'enter_post_title'	=> '输入文章标题',//'Enter the post title',
 'upload_insert'	=> '上传插入',//'Insert upload',
 'category_select'	=> '选择分类...',//'Select Category...',
 'post_time'		=> '发布于',//'Posted on',
 'advanced_options'	=> '高级选项',//'Advanced Options',
 'post_description'	=> '文章摘要',//'Post Description',
 'post_alias'		=> '文章链接别名',//'Post Link Alias',
 'post_alias_info'	=> '用于自定义文章链接。需要',//'Used to customize the post link. Required',
 'post_alias_enable'	=> '启用文章链接别名',//'Enable post link alias',
 'post_access_password'	=> '文章访问密码',//'Post Access Password',
 'home_top'		=> '首页置顶',//'Home Top',
 'category_top'		=> '分类置顶',//'Category Top',
 'allow_comments'	=> '允许评论',//'Allow Comments',
 'post_publish'		=> '发布文章',//'Publish Post',
 'save_draft'		=> '保存草稿',//'Save Draft',

//---------------------------
//admin/views/add_page.php
 'add_page'		=> '新建页面',//'Add page',
 'page_title_info'	=> '输入页面标题',//'Enter the page title',
 'upload_insert'	=> '上传插入',//'Insert upload',
 'link_alias'		=> '链接别名',//'Link Alias',
 'link_alias_info'	=> '用于自定义该页面的链接地址。需要',//'The page link custom address. Required',
 'link_alias_enable'	=> '启用链接别名',//'Enable Link Alias',
 'page_template'	=> '页面模板：',//'Page template: ',
 'page_template_info'	=> '（用于自定义页面模板，对应模板目录下.php文件）',//'(For custom page template, use the corresponding .php file under the template directory)',
 'page_enable_comments'	=> '页面接受评论',//'Page accepted comments',
 'page_publish'		=> '发布页面',//'Publish Page',
 'save'			=> '保存',//'Save',

//---------------------------
//admin/views/admin_log.php
 'deleted_ok'		=> '删除成功',//'Deleted successfully',
 'sticked_ok'		=> '置顶成功',//'Entry has been sticked successfully',
 'unsticked_ok'		=> '取消置顶成功',//'Entry has been unsticked successfully',
 'select_post_to_operate'	=> '请选择要处理的文章',//'Please, select the entry to operate',
 'select_action_to_perform'	=> '请选择要执行的操作',//'Please, select an action to perform',
 'published_ok'		=> '发布成功',//'Entry has been publised successfully',
 'moved_ok'		=> '移动成功',//'Moved successfully',
 'author_modified_ok'	=> '更改作者成功',//'Entry author has been modified successfully',
 'draft_moved_ok'	=> '转入草稿箱成功',//'Moved to Draft successfully',
 'draft_saved_ok'	=> '草稿保存成功',//'Draft has been saved successfully',
 'saved_ok'		=> '保存成功',//'Entry has been saved successfully',
 'audited_ok'		=> '文章审核成功',//'Entry has been audited successfully',
 'rejected_ok'		=> '文章驳回成功',//'Entry has been rejected successfully',
 'all'			=> '全部',//'All',
 'category_view'	=> '按分类查看',//'View by Category',
 'category'		=> '分类',//'Category',
 'uncategorized'	=> '未分类',//'Uncategorized',
 'view_by_author'	=> '按作者查看',//'View by author',
 'article_search'	=> '搜索文章',//'Search Article',
 'title'		=> '标题',//'Title',
 'view'			=> '查看',//'View',
 'views'		=> '查看',//'Views',
 'reads'		=> '阅读',//'Reads',
 'time'			=> '时间',//'Date',
 'comments'		=> '评论',//'Comments',
 'attachment_num'	=> '附件',//'Attachments',
 'pending'		=> '待审',//'Pending',
 'reject'		=> '驳回',//'Reject',
 'open_new_window'	=> '在新窗口查看',//'Open in a new window',
 'yet_no_posts'		=> '还没有文章',//'Yet no entries',
 'select_all'		=> '全选',//'Select all',
 'selected_items'	=> '选中项',//'Selected items',
 'publish'		=> '发布',//'Publish',
 'add_draft'		=> '放入草稿箱',//'Save as draft',
 'top_action'		=> '置顶操作',//'Top Operation',
 'unstick'		=> '取消置顶',//'Unstick',
 'move_to_category'	=> '移动到分类',//'Move to category',
 'change_author'	=> '更改作者为',//'Change the author',
 'have'			=> '有',//'Have ',
 'number_of_items'	=> '篇',//' ',//LEAVE THIS EMPTY! It is just a number of "Items", "Pieces", etc..
 'draft'		=> '草稿',//'Draft',
 'drafts'		=> '草稿',//'drafts',
 'posts'		=> '文章',//'posts',
 'select_post_to_operate_please'	=> '请选择要操作的文章',//'Please, select the entry to operate',
 'sure_delete_selected_posts'	=> '你确定要删除所选文章吗？',//'Are you sure to want delete selected entries?',

//---------------------------
//admin/views/admin_page.php
 'page_management'	=> '页面管理',//'Page management',
 'page_deleted_ok'	=> '删除页面成功',//'Page has been removed successfully',
 'page_published_ok'	=> '发布页面成功',//'Page has been published successfully',
 'page_disabled_ok'	=> '禁用页面成功',//'Page has been disabled successfully',
 'page_saved_ok'	=> '页面保存成功',//'Page has been saved successfully',
 'page_view'		=> '查看页面',//'View page',
 'attachments'		=> '附件',//'Attachments',
 'no_pages'		=> '还没有页面',//'No pages',
 'delete'		=> '删除',//'Delete',
 'make_draft'		=> '转为草稿',//'Convert to draft',
 '_pages'		=> '个页面',//' pages',
 'select_page_to_operate'	=> '请选择要操作的页面',//'Please, select the page to operate',
 'sure_delete_selected_pages'	=> '你确定要删除所选页面吗？',//'Are you sure you want to delete selected pages?',

//---------------------------
//admin/views/attlib.php
 'attachment_upload'	=> '上传附件',//'Upload attachment',
 'bulk_upload'		=> '批量上传',//'Bulk upload',//'('
 'attachment_library'	=> '附件库',//'Attachment Library',
// ')',//'）',
 'no_attachments'	=> '该文章没有附件',//'The post has no attachment',
 'insert'		=> '插入 ',//'Insert',
 'insert_full_size'	=> '插入原图',//'Insert full size image',
 'full_size'		=> '原图',//'Full size image',
 'insert_thumbnail'	=> '插入缩略图',//'Insert thumbnail',
 'thumbnail'		=> '缩略图',//'Thumbnail',

//---------------------------
//admin/views/blogger.php
 'basic_settings'		=> '基本设置',//'Basic Settings',
 'seo_settings'			=> 'SEO设置',//'SEO Settings',
 'background_style'		=> '后台风格',//'Background style',
 'personal_settings'		=> '个人设置',//'Personal Settings',
 'personal_data_modified_ok'	=> '个人资料修改成功',//'Personal data modified successfully',
 'avatar_deleted_ok'		=> '头像删除成功',//'Avatar deleted successfully',
 'nickname_too_long'		=> '昵称不能太长',//'Nickname can not be too long',
 'email_format_invalid'		=> '电子邮件格式错误',//'E-mail format invalid',
 'password_length_short'	=> '密码长度不得小于5位',//'Password length must be not less than 5 characters',
 'password_not_equal'		=> '两次输入的密码不一致',//'Two passwords are not equal',
 'username_exists'		=> '该登录名已存在',//'This login name already exists',
 'nickname_exists'		=> '该昵称已存在',//'This nickname already exists',
 'avatar'			=> '头像',//'Avatar',
 'avatar_format_supported'	=> '(支持JPG、PNG格式图片)',//'(Supported formats: JPG, PNG)',
 'nickname'			=> '昵称',//'Nicname',
 'email'			=> '邮箱',//'E-mail',
 'personal_description'		=> '个人描述',//'Personal Description',
 'login_name'			=> '登录用户名',//'Login Username',
 'new_password_info'		=> '新密码（不小于5位，不修改请留空）',//'New Password (not less than 5 characters, left blank if do not need to modify)',
 'new_password_repeat'		=> '再输入一次新密码',//'Repeat new password',
 'save_data'			=> '保存资料',//'Save Data',

//---------------------------
//admin/views/configure.php
 'settings_saved_ok'	=> '设置保存成功',//'Settings have been saved successfully',
 'site_title'		=> '站点标题',//'Site title',
 'site_subtitle'	=> '站点副标题',//'Site subtitle',
 'site_address	'	=> '站点地址',//'Site address',
 'per_page'		=> '每页显示',//'Show per page',
 '_posts'		=> '篇文章',//' posts',
 'your_timezone'	=> '你所在时区',//'Your time zone',
 'Etc/GMT'		=>	'(UTC)协调世界时',
 'Africa/Casablanca'	=>	'(UTC)卡萨布兰卡',
 'Atlantic/Reykjavik'	=>	'(UTC)蒙罗维亚，雷克雅未克',
 'Europe/London'	=>	'(UTC)都柏林，爱丁堡，里斯本，伦敦',
 'Africa/Lagos'		=>	'(UTC+01:00)中非西部',
 'Europe/Paris'		=>	'(UTC+01:00)布鲁塞尔，哥本哈根，马德里，巴黎',
 'Africa/Windhoek'	=>	'(UTC+01:00)温得和克',
 'Europe/Warsaw'	=>	'(UTC+01:00)萨拉热窝，斯科普里，华沙，萨格勒布',
 'Europe/Budapest'	=>	'(UTC+01:00)贝尔格莱德，布拉迪斯拉发，布达佩斯，卢布尔雅那，布拉格',
 'Europe/Berlin'	=>	'(UTC+01:00)阿姆斯特丹，柏林，伯尔尼，罗马，斯德哥尔摩，维也纳',
 'Europe/Istanbul'	=>	'(UTC+02:00)伊斯坦布尔',
 'Europe/Kaliningrad'	=>	'(UTC+02:00)加里宁格勒(RTZ 1)',
 'Africa/Johannesburg'	=>	'(UTC+02:00)哈拉雷，比勒陀利亚',
 'Asia/Damascus'	=>	'(UTC+02:00)大马士革',
 'Asia/Amman'		=>	'(UTC+02:00)安曼',
 'Africa/Cairo'		=>	'(UTC+02:00)开罗',
 'Africa/Tripoli'	=>	'(UTC+02:00)的黎波里',
 'Asia/Jerusalem'	=>	'(UTC+02:00)耶路撒冷',
 'Asia/Beirut'		=>	'(UTC+02:00)贝鲁特',
 'Europe/Kiev'		=>	'(UTC+02:00)赫尔辛基，基辅，里加，索非亚，塔林，维尔纽斯',
 'Europe/Bucharest'	=>	'(UTC+02:00)雅典，布加勒斯特',
 'Africa/Nairobi'	=>	'(UTC+03:00)内罗毕',
 'Asia/Baghdad'		=>	'(UTC+03:00)巴格达',
 'Europe/Minsk'		=>	'(UTC+03:00)明斯克',
 'Asia/Riyadh'		=>	'(UTC+03:00)科威特，利雅得',
 'Europe/Moscow'	=>	'(UTC+03:00)莫斯科，圣彼得堡，伏尔加格勒(RTZ 2)',
 'Asia/Tehran'		=>	'(UTC+03:30)德黑兰',
 'Europe/Samara'	=>	'(UTC+04:00)伊热夫斯克，萨马拉(RTZ 3)',
 'Asia/Yerevan'		=>	'(UTC+04:00)埃里温',
 'Asia/Baku'		=>	'(UTC+04:00)巴库',
 'Asia/Tbilisi'		=>	'(UTC+04:00)第比利斯',
 'Indian/Mauritius'	=>	'(UTC+04:00)路易港',
 'Asia/Dubai'		=>	'(UTC+04:00)阿布扎比，马斯喀特',
 'Asia/Kabul'		=>	'(UTC+04:30)喀布尔',
 'Asia/Karachi'		=>	'(UTC+05:00)伊斯兰堡，卡拉奇',
 'Asia/Yekaterinburg'	=>	'(UTC+05:00)叶卡捷琳堡(RTZ 4)',
 'Asia/Tashkent'	=>	'(UTC+05:00)阿什哈巴德，塔什干',
 'Asia/Colombo'		=>	'(UTC+05:30)斯里加亚渥登普拉',
 'Asia/Calcutta'	=>	'(UTC+05:30)钦奈，加尔各答，孟买，新德里',
 'Asia/Katmandu'	=>	'(UTC+05:45)加德满都',
 'Asia/Novosibirsk'	=>	'(UTC+06:00)新西伯利亚(RTZ 5)',
 'Asia/Dhaka'		=>	'(UTC+06:00)达卡',
 'Asia/Almaty'		=>	'(UTC+06:00)阿斯塔纳',
 'Asia/Rangoon'		=>	'(UTC+06:30)仰光',
 'Asia/Krasnoyarsk'	=>	'(UTC+07:00)克拉斯诺亚尔斯克(RTZ 6)',
 'Asia/Bangkok'		=>	'(UTC+07:00)曼谷，河内，雅加达',
 'Asia/Ulaanbaatar'	=>	'(UTC+08:00)乌兰巴托',
 'Asia/Irkutsk'		=>	'(UTC+08:00)伊尔库茨克(RTZ 7)',
 'Asia/Shanghai'	=>	'(UTC+08:00)北京，重庆，香港特别行政区，乌鲁木齐',
 'Asia/Taipei'		=>	'(UTC+08:00)台北',
 'Asia/Singapore'	=>	'(UTC+08:00)吉隆坡，新加坡',
 'Australia/Perth'	=>	'(UTC+08:00)珀斯',
 'Asia/Tokyo'		=>	'(UTC+09:00)大阪，札幌，东京',
 'Asia/Yakutsk'		=>	'(UTC+09:00)雅库茨克(RTZ 8)',
 'Asia/Seoul'		=>	'(UTC+09:00)首尔',
 'Australia/Darwin'	=>	'(UTC+09:30)达尔文',
 'Australia/Adelaide'	=>	'(UTC+09:30)阿德莱德',
 'Pacific/Port_Moresby'	=>	'(UTC+10:00)关岛，莫尔兹比港',
 'Australia/Sydney'	=>	'(UTC+10:00)堪培拉，墨尔本，悉尼',
 'Australia/Brisbane'	=>	'(UTC+10:00)布里斯班',
 'Asia/Vladivostok'	=>	'(UTC+10:00)符拉迪沃斯托克，马加丹(RTZ 9)',
 'Australia/Hobart'	=>	'(UTC+10:00)霍巴特',
 'Asia/Magadan'		=>	'(UTC+10:00)马加丹',
 'Asia/Srednekolymsk'	=>	'(UTC+11:00)乔库尔达赫(RTZ 10)',
 'Pacific/Guadalcanal'	=>	'(UTC+11:00)所罗门群岛，新喀里多尼亚',
 'Etc/GMT-12'		=>	'(UTC+12:00)协调世界时+12',
 'Pacific/Auckland'	=>	'(UTC+12:00)奥克兰，惠灵顿',
 'Pacific/Fiji'		=>	'(UTC+12:00)斐济',
 'Asia/Kamchatka'	=>	'(UTC+12:00)阿纳德尔，彼得罗巴甫洛夫斯克-堪察加(RTZ 11)',
 'Pacific/Tongatapu'	=>	'(UTC+13:00)努库阿洛法',
 'Pacific/Apia'		=>	'(UTC+13:00)萨摩亚群岛',
 'Pacific/Kiritimati'	=>	'(UTC+14:00)圣诞岛',
 'Atlantic/Azores'	=>	'(UTC-01:00)亚速尔群岛',
 'Atlantic/Cape_Verde'	=>	'(UTC-01:00)佛得角群岛',
 'Etc/GMT+2'		=>	'(UTC-02:00)协调世界时-02',
 'America/Cayenne'	=>	'(UTC-03:00)卡宴，福塔雷萨',
 'America/Sao_Paulo'	=>	'(UTC-03:00)巴西利亚',
 'America/Buenos_Aires'	=>	'(UTC-03:00)布宜诺斯艾利斯',
 'America/Godthab'	=>	'(UTC-03:00)格陵兰',
 'America/Bahia'	=>	'(UTC-03:00)萨尔瓦多',
 'America/Montevideo'	=>	'(UTC-03:00)蒙得维的亚',
 'America/St_Johns'	=>	'(UTC-03:30)纽芬兰',
 'America/La_Paz'	=>	'(UTC-04:00)乔治敦，拉巴斯，马瑙斯，圣胡安',
 'America/Asuncion'	=>	'(UTC-04:00)亚松森',
 'America/Halifax'	=>	'(UTC-04:00)大西洋时间(加拿大)',
 'America/Cuiaba'	=>	'(UTC-04:00)库亚巴',
 'America/Caracas'	=>	'(UTC-04:30)加拉加斯',
 'America/New_York'	=>	'(UTC-05:00)东部时间(美国和加拿大)',
 'America/Indianapolis'	=>	'(UTC-05:00)印地安那州(东部)',
 'America/Bogota'	=>	'(UTC-05:00)波哥大，利马，基多，里奥布朗库',
 'America/Guatemala'	=>	'(UTC-06:00)中美洲',
 'America/Chicago'	=>	'(UTC-06:00)中部时间(美国和加拿大)',
 'America/Mexico_City'	=>	'(UTC-06:00)瓜达拉哈拉，墨西哥城，蒙特雷',
 'America/Regina'	=>	'(UTC-06:00)萨斯喀彻温',
 'America/Phoenix'	=>	'(UTC-07:00)亚利桑那',
 'America/Chihuahua'	=>	'(UTC-07:00)奇瓦瓦，拉巴斯，马萨特兰',
 'America/Denver'	=>	'(UTC-07:00)山地时间(美国和加拿大)',
 'America/Santa_Isabel'	=>	'(UTC-08:00)下加利福尼亚州',
 'America/Los_Angeles'	=>	'(UTC-08:00)太平洋时间(美国和加拿大)',
 'America/Anchorage'	=>	'(UTC-09:00)阿拉斯加',
 'Pacific/Honolulu'	=>	'(UTC-10:00)夏威夷',
 'Etc/GMT+11'		=>	'(UTC-11:00)协调世界时-11',
 'Etc/GMT+12'		=>	'(UTC-12:00)国际日期变更线西',
 'local_time'			=> '本地时间',//'Local Time',
 'function_switch'		=> '功能开关',//'Function switch',
 'login_verification_code'	=> '登录验证码',//'Login verification code',
 'gzip_compression'		=> 'Gzip压缩',//'Gzip compression',
 'offline_writing'		=> '离线写作（支持用Windows Live Writer等工具写文章）',//'Offline Writing (Support the use of tools such as Windows Live Writer to write articles)',
 'mobile_access_address'	=> '手机访问版，地址',//'Mobile Access version, address',
 'access_site_by_mobile'	=> '用手机访问你的站点',//'Access to your site using a mobile phone',
 'auto_summary'			=> '自动摘要，截取文章的前',//'Automatic summary, intercept from the post',
 'characters_as_summary'	=> '个字作为摘要',//' characters as the summary',
 'twitters'			=> '微语',//'Twitters',
 'twitters_enable'		=> '开启微语，',//'Enable twitters, ',
 '_twitters'			=> '条微语',//' twitter(s)',
 'twitter_reply_enable'		=> '开启微语回复，',//'Enable twitter reply, ',
 'reply_verification_code'	=> '回复验证码，',//'Reply verification code, ',
 'reply_audit'			=> '回复审核',//'Reply audit',
 'rss'				=> 'RSS',//'RSS',
 'export'			=> '输出',//'Export ',
 '_posts_and_output'		=> '篇文章，且输出',//' posts, and output',
 'full_text'			=> '全文',//'Full Text',
 'summary'			=> '摘要',//'Summary',
 'enable_comment_interval'	=> '开启评论，发表评论间隔',//' Enable comments, comment interval ',
 '_seconds'			=> '秒',//' seconds',
 'comment_moderation'		=> '评论审核',//'Comment moderation',
 'comment_verification_code'	=> '评论验证码',//'Comments Verification Code',
 'comment_avatar'		=> '评论人头像',//'Comments author avatar',
 'comment_must_contain_chinese'	=> '评论内容必须包含中文',//'Comments must contain Chinese',
 'comment_per_page'		=> '评论分页，',//'Comments per page, ',
 'newer'			=> '较新的',//'Newer',
 'older'			=> '较旧的',//'Older',
 'standing_in_front'		=> '排在前面',//'Standing in front',
 'upload_max_size'		=> '附件上传最大限制',//'Upload attachment maximum size',
 'php_upload_max_size'		=> '上传文件还受到服务器空间PHP配置最大上传'//'Upload file has been configured by server PHP maximum upload space ',
 'allow_attach_type'		=> '允许上传的附件类型',//'Allow attachment types to upload',
 'separate_by_comma'		=> '（多个用半角逗号分隔）',//' (Separate multiple by a comma)',
 'thumbnail_max_size'		=> '上传图片生成缩略图，最大尺寸：',//'Uploaded pictures generated thumbnail maximum size: ',
 'unit_pixels'			=> '（单位：像素）',//' (Unit: pixels)',
 'icp_reg_no'			=> 'ICP备案号',//'ICP Reg.&nbsp;No.',
 'home_footer_info'		=> '首页底部信息',//'Footer info at the Home',
 'home_footer_info_html'	=> '(支持html，可用于添加流量统计代码)',//'(HTML supported, can be used to add a traffic statistics code)',
 'save_settings'		=> '保存设置',//'Save Settings',
 'before_intercept'		=> '截取文章的前',//'Intercept before article ',

//---------------------------
//admin/views/data.php
 'data_backup'			=> '数据备份',//'Data Backup',
 'backup_delete_ok'		=> '备份文件删除成功',//'Backup file deleted successfully',
 'backup_create_ok'		=> '数据备份成功',//'Data backup created successfully',
 'backup_import_ok'		=> '备份导入成功',//'Backup imported successfully',
 'backup_file_select'		=> '请选择要删除的备份文件',//'Please select the backup file you want to delete',
 'backup_file_invalid'		=> '备份文件名错误(应由英文字母、数字、下划线组成)',//'Invalid backup file name (use only letters, digits and underscore)',
 'backup_import_zip_unsupported'	=> '服务器不支持zip，无法导入zip备份',//'Server does not support zip, can not import zip backup',
 'backup_upload_failed'			=> '上传备份失败',//'Backup Upload Failed',
 'backup_file_wrong'			=> '错误的备份文件',//'Wrong backup file',
 'backup_export_zip_unsupported'	=> '服务器不支持zip，无法导出zip备份',//'Server does not support zip, zip backup can not be exported',
 'cache_update_ok'		=> '缓存更新成功',//'Cache updated successfully',
 'backup_file'			=> '备份文件',//'Backup file',
 'backup_time'			=> '备份时间',//'Backup time',
 'file_size'			=> '文件大小',//'File size',
 'import'			=> '导入',//'Import',
 'backup_no'			=> '还没有备份',//'No backups found',
 'db_backup'			=> '备份数据库',//'Database Backup',
 'backup_create'		=> '备份数据',//'备份数据+',//'Create Backup',
 'backup_import_local'		=> '导入本地备份',//'Import Local Backup',
 'cache_update'			=> '更新缓存',//'Update cache',
 'backup_choose_table'		=> '选择要备份的数据库表',//'Choose the database table to backup',
 'backup_export_to'		=> '将站点内容数据库备份到',//'Export database backup to',
 'backup_local'			=> '本地（自己电脑）',//'Local (your computer)',
 'backup_server'		=> '服务器空间',//'Server',
 'compress_zip'			=> '压缩成zip包',//'Compress to zip format',
 'backup_file_name'		=> '备份文件名',//'Backup file name',
 'backup_start'			=> '开始备份',//'Start Backup',
 'backup_version_tip'		=> '仅可导入相同版本emlog导出的数据库备份文件，且数据库表前缀需保持一致。<br>当前数据库表前缀：',//'You can import only the same emlog version database backup files, and the database table prefix must be the same.<br>Current database table prefix: ',
 'cache_update_info'		=> '缓存可以加快站点的加载速度。通常系统会自动更新缓存，无需手动。有些特殊情况，比如缓存文件被修改、手动修改过数据库、页面出现异常等才需要手动更新。',//'Caching can speed up the site loading speed. Usually the system will automatically update the cache, no manual operation required. But in some special cases, such as the cache file or the database were modified manually, and so the page appears abnormal, it is only need to update the cache manually.',
 'cache_update'			=> '更新缓存',//'Update the cache',
 'backup_file_select'		=> '请选择要操作的备份文件',//'Please select the backup file you want to operate',
 'backup_delete_sure'		=> '你确定要删除所选备份文件吗？',//'Are you sure you want to delete the selected backup files? ',

//---------------------------
//admin/views/edit_log.php
 'draft_edit'		=> '编辑草稿',//'Edit draft',
 'post_edit'		=> '编辑文章',//'Edit post',
 'used_to_customize'	=> '用于自定义该篇文章的链接地址。需要',//'It is used to customize the article link. Needs ',
 'save_and_return'	=> '保存并返回',//'Save and Return',

//---------------------------
//admin/views/edit_page.php
 'page_edit'			=> '编辑页面',//'Edit Page',

//---------------------------
//admin/views/footer.php
 'welcome_using'	=> '欢迎使用',//'Welcome using the',

//---------------------------
//admin/views/header.php
 'admin_center'		=> '管理中心',//'AdminCP',
 'return_to_admin_center'	=> '返回管理首页',//'Return to AdminCP',
 'to_site_new_window'	=> '在新窗口浏站点',//'Visit the site in a new window',
 'to_site'		=> '查看我的站点',//'View My site',
 'settings'		=> '设置',//'Settings',
 'logout'		=> '退出',//'Logout',
 'post_write'		=> '写文章',//'Write post',
 'draft'		=> '草稿',//'Draft',
 'posts'		=> '文章',//'Posts',
 'posts_pending'	=> '篇文章待审',//' Pending posts',
 'categories'		=> '分类',//'Categories',
 'comments_pending'	=> '条评论待审',//' Pending comments',
 'exterior'		=> '外观',//'Exterior',
 'sidebar'		=> '侧边栏',//'Sidebar',
 'navigation'		=> '导航',//'Navigation',
 'pages'		=> '页面',//'Pages',
 'links'		=> '链接',//'Links',
 'friend_links'		=> '友链',//'Friend links',
 'users'		=> '用户',//'Users',
 'data'			=> '数据',//'Data Backup',
 'templates'		=> '模板',//'Templates',
 'applications'		=> '应用',//'Apps',
 'extensions'		=> '扩展功能',//'Extensions',
// '<!--Sidebar Toggle-->',//'<!--边栏折叠-->'

//---------------------------
//admin/views/index.php
 'user_info'		=> '大伟',//'User info',
 'system_settings'	=> '系统设置',//'System settings',
 'control_panel'	=> '控制台首页',//'Control panel',
 'post_number'		=> '文章数量',//'Number of articles',
 'comment_number'	=> '评论数量',//'Number of comments',
 'tasks'		=> 'Tasks',
 'pending_requests'	=> 'Pending Requests',
 'emlog_official'	=> '采用emlog系统',//'Emlog official site',
 'logout_sure'		=> 'Ready to Leave?',
 'close'		=> 'Close',
 'logout_prompt'	=> 'Select "Logout" below if you are ready to end your current session.',
 'admincp'		=> '管理首页',//'AdminCP',
 'system'		=> '系统',//'System',
 'twitter_write_placeholder'	=> '用微语记录生活 ……',//'Write some words to the twitter...',
 'cancel'			=> '取消',//'Cancel',
 'twitter_write_length'		=> '(你还可以输入140字)',//'(You can enter 140 characters maximum)',
 'site_info'			=> '站点信息',//'Site Info',
 '_comments'			=> '条评论',//' comments',
 'db_prefix'			=> '数据库表前缀',//'Database table prefix',
 'php_version'			=> 'PHP版本',//'PHP version',
 'mysql_version'		=> 'MySQL版本',//'MySQL version',
 'server_environment'		=> '服务器环境',//'Server environment',
 'gd_library'			=> 'GD图形处理库',//'GD graphic library',
 'server_max_upload_size'	=> '服务器空间允许上传最大文件',//'Maximum upload file size allowed by server',
 'more_php_info'		=> '更多信息&raquo;',//'More Info&raquo;',
 'official_news'		=> '官方消息',//'Official news',
 'using_emlog'			=> '您正在使用emlog',//'You are using emlog',
 'update_check'			=> '检查更新',//'Check for updates',
 'reading'			=> '正在读取...',//'Is reading...',
 'checking_wait'		=> '正在检查，请稍后',//'Is checking, please wait',
 'updates_no'			=> '目前还没有适合您当前版本的更新！',//'There is no updates for your current version!',
 'update_exists'		=> '有可用的emlog更新版本 ',//'It is available emlog updated version ',
 'backup_before_update'		=> ' ，更新之前请您做好数据备份工作，',//' Do not forget to make a backup before updating job, ',
 'update_now'			=> '现在更新',//'Update now',
 'update_check_failed'		=> '检查失败，可能是网络问题',//'Check failed, may be a network problem exists',
 'updating'			=> '系统正在更新中，请耐心等待',//'Updating the system, please be patient',
 'update_completed'		=> '恭喜您！更新成功了，请',//'Congratulations! Update is successfully completed, please ',
 'page_refresh'			=> '刷新页面',//'Refresh the page',
 'start_new_emlog'		=> '开始体验新版emlog',//' Start experiencing the new emlog version',
 'update_download_failed'	=> '下载更新失败，可能是服务器网络问题',//'Download the update failed, may be a network problem exists',
 'update_extract_failed'	=> '解压更新失败，可能是你的服务器空间不支持zip模块',//'Extract the update failed, may be the server does not support the zip extension',
 'update_failed_nonwritable'	=> '更新失败，目录不可写',//'Update failed, the directory is not writable',
 'update_failed'		=> '更新失败',//'Update failed',
 'you_can_enter'		=> '(你还可以输入',//'(You can enter ',
 '_characters'			=> '字',//' characters',
 'exceeds'			=> '已超出',//'has been exceeded ',
 'release'			=> '发布',//,' release',

//---------------------------
//admin/views/links.php
 'link_add'		=> '添加链接+',//'Add Link+',

//---------------------------
//admin/views/login.php
 'login'		=> '登录',//'Login',
 'user_name'		=> '用户名',//'User name',
 'password'		=> '密码',//'Password',
 'remember_me'		=> '记住我',//'Remember Me',
 'log_in'		=> ' 登 录 ',//' Log in ',
 'back_home'		=> '&laquo;返回首页',//'&laquo; Back to home',
 'password_forget'	=> '忘记密码?',//'Forgot Password?',

//---------------------------
//admin/views/navbar.php
 'nav_manage'		=> '导航管理',//'Navigation Management',
 'nav_cat_update_ok'	=> '排序更新成功',//'Category updated successfully',
 'nav_delete_ok'	=> '删除导航成功',//'Navigation deleted successfully',
 'nav_edit_ok'		=> '修改导航成功',//'Navigation modified successfully',
 'nav_add_ok'		=> '添加导航成',//'Navigation added successfully',
 'nav_name_url_empty'	=> '导航名称和地址不能为空',//'Navigation name and address can not be empty',
 'nav_no_order'		=> '没有可排序的导航',//'There is no navigation categories',
 'nav_default_nodelete'	=> '默认导航不能删除',//'You can not delete the default navigation',
 'nav_select_category'	=> '请选择要添加的分类',//'Please choose the category to add in',
 'nav_select_page'	=> '请选择要添加的页面',//'Please select the page you want to add',
 'nav_url_invalid'	=> '导航地址格式错误(需包含http等前缀)',//'Navigation address format error (must include the prefix http, etc.)',
 'nav_edit'		=> '编辑导航',//'Edit navigation',
 'nav_hide_click'	=> '点击隐藏导航',//'Click to hide navigation',
 'nav_show_click'	=> '点击显示导航',//'Click to show navigation',
 'nav_no'		=> '还没有添加导航',//'Has not yet added navigation',
 'nav_add_custom'	=> '添加自定义导航',//'Add custom navigation',
 'nav_name'		=> '导航名称',//'Navigation Name',
 'nav_url_http'		=> '地址(带http)',//'Address (with http)',
 'nav_parent'		=> '父导航',//'Parent navigation',
 'nav_add_category'	=> '添加分类到导航',//'Add categories to navigation',
 'nav_page_add'		=> '添加页面到导航',//'Add pages to navigation',
 'id'			=> '序号',//'ID',
 'navigation'		=> '导航',//'Navigation',
 'type'			=> '类型',//'Type',
 'status'		=> '状态',//'Status',
 'view'			=> '查看',//'View',
 'address'		=> '地址',//'Address',

//---------------------------
//admin/views/naviedit.php
// 'nav_name'		=> '导航名称',//'Navigation Name',

//---------------------------
//admin/views/page.php
 'page_title'		=> '页面标题',//'Page title',
 'setting_items'	=> '设置项',//'Setting items',

//---------------------------
//admin/views/plugin.php
 'plugin_manage'		=> '插件管理',//'Plugin Management',
 'plugin_upload_ok'		=> '插件上传成功，请激活使用',//'Plugin uploaded successfully, please activate it to use',
 'plugin_active_ok'		=> '插件激活成功',//'Plug-in activated successfully',
 'plugin_active_failed'		=> '插件激活失败',//'Plug-in activation failed',
 'plugin_disable_ok'		=> '插件禁用成功',//'Plug-in disabled successfully',
 'plugin_delete_failed'		=> '删除失败，请检查插件文件权限',//'Delete failed, check the plug-in file permissions',
 'status'			=> '状态',//'Status',
 'version'			=> '版本',//'Version',
 'description'			=> '描述',//'Description',
 'plugin_active_ok'		=> '点击激活插件',//'Click to activate the plug-in',
 'plugin_disable_ok'		=> '点击禁用插件',//'Click to disable the plug-in',
 'plugin_settings_click'	=> '点击设置插件',//'Click to plug-in settings',
 'more_info'			=> '更多信息&raquo;',//'More Info&raquo;',
 'plugin_no_installed'		=> '还没有安装插件',//'No installed plugins',
 'plugin_install'		=> '安装插件',//'Install plugin',

//---------------------------
//admin/views/plugin_install.php
// 'plugin_install'		=> '安装插件',//'Install plugin',
 'plugin_zipped_only'		=> '只支持zip压缩格式的插件包',//'Supports plug-in package only in zip compression format',
 'plugin_upload_failed_nonwritable'	=> '上传失败，插件目录(content/plugins)不可写',//'Upload failed, plugin directory (content/plugins) is not writable',
 'plugin_zip_nonsupport'	=> '空间不支持zip模块，请按照提示手动安装插件',//'Server does not support zip module, follow the prompts to install the plugin manually' ,
 'plugin_zip_select'		=> '请选择一个zip插件安装包',//'Please select a zipped plug-in installation package',
 'plugin_install_failed_wrong_format'	=> '安装失败，插件安装包不符合标准',//'Installation failed, plug-in installation package does not meet the standards',
 'plugin_install_manually'	=> '手动安装插件',//'Install the plug-in manually',
 'install_promt_1'		=> '1、把解压后的插件文件夹上传到 content/plugins 目录下。',//'1) Unzip the plugin file and upload it to the content/plugins directory.',
 'install_prompt2'		=> '2、登录后台进入插件管理,插件管理里已经有了该插件，点击激活即可。',//'2) Log in to AdminCP, go to Plug-in management, and if the plug-in is already listed, you can click on it to activate it.',
 'upload_install'		=> '上传安装',//'Upload installation',
 'upload_install_info'		=> '（上传一个zip压缩格式的插件安装包）',//'Upload a plug-in installation package in zip compressed format',
 'plugin_get_more'		=> '获取更多插件',//'Get More Plugins',
 'app_center'			=> '应用中心&raquo;',//'App center &raquo;',

//---------------------------
//admin/views/seo.php
 'htaccess_not_writable'	=> '保存失败：根目录下的.htaccess不可写',//'Save failed: .htaccess file in the root directory is not writable',
 'post_url_settings'		=> '文章链接设置',//'Post URL settings',
 'post_url_rewriting'		=> '你可以在这里修改文章链接的形式，如果修改后文章无法访问，那可能是你的服务器空间不支持URL重写，请修改回默认形式、关闭文章连接别名。',//'Here you can modify the form of the post link. If the post URL can not be accessed, may be your server environment does not support the URL rewriting. Please restore back the default form, and disable the article post alias connection.',
 'post_url_custom'		=> '启用链接别名后可以自定义文章和页面的链接地址。',//'You can customize the of link enabled alias address for defined articles and pages.',
 'default_format'		=> '默认形式',//'Default format',
 'file_format'			=> '文件形式',//'File format',
 'directory_format'		=> '目录形式',//'Directory format',
 'category_format'		=> '分类形式',//'Category format',
 'enable_html_suffix'		=> '启用文章链接别名html后缀',//'Enable html suffix for article link alias',
 'meta_settings'		=> 'meta信息设置',//'Meta settings',
 'meta_title'			=> '站点浏览器标题(title)',//'Site Browser Title (title)',
 'meta_keywords'		=> '站点关键字(keywords)',//'Site keywords (keywords)',
 'meta_description'		=> '站点浏览器描述(description)',//'Site Browser Description (description)',
 'meta_title_scheme'		=> '文章浏览器标题方案',//'Post browser title scheme',
 'post_title'			=> '文章标题',//'Post title',
 'post_title_site_title'	=> '文章标题 - 站点标题',//'Post title - Site title',
 'post_title_site_meta_title'	=> '文章标题 - 站点浏览器标题',//'Post title - Site browser title',

//---------------------------
//admin/views/store.php

//---------------------------
//admin/views/store_install.php
 'install'			=> '安装',//'Install',
 'package_downloading'		=> '正在下载安装中',//'Downloading package...',
 'plugin_install_ok'		=> '安装成功，',//'Plugin has been installed successfully',
 'plugin_download_failed'	=> '下载失败，可能是服务器网络问题，请手动下载安装，',//'Download failed. It may be network problem. Please, download and install manually.',
 'return_app_center'		=> '返回应用中心',//'Return to app center',
 'install_failed_zip_nonsupport'	=> '安装失败，可能是你的服务器空间不支持zip模块，请手动下载安装，',//'Installation failed. It seems your server does not support zip module. Please, download and install manually.',
 'install_failed_folder_nonwritable'	=> '安装失败，可能是应用目录不可写，',//'Installation failed. Probably, directory is not wirtable.',
 'install_failed'		=> '安装失败，',//'Installation failed.',

//---------------------------
//admin/views/style.php
 'use_this_style'	=> '点击使用该风格',//'Click to use this style',

//---------------------------
//admin/views/tag.php

//---------------------------
//admin/views/tag.php
 '_save_'	=> '保 存',//' Save ',
 '_cancel_'	=> '取 消',//' Cancel ',

//---------------------------
//admin/views/template.php
 'template_manager'		=> '模板管理',//'Template Manager',
 'template_current'		=> '当前模板',//'Current template',
 'template_mount'		=> '安装模板',//'Mounting template',
 'template_change_ok'		=> '模板更换成功',//'Template have been replaced successfully',
 'template_current_use'		=> '当前使用的模板',//'Currently used template',
 'template_damaged'		=> '已被删除或损坏，请选择其他模板。',//'This template has been damaged! Please choose another template.',
 'template_top_image'		=> '自定义顶部图片',//'Custom top image',
 'template_library'		=> '模板库',//'Template library',
 'template_upload_ok'		=> '模板上传成功',//'Template have been uploaded successfully',
 'template_delete_ok'		=> '删除模板成功',//'Template have been removed successfully',
 'template_delete_failed'	=> '删除失败，请检查模板文件权限',//'Delete failed, check the template file permissions',
 'template_use_this'		=> '点击使用该模板',//'Click to use this template',
 'template_add'			=> '添加模板+',//'Add Template',

//---------------------------
//admin/views/template_crop.php
 'image_crop'		=> '裁剪图片',//'Crop image',
 'crop_and_save'	=> '剪裁并保存',//'Crop and save',
 'crop_cancel'		=> '取消裁剪',//'Cancel crop',
 'crop_load_prompt'	=> '(页面加载完毕后，未出现选择区域时请按下鼠标左键手动拖曳选取)',//'(When page loading is completed, but it is not appear in the select area, then press the left mouse button to drag the selected manually)',

//---------------------------
//admin/views/template_install.php
 'template_zip_support'		=> '只支持zip压缩格式的模板包',//'Only supported for .zip files.',
 'template_upload_failed_nonwritable'	=> '上传失败，模板目录(content/templates)不可写',//'Upload failed. Template directory (content/templates) cannot be written.',
 'template_no_zip_install_manually'	=> 'Server does not support zip module, follow the prompts to install the template manually',//'空间不支持zip模块，请按照提示手动安装模板',
 'template_select_zip'		=> '请选择一个zip模板安装包',//'Please select a zipped template installation package',
 'template_non_standard'	=> '安装失败，模板安装包不符合标准',//'Installation failed, template installation package does not meet the standards',
 'template_install_manual'	=> '手动安装模板',//'Template manual installation',
 'template_install_prompt1'	=> '1、把解压后的模板文件夹上传到 content/templates目录下。',//'1) After extracting the template files upload the template folder to the content/templates directory.',
 'template_install_prompt2'	=> '2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。',//'2) Log in to the AdminCP to change a template. If template library already have a template you just added, then click on it to use this template.',
 'template_upload_prompt'	=> '上传一个zip压缩格式的模板安装包',//'Upload .zip file that contains installation package',
 'template_get_more'		=> '获取更多模板',//'Get more templates',

//---------------------------
//admin/views/template_top.php
 'image_replace_ok'	=> '顶部图片更换成功',//'Image has been replaced successfully.',
 'image_crop_error'	=> '裁剪图片失败',//'Image crop error',
 'top_image_unavailable'	=> '当前未使用顶部图片或者使用中的顶部图片被删除',//'Current top image is unused or deleted',
 'images_optional'	=> '可选图片',//'Optional images',
 'image_click_to_use'	=> '点击使用该图片',//'Click on image to use it',
 'top_image_not_use'	=> '不使用顶部图片',//'Do not use the top image.',
 'top_image_custom'	=> '自定义图片',//'Custom image',
 'upload'		=> '上传',//'Upload',
 'top_image_upload_prompt'	=> '(上传一张你喜欢的顶部图片，支持JPG、PNG格式)',//'(Upload your favourite picture to top. Supported formats: jpg, png.)',

//---------------------------
//admin/views/upload.php
 'attach_max_size'	=> '单个附件最大',//'Maximum size of single attachment',
 'types_allowed'	=> '允许类型',//'Allowed types',
 'attachment_add'	=> '增加附件',//'Add attachment',
 'attach_reduce'	=> '减少附件',//'Reduce attachments',

//---------------------------
//admin/views/upload_multi.php
 'browser_upgrade'	=> '您正在使用的浏览器版本太低，无法使用批量上传功能。为了更好的使用emlog，建议您升级浏览器或者换用其他浏览器。',//'Your browser is too old to display this feature. You cannot use the bulk upload. Please, upgrade your web browser or switch to another.',
 'file_select'		=> '选择文件',//'Select the file',

//---------------------------
//admin/views/user.php
 'user_management'	=> '用户管理',//'User management',
 'user_modify_ok'	=> '修改用户资料成功',//'User data has been modified successfully',
 'user_add_ok'		=> '添加用户成功',//'User has been added successfully',
 'user_name_empty'	=> '用户名不能为空',//'Username cannot be empty',
 'user_name_exists'	=> '该用户名已存在',//'The username already exists',
 'passwords_not_equal'	=> '两次输入密码不一致',//'Entered twice passwords are not equal',
 'founder_not_delete'	=> '不能删除创始人',//'You can not delete Founder',
 'founder_not_edit'	=> '不能修改创始人信息',//'Information about Founder cannot be modified',
 'founder'		=> '创始人',//'Founder',
 'admin'		=> '管理员',//'Administrator',
 'posts_need_audit'	=> '(文章需审核)',//'Posts need to be verified',
 'edit'			=> '编辑',//'Edit',
 'delete'		=> '删除',//'Delete',
 'no_authors_yet'	=> '还没有添加作者',//'No authors yet',
 '_users'		=> '位用户',//' users',
 'user_add'		=> '添加用户',//'Add user',
 'author_contributor'	=> '作者（投稿人）',//'Author (Contributor)',
 'password_min_length'	=> '密码 (大于5位)',//'Password (not less than 5 characters)',
 'password_repeat'	=> '重复密码',//'Repeat password',
 'posts_not_need_audit'	=> '文章不需要审核',//'Posts not need to be verified',
 'posts_need_audit'	=> '文章需要审核',//'Posts need to be verified',

//---------------------------
//admin/views/useredit.php
 'author_info_manage'		=> '修改作者资料',//'Author Info management',
 'password_new'			=> '新密码(不修改请留空)',//'New password (leave blank, if you do not want to modify)',
 'password_new_repeat'		=> '重复新密码',//'Repeat new password',

//---------------------------
//admin/views/widgets.php
 'widget_manage'	=> '侧边栏组件管理',//'Sidebar widget management',
 'system_widgets'	=> '系统组件',//'System widgets',
 'blogger'		=> '个人资料',//'Personal information',
 'change'		=> '更改',//'Change',
 'calendar'		=> '日历',//'Calendar',
 'twitter_latest'	=> '最新微语',//'Latest twits',
 'twitter_latest_num'	=> '首页显示最新微语数',//'Number of latest twits',
 'last_comments_num'	=> '最新评论数',//'Last comments number',
 'new_comments_home'	=> '首页最新评论数',//'Home Latest comments',
 'new_comments_length'	=> '新近评论截取字节数',//'Summary length for latest comments',
 'new_posts_show'	=> '显示最新文章数',//'Show Latest Posts',
 'new_posts_home'	=> '首页显示最新文章数',//'Show Latest Posts at Home',
 'hot_posts_home'	=> '显示热门文章数',//'Show popular posts',
 'random_post_home'	=> '首页显示随机文章数',//'Show random entries at Home',
 'widgets_custom'	=> '自定义组件',//'Custom widgets',
 'widget_untitled'	=> '未命名组件',//'Untitled widget',
 'widget_delete'	=> '删除该组件',//'Remove widget',
 'widget_custom_add'	=> '自定义一个新的组件+',//'Add new custom widget+',
 'widget_title'		=> '组件名',//'Widget title',
 'widget_content_info'	=> '内容 （支持html）',//'Content (html supported)',
 'widget_add'		=> '添加组件',//'Add widget',
 'sidebar'		=> '侧边栏',//'Sidebar',
 'widget_use'		=> '使用中的组件',//'Used widgets',
 'widget_order_save'	=> '保存组件排序',//'Save widget order',
 'widget_setting_reset'	=> '恢复出厂设置',//'Reset default widget settings',

//---------------------------
//admin/views/write.php
 'publish_time'		=> '发布时间：',//'Publish time:',
 'access_password'	=> '访问密码',//'Access Password',


);
