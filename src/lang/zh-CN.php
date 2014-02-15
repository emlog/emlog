<?php
//emlog Simplified Chinese language PHP file

// : = ：
// ! ！
// , ，
// ( （
// ) ）
// 

$lang['install']	= '安装';//'Install';
$lang['install_program']	= '安装程序';//'Install program';
$lang['install_step1']	= '1、数据库设置 （MySQL数据库）';//'1. the database settings (MySQL database)';
$lang['install_step2']	= '2、博主设置 （用于安装成功后登录博客）';//'2. Administrator settings (for logon to the blog after the successful installation)';
$lang['install_seems_installed'] = '你的emlog看起来已经安装过了。继续安装可能会覆盖掉原有的数据，你要继续吗？';//'Your emlog seem to have installed before. Continue the installation may overwrite the original data, you want to continue? ';
$lang['install_continue']  = '继续';//'Continue';
$lang['install_post_title'] = '欢迎使用emlog';//'Welcome to emlog';
$lang['install_post_body'] = '欢迎使用emlog开始你的博客之旅。';//'Welcome to emlog! Start your blog journey now.';
$lang['install_slogan'] = '美好的生活需要用心记录';//'A happy life need to be carefullly recored.';
$lang['install_twitter'] = '用简单的文字记录你的生活';//'With a simple written records of your life';
$lang['install_admin_added']	= ' 添加成功';//' added successfully.';
$lang['install_ok']		= '恭喜，安装成功！';//'Congratulations, the installation is successful!';
$lang['install_ok_prompt']	= '您的emlog已经安装好了，现在可以开始您的创作了，就这么简单!';//'Your emlog has been installed, now you can start your creation, it is that simple!';
$lang['install_password']	= '您刚才设定的密码';//'The password you just set';
$lang['install_delete']		= '请删除根目录下安装文件(install.php)';//'Please delete the installation file (install.php)';
$lang['install_php_old']	= '您的php版本过低，请选用支持PHP5的环境安装emlog。';//'Your php version is too low, please choose an environment that supports PHP5 to install Emlog.';
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
$lang['db_connect_error'] = '连接数据库失败，数据库地址错误或者数据库服务器不可用';//'Failed to connect to the database, the database address is wrong or the database server is unavailable';
$lang['db_not_found']	= '连接数据库失败，未找到您填写的数据库';//'Failed to connect to the database, the database you filled in was not found';
$lang['db_port_error']	= '连接数据库失败，数据库端口错误';//'Failed to connect to the database, the database port is wrong';
$lang['db_server_error']	= '连接数据库失败，数据库服务器不可用';//'Failed to connect to the database, the database server is unavailable';
$lang['db_user_error']	= '连接数据库失败，数据库用户名或密码错误';//'Failed to connect to the database, the database user name or password is wrong';
$lang['db_error_code']	= '连接数据库失败，请检查数据库信息。错误编号：';//'Failed to connect to the database, please check the database information. Error number: ';

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
$lang['plugin_version']	= '版本';//'Version';
$lang['status']		= '状态';//'Status';
$lang['plugin_active'] = '已激活';//'Active';
$lang['plugin_inactive'] = '未激活';//'Inactive';
$lang['plugin_page'] = '插件主页';//'Plugin page';
$lang['plugin_repository'] = '获取更多插件';//'Emlog Plugin Repository';
$lang['plugin_activate_failed'] = '获取更多插件';//'Plug-in activation failed';
$lang['plugin_disable_all'] = '禁用所有插件';//'Disable all plugins';
$lang['plugin_reset'] = '恢复组件设置到初始安装状态';//'Reset plugin settings';
$lang['sidebar_widgets'] = '侧边栏组件管理';//'Manage sidebar widgets';
$lang['return_to_admin_center'] = '返回管理首页';//'Return to Admin Center';
$lang['site_in_new_window'] = '在新窗口浏站点';//'Browse the site in a New Window';


$lang['posts'] = '日志';//'Posts';
$lang['posted_blogs'] = '篇日志';//' blogs posted';
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
$lang['post_password'] = '文章访问密码';//'日志访问密码';//'Article Access Password';
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
$lang['homepage'] = '主页';//'homepage';
$lang['_homepage'] = '的主页';//'\'s homepage';
$lang['author_homepage'] = '作者主页';//'Author homepage';
$lang['rss_feed'] = 'RSS订阅';//'订阅Rss';//'RSS Feed';
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
$lang['blog_view'] = '浏览日志';//'查看博客';//'View Blog';
$lang['blog_view_link'] = '查看该日志';//'View the Blog';
$lang['blog_delete'] = 'Delete Blog';
$lang['blog_enter_password'] = '//输入日志访问密码';//'请输入该日志的访问密码';//'Please enter a Password to Access the Blog';
$lang['blog_password_protected'] = '该日志已设置加密';//'The blog is password protected';
$lang['blog_password_protected_info'] = '该日志已设置加密，请点击标题输入密码访问';//The blog is password protected. Click on the title to enter a password to access.';
$lang['blog_password_required'] = '该日志需要密码才能访问，请输入密码';//'The post requires a password to access, please enter the password';
$lang['blog_tags'] = '日志标签';//'Blog tags';

$lang['management'] = '站点管理';//'博客管理';//'Site Management';
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

$lang['twitter']	= '碎语';//'微语';//'Twitter';
$lang['twitters']	= '碎语';//'Twitters';
$lang['twitters_last'] = '最新碎语';//'Latest Twitters';
$lang['twitters_last_info'] = '首页显示最新碎语数';//'Show the latest twits at the homepage';
$lang['blogger_twitter'] = '博主唠叨';//'Blogger Twitter';
$lang['twitter_first_text'] = '使用微语记录您身边的新鲜事';//'Use twitter to record new things around you';
$lang['no_twitter_yet'] = 'No twitter yet!';
$lang['twitters_number'] = '首页显示twitter数';//'Number of twitters to show';
$lang['twitter_add'] = '唠叨两句';//'我要唠叨';//'Add twitter';
$lang['content'] = '内容';//'Content';

$lang['users'] = '用户';//'Users';
$lang['user'] = '用户';//'User';
$lang['user_name'] = '用户名';//'User Name';
$lang['author'] = '作者';//'Author';
$lang['user_management'] = '作者管理';//'User Management';
$lang['user_deleted_ok'] = '删除作者成功';//'Users deleted successfully';
$lang['user_edited_ok'] = '修改作者资料成功';//'User edited successfully';
$lang['user_added_ok'] = '添加作者成功';//'User added successfully';
$lang['user_name_empty'] = '用户名不能为空';//'User name should not be empty';
$lang['user_allready_exists'] = '该用户名已存在';//'This username allready exists';
$lang['user_add_info'] = '添加作者(联合撰写人)';//'Add a user (co-writer)';
$lang['user_add'] = '添加用户';//'添加作者';//'Add user';
$lang['login_modified_ok'] = '后台登录名修改成功!请重新登录';//'Login modified successfully! Please Log in.';
$lang['login_and_password_modified_ok'] = '密码和后台登录名修改成功!请重新登录';//'Login and Password modified successfully! Please Log in.';
$lang['password'] = '密码';//'Password';
$lang['password_length'] = '(大于5位)';//'(Not less than 5 characters)';
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
$lang['visit_home'] = '访问首页';//'Visit the home page';
$lang['visit_admin'] = '登录后台';//'Visit admin panel';
$lang['poster_homepage'] = 'The Home Page';
$lang['reply'] = '回复';//'Reply';
$lang['blog_reply'] = '博主回复';//'Blog reply';
$lang['cancel'] = '取消';//'Cancel';
$lang['_cancel_'] = '取 消';//'Cancel';
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

$lang['admin_center']	= '管理中心';//'管理首页';//'Admin center';
$lang['hello']		= '你好';//'Hello';
$lang['no_title']	= '无标题';//'No Title';

$lang['name_invalid'] = 'Error! Name entered is invalid.';
$lang['email_invalid'] = 'Error! Email entered is invalid.';
$lang['verification_code_empty'] = 'Error! Verification Code should not be empty.';
$lang['verification_code_invalid'] = 'Error! Verification Code is not valid.';
$lang['unclassified'] = '未分类';//'Unclassified';
$lang['title'] = '标题';//'Title';

$lang['category'] = '分类';//'Category';
$lang['categories'] = '分类';//'Categories';
$lang['categories_management'] = '分类管理';//'Categories Management';
$lang['category_choose']	= '选择分类';//'Choose category';
$lang['categories_ordered_ok'] = '排序更新成功';//'Categories ordered successfully.';
$lang['categories_deleted_ok'] = '删除分类成功';//'Categories deleted successfully.';
$lang['categories_edited_ok'] = '修改分类成功';//'Category edited successfully.';
$lang['category_added_ok'] = '添加分类成功';//'Category added successfully.';
$lang['category_is_empty'] = '分类名称不能为空';//'Category name should not be empty!';
$lang['category_name'] = '分类名称';//'Category Name';
$lang['category_order_nothing'] = '没有可排序的分类';//'There is no categories to Order';
$lang['category_add'] = '添加新分类';//'新建分类';//'Add New Category';
$lang['category_feed'] = '订阅该 分类';//'Category Feed';



$lang['advanced_options'] = '高级选项';//'Advanced Options';

$lang['save'] = '保 存';//'Save';
$lang['_save_'] = '保 存';//'Save';
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
$lang['backup_extension_invalid'] = '只能导入emlog备份的SQL文件';//'It is possible to import only SQL files backed up by emlog';
$lang['backup_format_invalid'] = '导入失败! 该备份文件不是 emlog ';//'Import failed! The backup file does not correspond emlog version ';
$lang['backup_bad_format']	= '只能导入emlog备份的压缩包，且不能修改压缩包文件名！';//'You can only import the compressed package backed up by emlog, and you cannot modify the compressed package file name!';
$lang['backup_prefix_invalid'] = '导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配 ';//'Import failed! Database Backup file prefix does not match the configured Database Prefix: ';
$lang['backup_read_error']	= '导入失败！读取文件失败';//'Import failed! Failed to read file';
$lang['backup_sql_error'] = '上传文件失败,错误码：';//'Failed to upload file, error code: ';
$lang['backup_filename'] = '备份文件名';//'Backup File name';
$lang['backup_filename_info'] = '由英文字母、数字、下划线组成';//'Backup File name can consist only latin alphabet characters, numbers, defis and underscores.';
$lang['backup_filename_invalid'] = '错误的备份文件名';//'Error! Wrong backup file name.';
$lang['backup_place'] = '备份文件保存在';//'Backup place';
$lang['backup_local'] = '本地';//'Local computer';
$lang['backup_local_file'] = '导入本地备份文件';//'Import local backup file';
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
$lang['backup_illegal_info'] = '非法提交的信息';//'Illegal information submitted';

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
$lang['photo_info'] = '头像 (推荐上传大小为120X120，格式为jpg或png的图片)';//'Avatar (Recommended size is 120x120 pixels, with jpg or png format)';
$lang['photo_delete'] = '删除头像';//'Delete Photo';
$lang['photo_deleted_ok'] = '头像删除成功';//'Photo removed successfully.';
$lang['photo_delete_failed'] = '头像删除失败';//'Photo delete failed';
$lang['nickname'] = '昵称';//'Nickname';
$lang['personal_description'] = '个人描述';//'Personal Description';
$lang['personal_data_save'] = '保存资料';//'Save Personal Data';
$lang['save changes'] = '确认修改';//'Save changes';
$lang['my_status'] = 'My status';
$lang['modify_login_password'] = '修改密码/登录名';//'Modify Login/Password';
$lang['password_current'] = '当前密码';//'Current Password';
$lang['password_new'] = '新密码';//'New Password';
$lang['password_not_less'] = '（不小于5位，不修改请留空）';//'（不小于6位，不修改请留空）';//'(not less than 5 characters)';
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
$lang['tags_by_comma'] = '日志标签，半角逗号分隔';//'Blog tags, separated by commas';

$lang['templates'] = '模板';//'Templates';
$lang['template'] = '模板';//'Template';
$lang['template_change'] = '换模板';//'Change template';
$lang['template_admin_not_found'] = 'the Admin-Center template not found!';
$lang['template_current'] = '当前模板';//'Current template';
$lang['template_changed_successfully'] = 模板更换成功;//'Template changed successfully';
$lang['templates_are_available'] = '可用模板';//'Available templates';
$lang['templates_available'] = '当前共有 个可用模板';//'Total templates available';
$lang['templates_more'] = '获取更多模板';//'More templates (Template Repository)';
$lang['template_click'] = '点击使用该模板';//'Click to use the template';
$lang['template_path_error'] = 'The Template Path Error';
$lang['template_view']		= '查看模板';//'View template';

$lang['upload'] = '上传';//'Start Upload!';
$lang['uploads'] = 'Uploads';
$lang['upload_failed_code'] = '上传文件失败,错误码:';//'Upload failed. Error code: ';
$lang['uploads_not_written'] = '上传失败。文件上传目录(content/uploadfile)不可写';//'Upload failed. File Upload Directory (content/uploadfile) can not be written';

$lang['attachments'] = '附件';//'文件 附件';//'Attachments';
$lang['attachment'] = '附件';//'Attachment';
$lang['attachment_manager'] = '附件管理';//'Attachment Manager';
$lang['attachment_create_failed'] = '创建文件上传目录失败';//'Create file upload directory failed';
$lang['attachment_upload'] = '上传附件';//'Upload attachment';
$lang['attachment_library'] = '附件库';//'Attachment gallery';
$lang['attachment_no'] = '该日志没有附件';//'No attachment here';
$lang['attachment_exceed_system_limit'] = '文件大小超过系统限制 ';//'File size exceeds the system limit ';
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
$lang['widgets_order_save'] = '保存组件排序';//'Save Widgets Order';
$lang['widget_delete'] = '删除该组件';//'Delete the Widget';
$lang['widget_name'] = '组件名';//'Widget Name';
$lang['widget_content'] = '内容 （支持html）';//'Widget Content (html supported)';
$lang['widget_new'] = '自定义一个新的组件';//'New Custom Widget';
$lang['widget_repository'] = '获取更多有趣的组件';//'Widget Repository';
$lang['widget_add'] = '添加组件';//'Add New Widget';
$lang['widgets_saved_ok'] = '设置保存成功';//'Widgets Settings saved successfuly';
$lang['widget_blogger'] = 'Blogger';//blogger
$lang['widget_blogger_info'] = '修改个人资料...';//'Modify User Personal Data';
$lang['change'] = '更改';//'Change';

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
$lang['trackback_management'] = '引用管理';//'引用通告（TrackBack）管理';//'Trackback Management';
$lang['trackback_delete_selected'] = 'Delete Selected Trackbacks';
$lang['trackback_delete_sure'] = '你确定要删除所选引用吗？';//'Are you sure you want to delete the selected trackbacks?';
$lang['trackback_deleted_ok'] = '删除引用成功';//'Trackback deleted successfully.';
$lang['trackback_select'] = '请选择要执行操作的引用';//'Please select the trackback to operate with.';
$lang['trackbacks_per_page'] = '/ 15 per page';
$lang['trackbacks_articles'] = '条引用';//' trackbacks';
$lang['trackbacks_use'] = '引用通告';//'Post trackbacks';


$lang['comments'] = '评论';//'Comments';
$lang['_comments'] = '条评论';//' comments';
$lang['comment'] = '评论';//'Comment';
$lang['comment_add'] = '发表评论';//'Add a Comment';
$lang['comment_posted_ok'] = 'Comment published successfully!';
$lang['comment_posted_premod'] = '评论发表成功，请等待管理员审核';//'Your comment saved successfully! Please wait for the administrator review and approve it!';
$lang['comments_no_yet'] = '还没有收到评论';//'No comments yet!';
$lang['comment_reply'] = '回复评论';//'Reply the comment';
$lang['comments_disabled'] = '评论失败：该日志已关闭评论';//'Add comment failed: this log has closed comments';
$lang['comment_allready_exists'] = '评论失败：已存在相同内容评论';//'Comment failed: a comment with the same content already exists';
$lang['comment_name_empty'] = '评论失败：请填写姓名';//'Comment failed: please fill in your name';
$lang['comment_name_invalid'] = '评论失败：姓名不符合规范';//'Comment failed: the name does not meet the specifications';
$lang['comment_email_invalid'] = '发表评论失败：邮件地址不符合规范';//'Failed to post a comment: the email address does not meet the specifications';
$lang['comment_admin_restricted'] = '评论失败：禁止使用管理员昵称或邮箱评论';//'Comment failed: the use of administrator nickname or email comment is prohibited';
$lang['comment_invalid'] = '发表评论失败：内容不符合规范';//'Failed to post a comment: the content does not meet the specifications';
$lang['comment_captcha_invalid'] = '发表评论失败：验证码错误';//'Failed to post a comment: verification code error';

$lang['comments_enable'] = '接受评论';//'Accept Comments';
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

$lang['comments_with_selected'] = 'With selected comments';
$lang['comments_per_page'] = '/ 15 per page';
$lang['comments_number_per_page'] = '每页评论数';//'Number of comments per page';
$lang['comments_require_approving'] = '开启评论审核';//'Require approvement for new comments';
$lang['comments_require_verification_code'] = '开启评论验证码';//'Require verification code for new comments';
$lang['comments_require_approving_info'] = '开启后评论需通过审核才能显示';//'Comments will be shown after approving only.';
$lang['comments_latest_number'] = '首页最新评论数';//'Number of latest comments at homepage';
$lang['comments_trim_length'] = '新近评论截取字节数';//'Trim comment length to N characters';
$lang['comment_error_disabled']	= '发表评论失败:该日志已关闭评论';//'Error. Comments for this post are disabled!';
$lang['comment_error_allready_exists']	= '发表评论失败:已存在相同内容评论';//'Error. The same comment content already exists!';
$lang['comment_error_invalid_name']	= '发表评论失败:姓名不符合规范';//'Error. UserName does not meet specifications!';
$lang['comment_error_invalid_email']	= '发表评论失败:邮件地址不符合规范';//'Error. Email does not meet specifications!';
$lang['comment_error_invalid_content']	= '发表评论失败:内容不符合规范';//'Error. Comment content does not meet specifications!';
$lang['comment_error_nocode']		= '发表评论失败:验证码不能为空';//'Error. You have to enter the verification code!';
$lang['comment_error_invalid_code']	= '发表评论失败:验证码错误';//'Error. You have entered invalid verification code!';
$lang['comment_error_homepage']		= '评论失败：主页地址不符合规范';//'Comment failed: Homepage address does not meet specifications';
$lang['comment_error_empty']		= '评论失败：请填写评论内容';//'Comment failed: Please fill in the comment content';

$lang['pages']			= '页面';//'Pages';
$lang['_pages']			= '个页面';//' pages';// number of!
$lang['page']			= '页面';//'Page';
$lang['page_add']		= '新建页面';//'新建一个页面';//'Add new page';
$lang['page_management']	= '页面管理';//'Page Management';
$lang['page_url']		= '转向地址';//'External page URL';
$lang['page_url_info']		= '如果填写，页面标题将指向该地址';//'If you fill out, the page title will point to this URL';
$lang['page_comments_enable']	= '页面是否接受评论';//'Enable comments for this page';
$lang['page_new_window']	= '在新窗口打开页面';//'Open the page in a new window';
$lang['page_publish']		= '发布页面';//'Publish page';
$lang['page_save']		= '保存';//'Save';
$lang['page_published_ok']	= '页面发布成功！';//'发布页面成功';//'Page published successfully!';
$lang['page_unpublished_ok']	= '禁用页面成功';//'Page unpublished successfully!';
$lang['page_saved_ok']		= '页面保存成功！';//'Page saved successfully!';
$lang['page_deleted_ok']	= '删除页面成功';//'Page deleted successfully!';
$lang['page_select_to_deal']	= '请选择要操作的页面';//'Please select the page to deal with';
$lang['page_delete_sure']	= '你确定要删除所选页面吗?';//'Are you sure you want to delete the selected page?';
$lang['page_edit']		= '编辑页面';//'Edit page';

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

$lang['can_yet_enter']	= '你还可以输入';//'You can add ';
$lang['twitter_reply_delete_sure']	= '你确定要删除该条回复吗？';//'Are you sure you want to delete the reply?';
$lang['twitter_reply_exists']		= '该回复已经存在';//'This reply already exists';
$lang['length_exceed']		= '已超出';//'Exceed the limit: ';
$lang['characters']		= '字';//'characters';
$lang['reply_captcha_enable']	= '开启回复验证码';//'Enable captcha on reply';
$lang['reply_premoderate']	= '开启回复审核';//'Enable reply premoderation';
$lang['twitters_per_page']	= '前台每页显示条数';//'Number of twitters per page';
$lang['save']			= '保存';//'Save';
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
$lang['twitter_show_front']	= '在前台显示';//'Show at the front';
$lang['write_something'] 	= '为今天写点什么吧……';//'Write something for today...';

$lang['use_mobile']		 = '用手机访问你的博客';//'Use your mobile phone to visit your blog';

$lang['error_htaccess']		= '保存失败：根目录下的.htaccess不可写';//'Failed to save: .htaccess in the root directory is not writable';
$lang['permalink_info']		= '你可以在这里修改日志链接的形式，以此提高链接的可读性和对搜索引擎的友好程度。<br />如果修改后日志无法访问，请修改回默认形式。';//'You can modify the form of the blog links here to improve the link readability and the friendliness of the search engine.<br />If the blog cannot be accessed after modification, please modify it back to the default format.';
$lang['default_format']		= '默认形式';//'Default format';
$lang['file_format']		= '文件形式';//'File format';
$lang['directory_format']	= '目录形式';//'Directory format';
$lang['category_format']	= '分类形式';//'Category format';

//$lang['template_current']	= '当前使用的模板';//'Current template';
$lang['template_not_found']	= '已被删除或损坏，请选择其他模板。';//'has been deleted or damaged, please select another template.';
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

$lang['plugin_upload_failed']	= '插件上传失败';//'Plugin upload failed';
$lang['posted_on']		= '发布于';//'posted on';
$lang['cancel_reply']		= '取消回复';//'Cancel reply';
$lang['parameter_error']	= '参数错误';//'Parameter error';
$lang['logged_as']		= '当前已登录为';//'Logged in as';

$lang['applicable_for_emlog']	= '适用于emlog：';//'Applicable to emlog: ';
$lang['template_upload_failed']	= '模板上传失败';//'Template upload failed';

$lang['link_alias']		= '链接别名';//'Link alias';
$lang['link_alias_need_to']	= '用于自定义日志链接。需要';//'used to customize the post/page link. Need to ';
$lang['link_alias_enable']	= '启用链接别名';//'Enable link alias';
$lang['link_alias_html']	= '启用日志链接别名html后缀';//'Enable html suffix for link alias';

$lang['reference_per_line']	= '每行一条引用地址';//'One reference address per line';
$lang['post_pin']		= '日志置顶';//'Pin the post';
$lang['comments_allow']		= '允许评论';//'Allow comments';
$lang['trackbacks_allow']	= '允许引用';//'Allow trackbacks';
$lang['page_comments_allow']	= '页面接受评论';//'Enable page comments';
$lang['backstage_style']	= '后台风格';//'Backstage style';
$lang['nickname_is_long']	= '昵称不能太长';//'Nickname cannot be too long';
$lang['email_format_invalid']	= '电子邮件格式错误';//'Email format error';
$lang['reply_empty']		= '回复内容不能为空';//'Reply content cannot be empty';
$lang['reply_is_long']		= '回复内容过长';//'The reply is too long';
$lang['output']			= '输出';//'Output';
$lang['posts_and_output']	= '篇日志，且输出';//' posts, and show as ';
$lang['full text']		= '全文';//'Full text';
$lang['gr_avatar']		= '评论人头像';//'Use commenter GRavatar';
$lang['comment_pagination']	= '评论分页';//'Comment pagination';
$lang['show_first']		= '排在前面';//'Show first';
$lang['newer']			= '较新的';//'Newer';
$lang['older']			= '较旧的';//'Older';
$lang['footer_info']		= '首页底部信息';//'Information at the bottom of the homepage';
$lang['footer_prompt']		= '(支持html, 可用于添加流量统计代码)';//'(Support html, can be used to add traffic statistics code)';
$lang['blog_view']		= '查看博客';//'View blog';
$lang['plugin_upload_ok']	= '插件上传成功，请激活使用';//'The plug-in is uploaded successfully, please activate it';
$lang['plugin_del_ok']		= '插件删除成功';//'Plug-in deleted successfully';
$lang['plugin_del_failed']	= '插件删除失败，请检查插件文件权限';//'Failed to delete the plug-in, please check the file permissions of the plug-in';
$lang['plugin_install']		= '安装插件';//'Install plugin';
$lang['plugin_zip_only']	= '只支持zip压缩格式的插件包';//'Only support plugin packages in zip compression format';
$lang['plugin_not_writable']	= '上传失败，请确保插件目录可写';//'Upload failed, please make sure the plugin directory is writable';
$lang['plugin_zip_nosupport']	= '空间不支持zip模块，请按照提示手动安装插件';//'Server does not support zip module, please follow the prompts to install the plug-in manually';
$lang['plugin_use_zip']		= '请选择一个zip插件安装包';//'Please select a zip plugin installation package';
$lang['plugin_non_standard']	= '安装失败，插件安装包不符合标准';//'Installation failed, the plug-in installation package does not meet the standard';
$lang['plugin_install_manually'] = '手动安装插件： <br />1、把解压后的插件文件夹上传到 content/plugins 目录下。<br />2、登录后台进入插件管理,插件管理里已经有了该插件，点击激活即可。<br />';//'Manually install the plugin:<br />1. Upload the decompressed plug-in folder to the content/plugins directory.<br />2. Log in to the background to enter the plug-in management. The plug-in already exists in the plug-in management, just click to activate it.<br />';
$lang['plugin_upload_zip']	= '请上传一个zip压缩格式的插件安装包。';//'Please upload a plug-in installation package in zip compression format.';
$lang['plugin_get_more']	= '获得更多插件';//'Get more plugins';
$lang['name']			= '名称';//'Name';
$lang['alias']			= '别名';//'Alias';
$lang['serial_number']		= '序号';//'Serial number';
$lang['alias_friendly']		= '用于URL的友好显示';//'Friendly display for URL';
$lang['alias_invalid']		= '别名错误，应由字母、数字、下划线、短横线组成';//'The alias is wrong, it should be composed of letters, numbers, underscores, and dashes';
$lang['post_links']		= '日志链接';//'Permanent links';
$lang['use_this_style']		= '点击使用该风格';//'Click to use this style';
$lang['template_install']	= '安装模板';//'Install template';
$lang['top_image_customize']	= '自定义顶部图片';//'Set top image';
$lang['template_library']	= '模板库';//'Template gallery';
$lang['template_upload_ok']	= '模板上传成功';//'The template was uploaded successfully';
$lang['template_del_ok']	= '删除模板成功';//'Template deleted successfully';
$lang['template_del_noperm']	= '删除失败，请检查模板文件权限';//'Delete failed, please check template file permissions';
$lang['twitter_use_name']	= '首页导航文字';//'Navigation text for Home';
$lang['image_crop']		= '裁剪图片';//'Crop image';
$lang['image_cut']		= '裁并保存';//'Cut and save';
$lang['cancel_crop']		= '取消裁剪';//'Cancel crop';
$lang['crop_prompt']		= '(页面加载完毕后，未出现选择区域时请按下鼠标左键手动拖曳选取)';//'(After the page is loaded, when the selection area does not appear, please press the left mouse button to manually drag and select)';
$lang['cut']			= '剪';//'Cut';
$lang['template_zip_only']	= '只支持zip压缩格式的模板包';//'Only support template package in zip compression format';
$lang['template_not_writable']	= '上传失败，请确保模板目录可写';//'Upload failed, please make sure the template directory is writable';
$lang['template_zip_nosupport'] = '空间不支持zip模块，请按照提示手动安装模板';//'Server does not support zip module, please follow the prompts to manually install the template';
$lang['template_select_zip']	= '请选择一个zip模板安装包';//'Please select a zip template installation package';
$lang['template_non_standard']	= '安装失败，模板安装包不符合标准';//'Installation failed, the template installation package does not meet the standard';
$lang['template_install_manually'] = '手动安装模板： <br />1、把解压后的模板文件夹上传到 content/templates目录下。 <br />2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。 <br />';//'Manually install the template:<br />1. Upload the decompressed template folder to the content/templates directory.<br />2. Log in to the background to change the template. The template you just added is already in the template library, just click to use it.<br />';
$lang['template_upload_zip']	= '请上传一个zip压缩格式的模板安装包。';//'Please upload a template installation package in zip format.';
$lang['top_image_replaced_ok']	= '顶部图片更换成功';//'Top image has been replaced successfully';
$lang['top_image_deleted_ok']	= '头像删除成功';//'Top image removed successfully.';
$lang['image_crop_failed']	= '裁剪图片失败';//'Failed to crop image';
$lang['top_image_damaged']	= '当前使用的顶部图片已被删除或损坏，请选择其它图片。';//'The top picture currently in use has been deleted or damaged. Please select another picture.';
$lang['image_optional']		= '可选图片';//'Optional image';
$lang['use_this_image']		= '点击使用该图片';//'Click to use this image';
$lang['custom_image']		= '自定义图片';//'Custom image';
$lang['top_image_prompt']	= '(上传一张你喜欢的顶部图片，支持JPG、PNG格式)';//'(Upload a top image you like, support JPG, PNG format)';
$lang['alias_characters']	= '别名只能由字母、数字、下划线、短横线组成';//'Aliases can only consist of letters, numbers, underscores, and dashes';
$lang['alias_unique']		= '别名不能重复';//'Alias cannot be repeated';
$lang['alias_no_system']	= '别名不得包含系统保留关键字';//'Alias must not contain system reserved keywords';
$lang['alias_no_numeric']	= '别名不能为纯数字';//'The alias cannot be a pure number';
$lang['load_failed']		= '加载失败。';//' failed to load.';
$lang['page_not_exists']	= '抱歉，你所请求的页面不存在！';//'Sorry, the page you requested does not exist!';
$lang['admin_password_len']	= '(不小于6位)';//'(Not less than 6 digits)';

$lang['no_posts_yet']		= '还没有日志';//'No posts yet';
$lang['no_pages_yet']		= '还没有页';//'还没有页面';//'No pages yet';
$lang['no_backups_yet']		= '还没有备份';//'No backups yet';
$lang['select all']		= '全选';//'Select all';
$lang['bulk_upload']		= '批量上传';//'Bulk upload';
$lang['embed']			= '插入';//'Embed';
$lang['show_perpage']		= '每页显示';//'Show per page';
$lang['keyword_perpage_max']	= '条日志';//' keywords max';
$lang['function_switch']	= '功能开关';//'Function switch';
$lang['login_captcha']		= '登录验证码';//'Login Verification Code (Captcha)';
$lang['attachment_thumb']	= '图片附件缩略图';//'Image attachment thumbnail';
$lang['gzip_compression']	= 'Gzip压缩';//'Gzip compression';
$lang['offline_writing']	= '离线写作';//'Offline writing';
$lang['site_title']		= '站点浏览器标题';//'Site META title';
$lang['twitter_enable']		= '开启微语';//'开启碎语';//'Enable Twitter';
$lang['upload_insert']		= '上传插入';//'Upload and insert';
$lang['site_view']		= '查看站点';//'View the site';
$lang['navbar']			= '导航';//'Navigation';
$lang['site_info']		= '站点信息';//'Site Information';
$lang['click_to_hide_link']	= '点击隐藏链接';//'Click to hide the link';
$lang['click_to_show_link']	= '点击显示链接';//'Click to show the link';
$lang['visible']		= '显示';//'Visible';
$lang['no_links_yet']		= '还没有添加链接';//'No links added yet';
$lang['nav_manage']		= '导航管理';//'Navigation management';
$lang['nav_del_ok']		= '删除导航成功';//'Navigation successfully deleted';
$lang['nav_edit_ok']		= '修改导航成功';//'Navigation successfully modified';
$lang['nav_add_ok']		= '添加导航成功';//'Navigation added successfully';
$lang['nav_empty']		= '导航名称和地址不能为空';//'Navigation name and address cannot be empty';
$lang['nav_no_category']	= '没有可排序的导航';//'No navigation categories';
$lang['nav_not_del']		= '默认导航不能删除';//'Default navigation cannot be deleted';
$lang['category_select']	= '请选择要添加的分类';//'Please select the category to add';
$lang['page_select']		= '请选择要添加的页面';//'Please select the page to add';
$lang['url_redirect']		= '跳转地址';//'Redirect address';
$lang['nav_edit']		= '修改导航';//'Edit navigation';
$lang['nav_hide']		= '点击隐藏导航';//'Click to hide navigation';
$lang['nav_show']		= '点击显示导航';//'Click to show navigation';
$lang['nav_no_yet']		= '还没有添加导航';//'No navigation added yet';
$lang['nav_add_custom']		= '添加自定义导航';//'Add custom navigation';
$lang['nav_name']		= '导航名称';//'Navigation name';
$lang['nav_url']		= '导航地址';//'Navigation address';
$lang['open_new_window']	= '在新窗口打开';//'Open in new window';
$lang['add']			= '添加';//'Add';
$lang['nav_add_category']	= '添加分类到导航';//'Add category to navigation';
$lang['category_no_yet']	= '还没有分类';//'No categories yet';
$lang['nav_page_add']		= '添加页面到导航';//'Add page to navigation';
$lang['no_plugin_yet']		= '还没有安装插件';//'No plugins installed yet';
$lang['official_recommendation'] = '官方推荐';//'Official recommendation';
$lang['plugin_more']		= '更多插件';//'More plugins';
$lang['alias_prompt']		= '用于自定义该页面的链接地址。';//'Used to customize the link address of this page. It is required to ';
$lang['need_for']		= '需要';//'It is required to ';

$lang['no_tags_yet']		= '还没有设置过标签！';//'No tags have been set yet!';
$lang['no_tags_yet_add']	= '还没有标签，写日志的时候可以给日志打标签';//'No tags yet. You can add tags when writing the post';
$lang['template_upload_zip']	= '(上传一个zip压缩格式的模板安装包)';//'(Upload a template installation package in zip compression format)';
$lang['template_more']		= '更多模板';//'More templates';
$lang['no_trackback_yet']	= '还没有收到引用';//'No trackbacks yet';
$lang['from_cloud']		= '来自云平台';//'From the cloud platform';
$lang['upload_bad_browser']	= '您正在使用的浏览器版本太低，无法使用批量上传功能。为了更好的使用emlog，建议您升级浏览器或者换用其他浏览器。';//'The browser version you are using is too low to use the bulk upload feature. In order to better use emlog, it is recommended that you upgrade your browser or switch to another browser.';
$lang['file_select']		= '选择文件';//'Select file';
$lang['administrator']		= '管理员';//'Administrator';
$lang['no_author_yet']		= '还没有添加作者';//'No authors added yet';

$lang['image_type_support']	= '(支持JPG、PNG格式图片)';//'(Support image format: JPG, PNG)';
$lang['comment_not_exist']	= '不存在该评论！';//'The comment does not exist!';
$lang['backup_not_emlog']	= '导入失败！该备份文件不是 emlog的备份文件!';//'Import failed! The backup file is not an emlog backup file!';
$lang['backup_bad_ver1']	= '导入失败！该备份文件不是emlog';//'Import failed! The backup file does not correspond Emlog ';
$lang['backup_bad_ver2']	= '生成的备份!';//'!';
$lang['plugin_view']		= '查看插件';//'View plugin';
$lang['image_share']		= '分享图片';//'Share image';
$lang['404_title']		= '错误提示-页面未找到';//'Error message - page not found';
$lang['not_found']		= '未找到';//'Not found';
$lang['search_no_results']	= '抱歉，没有符合您查询条件的结果。';//'Sorry, there are no results that meet your query.';
$lang['category_subscribe']	= '订阅该分类';//'Subscribe to this category';
$lang['image_view']		= '查看图片';//'View image';
$lang['article_write']		= '写文章';//'Add article';
$lang['comment_too_fast']	= '评论失败：您提交评论的速度太快了，请稍后再发表评论';//'Comment failed: You submitted a comment too fast, please comment later.';
$lang['comment_chinese']	= '评论失败：评论内容需包含中文';//'Comment failed: the content of the comment must contain Chinese characters';
$lang['captcha_invalid']	= '验证错误，请重新输入';//'Invalid verification code, please re-enter';
$lang['username_invalid']	= '用户名错误，请重新输入';//'Username is wrong, please re-enter';
$lang['password_invalid']	= '密码错误，请重新输入';//'Wrong password, please re-enter';
$lang['hot_articles']		= '热门文章';//'Popular articles';
$lang['mobile_disabled']	= '手机访问版已关闭！';//'Mobile access version has been disabled!';
$lang['reply_no_yet']		= '还没有回复！';//'No replies yet!';
$lang['twitter_content']	= '微语内容';//'Twit content';
$lang['image_select']		= '选择要上传的图片';//'Select the image to upload';
$lang['home_hot_articles']	= '首页显示热门文章数';//'Number of popular articles shown at the home page';
$lang['_users']			= '位用户';//' users';
$lang['app_center']		= '应用中心';//'App Center';
$lang['tag_empty']		= '标签不能为空';//'Tag cannot be empty';
$lang['seo_settings']		= 'SEO设置';//'SEO settings';
$lang['password_forget']	= '忘记密码?';//'Forget the password?';
$lang['image_original']		= '原图';//'Original image';
$lang['image_original_insert']	= '插入原图';//'Insert original image';
$lang['thumbnail_insert']	= '插入缩略图';//'Insert thumbnail';
$lang['comment_content']	= '评论内容';//'Comment content';
$lang['comment_edit']		= '编辑评论';//'Edit comment';
$lang['comment_edit_ok']	= '修改评论成功';//'Comment modified successfully';
$lang['comment_empty']		= '评论内容不能为空';//'Comment content cannot be empty';
$lang['nav_format_error']	= '导航地址格式错误(需包含http等前缀)';//'The navigation address format is wrong (need to include a prefix such as http)';
$lang['image_name']		= '图片名称';//'Image name';
$lang['download_install']	= '正在下载安装中';//'Downloading and installing';
$lang['back_to_appcenter']	= '返回应用中心';//'Back to App center';
$lang['download_error_manually']	= '下载失败，可能是服务器网络问题，请手动下载安装，';//'The download failed, it may be a server network problem, please download and install manually,';
$lang['decompression_error']	= '解压失败，可能是服务器不支持zip模块，请手动下载安装，';//'Decompression failed. It may be that the server does not support the zip module. Please download and install it manually.';
$lang['install_error']		= '安装失败，';//'Installation failed, ';
$lang['article_title']		= '文章标题';//'输入文章标题';//'Article title';
$lang['tags_current']		= '已有标签';//'Current article tags';
$lang['article_summary']	= '文章摘要';//'Article Summary';
$lang['article_link_alias']	= '文章链接别名';//'Article link alias';
$lang['trackback_1_perline']	= '(每行一条引用地址)';//'(1 address per line)';
$lang['mobile_version']		= '手机访问版';//'Mobile version';
$lang['mobile_use']		= '用手机访问你的站点';//'Use your mobile phone to visit your site';
$lang['_twits']			= '条微语';//' twits';
$lang['twitter_reply_enable']	= '开启微语回复';//'Enable Twitter replies';
$lang['comment_enable']		= '开启评论';//'Enable comments';
$lang['comment_delay']		= '发表评论间隔';//'Comment time interval';
$lang['_seconds']		= '秒';//' seconds';
$lang['comment_need_chinese']	= '评论内容必须包含中文';//'Comment content must contain Chinese characters';
$lang['server_zip_nosupport']	= '服务器不支持zip，无法导入zip备份';//'The server does not support zip and cannot import zip backup';
$lang['backup_upload_error']	= '上传备份失败';//'Failed to upload backup';
$lang['zip_export_error']	= '服务器不支持zip，无法导出zip备份';//'The server does not support zip and cannot export zip backup';
$lang['backup_export_to']	= '导出备份文件到';//'Export backup file to';
$lang['backup_compress']	= '压缩(zip格式)';//'Compression (zip format)';
$lang['backup_format_support']	= '(支持emlog导出的sql及zip格式备份)';//'(Supported emlog backup files in sql and zip format)';
$lang['extensions']		= '扩展功能';//'Extensions';
$lang['link_settings']		= '文章链接设置';//'Article link settings';
$lang['meta_settings']		= 'Meta设置';//'Meta settings';
$lang['meta_keywords']		= '站点关键字';//'Site meta keywords';
$lang['meta_description']	= '站点浏览器描述';//'Site meta description';
$lang['meta_title_scheme']	= '文章浏览器标题方案';//'Article meta title scheme';
$lang['article_title_site_title']	= '文章标题 - 站点标题';//'Article Title - Site Title';
$lang['article_title_site_meta_title']	= '文章标题 - 站点浏览器标题 ';//'Article Title - Site Meta Title';
$lang['article']		= '文章';//'Article';
$lang['none']			= '无';//'None';
$lang['category_parent']	= '父分类';//'Parent category';
$lang['category_description']	= '分类描述';//'Category Description';
$lang['alias_bad_format']	= '别名格式错误';//'Alias format error';
$lang['category_edit']		= '编辑分类';//'Edit category';

$lang['type']		= '类型';//'Type';
$lang['system']		= '系统';//'System';
$lang['custom']		= '自定';//'Custom';

$lang['login_name']	= '登陆名';//'Login name';
$lang['founder']	= '创始人';//'Founder';
$lang['article_need_premod']	= '(文章需审核)';//'(Articl needs to be reviewed)';
$lang['navigation_generated']	= '该导航地址由系统生成，无法修改';//'The navigation address is generated by the system and cannot be modified';
$lang['comment_hide_ok']	= '隐藏评论成功';//'Comment was hide successfully';
$lang['comment_del_from_ip']	= '删除来自该IP的所有评论';//'Delete all comments from this IP';

$lang['_pending_articles']	= '篇文章待审';//' pending articles';
$lang['top_image_no']		= '不使用顶部图片';//'Do not use top image';
$lang['founder_no_delete']	= '不能删除创始人';//'Cannot delete founder';
$lang['founder_no_edit']	= '不能修改创始人信息';//'Cannot modify founder information';
$lang['article_no_review']	= '文章不需要审核';//'The article does not need to be reviewed';
$lang['article_to_review']	= '文章需要审核';//'Article needs to be reviewed ';

$lang['plugin_setup_click']	= '点击设置插件';//'Click to set up the plugin';
$lang['article_review_ok']	= '文章审核成功';//'The article was successfully reviewed';
$lang['article_reject_ok']	= '文章驳回成功';//'The article was successfully rejected';
$lang['reject']			= '审核';//'Reject';
$lang['nickname_allready_exists'] = '该昵称已存在';//'The nickname already exists';
$lang['summary_auto']		= '自动摘要，截取文章的前';//'Automatic summary, get it from the article beginning';
$lang['summary_prompt']		= '个字作为摘要';//'Some words for a summary';
$lang['mobile_address']		= '手机访问版，地址';//'Mobile version address';
$lang['app_dir_not_writable']	= '安装失败，可能是应用目录不可写';//'Installation failed, may be the application directory is not writable';
$lang['emlog_using']		= '您正在使用emlog';//'You are using emlog';
$lang['check_update']		= '检查更新';//'Check for updates';
$lang['_articles']		= '篇文章';//' articles';

$lang['page_template']		= '页面模板';//'Page template';
$lang['page_template_file']	= '（对应模板目录下.php文件）';//'(Corresponding to the .php file in the template directory)';
$lang['category_top']		= '分类置顶';//'Top category';
$lang['attachment_max_upload']	= '附件上传最大限制';//'Maximum attachment upload limit';
$lang['attachment_php_info']	= '上传文件还受到服务器PHP配置最大上传';//'Uploaded files are also subject to the server PHP configuration maximum upload';
$lang['limit']			= '限制';//'';!!! Leave empty! for non-Chinese
$lang['separate_by_comma']	= '多个用半角逗号分隔';//'Separate multiple values by commas';
$lang['thumbnail_generate']	= '上传图片生成缩略图';//'Generate thumbnail for uploaded image';
$lang['max_size']		= '最大尺寸';//'Max size';
$lang['unit_pixel']		= '（单位：像素）';//'(Unit: pixel)';
$lang['apps']			= '应用';//'Applications';
$lang['template_log_list']	= '(用于自定义分类页面模板，默认为模板目录下log_list.php文件)';//'(Used to customize the category page template, the default is the log_list.php file in the template directory)';
$lang['article_top_home']	= '首页置顶文章';//'Top article on homepage';
$lang['article_top_category']	= '分类置顶文章';//'Top article on category';
