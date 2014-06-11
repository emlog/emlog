<?php
// LANG_CORE
$lang = array(

//---------------------------
//include/lib/cache.php
 'cache_date_format'	=> 'm.Y',//'Y年n月',
 'cache_read_error'	=> 'Cache read failed. If you are using a Unix/Linux host, modify the permissions of the cache directory (content/cache) and all the folders inside it to 777. If you are using a Windows host, please contact the administrator, and make all files under this directory writeable.',//'读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为可写',
 'cache_not_writable'	=> 'The cache directory (content/cache) is not writable.',//'写入缓存失败，缓存目录 (content/cache) 不可写',

//---------------------------
//include/lib/calendar.php

 'weekday1'	=> 'Monday',//'一',
 'weekday2'	=> 'Tuesday',//'二',
 'weekday3'	=> 'Wednesday',//'三',
 'weekday4'	=> 'Thursday',//'四',
 'weekday5'	=> 'Friday',//'五',
 'weekday6'	=> 'Saturday',//'六',
 'weekday7'	=> 'Sunday',//'日',

//---------------------------
//include/lib/function.base.php
 '_load_failed'	=> ' load failed.',//'加载失败。',
 '_bytes'	=> ' bytes',//'字节',
 'first_page'	=> 'First',//'首页',
 'last_page'	=> 'Last',//'尾页',
 'read_more'	=> 'Read more&gt;&gt;';//'阅读全文&gt;&gt;',
 '_sec_ago'	=> ' seconds ago.',//'秒前',
 '_min_ago'	=> ' minutes ago.',//'分钟前',
 'about_'	=> '~ ',//'约 ',
 '_hour_ago'	=> ' hour(s) ago.',//' 小时前',
 'file_size_exceeds_system'	=> 'File size exceeds the system limit ',//'文件大小超过系统 ',
 '_limit'			=> '',//' limit',//'限制',//LEAVE THIS EMPTY???
 'upload_failed_error_code'	=> 'Upload failed. Error code: ',//'上传文件失败,错误码: ',
 'file_type_not_supported'		=> 'This file type is not supported.',//'错误的文件类型',
 'file_size_exceeds_'	=> 'File size exceeds the limit ',//'文件大小超出',
 '_of_limit'		=> '',//' limit',//'的限制',
 'upload_folder_create_error'	=> 'Failed to create file upload directory.',//'创建文件上传目录失败',
 'upload_folder_unwritable'	=> 'Upload failed. Directory (content/uploadfile) cannot be written.',//'上传失败。文件上传目录(content/uploadfile)不可写',
 '404_description'			=> 'Sorry, the page that you requested does not exist.',//'抱歉，你所请求的页面不存在！',
 'prompt'		=> 'Prompt Message',//'提示信息',
 'click_return'		=> '&laquo;Return back',//'&laquo;点击返回',
//[930] MUST BE THE SAME AS IN: /admin/views/js/emo.js
 'emoticons'	=> array(
		'[Smile]'	=> '0.gif',
		'[Disappoint]'	=> '1.gif',
		'[Love]'	=> '2.gif',
		'[Crazy]'	=> '3.gif',
		'[Cool]'	=> '4.gif',
		'[Tear]'	=> '5.gif',
		'[Shy]'		=> '6.gif',
		'[Shutdown]'	=> '7.gif',
		'[Sleep]'	=> '8.gif',
		'[Cry]'		=> '9.gif',
		'[Confused]'	=> '10.gif',
		'[Evil]'	=> '11.gif',
		'[Tongue]'	=> '12.gif',
		'[Lol]'		=> '13.gif',
		'[Amazed]'	=> '14.gif',
		'[Sad]'		=> '15.gif',
		'[Displeased]'	=> '16.gif',
		'[Weary]'	=> '17.gif',
		'[Angry]'	=> '18.gif',
		'[Vomit]'	=> '19.gif',
		'[Giggle]'	=> '20.gif',
		'[Happy]'	=> '21.gif',
		'[Unsure]'	=> '22.gif',
		'[Curvedlips]'	=> '23.gif',
		'[Lick]'	=> '24.gif',
		'[Sleepy]'	=> '25.gif',
		'[Tired]'	=> '26.gif',
		'[Sweaty]'	=> '27.gif',
		'[Loud]'	=> '28.gif',
		'[Martinet]'	=> '29.gif',
		'[Pirate]'	=> '30.gif',
		'[Swear]'	=> '31.gif',
		'[Bemused]'	=> '32.gif',
		'[Secret]'	=> '33.gif',
		'[Bewitched]'	=> '34.gif',
		'[Disagree]'	=> '35.gif',
		);
//[930] 'emoticons'	=> array(
//		'[耶]'	=> '0.gif',
//		'[呵呵]'	=> '1.gif',
//		'[悲伤]'	=> '2.gif',
//		'[抓狂]'	=> '3.gif',
//		'[衰]'	=> '4.gif',
//		'[花心]'	=> '5.gif',
//		'[哼]'	=> '6.gif',
//		'[泪]'	=> '7.gif',
//		'[害羞]'	=> '8.gif',
//		'[酷]'	=> '9.gif',
//		'[晕]'	=> '10.gif',
//		'[挤眼]'	=> '11.gif',
//		'[鬼脸]'	=> '12.gif',
//		'[汗]'	=> '13.gif',
//		'[吃惊]'	=> '14.gif',
//		'[发呆]'	=> '15.gif',
//		'[闭嘴]'	=> '16.gif',
//		'[撇嘴]'	=> '17.gif',
//		'[疑问]'	=> '18.gif',
//		'[睡觉]'	=> '19.gif',
//		'[NO]'	=> '20.gif',
//		'[大哭]'	=> '21.gif',
//		'[爱你]'	=> '22.gif',
//		'[嘻嘻]'	=> '23.gif',
//		'[生病]'	=> '24.gif',
//		'[偷笑]'	=> '25.gif',
//		'[思考]'	=> '26.gif',
//		'[玫瑰]'	=> '27.gif',
//		'[心]'	=> '28.gif',
//		'[伤心]'	=> '29.gif',
//		'[咖啡]'	=> '30.gif',
//		'[音乐]'	=> '31.gif',
//		'[下雨]'	=> '32.gif',
//		'[晴天]'	=> '33.gif',
//		'[星星]'	=> '34.gif',
//		'[月亮]'	=> '35.gif',
//		);

//---------------------------
//include/lib/loginauth.php
 'captcha'			=> 'Captcha',//'验证码',
 'captcha_error_reenter'	=> 'Captcha error. Please, re-enter.',//'验证错误，请重新输入',
 'user_name_wrong_reenter'	=> 'Wrong username. Please, re-enter.',//'用户名错误，请重新输入',
 'password_wrong_reenter'	=> 'Wrong password. Please, re-enter.',//'密码错误，请重新输入',

//---------------------------
//include/lib/option.php
 'blogger'		=> 'Personal info',//'个人资料',
 'calendar'		=> 'Calendar',//'日历',
 'twitter_latest'	=> 'Latest twits',//'最新微语',
 'tags'			=> 'Tags',//'标签',
 'category'		=> 'Category',//'分类',
 'archive'		=> 'Archive',//'存档',
 'new_comments'		=> 'Latest comments',//'最新评论',
 'new_posts'		=> 'Latest posts',//'最新文章',
 'random_post'		=> 'Random entry',//'随机文章',
 'hot_posts'		=> 'Popular entries',//'热门文章',
 'links'		=> 'Links',//'链接',
 'search'		=> 'Search',//'搜索',
 'widget_custom'	=> 'Custom widget',//'自定义组件',

//---------------------------
//include/lib/view.php
 'template_not_found'	=> 'The current template has been deleted or corrupted. Please please login as administrator to replace other template.',//'当前使用的模板已被删除或损坏，请登录后台更换其他模板。',

//---------------------------------------
//include/lib/mysql.php
 'php_mysql_not_supported'	=> 'Server does not support PHP MySql database',//'服务器PHP不支持MySql数据库',
 'db_database_unavailable'	=> 'Database connection error: The database server or database is unavailable.',//'连接数据库失败，数据库地址错误或者数据库服务器不可用',
 'db_port_invalid'		=> 'Database connection error: The database port is invalid.',//'连接数据库失败，数据库端口错误',
 'db_server_unavailable'	=> 'Database connection error: The database server is unavailable.',//'连接数据库失败，数据库服务器不可用',
 'db_credential_error'		=> 'Database connection error: Wrong username or password.',//'连接数据库失败，数据库用户名或密码错误',
 'db_error_code'		=> 'Database connection error: Please, check database information. Error code ',//'连接数据库失败，请检查数据库信息。错误编号：',
 'db_not_found'			=> 'Database connection failed. The database you filled in was not found.',//'连接数据库失败，未找到您填写的数据库',
 'db_sql_error'			=> 'SQL statement execution error',//'SQL语句执行错误',

//---------------------------------------
//include/lib/mysqlii.php
 'mysqli_not_supported'		=> 'Server does not support PHP MySqli extension',//'服务器空间PHP不支持MySqli函数',
// 'db_credential_error'	=> 'Database connection error: Wrong username or password.',//'连接数据库失败，数据库用户名或密码错误',
// 'db_not_found'		=> 'Database connection failed. The database you filled in was not found.',//'连接数据库失败，未找到您填写的数据库',
// 'db_port_invalid'		=> 'Database connection error: The database port is invalid.',//'连接数据库失败，数据库端口错误',
// 'db_unavailable'		=> 'Database connection error: The database server or database is unavailable.',//'连接数据库失败，数据库地址错误或者数据库服务器不可用',
// 'db_server_unavailable'	=> 'Database connection error: The database server is unavailable.',//'连接数据库失败，数据库服务器不可用',
// 'db_error_code'		=> 'Database connection error: Please, check database information. Error code ',//'连接数据库失败，请检查数据库信息。错误编号：',
 'db_error_name'		=> 'Database connection error:  Please fill out the database name',//'连接数据库失败，请填写数据库名',
// 'db_sql_error'		=> 'SQL statement execution error',//'SQL语句执行错误',

//---------------------------
//content/templates/default/404.php
 '404_error'	=> 'Error - page not found.',//'错误提示-页面未找到',
 '404_description'	=> 'Sorry, the page that you requested does not exist.',//'抱歉，你所请求的页面不存在！',
 'click_return'		=> '&laquo;Return back',//'&laquo;点击返回',

//---------------------------
//content/templates/default/footer.php
 'powered_by'	=> 'Powered by',
 'powered_by_emlog'	=> 'Powered by Emlog',//'采用emlog系统',

//---------------------------
//content/templates/default/module.php
[46]// '_posts'			=> 'posts',//'篇文章',
[65] 'subscribe_category'	=> 'Subscribe this category',//'订阅该分类',
[75]// 'subscribe_category'	=> 'Subscribe this category',//'订阅该分类',
[95]// 'view_images'		=> 'View images',//'查看图片',
[99] 'more'			=> 'More &raquo;',//'更多&raquo;',
[232] 'site_management'		=> 'Site management',//'管理站点',
[233]// 'logout'		=> 'Logout',//'退出',
[257] 'top_posts'		=> 'Top entries',//'置顶文章',
[264]// 'edit'			=> 'Edit',//'编辑',
[275]// 'category'		=> 'Category',//'分类',
[284]// 'tags'			=> 'Tags',//'标签',
[324]// 'comments'		=> 'Comments',//'评论',
[338]// 'reply'			=> 'Reply',//'回复',
[361]// 'reply'			=> 'Reply',//'回复',
[373] 'cancel_reply'		=> 'Cancel reply',//'取消回复',
[374]// 'comment_leave'		=> 'Leave a comment',//'发表评论',
[380]// 'nickname'		=> 'Nicname',//'昵称',
[384]// 'email_optional'	=> 'E-Mail adress (optional)',//'邮件地址 (选填)',
[388]// 'homepage_optional'	=> 'Homepage (optional)',//'个人主页 (选填)',
[392]// 'comment_leave'		=> 'Leave a comment',//'发表评论',

//---------------------------
//content/templates/default/side.php
[34] 'rss_feed'	=> 'RSS Subscription',//'RSS订阅',
[34] 'feed_rss'	=> 'RSS Subscription',//'订阅Rss',


);
