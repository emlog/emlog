<?php
// LANG_CORE
$lang = array(

//---------------------------
//include/lib/cache.php
 'cache_date_format'	=> 'Y年n月',//'m.Y',
 'cache_read_error'	=> '读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为可写',//'Cache read failed. If you are using a Unix/Linux host, modify the permissions of the cache directory (content/cache) and all the folders inside it to 777. If you are using a Windows host, please contact the administrator, and make all files under this directory writeable.',
 'cache_not_writable'	=> '写入缓存失败，缓存目录 (content/cache) 不可写',//'The cache directory (content/cache) is not writable.',

//---------------------------
//include/lib/calendar.php

 'weekday1'	=> '一',//'Mo',//'Monday',
 'weekday2'	=> '二',//'Tu',//'Tuesday',
 'weekday3'	=> '三',//'We',//'Wednesday',
 'weekday4'	=> '四',//'Th',//'Thursday',
 'weekday5'	=> '五',//'Fr',//'Friday',
 'weekday6'	=> '六',//'Sa',//'Saturday',
 'weekday7'	=> '日',//'Su',//'Sunday',

//---------------------------
//include/lib/function.base.php
 '_load_failed'	=> '加载失败。',//' load failed.',
 '_bytes'	=> '字节',//' bytes',
 'home'		=> '首页',//'Home',
 'first_page'	=> '首页',//'First',
 'last_page'	=> '尾页',//'Last',
 'read_more'	=> '阅读全文&gt;&gt;',//'Read more&gt;&gt;',
 '_sec_ago'	=> '秒前',//' seconds ago.',
 '_min_ago'	=> '分钟前',//' minutes ago.',
 'about_'	=> '约 ',//'~ ',
 '_hour_ago'	=> ' 小时前',//' hour(s) ago.',
 'file_size_exceeds_system'	=> '文件大小超过系统',//'File size exceeds the system limit ',
 '_limit'			=> '限制',//'',//' limit',//LEAVE THIS EMPTY???
 'upload_failed_error_code'	=> '上传文件失败,错误码：',//'Upload failed. Error code: ',
 'file_type_not_supported'	=> '错误的文件类型',//'This file type is not supported.',
 'file_size_exceeds_'		=> '文件大小超出',//'File size exceeds the limit ',
 '_of_limit'			=> '的限制',//'',//' limit',
 'upload_folder_create_error'	=> '创建文件上传目录失败',//'Failed to create file upload directory.',
 'upload_folder_unwritable'	=> '上传失败。文件上传目录(content/uploadfile)不可写',//'Upload failed. Directory (content/uploadfile) cannot be written.',
 '404_description'		=> '抱歉，你所请求的页面不存在！',//'Sorry, the page that you requested does not exist.',
 'prompt'			=> '提示信息',//'Prompt Message',
 'click_return'			=> '点击返回',//'Return back',
 'upload_ok'			=> '上传成功',//'Upload successful',

//---------------------------
//include/lib/loginauth.php
 'captcha'			=> '验证码',//'Captcha',
 'captcha_error_reenter'	=> '验证错误，请重新输入',//'Captcha error. Please, re-enter.',
 'user_name_wrong_reenter'	=> '用户名错误，请重新输入',//'Wrong username. Please, re-enter.',
 'password_wrong_reenter'	=> '密码错误，请重新输入',//'Wrong password. Please, re-enter.',
// 'no_permission'		=> '权限不足！',//'Insufficient permissions!',
 'token_error'			=> 'token error','Token error',

//---------------------------
//include/lib/option.php
 'blogger'		=> '个人资料',//'Personal info',
 'calendar'		=> '日历',//'Calendar',
 'twitter_latest'	=> '最新微语',//'Latest twits',
 'tags'			=> '标签',//'Tags',
 'category'		=> '分类',//'Category',
 'archive'		=> '存档',//'Archive',
 'new_comments'		=> '最新评论',//'Latest comments',
 'new_posts'		=> '最新文章',//'Latest posts',
 'random_post'		=> '随机文章',//'Random entry',
 'hot_posts'		=> '热门文章',//'Popular entries',
 'links'		=> '链接',//'Links',
 'search'		=> '搜索',//'Search',
 'widget_custom'	=> '自定义组件',//'Custom widget',
 'search_placeholder'	=> 'Search...and Enter',//'Search...and Enter',

//---------------------------
//include/lib/view.php
 'template_not_found'	=> '当前使用的模板已被删除或损坏，请登录后台更换其他模板。',//'The current template has been deleted or corrupted. Please please login as administrator to replace other template.',

//---------------------------------------
//include/lib/mysql.php
 'php_mysql_not_supported'	=> '服务器空间PHP不支持MySql数据库',//'Server does not support PHP MySql database',
 'db_database_unavailable'	=> '连接数据库失败，数据库地址错误或者数据库服务器不可用',//'Database connection error: The database server or database is unavailable.',
 'db_port_invalid'		=> '连接数据库失败，数据库端口错误',//'Database connection error: The database port is invalid.',
 'db_server_unavailable'	=> '连接数据库失败，数据库服务器不可用',//'Database connection error: The database server is unavailable.',
 'db_credential_error'		=> '连接数据库失败，数据库用户名或密码错误',//'Database connection error: Wrong username or password.',
 'db_error_code'		=> '连接数据库失败，请检查数据库信息。错误编号：',//'Database connection error: Please, check database information. Error code: ',
 'db_not_found'			=> '连接数据库失败，未找到您填写的数据库',//'Database connection failed. The database you filled in was not found.',
 'db_sql_error'			=> 'SQL语句执行错误',//'SQL statement execution error',

//---------------------------------------
//include/lib/mysqlii.php
 'mysqli_not_supported'		=> '服务器空间PHP不支持MySqli函数',//'Server does not support PHP MySqli extension',
// 'db_credential_error'	=> '连接数据库失败，数据库用户名或密码错误',//'Database connection error: Wrong username or password.',
// 'db_not_found'		=> '连接数据库失败，未找到您填写的数据库',//'Database connection failed. The database you filled in was not found.',
// 'db_port_invalid'		=> '连接数据库失败，数据库端口错误',//'Database connection error: The database port is invalid.',
// 'db_unavailable'		=> '连接数据库失败，数据库地址错误或者数据库服务器不可用',//'Database connection error: The database server or database is unavailable.',
// 'db_server_unavailable'	=> '连接数据库失败，数据库服务器不可用',//'Database connection error: The database server is unavailable.',
// 'db_error_code'		=> '连接数据库失败，请检查数据库信息。错误编号：',//'Database connection error: Please, check database information. Error code ',
 'db_error_name'		=> '连接数据库失败，请填写数据库名',//'Database connection error:  Please fill out the database name',
// 'db_sql_error'		=> 'SQL语句执行错误',//'SQL statement execution error',

//---------------------------------------
//include/lib/mysqlpdo.php
'pdo_not_supported'		=> '服务器空间PHP不支持PDO函数',//'Server PHP does not support PDO function',
'pdo_connect_error'		=> '连接数据库失败，请检查数据库信息。错误原因：',//'Failed to connect to the database, please check the database information. Error message: ',

//---------------------------
//content/templates/default/404.php
 '404_error'		=> '错误提示-页面未找到',//'Error - page not found.',
 '404_description'	=> '抱歉，你所请求的页面不存在！',//'Sorry, the page that you requested does not exist.',
 'click_return'		=> '&laquo;点击返回',//'&laquo;Return back',

//---------------------------
//content/templates/default/footer.php
 'powered_by'		=> 'Powered by',
 'powered_by_emlog'	=> '采用emlog系统',//'Powered by Emlog',

//---------------------------
//content/templates/default/module.php
// '_posts'			=> '篇文章',//'posts',
// 'subscribe_category'	=> '订阅该分类',//'Subscribe this category',
// 'subscribe_category'	=> '订阅该分类',//'Subscribe this category',
 'view_image'		=> '查看图片',//'View image',
 'more'			=> '更多&raquo;',//'More &raquo;',
 'site_management'	=> '管理',//'Management',
 'logout'		=> '退出',//'Logout',
 'top_posts'		=> '置顶文章',//'Top entries',
 'cat_top_posts'	=> '分类置顶文章',//'Category Top entries',
 'edit'			=> '编辑',//'Edit',
// 'category'		=> '分类',//'Category',
// 'tags'		=> '标签',//'Tags',
// 'comments'		=> '评论',//'Comments',
// 'reply'		=> '回复',//'Reply',
// 'reply'		=> '回复',//'Reply',
 'cancel_reply'		=> '取消回复',//'Cancel reply',
 'comment_leave'	=> '发表评论',//'Leave a comment',
 'nickname'		=> '昵称',//'Nicname',
 'email_optional'	=> '邮件地址 (选填)',//'E-Mail adress (optional)',
 'email'		=> '邮件地址',//'E-Mail adress',
 'homepage'		=> '个人主页',//'Homepage',
 'homepage_optional'	=> '个人主页 (选填)',//'Homepage (optional)',
 'comment_leave'	=> '发布评论',//'Post a comment',

//---------------------------
//content/templates/default/side.php
 'rss_feed'	=> 'RSS订阅',//'RSS Subscription',
 'feed_rss'	=> '订阅Rss',//'RSS Subscription',


);
