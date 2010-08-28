<?php
//emlog Simplified Chinese PHP language file

// : = ：
// ! ！
// , ，
// ( （
// ) ）
// 

$lang['install']	= '安装程序';//'install';
$lang['install_step1']	= '1、数据库设置 （MySQL数据库）';//'1. the database settings (MySQL database)';
$lang['install_step2']	= '2、博主设置 （用于安装成功后登录博客）';//'2. Administrator settings (for logon to the blog after the successful installation)';
$lang['install_seems_installed'] = '你的emlog看起来已经安装过了。继续安装可能会覆盖掉原有的数据，你要继续吗？';//'Your emlog seem to have installed before. Continue the installation may overwrite the original data, you want to continue? ';
$lang['install_continue']  = '继续';//'Continue';
$lang['install_post_body'] = '欢迎使用emlog开始你的博客之旅。';//'Welcome to emlog! Start your blog journey now.';
$lang['install_slogan'] = '美好的生活需要用心记录';//'A happy life need to be carefullly recored.';
$lang['install_twitter'] = '用简单的文字记录你的生活';//'With a simple written records of your life';
$lang['install_admin_added']	= ' 添加成功';//' added successfully.';
$lang['install_ok']	= '恭喜你！emlog 安装成功<br /><span style="color:red;"><b>请删除根目录下安装文件(install.php)</b></span> <a href="./"> 进入emlog </a>';//' added successfully.<br />Congratulations! emlog installed successfully.<br /><span style="color:red;"><b>Please delete the installation file (install.php) from the root directory!</b></span><br /><br /><a href="./"> Enter the emlog </a>';
$lang['install_delete']		= '请删除根目录下安装文件(install.php)';//'Please delete the installation file (install.php)';
$lang['install_php_old']	= 'emlog从3.5开始不再支持您当前的 PHP ';//'Starting from version 3.5 emlog no longer supports your current PHP ';
$lang['install_php_update']	= ' 环境，请您选用支持 PHP5 的主机，或下载 emlog3.4 安装。';//', please choose a host that supports PHP5, or download emlog3.4 and install it.';
$lang['go_to_emlog']		= '进入emlog';//'Go to Emlog';
$lang['mysql_not_supported'] = '服务器PHP不支持MySql数据库';//'Your PHP does not support MySql database.';
$lang['mysql_settings']	= '数据库设置 （MySQL数据库）';//'Database settings (MySql database)';
$lang['db_hostname']	= '数据库地址';//'Database Hostname';
$lang['db_hostname_info'] = '通常为 localhost 不必修改';//'(Usually no need to modify localhost)';
$lang['db_username']	= '数据库用户名';//'Database Username';
$lang['db_password']	= '数据库密码';//'Database Password';
$lang['db_name']	= '数据库名';//'Database Name';
$lang['db_name_info']	= '程序不会自动创建数据库，请提前创建一个空数据库或使用已有数据库';//'(Program does not automatically create the database, please create an empty database or use the existing database)';
$lang['db_prefix']	= '数据库前缀';//'Database prefix';
$lang['db_prefix_info'] = '可随意填写，由英文字母、数字、下划线组成，且必须以下划线结束';//'(Can be filled out, but by the letters of the alphabet, numbers, underscores the composition and must be underlined Ending)';
$lang['db_prefix_empty'] = '数据库前缀不能为空!'//'Database prefix should not be empty!';
$lang['db_prefix_invalid'] = '数据库前缀格式错误!'//'Database prefix format error!';
$lang['db_connect_error'] = '连接数据库失败,可能是数据库用户名或密码错误';//'Connect to database failed. Check the database username or password.';
$lang['db_not_found']	= '未找到指定数据库';//'Specified database not found.';
$lang['admin_settings'] = '博主设置 （用于安装成功后登录博客）';//'Blogger settings (used to log in to the blog after successful installation)';
$lang['admin_name']	= '博主登录名';//'Administrator Name';
$lang['admin_password'] = '博主登录密码';//'Administrator Password';
$lang['admin_password_repeat'] = '再次输入博主登录密码';//'Re-enter the Administrator Password';
$lang['admin_password_empty'] = '博主登录名和密码不能为空!'//'Administrator Name and password should not be empty!';
$lang['admin_name_added'] = '添加成功';//'added successfully';


$lang['with'] = '有';//'There are';
$lang['items'] = '条';//'items';
$lang['data'] = '数据';//'Data';
$lang['extensions'] = 'Extensions';//'功能扩展';

$lang['plugins'] = '插件';//'Plug-ins';
$lang['plugin_management'] = '插件管理';//'Plugin Management';
$lang['plugin_activated_ok'] = '插件激活成功';//'Plugin activated successfully!';
$lang['plugin_deactivated_ok'] = '插件禁用成功';//'Plugin deactivated successfully!';
$lang['plugin_name'] = '插件';//'Plugin';
$lang['plugin_version'] = '版本';//'Version';
$lang['plugin_status'] = '状态';//'Status';
$lang['plugin_active'] = '已激活';//'Active';
$lang['plugin_inactive'] = '未激活';//'Inactive';
$lang['plugin_page'] = '插件主页';//'Plugin page';
$lang['plugin_repository'] = '获取更多插件';//'Emlog Plugin Repository';
$lang['plugin_activate_failed'] = '获取更多插件';//'Plug-in activation failed';
$lang['plugin_disable_all'] = '禁用所有插件';//'Disable all plugins';
$lang['plugin_reset'] = '恢复组件设置到初始安装状态';//'Reset plugin settings';
$lang['sidebar_widgets'] = '侧边栏组件管理';//'Manage sidebar widgets';
$lang['return_to_admin_center'] = '返回管理首页';//'Return to Admin Center';
$lang['blog_view_in_new_window'] = '在新窗口浏览我的blog';//'Show the Blog in a New Window';


$lang['posts'] = '日志';//'Posts';
$lang['posted_blogs'] = '篇日志';//'blogs posted';
$lang['post_deleted_ok'] = '删除日志成功';//'Post deleted successfully';
$lang['post_recommended_ok'] = '日志置顶成功';//'Post recommended successfully';
$lang['post_unrecommended_ok'] = '取消置顶成功';//'Post removed from recommended successfully';
$lang['post_select_to_deal'] = '请选择要处理的日志';//'请选择要操作的日志';//'Please select posts to be processed';
$lang['post_what_to_do'] = '请选择要执行的操作';//'Please select what to do with the post(s)';
$lang['post_moved_ok'] = '移动日志成功';//'Post moved successfully';
$lang['post_draft_ok'] = '转入草稿箱成功';//'Post marked as Draft successfully';
$lang['post_save_and_return'] = '保存并返回';//'Save and return';
$lang['post_save_draft'] = '保存草稿';//'Save as Draft';
$lang['save'] = '保存';//'Save';
$lang['post_saved_draft_ok'] = '草稿保存成功!';//'转入草稿箱成功';//'The post saved as Draft successfully!';
$lang['post_publish'] = '发布日志';//'Publish the Post';
$lang['post_published_ok'] = '日志发布成功!';//'发布日志成功';//'The post published successfully!';
$lang['post_saved_ok'] = '页面保存成功!';//'日志保存成功!';//'The post saved successfully!';
$lang['post_author_changed_ok'] = '更改 作者成功';//'The post author changed successfully!';
$lang['post_view_in_new_window'] = '在新窗口查看';//'Show the Post in a New Window';
$lang['post_delete_sure'] = '你确定要删除所选日志吗？';//'Are you sure you want to delete the selected posts?';
$lang['post_password'] = '日志访问密码';//'Post Access Password';
$lang['post_password_leave_empty'] = '留空则不加访问密码';//'Leave Password empty if not required';
$lang['post_add'] = '写日志';//'Add Post';
$lang['post_add_new'] = '新建页面';//'Add New Post';
$lang['post_not_exists'] = '不存在该日志';//'The entry does not exist';
$lang['post_time'] = '发布时间：';//'Post Time';
$lang['post_abstract'] = '日志摘要';//'Abstract';
$lang['post_edit'] = '编辑日志';//'Edit Post';
$lang['posted_by'] = 'post by';

$lang['publish'] = '发布';//'Publish';
$lang['unpublish'] = '转入草稿箱';//'Make Draft';





$lang['yes'] = '是';//'Yes';
$lang['no'] = '否';//'No';

$lang['mail_to'] = '发邮件给';//'Mail to';
$lang['go_to'] = '访问';//'Go to';
$lang['homepage'] = '的主页';//'homepage';
$lang['author_homepage'] = '作者主页';//'Author homepage';
$lang['rss_feed'] = '订阅Rss';//'RSS Feed';
$lang['bytes'] = '字节';//' bytes';
$lang['access_disabled'] = '权限不足！';//'Insufficient privileges!';//'Access disabled';
$lang['enter'] = '进入';//'Enter';



$lang['parameter_invalid'] = '提交参数错误';//'Submitted parameters error';
$lang['calendar'] = '日历';//'Calendar';
$lang['archive'] = '归档';//'存档';//'Archive';
$lang['submit'] = '确 定';//'提交';//'Submit';
$lang['reset'] = '重 置';//'Reset';




$lang['blog'] = 'Blog';
$lang['no_blogs_yet'] = 'No blogs yet!';
$lang['blog_view'] = '浏览日志';//'View Blog';
$lang['blog_view_link'] = '查看该日志';//'View the Blog';
$lang['blog_delete'] = 'Delete Blog';
$lang['blog_enter_password'] = '//输入日志访问密码';//'请输入该日志的访问密码';//'Please enter a Password to Access the Blog';
$lang['blog_password_protected'] = '该日志已设置加密';//'The blog is password protected';
$lang['blog_password_protected_info'] = '该日志已设置加密，请点击标题输入密码访问';//The blog is password protected. Click on the title to enter a password to access.';
$lang['blog_password_required'] = '该日志需要密码才能访问，请输入密码';//'The post requires a password to access, please enter the password';
$lang['blog_tags'] = '日志标签';//'Blog tags';

$lang['management'] = '博客管理';//'Manage';
$lang['blog_author'] = '日志作者';//'Blog Author';


$lang['config_no_permission'] = '配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为everyone可写';//'Configuration file (config.php) is not written. If you are using Unix/Linux host, change the file permissions to 777. If you are using a Windows host, please contact the administrator, this file must have Write permissions for everyone';
$lang['config_saved'] = '配置文件修改成功';//'Configuration file modified successfully';

$lang['latest_comments'] = '最新评论';//'Latest comments';
$lang['latest_posts'] = '最新日志';//'Latest posts'; 
$lang['latest_posts_number'] = '首页显示最新日志数';//'Number of Latest posts to show';
$lang['random_posts'] = '随机日志';//'Random posts';
$lang['random_posts_number'] = '首页显示随机日志数';//'Number of Random post to show';

$lang['music'] = '音乐';//'Music';
$lang['music_links'] = '音乐链接:(每行一条，仅支持mp3格式)';//'Music Links: (one per line, only mp3 format supported)';
$lang['music_links_info'] = '如:http://www.emlog.net/a.mp3 音乐介绍';//'E.g.: http://www.emlog.net/a.mp3 This Music File Description';
$lang['music_random'] = '启用随机播放';//'Enable random play';
$lang['music_autoplay'] = '启用自动播放';//'Enable automatic play';
$lang['music_submit'] = '确 定';//'OK';


$lang['search'] = '搜索';//'Search';
$lang['do_search'] = '搜索';//'Go';
$lang['information'] = 'Information';
$lang['welcome_hello'] = 'Hello Blogger';
$lang['welcome_text'] = 'Thank you for use the emlog! This is the default blog, you can delete it!';
$lang['emlog_homepage'] = 'emlog官方主页';//'emlog Official Home Page';
$lang['emlog_welcome'] = 'Welcome to emlog!';
$lang['db_table'] = '数据库表';//'Database table';
$lang['db_table_created'] = '创建成功';//'created successfully';
$lang['table_create_error'] = '<b>Failed!</b>, can not successfully finish the installation, please check the mysql user has permissions to create tables';
$lang['success'] = 'Success';
$lang['sql_query_error'] = '<b>Error!</b>Can\'t execute the following sql statement, the installation can not be successfully completed.';

$lang['admin'] = 'Administrator';

$lang['sql_statement_error'] = 'SQL语句执行错误';//'SQL Statement Error';

$lang['cache'] = '数据缓存';//'Data Cache';
$lang['cache_info'] = '缓存技术可以大幅度加快你博客首页的加载速度。<br>通常系统会自动更新缓存，但也有些特殊情况需要你手动更新，比如缓存文件被无意修改、你手动修改过数据库等。';//'Caching the blog can dramatically increase the page loading speed.<br />Usually the system will automatically update the cache, but some special operations require to manually update the cache, such as cache file was no intention to amend, you manually modified, such as Database.';
$lang['cache_rebuild'] = '更新缓存';//'Rebuild the Cache';
$lang['cache_updated_ok'] = '缓存更新成功';//'Cache updated successfully';
$lang['cache_open_error'] = '读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为everyone可写';//'Cache open failed. If you are using Unix/Linux host, change the cache directory (content/cache) and all the files in it to 777 permissions. If you are using a Windows host, please contact the host administrator. Th directory and all the files must have write permission for everyone';
$lang['cache_write_error'] = '写入缓存失败，缓存目录 (content/cache) 不可写';//'Cache write failure. The cache directory (content/cache) is not written.';

$lang['read_more'] = '阅读全文';//'Read more';
$lang['about'] = 'About';
$lang['seconds_ago'] = ' 秒前';//' second ago';
$lang['minutes_ago'] = ' 分钟前';//' minutes ago';
$lang['hours_ago'] = ' 小时前';//' hours ago';
$lang['wrong_file_type'] = '错误的文件类型';//'Wrong file type';
$lang['file_size_exceeded'] = '文件大小超出';//'File size exceeded ';
$lang['restrictions'] = '的限制';//' limit';


$lang['return_back'] = '点击返回';//'Click to return back';
$lang['verification_code'] = '验证码';//'Verification Code';
$lang['first_page']	= '首页';//'First';
$lang['last_page']	= '尾页';//'Last';


$lang['monday_short']	= '一';//'Mn';
$lang['tuesday_short']	= '二';//'Tu';
$lang['wednesday_short']= '三';//'We';
$lang['thursday_short'] = '四';//'Th';
$lang['friday_short']	= '五';//'Fr';
$lang['saturday_short'] = '六';//'Sa';
$lang['sunday_short']	= '日';//'Su';

$lang['month_1']	= '一月';
$lang['month_2']	= '二月';
$lang['month_3']	= '行进';
$lang['month_4']	= '四月';
$lang['month_5']	= '可能';
$lang['month_6']	= '六月';
$lang['month_7']	= '七月';
$lang['month_8']	= '八月';
$lang['month_9']	= '九月';
$lang['month_10']	= '十月';
$lang['month_11']	= '十一月';
$lang['month_12']	= '十二月';

$lang['parameter_error'] = 'Parameter error';
$lang['send_message_form'] = 'Send message form';
$lang['remove'] = '删除';//'Remove';
$lang['previous'] = 'Previous';
$lang['next'] = 'Next';

$lang['message_send'] = 'Send a message to Administrator';

$lang['welcome_login'] = '欢迎你,你已登录';//'Welcome, you have logged';
$lang['logout'] = '退出';//'Logout';
$lang['login'] = '登录';//'Login';
$lang['remember_me'] = '记住我';//'Remember Me';


$lang['home'] = '首页';//'Home';
$lang['back_home'] = '返回主页';//'返回 首页';//'返回首页';//'Back to Homepage';
$lang['time'] = '时间';//'Time';
$lang['back_to_list'] = '返回日志列表';//'Back to blog list';

$lang['twitter']	= '碎语';//'Twitter';
$lang['twitters']	= '碎语';//'Twitters';
$lang['twitters_last'] = '最新碎语';//'Latest Twitters';
$lang['twitters_last_info'] = '首页显示最新碎语数';//'Show the latest twits at the homepage';
$lang['blogger_twitter'] = '博主唠叨';//'Blogger Twitter';
$lang['twitter_first_text'] = 'Simple language Record your life';
$lang['no_twitter_yet'] = 'No twitter yet!';
$lang['twitters_number'] = '首页显示twitter数';//'Number of twitters to show';
$lang['twitter_add'] = '唠叨两句';//'我要唠叨';//'Add twitter';
$lang['content'] = '内容';//'Content';

$lang['user'] = '用户';//'User';
$lang['users'] = '用户';//'Users';
$lang['user_name'] = '用户名';//'User Name';
$lang['author'] = '作者';//'Author';
$lang['user_management'] = '作者管理';//'User Management';
$lang['user_deleted_ok'] = '删除作者成功';//'Users deleted successfully';
$lang['user_edited_ok'] = '修改作者资料成功';//'User edited successfully';
$lang['user_added_ok'] = '添加作者成功';//'User added successfully';
$lang['user_name_empty'] = '用户名不能为空';//'User name should not be empty';
$lang['user_allready_exists'] = '该用户名已存在';//'This username allready exists';
$lang['user_add_info'] = '添加作者(联合撰写人)';//'Add the user (co-writer)';
$lang['user_add'] = '添加作者';//'Add user';
$lang['login_modified_ok'] = '后台登录名修改成功!请重新登录';//'Login modified successfully! Please Log in.';
$lang['login_and_password_modified_ok'] = '密码和后台登录名修改成功!请重新登录';//'Login and Password modified successfully! Please Log in.';
$lang['password'] = '密码';//'Password';
$lang['password_length'] = '(Not less than 5 characters)';
$lang['password_auth'] = 'Authentication Password';
$lang['password_modified_ok'] = '密码修改成功!';//'Password successfully modified!';
$lang['wrong_current_password'] = '错误的当前密码';//'Wrong current Password';
$lang['password_empty'] = 'Name and password should not be empty!';
$lang['password_short'] = '密码长度不得小于5位';//'Password should not be less than 5 characters';
$lang['password_repeat'] = '重复密码';//'Re-enter the Password';
$lang['password_not_equal'] = '两次输入的密码不一致';//'The confirmed password does not equal to the first entered password';


$lang['mail'] = '邮箱';//'mail';
$lang['email'] = '电子邮件';//'E-mail';
$lang['email_address'] = '邮件地址';//'E-mail address';
$lang['optional'] = '选填';//'optional';
$lang['visit'] = 'Visit';
$lang['poster_homepage'] = 'The Home Page';
$lang['reply'] = '回复';//'Reply';
$lang['blog_reply'] = '博主回复';//'Blog reply';
$lang['cancel'] = '取消';//'Cancel';
$lang['your_name'] = 'Your Name';
$lang['optional'] = 'Optional';
$lang['your_homepage'] = '个人主页';//'Personal Home Page';
$lang['your_comment'] = 'Your Comment Text';
$lang['powered_by'] = 'Powered by';
$lang['total_blogs'] = 'Total blogs';
$lang['subscribe'] = 'Subscribe';//订阅
$lang['subscribe_blog'] = 'Subscribe to this blog';
$lang['subscribe_category'] = 'Subscribe to this Category';
$lang['total_comments'] = 'Total Comments';



$lang['views'] = '浏览';//'阅读';//查看';//'Views';
$lang['view'] = '查看';//'View';

$lang['admin_center'] = '管理中心';//'管理首页';//'Admin center';
$lang['you_are'] = '你好';//'You are';
$lang['no_title'] = 'No Title';

$lang['name_invalid'] = 'Error! Name entered is invalid.';
$lang['email_invalid'] = 'Error! Email entered is invalid.';
$lang['verification_code_empty'] = 'Error! Verification Code should not be empty.';
$lang['verification_code_invalid'] = 'Error! Verification Code is not valid.';
$lang['unclassified'] = '未分类';//'Unclassified';
$lang['title'] = '标题';//'Title';

$lang['category'] = '分类';//'Category';
$lang['categories'] = '分类';//'Categories';
$lang['categories_management'] = '分类管理';//'Categories Management';
$lang['choose_category'] = '选择 分类...';//'Choose Category';
$lang['categories_ordered_ok'] = '排序更新成功';//'Categories ordered successfully.';
$lang['categories_deleted_ok'] = '删除分类成功';//'Categories deleted successfully.';
$lang['categories_edited_ok'] = '修改分类成功';//'Category edited successfully.';
$lang['category_added_ok'] = '添加分类成功';//'Category added successfully.';
$lang['category_is_empty'] = '分类名称不能为空';//'Category name should not be empty!';
$lang['category_name'] = '分类名称';//'Category Name';
$lang['category_order_nothing'] = '没有可排序的分类';//'There is no categories to Order';
$lang['category_add'] = '添加新分类';//'Add New Category';
$lang['category_feed'] = '订阅该 分类';//'Category Feed';



$lang['advanced_options'] = '高级选项';//'Advanced Options';

$lang['save'] = '保 存';//'Save';
$lang['save_and_return'] = 'Save and return';

$lang['all'] = '全部';//'All';
$lang['with_selected_do'] = '选中项';//'With selected do';
$lang['publish'] = 'Publish';
$lang['make_draft'] = 'Make Draft';
$lang['recommend'] = '置顶';//'Recommend';
$lang['unrecommend'] = '取消置顶';//'Unrecommend';
$lang['recommended'] = '置顶';//'Recommended';
$lang['post_recommend'] = '置顶日志';//'Recommend the post';
$lang['change_author'] = '更改作者为';//'Change author to';
$lang['move_to_category'] = '移动到分类';//'Move to category';

$lang['total'] = 'Total';
$lang['total_articles'] = 'Total articles';
$lang['articles_per_page'] = '/ 15 per page';
$lang['filters'] = 'Filters';

$lang['blog_settings'] = '博客设置';//'Blog Settings';
$lang['save_settings'] = '保存设置';//'Save Settings';
$lang['settings_saved_ok'] = '设置保存成功';//'Settings saved successfully.';

$lang['posts_manage'] = 'Posts';
$lang['data_manage'] = 'Data';
$lang['draft'] = '草稿';//'Draft';
$lang['drafts'] = '草稿箱';//'Drafts';
$lang['hide'] = '隐藏';//'Hide';
$lang['hidden'] = '隐藏';//'Hidden';
$lang['published'] = '日志管理';//'Published';
$lang['publications'] = '日志管理';//'Blog posts';
$lang['database'] = 'Database';
$lang['mysql_database'] = 'MySQL Database';
$lang['server_environment'] = '服务器环境';//'Server environment';
$lang['server_info'] = '服务器信息';//'Server information';
$lang['php_version'] = 'PHP版本';//'PHP version';
$lang['php_info'] = '更多信息';//'PHPinfo';
$lang['mysql_version'] = 'MySQL版本';//'MySQL version';
$lang['server_time'] = '服务器时间';//'Server time';
$lang['gd_library'] = 'GD图形处理库';//'GD Graphics Library version';
$lang['safe_mode'] = '安全模式';//'Safe mode';
$lang['official_info'] = '官方消息';//'Official Information';
$lang['batch_actions'] = 'Batch operation';
$lang['enabled'] = '开启';//'Enabled';
$lang['disabled'] = '关闭';//'Disabled';
$lang['loading'] = '正在读取...';//'Loading...';
$lang['there_are'] = '目前有';//'There are';

$lang['file_not_exists'] = '文件不存在';//'File does not exist';

$lang['backup'] = '数据';//'Backup';
$lang['backup_database'] = '数据备份';//'Database Backup';
$lang['backup_directory_not_writable'] = '备份失败。备份目录(content/backup)不可写';//'Backup failed. Backup directory (content/backup) is not writable.';
$lang['backup_create_file_error'] = '创建备份文件失败。备份目录(content/backup)不可写';//'Create a backup file failed. Backup directory (content/backup) is not writable.';
$lang['backup_empty'] = '数据表没有任何内容';//'Nothing to backup. Database tables have no any content.';
$lang['backup_extension_invalid'] = '读取数据库文件失败, 只能恢复 *.sql 文件';//'Database Backup File Extension is invalid. Can only restore *.sql file.';
$lang['backup_format_invalid'] = '导入失败! 该备份文件不是 emlog ';//'Import failed! The backup file does not correspond emlog version ';
$lang['backup_bad_format']	= '导入失败! 该备份文件不是 emlog 的备份文件!';//'Import failed! The backup file is not a emlog backup file! ';
$lang['backup_prefix_invalid'] = '导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配';//'Import failed! Database Backup file prefix does not match the configured Database Prefix.';
$lang['backup_not_readable']	= '导入失败! 备份文件无法读取!';//'Import failed! Can not read backup file! ';
$lang['backup_filename'] = '备份文件名';//'Backup File name';
$lang['backup_filename_info'] = '由英文字母、数字、下划线组成';//'Backup File name can consist only latin alphabet characters, numbers, defis and underscores.';
$lang['backup_filename_invalid'] = '错误的备份文件名';//'Error! Wrong backup file name.';
$lang['backup_place'] = '备份文件保存在';//'Backup place';
$lang['backup_local'] = '本地';//'Local computer';
$lang['backup_server'] = '服务器';//'Server';
$lang['backup_file'] = '备份文件';//'Filename';
$lang['backup_time'] = '备份时间';//'Time';
$lang['backup_size'] = '文件大小';//'Size';
$lang['backup_import'] = '导入';//'Import';
$lang['backup_info'] = '备份数据';//'Backup info';
$lang['backup_choose_database'] = '选择要备份的数据库表';//'Choose Database tables to Backup.';
$lang['backup_start'] = '开始备份';//'Start backup';
$lang['backup_delete_selected'] = 'Delete selected backup files';
$lang['backup_delete_sure'] = '你确定要删除所选备份文件吗？';//'Are you sure you want to delete the selected backup file?';
$lang['backup_deleted_ok'] = '备份文件删除成功';//'Backup File deleted successfully.';
$lang['backup_saved_ok'] = '数据备份成功';//'Backup File saved successfully.';
$lang['backup_imported_ok'] = '备份导入成功';//'Backup File imported successfully.';
$lang['backup_select_file'] = '请选择要删除的备份文件';//'Please select the backup files to operate with.';

$lang['enter_modifications'] = 'Please enter the modifications in the project parameters';
$lang['verification_code_not_supported'] = '开启登录验证码失败!服务器不支持该功能';//'Open Verification Code failure! Server does not support this feature.';
$lang['phpinfo_disabled'] = 'phpinfo函数被禁用!';//'phpinfo function is disabled!';
$lang['logout_ok'] = '退出成功！';//'Log out success!';
$lang['supported'] = '支持';//'Supported';
$lang['not_supported'] = '不支持';//'NOT supported';
$lang['gd_not_supported'] = 'Does not support the GD graphics library';
$lang['drafts_saved_ok'] = 'Drafts saved successfully!';
$lang['post_added_ok'] = 'Post added successfully!';
$lang['post_saved_ok'] = 'Post saved successfully!';
$lang['music_link_invalid'] = '有错误的音乐链接格式';//'Music Link has wrong format!';
$lang['image_delete'] = 'Delete image';

$lang['personal_data'] = '个人资料';//'Personal Data';
$lang['personal_data_edit'] = '修改作者资料';//'Edit Personal Data';
$lang['click_to_edit_personal_data'] = '点击修改个人资料';//'Click to Edit Personal Data';
$lang['personal_data_saved_ok'] = '个人资料修改成功';//'Personal Data saved successfully.';
$lang['photo'] = '头像';//'Photo';
$lang['photo_info'] = '头像 (推荐上传大小为185 X 230，格式为jpg或png的图片)';//'Photo (Recommended size is 185x230 pixels, in the format of jpg or png image)';
$lang['photo_delete'] = '删除头像';//'Delete Photo';
$lang['photo_deleted_ok'] = '头像删除成功';//'Photo removed successfully.';
$lang['photo_delete_failed'] = '头像删除失败';//'Photo delete failed';
$lang['nickname'] = '昵称';//'Nickname';
$lang['personal_description'] = '个人描述';//'Personal Description';
$lang['personal_data_save'] = '保存资料';//'Save Personal Data';
$lang['save changes'] = '确认修改';//'Save changes';
$lang['my_status'] = 'My status';
$lang['modify_login_password'] = '//修改密码/登录名';//'Modify Login/Password';
$lang['password_current'] = '当前密码';//'Current Password';
$lang['password_new'] = '新密码';//'New Password (not less than 5 characters)';
$lang['password_new_confirm'] = '重复新密码';//'Confirm New Password';
$lang['password_leave_empty'] = '不修改请留空';//'Leave Password empty if not changed';

$lang['unapproved'] = '未审核';//'Unapproved';
$lang['unapprove'] = '未审核';//'Unapprove';
$lang['approved'] = '审核';//'Approved';
$lang['approve'] = '审核';//'Approve';
$lang['author'] = '作者';//'Author';

$lang['blog_name'] = '博客名称';//'Blog name';
$lang['blog_description'] = '博客描述';//'Blog Description';
$lang['modify_blog_descr'] = 'Modify blog description';
$lang['blog_url'] = '博客地址';//'Blog URL';
$lang['blog_keywords'] = '博客关键字';//'Blog Keywords';


$lang['separate_keywords'] = '(关键字之间用半角逗号)","隔开';//'(Separate multiple keywords with a comma &quot;,&quot;)';
$lang['registration_number'] = 'ICP备案号';//'Registration Code';
$lang['posts_per_page'] = '每页日志数';//'Posts per page';
$lang['server_tz'] = '服务器时区';//'The server time zone';


$lang['require_login_verification'] = '开启登录验证码';//'Require the Verification Code when Log in';
$lang['url_rewrite_enable'] = '开启URL优化';//'Open URL as pseudo-static (URL rewriting)';
$lang['url_rewrite_info'] = '开启需要服务器支持，如果开启后出现日志无法访问的情况请关闭';//'Before enable this feature you MUST configure mod_rewrite settings for your server!<br>Else some published posts could not be opened.<br>Please consult the emlog documentation first!';
$lang['url_rewrite_not_supported'] = '开启URL优化失败!服务器未开启mod_rewrite模块';//'Failed to open URL Optimization! The server does not support the mod_rewrite module.';
$lang['url_rewrite_no_htaccess'] = '开启URL优化失败!未找到.htaccess文件,请将下载包内ext目录下该文件上传至根目录';//'Failed to open URL Optimization! was not found. htaccess file, please download the package ext directory of the file is uploaded to the root directory';
$lang['gzip_enable'] = '开启页面Gzip压缩';//'Compress output page with Gzip';
$lang['edit_published'] = 'Edit Published';

$lang['links'] = '链接';//'Links';
$lang['link'] = '链接';//'Link';
$lang['link_edit'] = '修改链接';//'Edit link';
$lang['link_add'] = '添加链接';//'Add link';
$lang['link_follow'] = '查看链接';//'Follow the link';
$lang['link_name'] = '名称';//'Site name';
$lang['link_url'] = '地址';//'Site URL';
$lang['link_description'] = '描述';//'Site description';
$lang['links_ordered_ok'] = '排序更新成功';//'Links ordered successfully.';
$lang['links_deleted_ok'] = '删除链接成功';//'Links deleted successfully.';
$lang['links_edited_ok'] = '修改链接成功';//'Link edited successfully.';
$lang['links_added_ok'] = '添加链接成功';//'Link added successfully.';
$lang['link_is_empty'] = '站点名称和地址不能为空';//'Site name and URL should not be empty!';
$lang['link_sort_nothing'] = '没有可排序的链接';//'There are no links ro order';

$lang['order'] = '序号';//'Order';
$lang['update_sort_order'] = '改变排序';//'Update Sort Order';
$lang['information_message'] = 'Information message';
$lang['redirect_title'] = '提示信息';//'Redirection';
$lang['redirect_click'] = '如果页面没有跳转,请点击返回!';//'If the page will not redirect automatically, click here!';

$lang['tags'] = '标签';//'Tags';
$lang['tag'] = '标签';//'Tag';
$lang['tag_not_exists'] = 'The tag does not exist';
$lang['tag_too_long'] = 'The tag is too long';
$lang['tag_too_short'] = 'The tag is too short';
$lang['tag_separate'] = 'Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签';//'Separate multiple Tags with a comma &quot;,&quot;';
$lang['tag_select'] = '选择已有标签';//'Choose your tags';
$lang['tags_management'] = '标签管理';//'Tags Management';
$lang['tags_deleted_ok'] = '删除标签成功';//'Tags deleted successfully.';
$lang['tags_edited_ok'] = '修改标签成功';//'Tag edited successfully.';
$lang['tag_select_for_delete'] = '请选择要删除的标签';//'Please select the Tag for delete.';
$lang['tags_delete_selected'] = '删除所选标签';//'Delete Selected Tags';
$lang['tag_edit'] = '标签修改';//'Edit Tag';
$lang['tag_blogs_used'] = '篇日志';//'Used in posts (times)';

$lang['templates'] = '换模板';//'Templates';
$lang['template_admin_not_found'] = 'the Admin-Center template not found!';
$lang['template_current'] = '当前模板';//'Current template';
$lang['template_changed_successfully'] = 模板更换成功;//'Template changed successfully';
$lang['templates_are_available'] = '可用模板';//'Available templates';
$lang['templates_available'] = '当前共有 个可用模板';//'Total templates available';
$lang['templates_more'] = '获取更多模板';//'More templates (Templates Repository)';
$lang['template_click'] = '点击使用该模板';//'Click to use the template';
$lang['template_path_error'] = 'The Template Path Error';


$lang['upload'] = '上传';//'Start Upload!';
$lang['uploads'] = 'Uploads';
$lang['upload_failed_code'] = '上传文件失败,错误码:';//'Upload failed. Error code: ';
$lang['uploads_not_written'] = '上传失败。文件上传目录(content/uploadfile)不可写';//'Upload failed. File Upload Directory (content/uploadfile) can not be written';

$lang['attachment_manager'] = '附件管理';//'Attachment Manager';
$lang['attachment_create_failed'] = '创建文件上传目录失败';//'Create file upload directory failed';
$lang['attachment'] = '附件';//'Attachment';
$lang['attachments'] = '附件';//'文件 附件';//'Attachments';
$lang['attachment_upload'] = '上传附件';//'Upload attachment';
$lang['attachment_library'] = '附件库';//'Attachment gallery';
$lang['attachment_no'] = '该日志没有附件';//'No attachment here';
$lang['attachment_exceed_system_limit'] = '附件大小超过系统限制';//'Attachment size exceeds the system limit ';
$lang['attachment_delete_error'] = '删除附件失败!';//'Attachment Delete failure';
$lang['attachment_increase'] = '增加附件';//'Increase attachment fields';
$lang['attachment_decrease'] = '减少附件';//'Decrease attachment fields';
$lang['attachment_max_size'] = '单个附件最大';//'Max enabled upload file size';
$lang['attachment_max_system_size'] = '服务器允许上传最大文件';//'Max enabled upload file size';
$lang['attachment_types'] = '允许类型';//'Enabled attachment types';
$lang['attachment_type_archive'] = '压缩包';//'Archive';
$lang['compressed_package'] = 'Compressed package';
$lang['attachment_embed'] = '嵌入';//'Embed';

$lang['widgets'] = '组件';//'Widgets';
$lang['widgets_custom'] = '自定义组件';//'Custom Widgets';
$lang['widget_custom'] = '未命名组件';//'Custom widget';
$lang['widgets_list'] = 'Widget List';
$lang['widgets_order'] = 'Widgets Order (drag-n-drop)';
$lang['widgets_order_save'] = '保存组件排序';//'Save Widgets Order)';
$lang['widget_delete'] = '删除该组件';//'Delete the Widget';
$lang['widget_name'] = '组件名';//'Widget Name';
$lang['widget_content'] = '内容 （支持html）';//'Widget Content (html supported)';
$lang['widget_new'] = '自定义一个新的组件';//'New Custom Widget';
$lang['widget_repository'] = '获取更多有趣的组件';//'Wiget Repository';
$lang['widget_add'] = '添加组件';//'Add New Widget';
$lang['widgets_saved_ok'] = '设置保存成功';//'Widgets Settings saved successfuly';
$lang['widget_blogger'] = 'Blogger';//blogger
$lang['widget_blogger_info'] = '修改个人资料...';//'Modify User Personal Data';
$lang['widget_change'] = '更改';//'Change';

$lang['edit'] = '编辑';//'Edit';
$lang['modify'] = '修改我的状态';//'Modify';
$lang['personal_data_modify'] = 'Modify Personal Data';

$lang['sidebar'] = '侧边栏';//'Sidebar';
$lang['description'] = '描述';//'Description';
$lang['change_my_status'] = '修改我的状态';//'Change my status';
$lang['twitter_previous'] = '较近的';//'Previous';
$lang['twitter_next'] = '较早的';//'Next';
$lang['blog_statistics'] = '信息';//'Statistics';
$lang['number_of_posts'] = '日志数量';//'Posts';
$lang['number_of_comments'] = '评论数量';//'Comments';
$lang['number_of_trackbacks'] = '引用数量';//'Trackbacks';
$lang['visits_today'] = '今日访问';//'Today Visits';
$lang['visits_total'] = '总访问量';//'Total Visits';


$lang['trackbacks'] = '引用';//'Trackbacks';
$lang['trackback'] = '引用';//'Trackback';
$lang['trackback_address'] = '引用地址';//'Reference Address';
$lang['trackback_source'] = '来源';//'Source';
$lang['trackback_url_invalid'] = 'Invalid trackback URL';
$lang['trackback_disabled'] = 'Trackbacks for this blog are disabled';
$lang['trackback_successful'] = 'Successful reception';
$lang['trackback_refused'] = 'Take the initiative to refuse to quote';
$lang['trackback_send_error'] = '发送失败';//'Send failed';
$lang['trackback_send_ok'] = '发送成功';//'Sent successfully';
$lang['trackback_notes'] = '引用通告:(Trackback，通知你所引用的日志)';//'Trackbacks: (Reference to inform you that the post quoted)';
$lang['trackback_enter'] = '每行输入一个引用地址';//'Enter trackback Addresses, one per line';
$lang['trackbacks_total'] = 'Total trackbacks';
$lang['trackback_enable'] = '接受引用？是';//'Accept trackbacks';
$lang['trackback_settings_enable'] = '开启引用通告';//'Enable trackbacks';
$lang['trackback_management'] = '引用管理';//'Trackback Management';
$lang['trackback_delete_selected'] = 'Delete Selected Trackbacks';
$lang['trackback_delete_sure'] = '你确定要删除所选引用吗？';//'Are you sure you want to delete the selected trackbacks?';
$lang['trackback_deleted_ok'] = '删除引用成功';//'Trackback deleted successfully.';
$lang['trackback_select'] = '请选择要执行操作的引用';//'Please select the trackback to operate with.';
$lang['trackbacks_per_page'] = '/ 15 per page';
$lang['trackbacks_articles'] = '条引用';//'Citations / trackbacks';
$lang['trackback_number'] = '引用通告';//'Trackbacks';


$lang['comments'] = '评论';//'条评论';//'Comments';
$lang['comment'] = '评论';//'Comment';
$lang['comment_add'] = '发表评论';//'Add a Comment';
$lang['comment_posted_ok'] = 'Comment published successfully!';
$lang['comment_posted_premod'] = '评论发表成功，请等待管理员审核';//'Your comment saved successfully! Please wait for the administrator review and approve this!';
$lang['comments_no_yet'] = 'No comments yet!';
$lang['comment_reply'] = '回复评论';//'Comment reply';
$lang['comments_disabled'] = '发表评论失败：该日志已关闭评论';//'Add Comment Failed. Comments for this Blog disabled.';
$lang['comment_allready_exists'] = '发表评论失败：已存在相同内容评论';//'Failed to post a comment: A Comment with the same content already exists.';
$lang['comment_name_invalid'] = '发表评论失败：姓名不符合规范';//'Failed to post a comment: the name does not meet the specifications';
$lang['comment_email_invalid'] = '发表评论失败：邮件地址不符合规范';//'Failed to post a comment: the email address does not meet the specifications';
$lang['comment_invalid'] = '发表评论失败：内容不符合规范';//'Failed to post a comment: the content does not meet the specifications';
$lang['comment_captcha_invalid'] = '发表评论失败：验证码错误';//'Failed to post a comment: verification code error';

$lang['comments_enable'] = '接受评论？是';//'Accept Comments';
$lang['comments_approve'] = '审核';//'Approve';
$lang['comments_approved'] = '已审核';//'Approved';
$lang['comments_unapproved'] = '未审核';//'Unapproved';
$lang['comments_replied'] = '已回复';//'Replied';
$lang['comments_management'] = '评论管理';//'Comments Management';
$lang['comments_delete_sure'] = '你确定要删除所选评论吗？';//'Are you sure you want to delete the selected comment?';
$lang['comments_deleted_ok'] = '删除评论成功';//'Comments deleted successfully.';
$lang['comments_approved_ok'] = '审核评论成功';//'Comments approved successfully.';
$lang['comments_hide'] = '屏蔽';//'Hide';
$lang['comments_hide_ok'] = '屏蔽评论成功';//'Comments hide successfully.';
$lang['comments_select'] = '请选择要执行操作的评论';//'请选择要操作的评论';//'Please select the comments to perform the operation.';
$lang['comments_select_operation'] = '请选择要执行的操作';//'Please select the operation to perform.';
$lang['comment_replied_ok'] = '回复评论成功';//'Comment replied successfully.';
$lang['comment_author'] = '所属日志';//'评论人';//'From';
$lang['from'] = '来自';//'From';
$lang['ip'] = 'IP';
$lang['hide'] = '屏蔽';//'Hide';

$lang['comments_with_selected'] = 'With seclected comments';
$lang['comments_per_page'] = '/ 15 per page';
$lang['comments_require_approving'] = '开启评论审核';//'Require approvement for new comments';
$lang['comments_require_verification_code'] = '开启评论验证码';//'Require verification code for new comments';
$lang['comments_require_approving_info'] = '开启后评论需通过审核才能显示';//'Comments will be shown after approving only.';
$lang['comments_latest_number'] = '首页最新评论数';//'Number of latest comments at homepage';
$lang['comments_trim_length'] = '新近评论截取字节数';//'Trim comment length to N characters';
$lang['comment_error_disabled'] = '发表评论失败:该日志已关闭评论';//'Error. Comments for this post are disabled!';
$lang['comment_error_allready_exists'] = '发表评论失败:已存在相同内容评论';//'Error. The same comment content already exists!';
$lang['comment_error_invalid_name'] = '发表评论失败:姓名不符合规范';//'Error. UserName does not meet specifications!';
$lang['comment_error_invalid_email'] = '发表评论失败:邮件地址不符合规范';//'Error. Email does not meet specifications!';
$lang['comment_error_invalid_content'] = '发表评论失败:内容不符合规范';//'Error. Comment content does not meet specifications!';
$lang['comment_error_nocode'] = '发表评论失败:验证码不能为空';//'Error. You have to enter the verification code!';
$lang['comment_error_invalid_code'] = '发表评论失败:验证码错误';//'Error. You have entered invalid verification code!';
$lang['comment_error_'] = 'Error. !';//

$lang['pages']	= '个页面';//'Pages';
$lang['page_add']	= '新建一个页面';//'Add new page';
$lang['page_management']	= '页面管理';//'Page Management';
$lang['page_url']	= '转向地址';//'External page URL';
$lang['page_url_info']	= '如果填写，页面标题将指向该地址';//'If you fill out, the page title will point to this URL';
$lang['page_comments_enable']	= '页面是否接受评论';//'Enable comments for this page';
$lang['page_new_window']	= '在新窗口打开页面';//'Open the page in a new window';
$lang['page_publish']	= '发布页面';//'Publish page';
$lang['page_save']	= '保存';//'Save';
$lang['page_published_ok'] = '页面发布成功！';//'发布页面成功';//'Page published successfully!';
$lang['page_unpublished_ok'] = '禁用页面成功';//'Page unpublished successfully!';
$lang['page_saved_ok']	= '页面保存成功！';//'Page saved successfully!';
$lang['page_deleted_ok']	= '删除页面成功';//'Page deleted successfully!';
$lang['page_select_to_deal']	= '请选择要操作的页面';//'Please select the page to deal with';
$lang['page_delete_sure']	= '你确定要删除所选页面吗?';//'Are you sure you want to delete the selected page?';
$lang['page_edit']	= '编辑页面';//'Edit page';

$lang['username_allready_exists'] = '用户名已存在';//'The username already exists';
$lang['enter_items'] = '请输入要修改的项目';//'Please enter the items you want to modify';

$lang['tz-12:00'] = '(标准时-12:00) 日界线西';//'[-12:00] Dateline West';
$lang['tz-11:00'] = '(标准时-11:00) 中途岛、萨摩亚群岛';//'[-11:00] Midway Island, Samoa';
$lang['tz-10:00'] = '(标准时-10:00) 夏威夷';//'[-10:00] Hawaii';
$lang['tz-09:00'] = '(标准时-9:00) 阿拉斯加';//'[-09:00] Alaska';
$lang['tz-08:00'] = '(标准时-8:00) 太平洋时间(美国和加拿大)';//'[-08:00] Pacific Time (U.S. & Canada)';
$lang['tz-07:00'] = '(标准时-7:00) 山地时间(美国和加拿大)';//'[-07:00] Mountain Time (U.S. & Canada)';
$lang['tz-06:00'] = '(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城';//'[-06:00] Central Time (U.S. & Canada), Mexico City';
$lang['tz-05:00'] = '(标准时-5:00) 东部时间(美国和加拿大)、波哥大';//'[-05:00] Eastern Time (U.S. & Canada), Bogota';
$lang['tz-04:00'] = '(标准时-4:00) 大西洋时间(加拿大)、加拉加斯';//'[-04:00] Atlantic Time (Canada), Caracas';
$lang['tz-03:30'] = '(标准时-3:30) 纽芬兰';//'[-03:30] Newfoundland';
$lang['tz-03:00'] = '(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦';//'[-03:00] Brazil, Buenos Aires, Georgetown';
$lang['tz-02:00'] = '(标准时-2:00) 中大西洋';//'[-02:00] Mid-Atlantic';
$lang['tz-01:00'] = '(标准时-1:00) 亚速尔群岛、佛得角群岛';//'[-01:00] Azores, Cape Verde Islands';
$lang['tz 00:00'] = '(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡';//'[ 00:00] Western European Time, London, Casablanca';
$lang['tz+01:00'] = '(标准时+1:00) 中欧时间、安哥拉、利比亚';//'[+01:00] Central European Time, Angola, Libya';
$lang['tz+02:00'] = '(标准时+2:00) 东欧时间、开罗，雅典';//'[+02:00] Eastern European Time, Cairo, Athens';
$lang['tz+03:00'] = '(标准时+3:00) 巴格达、科威特、莫斯科';//'[+03:00] Baghdad, Kuwait, Moscow';
$lang['tz+03:30'] = '(标准时+3:30) 德黑兰';//'[+03:30] Tehran';
$lang['tz+04:00'] = '(标准时+4:00) 阿布扎比、马斯喀特、巴库';//'[+04:00] Abu Dhabi, Muscat, Baku';
$lang['tz+04:30'] = '(标准时+4:30) 喀布尔';//'[+04:30] Kabul';
$lang['tz+05:00'] = '(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇';//'[+05:00] Ekaterinburg, Islamabad, Karachi';
$lang['tz+05:30'] = '(标准时+5:30) 孟买、加尔各答、新德里';//'[+05:30] Bombay, Calcutta, New Delhi';
$lang['tz+06:00'] = '(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚';//'[+06:00] Almaty, Dhaka, New Abelia';
$lang['tz+07:00'] = '(标准时+7:00) 曼谷、河内、雅加达';//'[+07:00] Bangkok, Hanoi, Jakarta';
$lang['tz+08:00'] = '(标准时+8:00) 北京、重庆、香港、新加坡';//'[+08:00] Beijing, Chongqing, Hong Kong, Singapore';
$lang['tz+09:00'] = '(标准时+9:00) 东京、汉城、大阪、雅库茨克';//'[+09:00] Tokyo, Seoul, Osaka, Yakutsk';
$lang['tz+09:30'] = '(标准时+9:30) 阿德莱德、达尔文';//'[+09:30] Adelaide, Darwin';
$lang['tz+10:00'] = '(标准时+10:00) 悉尼、关岛';//'[+10:00] Sydney, Guam';
$lang['tz+11:00'] = '(标准时+11:00) 马加丹、索罗门群岛';//'[+11:00] Magadan, Solomon Islands';
$lang['tz+12:00'] = '(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛';//'[+12:00] Auckland, Wellington, Kamchatka';

$lang['can_yet_enter']	= '你还可以输入';//'You can add';
$lang['twitter_reply_delete_sure']	= '你确定要删除该条回复吗？';//'Are you sure you want to delete the reply?';
$lang['twitter_reply_exists']		= '该回复已经存在';//'This reply already exists';
$lang['length_exceed']		= '已超出';//'Exceed the limit: ';
$lang['characters']		= '字';//'characters';
$lang['twitter_captcha']	= '开启回复验证码';//'Enable captcha';
$lang['twitter_trial']		= '开启回复审枧';//'Enable reply review';
$lang['twitter_premoderate']	= '开启回复审核';//'Enable twitter premoderation';
$lang['twitters_per_page']	= '前台每页显示条数';//'Number of twitters per page';
$lang['save']		= '保存';//'Save';
$lang['reply_approve']	= '回复并审核';//'Approve the reply';
$lang['base_settings']	= '基本设置';//'Basic Settings';
$lang['permalink']	= '固定链接';//'Permalink';
$lang['time_local']	= '本地时间';//'Local Time';
$lang['enable_offline_writing']	= '开启离线写作支持';//'Enable Offline Writing Support';
$lang['draft_edit']		= '编辑草稿';//'Edit draft';
$lang['pending']		= '待审';//'Pending';
$lang['approved']		= '已审';//'Approved';//'Reviewed';
$lang['comments_pending']	= '条待审';//'Pending comments';
$lang['twitter_number']		= '条碎语';//' twitters';
$lang['twitter_length_max']	= '你还可以输入140字';//'You can enter max 140 characters';
//$lang['twitter_length_max_info']	= '回复长度需在140个字内';//'The length for store must be 140 characters or less';//
$lang['twitter_not_guest']	= '抱歉，碎语未开启前台访问！';//'Sorry, twitter is not enabled for guests!';
$lang['twitter_show_front']	= '前台是否显示';//'Whether to display at the front';
$lang['write_something'] 	= '为今天写点什么吧……';//'Write something for today...';

$lang['use_mobile']		 = '用手机访问你的博客';//'Use your mobile phone to visit your blog';

$lang['error_htaccess']		= '保存失败：根目录下的.htaccess不可写';//'Failed to save: .htaccess in the root directory is not writable';
$lang['permalink_info']		= '你可以在这里修改日志链接的形式，以此提高链接的可读性和对搜索引擎的友好程度。<br />如果修改后日志无法访问，请修改回默认形式。';//'You can modify the form of the blog links here to improve the link readability and the friendliness of the search engine.<br />If the blog cannot be accessed after modification, please modify it back to the default format.';
$lang['default_format']		= '默认形式';//'Default format';
$lang['file_format']		= '文件形式';//'File format';
$lang['directory_format']	= '目录形式';//'Directory format';
$lang['template_current']	= '当前使用的模板(';//'The currently used template (';
$lang['template_not_found']	= ')已被删除或损坏，请选择其他模板。';//') has been deleted or damaged, please select another template.';
$lang['template_damaged']	= '当前使用的模板已被删除或损坏，请登录后台更换其他模板。';//'The currently used template has been deleted or damaged, please log in to the background to replace other templates.';

$lang['posted_ok']	= '发布成功';//'Published successfully';
$lang['twitter_del_ok']	= '碎语删除成功';//'Twit deleted successfully';
$lang['twitter_empty']	= '碎语内容不能为空';//'Twit content cannot be empty';
$lang['settings'] 	= '设置';//'Settings';
$lang['change'] = '更改';//'Change';
$lang['more'] = '更多',//'More';
$lang['twit_post'] = '发布碎语';//'Post a twit';
$lang['approximately'] = '约 ';//'approximately ';
$lang['entry_not_exists']	= '不存在该条目';//'The entry does not exist';
$lang['sure']			= '确定';//'Sure';
$lang['log_in']			= ' 登 录 ';//' Log in ';
$lang['return']			= '返回';//'Return';
$lang['email_optional']		= '邮件地址 (选填)';//'Email address (optional)';
$lang['homepage_optional']	= '个人主页 (选填)';//'Personal homepage (optional)';
$lang['twitter_send']		= '发碎语';//'Send the twit';
$lang['summary']		= '摘要';//'Summary';

$lang['xmlrpc_disabled']	= '提示:博客XMLRPC服务未开启.';//'Tip: The blog XMLRPC service is not enabled.';
$lang['xmlrpc_error_post']	= '错误:XML-RPC服务器只能接受POST数据';//'Error: XML-RPC server can only accept POST data';
$lang['xmlrpc_empty']		= '错误:提交数据内容为空';//'Error: The submitted data content is empty';
$lang['post_not_exists']	= '对不起,您访问日志不存在';//'Sorry, the blog you tried to access does not exist';
$lang['post_not_found']		= '没有日志';//'Post not found';
$lang['file_error']		= '文件错误';//'File error';
$lang['file_name_error']	= '文件名错误';//'File name error';
$lang['file_type_error']	= '文件类型错误';//'File type error';
$lang['file_write_error']	= '文件无法写入';//'File cannot be written';
$lang['user_name_pass_wrong']	= '用户名密码错误';//'Username or password is wrong';
