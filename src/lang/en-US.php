<?php
//emlog ENGLISH language PHP file

// : = ：
// ! ！
// , ，
// ( （
// ) ）
// 

$lang['install']	= 'Install';//'安装';
$lang['install_program']	= 'Install program';//'安装程序';
$lang['install_step1']	= '1. the database settings (MySQL database)';//1、数据库设置 （MySQL数据库）
$lang['install_step2']	= '2. Administrator settings (for logon to the blog after the successful installation)';//2、博主设置 （用于安装成功后登录博客）
$lang['install_seems_installed'] = 'Your emlog seem to have installed before. Continue the installation may overwrite the original data, you want to continue? ';//你的emlog看起来已经安装过了。继续安装可能会覆盖掉原有的数据，你要继续吗？
$lang['install_continue']  = 'Continue';//继续
$lang['install_post_title'] = 'Welcome to emlog';//'欢迎使用emlog';
$lang['install_post_body'] = 'Welcome to emlog! Start your blog journey now.';//欢迎使用emlog开始你的博客之旅。
$lang['install_slogan'] = 'A happy life need to be carefullly recored.';//美好的生活需要用心记录
$lang['install_twitter'] = 'With a simple written records of your life';//用简单的文字记录你的生活
$lang['install_admin_added']	= 'added successfully.';//' 添加成功';
$lang['install_ok']		= 'Congratulations, the installation is successful!';//'恭喜，安装成功！';
$lang['install_ok_prompt']	= 'Your emlog has been installed, now you can start your creation, it is that simple!';//'您的emlog已经安装好了，现在可以开始您的创作了，就这么简单!';
$lang['install_password']	= 'The password you just set';//'您刚才设定的密码';
$lang['install_delete']		= 'Please delete the installation file (install.php)';//'请删除根目录下安装文件(install.php)';
$lang['install_php_old']	= 'Your php version is too low, please choose an environment that supports PHP5 to install Emlog.';//'您的php版本过低，请选用支持PHP5的环境安装emlog。';
$lang['install_php_update']	= ' Choose a host that supports PHP5, or download and install emlog v.3.4.';//' 请您选用支持 PHP5 的主机，或下载 emlog3.4 安装。';
$lang['go_to_emlog']		= 'Go to Emlog';//'进入emlog';

$lang['mysql_not_supported'] = 'Your PHP does not support MySql database.';//服务器PHP不支持MySql数据库
$lang['mysql_settings']	= 'Database settings (MySql database)';
$lang['db_hostname']	= 'Database Hostname';//数据库地址
$lang['db_hostname_info'] = '(Usually no need to modify localhost)';//通常为 localhost 不必修改
$lang['db_username']	= 'Database Username';//数据库用户名
$lang['db_password']	= 'Database Password';//数据库密码
$lang['db_name']	= 'Database Name';//数据库名
$lang['db_name_info']	= '(Program does not automatically create the database, please create an empty database or use the existing database)';//程序不会自动创建数据库，请提前创建一个空数据库或使用已有数据库
$lang['db_prefix']	= 'Database prefix';//数据库前缀
$lang['db_prefix_info'] = '(Can be filled out, but by the letters of the alphabet, numbers, underscores the composition and must be underlined Ending)';//可随意填写，由英文字母、数字、下划线组成，且必须以下划线结束
$lang['db_prefix_empty'] = 'Database prefix should not be empty!';//'数据库前缀不能为空!'
$lang['db_prefix_invalid'] = 'Database prefix format error!';//'数据库前缀格式错误!'
$lang['db_connect_error'] = 'Failed to connect to the database, the database address is wrong or the database server is unavailable';//'连接数据库失败，数据库地址错误或者数据库服务器不可用';
$lang['db_not_found']	= 'Specified database not found.';//未找到指定数据库
$lang['db_port_error']	= 'Failed to connect to the database, the database port is wrong';//'连接数据库失败，数据库端口错误';
$lang['db_server_error']	= 'Failed to connect to the database, the database server is unavailable';//'连接数据库失败，数据库服务器不可用';
$lang['db_user_error']	= 'Failed to connect to the database, the database user name or password is wrong';//'连接数据库失败，数据库用户名或密码错误';
$lang['db_error_code']	= 'Failed to connect to the database, please check the database information. Error number: ';//'连接数据库失败，请检查数据库信息。错误编号：';

$lang['admin_settings'] = 'Administrator settings (for the installation of sign after the success of blog use)';
$lang['admin_name']	= 'Administrator Name';//博主登录名
$lang['admin_password'] = 'Administrator Password';//博主登录密码
$lang['admin_password_repeat'] = 'Re-enter the Administrator Password';//再次输入博主登录密码
$lang['admin_password_empty'] = 'Administrator Name and password should not be empty!';//'博主登录名和密码不能为空!'
$lang['admin_name_added'] = 'added successfully';//添加成功


$lang['with'] = 'There are';//'有';
$lang['items'] = 'items';//条
$lang['data'] = 'Data';//数据
$lang['extensions'] = 'Extensions';//功能扩展

$lang['plugins'] = 'Plug-ins';//插件
$lang['plugin_management'] = 'Plugin Management';//插件管理
$lang['plugin_activated_ok'] = 'Plugin activated successfully!';//插件激活成功
$lang['plugin_deactivated_ok'] = 'Plugin deactivated successfully!';//插件禁用成功
$lang['plugin_name'] = 'Plugin';//插件
$lang['plugin_version']	= 'Version';//版本
$lang['status']		= 'Status';//状态
$lang['plugin_active'] = 'Active';//已激活
$lang['plugin_inactive'] = 'Inactive';//未激活
$lang['plugin_page'] = 'Plugin page';//插件主页
$lang['plugin_repository'] = 'Emlog Plugin Repository';//'获取更多插件';
$lang['plugin_activate_failed'] = 'Plug-in activation failed';//'获取更多插件';
$lang['plugin_disable_all'] = 'Disable all plugins';//'禁用所有插件';
$lang['plugin_reset'] = 'Reset plugin settings';//'恢复组件设置到初始安装状态';
$lang['sidebar_widgets'] = 'Manage sidebar widgets';//'侧边栏组件管理';
$lang['return_to_admin_center'] = 'Return to Admin Center';//返回管理首页
$lang['site_in_new_window'] = 'Show the Blog in a New Window';//在新窗口浏览我的blog


$lang['posts'] = 'Posts';//'日志';
$lang['posted_blogs'] = ' blogs posted';//'篇日志';
$lang['post_deleted_ok'] = 'Post deleted successfully';//删除日志成功
$lang['post_recommended_ok'] = 'Post recommended successfully';//日志置顶成功
$lang['post_unrecommended_ok'] = 'Post removed from recommended successfully';//取消置顶成功
$lang['post_select_to_deal'] = 'Please select a post to deal with';//请选择要处理的日志 //'请选择要操作的日志'
$lang['post_what_to_do'] = 'Please select what to do with the post(s)';//请选择要执行的操作
$lang['post_moved_ok'] = 'Post moved successfully';//移动日志成功
$lang['post_draft_ok'] = 'Post marked as Draft successfully';//转入草稿箱成功
$lang['post_save_and_return'] = 'Save and return';//保存并返回
$lang['post_save_draft'] = 'Save as Draft';//保存草稿 //保存
$lang['save'] = 'Save';//'保存';
$lang['post_saved_draft_ok'] = 'The post saved as Draft successfully!';//'草稿保存成功!'//转入草稿箱成功
$lang['post_publish'] = 'Publish the Post';//'发布日志';
$lang['post_published_ok'] = 'The post published successfully!';//'页面发布成功!'//'日志发布成功!'//发布日志成功
$lang['post_saved_ok'] = 'The post saved successfully!';//'页面保存成功!'//'日志保存成功!'
$lang['post_author_changed_ok'] = 'The post author changed successfully!';//更改 作者成功
$lang['post_view_in_new_window'] = 'Show the Post in a New Window';//在新窗口查看
$lang['post_delete_sure'] = 'Are you sure you want to delete the selected posts?';//'你确定要删除所选日志吗？'
$lang['post_password'] = 'Article Access Password';//'文章访问密码';//'日志访问密码';
$lang['post_password_leave_empty'] = 'Leave Password empty if not required';//留空则不加访问密码
$lang['post_add'] = 'Add Post';//写日志
$lang['post_add_new'] = 'Add New Post';//新建页面
$lang['post_not_exists'] = 'The entry does not exist';//不存在该日志
$lang['post_time'] = 'Post Time';//'发布时间';
$lang['post_abstract'] = 'Abstract';//日志摘要
$lang['post_edit'] = 'Edit Post';//编辑日志
$lang['posted_by'] = 'Posted by';

$lang['publish'] = 'Publish';//'发布';
$lang['unpublish'] = 'Make Draft';//转入草稿箱





$lang['yes'] = 'Yes';//否
$lang['no'] = 'No';//

$lang['mail_to'] = 'Mail to';//发邮件给
$lang['go_to'] = 'Go to';//访问
$lang['homepage'] = 'homepage';//'主页';
$lang['_homepage'] = '\'s homepage';//'的主页';
$lang['author_homepage'] = 'homepage';//的主页 //作者主页
$lang['rss_feed'] = 'RSS Feed';//'RSS订阅';//'订阅Rss';
$lang['bytes'] = 'bytes';//字节
$lang['access_disabled'] = 'Insufficient privileges!';//权限不足!
$lang['enter'] = 'Enter';//进入



$lang['parameter_invalid'] = 'Submitted parameters error';//提交参数错误
$lang['calendar'] = 'Calendar';//'日历';
$lang['archive'] = 'Archive';//归档 //存档
$lang['submit'] = 'Submit';//提交 //确 定
$lang['reset'] = 'Reset';//重 置




$lang['blog'] = 'Blog';
$lang['no_blogs_yet'] = 'No blogs yet!';
$lang['blog_view'] = 'View Blog';//'浏览日志';//'查看博客';
$lang['blog_view_link'] = 'View the Blog';//'查看该日志';
$lang['blog_delete'] = 'Delete Blog';
$lang['blog_enter_password'] = 'Please enter a Password to Access the Blog';//输入日志访问密码 //请输入该日志的访问密码
$lang['blog_password_protected'] = 'The blog is password protected';
$lang['blog_password_protected_info'] = 'The blog is password protected. Click on the title to enter a password to access.';//该日志已设置加密，请点击标题输入密码访问
$lang['blog_password_required'] = 'The post requires a password to access, please enter the password';//'该日志需要密码才能访问，请输入密码';
$lang['blog_tags'] = 'Blog tags';//'日志标签';

$lang['management'] = 'Management';//'博客管理';
$lang['blog_author'] = 'Blog Author';//'日志作者';


$lang['config_no_permission'] = 'Configuration file (config.php) is not written. If you are using Unix/Linux host, change the file permissions to 777. If you are using a Windows host, please contact the administrator, this file must have Write permissions for everyone';//'配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为everyone可写'
$lang['config_saved'] = 'Configuration file modified successfully';//配置文件修改成功

$lang['latest_comments'] = 'Latest comments';//最新评论
$lang['latest_posts'] = 'Latest posts'; //最新日志
$lang['latest_posts_number'] = 'Number of Latest posts to show';//首页显示最新日志数
$lang['random_posts'] = 'Random posts';//随机日志
$lang['random_posts_number'] = 'Number of Random post to show';//首页显示随机日志数

$lang['music'] = 'Music';//音乐
$lang['music_links'] = 'Music Links: (one per line, only mp3 format supported)';//音乐链接:(每行一条，仅支持mp3格式)
$lang['music_links_info'] = 'E.g.: http://www.emlog.net/a.mp3 This Music File Description';//如:http://www.emlog.net/a.mp3 音乐介绍
$lang['music_random'] = 'Enable random play';//启用随机播放
$lang['music_autoplay'] = 'Enable automatic play';//启用自动播放
$lang['music_submit'] = 'OK';//确 定


$lang['search'] = 'Search';//搜索
$lang['do_search'] = 'Go';//搜索
$lang['information'] = 'Information';
$lang['welcome_hello'] = 'Hello Blogger';
$lang['welcome_text'] = 'Thank you for use the emlog! This is the default blog, you can delete it!';
$lang['emlog_homepage'] = 'Emlog Official Home Page';//emlog官方主页
$lang['emlog_welcome'] = 'Welcome to emlog!';
$lang['db_table'] = 'Database table';//数据库表
$lang['db_table_created'] = 'created successfully';//创建成功
$lang['table_create_error'] = '<b>Failed!</b>, can not successfully finish the installation, please check the mysql user has permissions to create tables';
$lang['success'] = 'Success';
$lang['sql_query_error'] = '<b>Error!</b>Can\'t execute the following sql statement, the installation can not be successfully completed.';

$lang['admin'] = 'Administrator';

$lang['sql_statement_error'] = 'SQL Statement Error';//"SQL语句执行错误"

$lang['cache'] = 'Data Cache';//数据缓存
$lang['cache_info'] = 'Caching the blog can dramatically increase the page loading speed.<br />Usually the system will automatically update the cache, but some special operations require to manually update the cache, such as cache file was no intention to amend, you manually modified, such as Database.';//缓存技术可以大幅度加快你博客首页的加载速度。<br>通常系统会自动更新缓存，但也有些特殊情况需要你手动更新，比如缓存文件被无意修改、你手动修改过数据库等。
$lang['cache_rebuild'] = 'Rebuild the Cache';//更新缓存
$lang['cache_updated_ok'] = 'Cache updated successfully';//缓存更新成功
$lang['cache_open_error'] = 'Cache open failed. If you are using Unix/Linux host, change the cache directory (content/cache) and all the files in it to 777 permissions. If you are using a Windows host, please contact the host administrator. Th directory and all the files must have write permission for everyone';//读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为everyone可写
$lang['cache_write_error'] = 'Cache write failure. The cache directory (content/cache) is not written.';//写入缓存失败，缓存目录 (content/cache) 不可写

$lang['read_more'] = 'Read more';//阅读全文
$lang['about'] = 'About';
$lang['seconds_ago'] = ' second ago';//' 秒前'
$lang['minutes_ago'] = ' minutes ago';//' 分钟前'
$lang['hours_ago'] = ' hours ago';//' 小时前';
$lang['wrong_file_type'] = 'Wrong file type';//错误的文件类型
$lang['file_size_exceeded'] = 'File size exceeded';//文件大小超出
$lang['restrictions'] = 'Restrictions';//的限制


$lang['return_back'] = 'Click to return back';//点击返回
$lang['verification_code'] = 'Verification Code';//验证码
$lang['first_page']	= 'First';//首页
$lang['last_page']	= 'Last';//尾页


$lang['monday_short']	= 'Mn';//一
$lang['tuesday_short']	= 'Tu';//二
$lang['wednesday_short']= 'We';//三
$lang['thursday_short'] = 'Th';//四
$lang['friday_short']	= 'Fr';//五
$lang['saturday_short'] = 'Sa';//六
$lang['sunday_short']	= 'Su';//日

$lang['month_1']	= 'January';
$lang['month_2']	= 'February';
$lang['month_3']	= 'March';
$lang['month_4']	= 'April';
$lang['month_5']	= 'May';
$lang['month_6']	= 'Jun';
$lang['month_7']	= 'July';
$lang['month_8']	= 'August';
$lang['month_9']	= 'September';
$lang['month_10']	= 'October';
$lang['month_11']	= 'November';
$lang['month_12']	= 'December';

$lang['parameter_error'] = 'Parameter error';
$lang['send_message_form'] = 'Send message form';
$lang['remove'] = 'Remove';//删除
$lang['previous'] = 'Previous';
$lang['next'] = 'Next';

$lang['message_send'] = 'Send a message to Administrator';

$lang['welcome_login'] = 'Welcome, you have logged';//欢迎你,你已登录
$lang['logout'] = 'Logout';//退出
$lang['login'] = 'Login';//登录
$lang['remember_me'] = 'Remember Me';//记住我


$lang['home'] = 'Home';//'首页';
$lang['back_home'] = 'Back to Homepage';//'返回主页';//'返回 首页';
$lang['time'] = 'Time';//'时间';
$lang['back_to_list'] = 'Back to blog list';//'返回日志列表';

$lang['twitter']	= 'Twitter';//'碎语';//'微语';
$lang['twitters']	= 'Twitters';//'碎语';
$lang['twitters_last'] = 'Latest Twitters';//'最新碎语';
$lang['twitters_last_info'] = 'Show the latest twits at the homepage';//'首页显示最新碎语数';
$lang['blogger_twitter'] = 'Blogger Twitter';//'博主唠叨';
$lang['twitter_first_text'] = 'Use twitter to record new things around you';//'使用微语记录您身边的新鲜事';
$lang['no_twitter_yet'] = 'No twitter yet!';
$lang['twitters_number'] = 'Number of twitters to show';//首页显示twitter数
$lang['twitter_add'] = 'Add twitter';//'发布碎语' //唠叨两句 //我要唠叨
$lang['content'] = 'Content';//内容

$lang['users'] = 'Users';//作者
$lang['user'] = 'User';//'用户';
$lang['user_name'] = 'User Name';//用户 //用户名
$lang['author'] = 'Author';//'作者';
$lang['user_management'] = 'User Management';//作者管理
$lang['user_deleted_ok'] = 'Users deleted successfully';//删除作者成功
$lang['user_edited_ok'] = 'User edited successfully';//修改作者资料成功
$lang['user_added_ok'] = 'User added successfully';//添加作者成功
$lang['user_name_empty'] = 'User name should not be empty';//用户名不能为空
$lang['user_allready_exists'] = 'This username allready exists';//该用户名已存在
$lang['user_add_info'] = 'Add a user (co-writer)';//添加作者(联合撰写人)
$lang['user_add'] = 'Add user';//'添加用户';//'添加作者';
$lang['login_modified_ok'] = 'Login modified successfully! Please Log in.';//'后台登录名修改成功!请重新登录'
$lang['login_and_password_modified_ok'] = 'Login and Password modified successfully! Please Log in.';//'密码和后台登录名修改成功!请重新登录'
$lang['password'] = 'Password';//密码
$lang['password_length'] = '(Not less than 5 characters)';//'(大于5位)';
$lang['password_auth'] = 'Authentication Password';
$lang['password_modified_ok'] = 'Password successfully modified!';//'密码修改成功!'
$lang['wrong_current_password'] = 'Wrong current Password';//'错误的当前密码'
$lang['password_empty'] = 'Name and password should not be empty!';
$lang['password_short'] = 'Password should not be less than 5 characters';//'密码长度不得小于5位'
$lang['password_repeat'] = 'Re-enter the Password';//重复密码
$lang['password_not_equal'] = 'The confirmed password does not equal to the first entered password';//'两次输入的密码不一致'


$lang['mail'] = 'mail';//邮箱
$lang['email'] = 'E-mail';//电子邮件
$lang['email_address'] = 'E-mail address';//邮件地址
$lang['optional'] = 'optional';//选填
$lang['visit_home'] = 'Visit the home page';//'访问首页';
$lang['visit_admin'] = 'Visit admin panel';//'登录后台';
$lang['poster_homepage'] = 'The Home Page';
$lang['reply'] = 'Reply';//博主回复 //回复
$lang['blog_reply'] = 'Blog reply';//'博主回复';
$lang['cancel'] = 'Cancel';//'取消';
$lang['_cancel_'] = 'Cancel';//'取 消';
$lang['your_name'] = 'Your Name';
$lang['optional'] = 'Optional';
$lang['your_homepage'] = 'Personal Home Page';//个人主页
$lang['your_comment'] = 'Your Comment Text';
$lang['powered_by'] = 'Powered by';
$lang['total_blogs'] = 'Total blogs';
$lang['subscribe'] = 'Subscribe';//订阅
$lang['subscribe_blog'] = 'Subscribe to this blog';
$lang['subscribe_category'] = 'Subscribe to this Category';
$lang['total_comments'] = 'Total Comments';



$lang['views'] = 'Views';//浏览 //阅读 //查看
$lang['view'] = 'View';//查看

$lang['admin_center']	= 'Admin center';//管理中心 //管理首页
$lang['hello']		= 'Hello';//你好
$lang['no_title']	= 'No Title';//'无标题';

$lang['name_invalid'] = 'Error! Name entered is invalid.';
$lang['email_invalid'] = 'Error! Email entered is invalid.';
$lang['verification_code_empty'] = 'Error! Verification Code should not be empty.';
$lang['verification_code_invalid'] = 'Error! Verification Code is not valid.';
$lang['unclassified'] = 'Unclassified';//'未分类'
$lang['title'] = 'Title';//标题

$lang['category'] = 'Category';//分类
$lang['categories'] = 'Categories';//分类
$lang['categories_management'] = 'Categories Management';//分类管理
$lang['choose_category'] = 'Choose Category';//选择 分类...
$lang['categories_ordered_ok'] = 'Categories ordered successfully.';//排序更新成功
$lang['categories_deleted_ok'] = 'Categories deleted successfully.';//删除分类成功
$lang['categories_edited_ok'] = 'Category edited successfully.';//修改分类成功
$lang['category_added_ok'] = 'Category added successfully.';//添加分类成功
$lang['category_is_empty'] = 'Category name should not be empty!';//分类名称不能为空
$lang['category_name'] = 'Category Name';//分类名称
$lang['category_order_nothing'] = 'There is no categories to Order';//没有可排序的分类
$lang['category_add'] = 'Add New Category';//'添加新分类';//'新建分类';
$lang['category_feed'] = 'Category Feed';//订阅该 分类



$lang['advanced_options'] = 'Advanced Options';//高级选项

$lang['save'] = 'Save';//'保 存';
$lang['_save_'] = 'Save';//'保 存';
$lang['save_and_return'] = 'Save and return';

$lang['all'] = 'All';//全部
$lang['with_selected_do'] = 'With selected do';//选中项
$lang['publish'] = 'Publish';
$lang['make_draft'] = 'Make Draft';
$lang['recommend'] = 'Recommend';//置顶
$lang['unrecommend'] = 'Unrecommend';//取消置顶
$lang['recommended'] = 'Recommended';//置顶
$lang['post_recommend'] = 'Recommend the post';//置顶日志
$lang['change_author'] = 'Change author to';//'更改作者为';
$lang['move_to_category'] = 'Move to category';//更改作者为 //移动到分类

$lang['total'] = 'Total';
$lang['total_articles'] = 'Total articles';
$lang['articles_per_page'] = '/ 15 per page';
$lang['filters'] = 'Filters';

$lang['blog_settings'] = 'Blog Settings';//博客设置
$lang['save_settings'] = 'Save Settings';//保存设置
$lang['settings_saved_ok'] = 'Settings saved successfully.';//设置保存成功

$lang['posts_manage'] = 'Posts';
$lang['data_manage'] = 'Data';
$lang['draft'] = 'Draft';//'草稿';//'隐藏';
$lang['drafts'] = 'Drafts';//'草稿箱';
$lang['hide'] = 'Hide';//'隐藏';
$lang['hidden'] = 'Hidden';//'隐藏';
$lang['published'] = 'Published';//'日志管理'
$lang['publications'] = 'Blog';//'日志管理'
$lang['database'] = 'Database';
$lang['mysql_database'] = 'MySQL Database';
$lang['server_environment'] = 'Server environment';//服务器环境
$lang['server_info'] = 'Server information';//服务器信息
$lang['php_version'] = 'PHP version';//PHP版本
$lang['php_info'] = 'PHPinfo';//更多信息
$lang['mysql_version'] = 'MySQL version';//MySQL版本
$lang['server_time'] = 'Server time';//服务器时间
$lang['gd_library'] = 'GD Graphics Library version';//GD图形处理库
$lang['safe_mode'] = 'Safe mode';//安全模式
$lang['official_info'] = 'Official Information';//官方消息
$lang['batch_actions'] = 'Batch operation';
$lang['enabled'] = 'Enabled';//开启
$lang['disabled'] = 'Disabled';//关闭
$lang['loading'] = 'Loading...';//正在读取...
$lang['there_are'] = 'There are';//目前有

$lang['file_not_exists'] = 'File does not exist';//'文件不存在'

$lang['backup'] = 'Backup';//数据 
$lang['backup_database'] = 'Database Backup';//数据备份
$lang['backup_directory_not_writable'] = 'Backup failed. Backup directory (content/backup) is not writable.';//'备份失败。备份目录(content/backup)不可写'
$lang['backup_create_file_error'] = 'Create a backup file failed. Backup directory (content/backup) is not writable.';//'创建备份文件失败。备份目录(content/backup)不可写'
$lang['backup_empty'] = 'Nothing to backup. Database tables have no any content.';//'数据表没有任何内容'
$lang['backup_extension_invalid'] = 'It is possible to import only SQL files backed up by emlog';//'只能导入emlog备份的SQL文件';
$lang['backup_format_invalid'] = 'Import failed! The backup file does not correspond the emlog version ';//"导入失败! 该备份文件不是 emlog "
$lang['backup_bad_format']	= 'You can only import the compressed package backed up by emlog, and you cannot modify the compressed package file name!';//'只能导入emlog备份的压缩包，且不能修改压缩包文件名！';
$lang['backup_prefix_invalid'] = 'Import failed! Database Backup file prefix does not match the configured Database Prefix: ';//'导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配 ';
$lang['backup_read_error']	= 'Import failed! Failed to read file';//'导入失败！读取文件失败';
$lang['backup_sql_error'] = 'Failed to upload file, error code: ';//'上传文件失败,错误码：';
$lang['backup_filename'] = 'Backup File name';//备份文件名
$lang['backup_filename_info'] = 'Backup File name can consist only latin alphabet characters, numbers, defis and underscores.';//由英文字母、数字、下划线组成
$lang['backup_filename_invalid'] = 'Error! Wrong backup file name.';//错误的备份文件名
$lang['backup_place'] = 'Backup location';//备份文件保存在
$lang['backup_local'] = 'Local computer';//本地
$lang['backup_local_file'] = 'Import local backup file';//'导入本地备份文件';
$lang['backup_server'] = 'Server';//服务器
$lang['backup_file'] = 'Filename';//备份文件
$lang['backup_time'] = 'Time';//备份时间
$lang['backup_size'] = 'Size';//文件大小
$lang['backup_import'] = 'Import';//导入
$lang['backup_info'] = 'Backup info';//备份数据
$lang['backup_choose_database'] = 'Choose Database tables to Backup.';//选择要备份的数据库表
$lang['backup_start'] = 'Start backup';//开始备份
$lang['backup_delete_selected'] = 'Delete selected backup files';
$lang['backup_delete_sure'] = 'Are you sure you want to delete the selected backup file?';//你确定要删除所选备份文件吗？
$lang['backup_deleted_ok'] = 'Backup File deleted successfully.';//备份文件删除成功
$lang['backup_saved_ok'] = 'Backup File saved successfully.';//数据备份成功
$lang['backup_imported_ok'] = 'Backup File imported successfully.';//备份导入成功
$lang['backup_select_file'] = 'Please select the backup files to operate with.';//请选择要删除的备份文件
$lang['backup_illegal_info'] = 'Illegal information submitted';//'非法提交的信息';

$lang['enter_modifications'] = 'Please enter the modifications in the project parameters';
$lang['verification_code_not_supported'] = 'Open Verification Code failure! Server does not support this feature.';//"开启登录验证码失败!服务器不支持该功能"
$lang['phpinfo_disabled'] = 'phpinfo function is disabled!';//'phpinfo函数被禁用!';
$lang['logout_ok'] = 'Log out success!';//'退出成功！';
$lang['supported'] = 'Supported';//'支持';
$lang['not_supported'] = 'NOT supported';//'不支持';
$lang['gd_not_supported'] = 'Does not support the GD graphics library';
$lang['drafts_saved_ok'] = 'Drafts saved successfully!';
$lang['post_added_ok'] = 'Post added successfully!';
$lang['post_saved_ok'] = 'Post saved successfully!';
$lang['music_link_invalid'] = 'Music Link has wrong format!';//'有错误的音乐链接格式'
$lang['image_delete'] = 'Delete image';

$lang['personal_data'] = 'Personal Data';//个人资料
$lang['personal_data_edit'] = 'Edit Personal Data';//修改作者资料
$lang['click_to_edit_personal_data'] = 'Click to Edit Personal Data';//点击修改个人资料
$lang['personal_data_saved_ok'] = 'Personal Data saved successfully.';//个人资料修改成功
$lang['photo'] = 'Photo';//头像
$lang['photo_info'] = 'Avatar (Recommended size is 120x120 pixels, with jpg or png format)';//'头像 (推荐上传大小为120X120，格式为jpg或png的图片)';
$lang['photo_delete'] = 'Delete Photo';//删除头像
$lang['photo_deleted_ok'] = 'Photo removed successfully.';//头像删除成功
$lang['photo_delete_failed'] = 'Photo delete failed';//'头像删除失败'
$lang['nickname'] = 'Nickname';//昵称
$lang['personal_description'] = 'Personal Description';//个人描述
$lang['personal_data_save'] = 'Save Personal Data';//保存资料
$lang['save changes'] = 'Save changes';//确认修改
$lang['my_status'] = 'My status';
$lang['modify_login_password'] = 'Modify Login/Password';//修改密码/登录名
$lang['password_current'] = 'Current Password';//当前密码
$lang['password_new'] = 'New Password (not less than 5 characters)';//新密码
$lang['password_new_confirm'] = 'Confirm New Password (to ensure that the new Password is equal with the above)';//重复新密码
$lang['password_leave_empty'] = 'Leave Password empty if not changed';//不修改请留空

$lang['unapproved'] = 'Unapproved';//未审核
$lang['unapprove'] = 'Unapprove';//'未审核';
$lang['approved'] = 'Approved';//'审核';
$lang['approve'] = 'Approve';//'审核';
$lang['author'] = 'Author';//'作者';

$lang['blog_name'] = 'Blog name';//博客名称
$lang['blog_description'] = 'Blog Description';//博客描述
$lang['modify_blog_descr'] = 'Modify blog description';
$lang['blog_url'] = 'Blog URL';//博客地址
$lang['blog_keywords'] = 'Blog Keywords';//博客关键字


$lang['separate_keywords'] = '(Separate multiple keywords with a comma &quot;,&quot;)';//关键字之间用半角逗号","隔开
$lang['registration_number'] = 'Registration Code';//ICP备案号
$lang['posts_per_page'] = 'Posts per page';//每页日志数
$lang['server_tz'] = 'The server time zone';//服务器时区


$lang['require_login_verification'] = 'Require the Verification Code when Log in';//开启登录验证码
$lang['url_rewrite_enable'] = 'Open URL as pseudo-static (URL rewriting)';//开启URL优化
$lang['url_rewrite_info'] = 'Before enable this feature you MUST configure mod_rewrite settings for your server!<br>Else some published posts could not be opened.<br>Please consult the emlog documentation first!';//开启需要服务器支持，如果开启后出现日志无法访问的情况请关闭
$lang['url_rewrite_not_supported'] = 'Failed to open URL Optimization! The server does not support the mod_rewrite module.';//"开启URL优化失败!服务器未开启mod_rewrite模块"
$lang['url_rewrite_no_htaccess'] = 'Failed to open URL Optimization! was not found. htaccess file, please download the package ext directory of the file is uploaded to the root directory';// "开启URL优化失败!未找到.htaccess文件,请将下载包内ext目录下该文件上传至根目录"
$lang['gzip_enable'] = 'Compress output page with Gzip';//开启页面Gzip压缩
$lang['edit_published'] = 'Edit Published';

$lang['links'] = 'Links';//链接
$lang['link'] = 'Link';//链接
$lang['link_edit'] = 'Edit link';//修改链接
$lang['link_add'] = 'Add link';//添加链接
$lang['link_follow'] = 'Follow the link';//查看链接
$lang['link_url'] = 'Site URL';//地址
$lang['link_description'] = 'Site description';//描述
$lang['links_ordered_ok'] = 'Links ordered successfully.';//排序更新成功
$lang['links_deleted_ok'] = 'Links deleted successfully.';//删除链接成功
$lang['links_edited_ok'] = 'Link edited successfully.';//修改链接成功
$lang['links_added_ok'] = 'Link added successfully.';//添加链接成功
$lang['link_is_empty'] = 'Site name and URL should not be empty!';//站点名称和地址不能为空
$lang['link_sort_nothing'] = 'There are no links ro order';//没有可排序的链接

$lang['order'] = 'Order';//序号
$lang['update_sort_order'] = 'Update Sort Order';//改变排序
$lang['information_message'] = 'Information message';
$lang['redirect_title'] = 'Redirection';//提示信息
$lang['redirect_click'] = 'If the page will not redirect automatically, click here!';//如果页面没有跳转,请点击返回!

$lang['tags'] = 'Tags';//标签
$lang['tag'] = 'Tag';
$lang['tag_not_exists'] = 'The tag does not exist';
$lang['tag_too_long'] = 'The tag is too long';
$lang['tag_too_short'] = 'The tag is too short';
$lang['tag_separate'] = 'Separate multiple Tags with a comma &quot;,&quot;';//Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签
$lang['tag_select'] = 'Choose your tags';//选择已有标签
$lang['tags_management'] = 'Tags Management';//标签管理
$lang['tags_deleted_ok'] = 'Tags deleted successfully.';//删除标签成功
$lang['tags_edited_ok'] = 'Tag edited successfully.';//修改标签成功
$lang['tag_select_for_delete'] = 'Please select the Tag for delete.';//请选择要删除的标签
$lang['tags_delete_selected'] = 'Delete Selected Tags';//删除所选标签
$lang['tag_edit'] = 'Edit Tag';//标签修改
$lang['tag_blogs_used'] = 'Used in posts (times)';//篇日志
$lang['tags_by_comma'] = 'Blog tags, separated by commas';//'日志标签，半角逗号分隔';

$lang['templates'] = 'Templates';//'模板';
$lang['template'] = 'Template';//'模板';
$lang['template_change'] = 'Change template';//'换模板';
$lang['template_admin_not_found'] = 'the Admin-Center template not found!';
$lang['template_current'] = 'Current template';//当前模板
$lang['template_changed_successfully'] = 'Template changed successfully';//模板更换成功
$lang['templates_are_available'] = 'Available templates';//可用模板
$lang['templates_available'] = 'Total templates available';//当前共有 个可用模板
$lang['templates_more'] = 'More templates (Template Repository)';//获取更多模板
$lang['template_click'] = 'Click to use the template';//点击使用该模板
$lang['template_path_error'] = 'The Template Path Error';
$lang['template_view']		= 'View template';//'查看模板';

$lang['upload'] = 'Start Upload!';//上传
$lang['uploads'] = 'Uploads';
$lang['upload_failed_code'] = 'Upload failed. Error code';//上传文件失败,错误码
$lang['uploads_not_written'] = 'Upload failed. File Upload Directory (content/uploadfile) can not be written';//上传失败。文件上传目录(content/uploadfile)不可写

$lang['attachments'] = 'Attachments';//'附件';//'文件 附件';
$lang['attachment'] = 'Attachment';//'附件';
$lang['attachment_manager'] = 'Attachment Manager';//附件管理
$lang['attachment_create_failed'] = 'Create file upload directory failed';//创建文件上传目录失败
$lang['attachment_upload'] = 'Upload attachment';//上传附件
$lang['attachment_library'] = 'Attachment gallery';//附件库
$lang['attachment_no'] = 'No attachment here';//该日志没有附件
$lang['attachment_exceed_system_limit'] = 'File size exceeds the system limit ';//'文件大小超过系统限制 ';
$lang['attachment_delete_error'] = 'Attachment Delete failure';//"删除附件失败!"
$lang['attachment_increase'] = 'Increase attachment fields';//增加附件
$lang['attachment_decrease'] = 'Decrease attachment fields';//减少附件
$lang['attachment_max_size'] = 'Max enabled upload file size';//单个附件最大
$lang['attachment_max_system_size'] = 'Max enabled upload file size';//服务器允许上传最大文件
$lang['attachment_types'] = 'Enabled attachment types';//允许类型
$lang['attachment_type_archive'] = 'Archive';//'压缩包'
$lang['compressed_package'] = 'Compressed package';
$lang['attachment_embed'] = 'Embed';//嵌入

$lang['widgets'] = 'Widgets';//'组件';
$lang['widgets_custom'] = 'Custom Widgets';//自定义组件
$lang['widget_custom'] = 'Custom widget';//未命名组件
$lang['widgets_list'] = 'Widget List';
$lang['widgets_order'] = 'Widgets Order (drag-n-drop)';
$lang['widgets_order_save'] = 'Save Widgets Order';//保存组件排序
$lang['widget_delete'] = 'Delete the Widget';//删除该组件
$lang['widget_name'] = 'Widget Name';//组件名
$lang['widget_content'] = 'Widget Content (html supported)';//内容 （支持html）
$lang['widget_new'] = 'New Custom Widget';//自定义一个新的组件
$lang['widget_repository'] = 'Widget Repository';//获取更多有趣的组件
$lang['widget_add'] = 'Add New Widget';//添加组件
$lang['widgets_saved_ok'] = 'Widgets Settings saved successfuly';//设置保存成功
$lang['widget_blogger'] = 'Blogger';//blogger
$lang['widget_blogger_info'] = 'Modify User Personal Data';//修改个人资料...
$lang['change'] = 'Change';//'更改';

$lang['edit'] = 'Edit';//编辑
$lang['modify'] = 'Modify';//修改我的状态
$lang['personal_data_modify'] = 'Modify Personal Data';

$lang['sidebar'] = 'Sidebar';//侧边栏
$lang['description'] = 'Description';//描述
$lang['change_my_status'] = 'Change my status';//修改我的状态
$lang['twitter_previous'] = 'Previous';//较近的
$lang['twitter_next'] = 'Next';//较早的
$lang['blog_statistics'] = 'Statistics';//信息
$lang['number_of_posts'] = 'Posts';//日志 //日志数量
$lang['number_of_comments'] = 'Comments';//评论 //评论数量
$lang['number_of_trackbacks'] = 'Trackbacks';//引用 //引用数量
$lang['visits_today'] = 'Today Visits';//今日访问
$lang['visits_total'] = 'Total Visits';//总访问量


$lang['trackbacks'] = 'Trackbacks';//'引用';
$lang['trackback'] = 'Trackback';//'引用';
$lang['trackback_address'] = 'Reference Address';//引用地址
$lang['trackback_source'] = 'Source';//来源
$lang['trackback_url_invalid'] = 'Invalid trackback URL';
$lang['trackback_disabled'] = 'Trackbacks for this blog are disabled';
$lang['trackback_successful'] = 'Successful reception';
$lang['trackback_refused'] = 'Take the initiative to refuse to quote';
$lang['trackback_send_error'] = 'Send failed';//发送失败
$lang['trackback_send_ok'] = 'Sent successfully';//发送成功
$lang['trackback_notes'] = 'Trackbacks: (Reference to inform you that the post quoted)';//引用通告:(Trackback，通知你所引用的日志)
$lang['trackback_enter'] = 'Enter trackback Addresses, one per line';//每行输入一个引用地址
$lang['trackbacks_total'] = 'Total trackbacks';
$lang['trackback_enable'] = 'Accept trackbacks';//接受引用？是
$lang['trackback_settings_enable'] = 'Enable trackbacks';//开启引用通告
$lang['trackback_management'] = 'Trackback Management';//'引用管理';//'引用通告（TrackBack）管理';
$lang['trackback_delete_selected'] = 'Delete Selected Trackbacks';
$lang['trackback_delete_sure'] = 'Are you sure you want to delete the selected trackbacks?';//你确定要删除所选引用吗？
$lang['trackback_deleted_ok'] = 'Trackback deleted successfully.';//'删除引用成功';
$lang['trackback_select'] = 'Please select the trackback to operate with.';//请选择要执行操作的引用
$lang['trackbacks_per_page'] = '/ 15 per page';
$lang['trackbacks_articles'] = ' trackbacks';//条引用
$lang['trackbacks_use'] = 'Trackbacks';//'引用通告';


$lang['comments'] = 'Comments';//'评论';
$lang['_comments'] = ' comments';//'条评论';
$lang['comment'] = 'Comment';//发表评论
$lang['comment_add'] = 'Add a Comment';//'发表评论';
$lang['comment_posted_ok'] = 'Comment published successfully!';//'评论发表成功';
$lang['comment_posted_premod'] = 'Your comment was saved successfully! Please wait for the administrator review and approve it!';//'评论发表成功，请等待管理员审核';
$lang['comments_no_yet'] = 'No comments yet!';//'还没有收到评论';
$lang['comment_reply'] = 'Reply the comment';//'回复评论';
$lang['comments_disabled'] = 'Add comment failed: this log has closed comments';//'评论失败：该日志已关闭评论';
$lang['comment_allready_exists'] = 'Comment failed: a comment with the same content already exists';//'评论失败：已存在相同内容评论';
$lang['comment_name_empty'] = 'Comment failed: please fill in your name';//'评论失败：请填写姓名';
$lang['comment_name_invalid'] = 'Comment failed: the name does not meet the specifications';//'评论失败：姓名不符合规范';
$lang['comment_email_invalid'] = 'Failed to post a comment: the email address does not meet the specifications';//'发表评论失败：邮件地址不符合规范';
$lang['comment_admin_restricted'] = 'Comment failed: the use of administrator nickname or email comment is prohibited';//'评论失败：禁止使用管理员昵称或邮箱评论';
$lang['comment_invalid'] = 'Failed to post a comment: the content does not meet the specifications';//'发表评论失败：内容不符合规范';
$lang['comment_captcha_invalid'] = 'Failed to post a comment: verification code error';//'发表评论失败：验证码错误';

$lang['comments_enable'] = 'Accept Comments';//'接受评论';
$lang['comments_approve'] = 'Approve';//审核
$lang['comments_approved'] = 'Approved';//已审核
$lang['comments_unapproved'] = 'Unapproved';//未审核
$lang['comments_replied'] = 'Replied';//已回复
$lang['comments_management'] = 'Comments Management';//评论管理
$lang['comments_delete_sure'] = 'Are you sure you want to delete the selected comment?';//你确定要删除所选评论吗？
$lang['comments_deleted_ok'] = 'Comments deleted successfully.';//删除评论成功
$lang['comments_approved_ok'] = 'Comments approved successfully.';//审核评论成功
$lang['comments_hide'] = 'Hide';//'屏蔽';
$lang['comments_hide_ok'] = 'Comments hide successfully.';//屏蔽评论成功
$lang['comments_select'] = 'Please select the comments to perform the operation.';//请选择要执行操作的评论 //请选择要操作的评论
$lang['comments_select_operation'] = 'Please select the operation to perform.';//请选择要执行的操作
$lang['comment_replied_ok'] = 'Comment replied successfully.';//回复评论成功
$lang['comment_author'] = 'From';//所属日志 //评论人
$lang['from'] = 'From';//'来自';
$lang['ip'] = 'IP';
$lang['hide'] = 'Hide';//'屏蔽';

$lang['comments_with_selected'] = 'With selected comments';
$lang['comments_per_page'] = '/ 15 per page';
$lang['comments_number_per_page'] = 'Number of comments per page';//'每页评论数';
$lang['comments_require_approving'] = 'Require approvement for new comments';//开启评论审核
$lang['comments_require_verification_code'] = 'Require verification code for new comments';//开启评论验证码
$lang['comments_require_approving_info'] = 'Comments will be shown after approving only.';//开启后评论需通过审核才能显示
$lang['comments_latest_number'] = 'Number of latest comments at homepage';//首页最新评论数
$lang['comments_trim_length'] = 'Trim comment length to N characters';//新近评论截取字节数
$lang['comment_error_disabled']	= 'Error. Comments for this post are disabled!';//'发表评论失败:该日志已关闭评论';
$lang['comment_error_allready_exists']	= 'Error. The same comment content already exists!';//'发表评论失败:已存在相同内容评论';
$lang['comment_error_invalid_name']	= 'Error. UserName does not meet specifications!';//'发表评论失败:姓名不符合规范';
$lang['comment_error_invalid_email']	= 'Error. Email does not meet specifications!';//'发表评论失败:邮件地址不符合规范';
$lang['comment_error_invalid_content']	= 'Error. Comment content does not meet specifications!';//'发表评论失败:内容不符合规范';
$lang['comment_error_nocode']		= 'Error. You have to enter the verification code!';//'发表评论失败:验证码不能为空';
$lang['comment_error_invalid_code']	= 'Error. You have entered invalid verification code!';//'发表评论失败:验证码错误';
$lang['comment_error_homepage']		= 'Comment failed: Homepage address does not meet specifications';//'评论失败：主页地址不符合规范';
$lang['comment_error_empty']		= 'Comment failed: Please fill in the comment content';//'评论失败：请填写评论内容';

$lang['pages']			= 'Pages';//'页面';
$lang['_pages']			= ' pages';// number of!//'个页面';
$lang['page']			= 'Page';//'页面';
$lang['page_add']		= 'Add new page';//'新建页面';//'新建一个页面';
$lang['page_management']	= 'Page Management';//页面管理
$lang['page_url']		= 'External page URL';//'转向地址';
$lang['page_url_info']		= 'If you fill out, the page title will point to this URL';//'如果填写，页面标题将指向该地址';
$lang['page_comments_enable']	= 'Enable comments for this page';//页面是否接受评论
$lang['page_new_window']	= 'Open the page in a new window';//在新窗口打开页面
$lang['page_publish']		= 'Publish page';//'发布页面';
$lang['page_save']		= 'Save';//'保存';
$lang['page_published_ok']	= 'Page published successfully!';//'页面发布成功！';//'发布页面成功';
$lang['page_unpublished_ok']	= 'Page unpublished successfully!';//'禁用页面成功';
$lang['page_saved_ok']		= 'Page saved successfully!';//'页面保存成功！';
$lang['page_deleted_ok']	= 'Page deleted successfully!';//'删除页面成功';
$lang['page_select_to_deal']	= 'Please select the page to deal with';//请选择要操作的页面
$lang['page_delete_sure']	= 'Are you sure you want to delete the selected page?';//你确定要删除所选页面吗?
$lang['page_edit']		= 'Edit page';//编辑页面

$lang['username_allready_exists'] = 'The username already exists';//'用户名已存在'
$lang['enter_items'] = 'Please enter the items you want to modify';//'请输入要修改的项目'

$lang['tz-12:00'] = '[-12:00] Dateline West';//'(标准时-12:00) 日界线西';
$lang['tz-11:00'] = '[-11:00] Midway Island, Samoa';//'(标准时-11:00) 中途岛、萨摩亚群岛';
$lang['tz-10:00'] = '[-10:00] Hawaii';//'(标准时-10:00) 夏威夷';
$lang['tz-09:00'] = '[-09:00] Alaska';//'(标准时-9:00) 阿拉斯加';
$lang['tz-08:00'] = '[-08:00] Pacific Time (U.S. & Canada)';//'(标准时-8:00) 太平洋时间(美国和加拿大)';
$lang['tz-07:00'] = '[-07:00] Mountain Time (U.S. & Canada)';//'(标准时-7:00) 山地时间(美国和加拿大)';
$lang['tz-06:00'] = '[-06:00] Central Time (U.S. & Canada), Mexico City';//'(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城';
$lang['tz-05:00'] = '[-05:00] Eastern Time (U.S. & Canada), Bogota';//'(标准时-5:00) 东部时间(美国和加拿大)、波哥大';
$lang['tz-04:00'] = '[-04:00] Atlantic Time (Canada), Caracas';//'(标准时-4:00) 大西洋时间(加拿大)、加拉加斯';
$lang['tz-03:30'] = '[-03:30] Newfoundland';//'(标准时-3:30) 纽芬兰';
$lang['tz-03:00'] = '[-03:00] Brazil, Buenos Aires, Georgetown';//'(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦';
$lang['tz-02:00'] = '[-02:00] Mid-Atlantic';//'(标准时-2:00) 中大西洋';
$lang['tz-01:00'] = '[-01:00] Azores, Cape Verde Islands';//'(标准时-1:00) 亚速尔群岛、佛得角群岛';
$lang['tz 00:00'] = '[ 00:00] Western European Time, London, Casablanca';//(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡';
$lang['tz+01:00'] = '[+01:00] Central European Time, Angola, Libya';//'(标准时+1:00) 中欧时间、安哥拉、利比亚';
$lang['tz+02:00'] = '[+02:00] Eastern European Time, Cairo, Athens';//'(标准时+2:00) 东欧时间、开罗，雅典';
$lang['tz+03:00'] = '[+03:00] Baghdad, Kuwait, Moscow';//'(标准时+3:00) 巴格达、科威特、莫斯科';
$lang['tz+03:30'] = '[+03:30] Tehran';//'(标准时+3:30) 德黑兰';
$lang['tz+04:00'] = '[+04:00] Abu Dhabi, Muscat, Baku';//'(标准时+4:00) 阿布扎比、马斯喀特、巴库';
$lang['tz+04:30'] = '[+04:30] Kabul';//'(标准时+4:30) 喀布尔';
$lang['tz+05:00'] = '[+05:00] Ekaterinburg, Islamabad, Karachi';//'(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇';
$lang['tz+05:30'] = '[+05:30] Bombay, Calcutta, New Delhi';//'(标准时+5:30) 孟买、加尔各答、新德里';
$lang['tz+06:00'] = '[+06:00] Almaty, Dhaka, New????';//'(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚';
$lang['tz+07:00'] = '[+07:00] Bangkok, Hanoi, Jakarta';//(标准时+7:00) 曼谷、河内、雅加达';
$lang['tz+08:00'] = '[+08:00] Beijing, Chongqing, Hong Kong, Singapore';//'(标准时+8:00) 北京、重庆、香港、新加坡';
$lang['tz+09:00'] = '[+09:00] Tokyo, Seoul, Osaka, Yakutsk';//'(标准时+9:00) 东京、汉城、大阪、雅库茨克';
$lang['tz+09:30'] = '[+09:30] Adelaide, Darwin';//'(标准时+9:30) 阿德莱德、达尔文';
$lang['tz+10:00'] = '[+10:00] Sydney, Guam';//'(标准时+10:00) 悉尼、关岛';
$lang['tz+11:00'] = '[+11:00] Magadan, Solomon Islands';//'(标准时+11:00) 马加丹、索罗门群岛';
$lang['tz+12:00'] = '[+12:00] Auckland, Wellington, Kamchatka';//'(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛';

$lang['can_yet_enter']	= 'You can add ';//'你还可以输入';
$lang['twitter_reply_delete_sure']	= 'Are you sure you want to delete the reply?';//'你确定要删除该条回复吗？';
$lang['twitter_reply_exists']		= 'This reply already exists';//'该回复已经存在';
$lang['length_exceed']		= 'Exceed the limit:';//'已超出';
$lang['characters']		= 'characters';//'字';
$lang['reply_captcha_enable']	= 'Enable captcha on reply';//'开启回复验证码';
$lang['reply_premoderate']	= 'Enable reply premoderation';//开启回复审核';
$lang['twitters_per_page']	= 'Number of twitters per page';//'前台每页显示条数';
$lang['save']			= 'Save';//'保存';
$lang['reply_approve']	= 'Approve the reply';//'回复并审核';
$lang['base_settings']	= 'Basic Settings';//'基本设置';
$lang['permalink']	= 'Permalink';//'固定链接';
$lang['time_local']	= 'Local Time';//'本地时间';
$lang['enable_offline_writing']	= 'Enable Offline Writing Support';//'开启离线写作支持';
$lang['draft_edit']		= 'Edit draft';//'编辑草稿';
$lang['pending']		= 'Pending';//'待审';
$lang['approved']		= 'Approved';//'Reviewed';//'已审';
$lang['comments_pending']	= 'Pending comments';//'条待审';
$lang['twitter_number']		= 'Twitters';//'条碎语';
$lang['twitter_length_max']	= 'You can enter max 140 characters';//'你还可以输入140字';
//$lang['twitter_length_max_info']	= 'The length for store must be 140 characters or less';//'回复长度需在140个字内';
$lang['twitter_not_guest']	= 'Sorry, twitter is not enabled for guests!';//'抱歉，碎语未开启前台访问！';
$lang['twitter_show_front']	= 'Whether to display at the front';//'前台是否显示';
$lang['write_something'] 	= 'Write something for today...';//'为今天写点什么吧……';

$lang['use_mobile']		 = 'Use your mobile phone to visit your blog';//'用手机访问你的博客';

$lang['error_htaccess']		= 'Failed to save: .htaccess in the root directory is not writable';//'保存失败：根目录下的.htaccess不可写';
$lang['permalink_info']		= 'You can modify the form of the blog links here to improve the link readability and the friendliness of the search engine.<br />If the blog cannot be accessed after modification, please modify it back to the default format.';//'你可以在这里修改日志链接的形式，以此提高链接的可读性和对搜索引擎的友好程度。<br />如果修改后日志无法访问，请修改回默认形式。';
$lang['default_format']		= 'Default format';//'默认形式';
$lang['file_format']		= 'File format';//'文件形式';
$lang['directory_format']	= 'Directory format';//'目录形式';
$lang['category_format']	= 'Category format';//'分类形式';

//$lang['template_current']	= 'The currently used template (';//'当前使用的模板(';
$lang['template_not_found']	= 'has been deleted or damaged, please select another template.';//'已被删除或损坏，请选择其他模板。';
$lang['template_damaged']	= 'The currently used template has been deleted or damaged, please log in to the background to replace other templates.';//'当前使用的模板已被删除或损坏，请登录后台更换其他模板。';

$lang['posted_ok']	= 'Published successfully';//'发布成功';
$lang['twitter_del_ok']	= 'Twit deleted successfully';//'碎语删除成功';
$lang['twitter_empty']	= 'Twit content cannot be empty';//'碎语内容不能为空';
$lang['settings'] 	= 'Settings';//'设置';
$lang['change'] = 'Change';//'更改';
$lang['more'] = 'More';//'更多',
$lang['twit_post'] = 'Post a twit';//'发布碎语';
$lang['approximately'] = 'approximately ';//'约 ';
$lang['entry_not_exists']	= 'The entry does not exist';//'不存在该条目';
$lang['sure']			= 'Sure';//'确定';
$lang['log_in']			= ' Log in ';//' 登 录 ';
$lang['return']			= 'Return';//'返回';
$lang['email_optional']		= 'Email address (optional)';//'邮件地址 (选填)';
$lang['homepage_optional']	= 'Personal homepage (optional)';//'个人主页 (选填)';
$lang['twitter_send']		= 'Send the twit';//'发碎语';
$lang['summary']		= 'Summary';//'摘要';

$lang['xmlrpc_disabled']	= 'Tip: The blog XMLRPC service is not enabled.';//'提示:博客XMLRPC服务未开启.';
$lang['xmlrpc_error_post']	= 'Error: XML-RPC server can only accept POST data';//'错误:XML-RPC服务器只能接受POST数据';
$lang['xmlrpc_empty']		= 'Error: The submitted data content is empty';//'错误:提交数据内容为空';
$lang['post_not_exists']	= 'Sorry, the blog you tried to access does not exist';//'对不起,您访问日志不存在';
$lang['post_not_found']		= 'Post not found';//'没有日志';
$lang['file_error']		= 'File error';//'文件错误';
$lang['file_name_error']	= 'File name error';//'文件名错误';
$lang['file_type_error']	= 'File type error';//'文件类型错误';
$lang['file_write_error']	= 'File cannot be written';//'文件无法写入';
$lang['user_name_pass_wrong']	= 'Username or password is wrong';//'用户名密码错误';

$lang['plugin_upload_failed']	= 'Plugin upload failed';//'插件上传失败';
$lang['posted_on']		= 'posted on';//'发布于';
$lang['cancel_reply']		= 'Cancel reply';//'取消回复';
$lang['parameter_error']	= 'Parameter error';//'参数错误';
$lang['logged_as']		= 'Logged in as';//'当前已登录为';

$lang['applicable_for_emlog']	= 'Applicable to emlog: ';//'适用于emlog：';
$lang['template_upload_failed']	= 'Template upload failed';//'模板上传失败';

$lang['link_alias']		= 'Link alias';//'链接别名';
$lang['link_alias_need_to']	= 'used to customize the post/page link. Need to ';//'用于自定义日志链接。需要';
$lang['link_alias_enable']	= 'Enable link alias';//'启用链接别名';
$lang['link_alias_html']	= 'Enable html suffix for link alias';//'启用日志链接别名html后缀';

$lang['reference_per_line']	= 'One reference address per line';//'每行一条引用地址';
$lang['post_pin']		= 'Pin the post';//'日志置顶';
$lang['comments_allow']		= 'Allow comments';//'允许评论';
$lang['trackbacks_allow']	= 'Allow trackbacks';//'允许引用';
$lang['page_comments_allow']	= 'Enable page comments';//'页面接受评论';
$lang['backstage_style']	= 'Backstage style';//'后台风格';
$lang['nickname_is_long']	= 'Nickname cannot be too long';//'昵称不能太长';
$lang['email_format_invalid']	= 'Email format error';//'电子邮件格式错误';
$lang['reply_empty']		= 'Reply content cannot be empty';//'回复内容不能为空';
$lang['reply_is_long']		= 'The reply is too long';//'回复内容过长';
$lang['output']			= 'Output';//'输出';
$lang['posts_and_output']	= ' posts, and show as ';//'篇日志，且输出';
$lang['full text']		= 'Full text';//'全文';
$lang['gr_avatar']		= 'Use commenter GRavatar';//'评论人头像';
$lang['comment_pagination']	= 'Comment pagination';//'评论分页';
$lang['show_first']		= 'Show first';//'排在前面';
$lang['newer']			= 'Newer';//'较新的';
$lang['older']			= 'Older';//'较旧的';
$lang['footer_info']		= 'Information at the bottom of the homepage';//'首页底部信息';
$lang['footer_prompt']		= '(Support html, can be used to add traffic statistics code)';//'(支持html, 可用于添加流量统计代码)';
$lang['blog_view']		= 'View blog';//'查看博客';
$lang['plugin_upload_ok']	= 'The plug-in is uploaded successfully, please activate it';//'插件上传成功，请激活使用';
$lang['plugin_del_ok']		= 'Plug-in deleted successfully';//'插件删除成功';
$lang['plugin_del_failed']	= 'Failed to delete the plug-in, please check the file permissions of the plug-in';//'插件删除失败，请检查插件文件权限';
$lang['plugin_install']		= 'Install plugin';//'安装插件';
$lang['plugin_zip_only']	= 'Only support plugin packages in zip compression format';//'只支持zip压缩格式的插件包';
$lang['plugin_not_writable']	= 'Upload failed, please make sure the plugin directory is writable';//'上传失败，请确保插件目录可写';
$lang['plugin_zip_nosupport']	= 'Server does not support zip module, please follow the prompts to install the plug-in manually';//'空间不支持zip模块，请按照提示手动安装插件';
$lang['plugin_use_zip']		= 'Please select a zip plugin installation package';//'请选择一个zip插件安装包';
$lang['plugin_non_standard']	= 'Installation failed, the plug-in installation package does not meet the standard';//'安装失败，插件安装包不符合标准';
$lang['plugin_install_manually'] = 'Manually install the plugin:<br />1. Upload the decompressed plug-in folder to the content/plugins directory.<br />2. Log in to the background to enter the plug-in management. The plug-in already exists in the plug-in management, just click to activate it.<br />';//'手动安装插件： <br />1、把解压后的插件文件夹上传到 content/plugins 目录下。<br />2、登录后台进入插件管理,插件管理里已经有了该插件，点击激活即可。<br />';
$lang['plugin_upload_zip']	= 'Please upload a plug-in installation package in zip compression format.';//'请上传一个zip压缩格式的插件安装包。';
$lang['plugin_get_more']	= 'Get more plugins';//'获得更多插件';
$lang['name']			= 'Name';//'名称';
$lang['alias']			= 'Alias';//'别名';
$lang['serial_number']		= 'Serial number';//'序号';
$lang['alias_friendly']		= 'Friendly display for URL';//'用于URL的友好显示';
$lang['alias_invalid']		= 'The alias is wrong, it should be composed of letters, numbers, underscores, and dashes';//'别名错误，应由字母、数字、下划线、短横线组成';
$lang['post_links']		= 'Permanent links';//'日志链接';
$lang['use_this_style']		= 'Click to use this style';//'点击使用该风格';
$lang['template_install']	= 'Install template';//'安装模板';
$lang['top_image_customize']	= 'Set top image';//'自定义顶部图片';
$lang['template_library']	= 'Template gallery';//'模板库';
$lang['template_upload_ok']	= 'The template was uploaded successfully';//'模板上传成功';
$lang['template_del_ok']	= 'Template deleted successfully';//'删除模板成功';
$lang['template_del_noperm']	= 'Delete failed, please check template file permissions';//'删除失败，请检查模板文件权限';
$lang['twitter_use_name']	= 'Navigation text for Home';//'首页导航文字';
$lang['image_crop']		= 'Crop image';//'裁剪图片';
$lang['image_cut']		= 'Cut and save';//'裁并保存';
$lang['cancel_crop']		= 'Cancel crop';//'取消裁剪';
$lang['crop_prompt']		= '(After the page is loaded, when the selection area does not appear, please press the left mouse button to manually drag and select)';//'(页面加载完毕后，未出现选择区域时请按下鼠标左键手动拖曳选取)';
$lang['cut']			= 'Cut';//'剪';
$lang['template_zip_only']	= 'Only support template package in zip compression format';//'只支持zip压缩格式的模板包';
$lang['template_not_writable']	= 'Upload failed, please make sure the template directory is writable';//'上传失败，请确保模板目录可写';
$lang['template_zip_nosupport'] = 'Server does not support zip module, please follow the prompts to manually install the template';//'空间不支持zip模块，请按照提示手动安装模板';
$lang['template_select_zip']	= 'Please select a zip template installation package';//'请选择一个zip模板安装包';
$lang['template_non_standard']	= 'Installation failed, the template installation package does not meet the standard';//'安装失败，模板安装包不符合标准';
$lang['template_install_manually'] = 'Manually install the template:<br />1. Upload the decompressed template folder to the content/templates directory.<br />2. Log in to the background to change the template. The template you just added is already in the template library, just click to use it.<br />';//'手动安装模板： <br />1、把解压后的模板文件夹上传到 content/templates目录下。 <br />2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。 <br />';
$lang['template_upload_zip']	= 'Please upload a template installation package in zip format.';//'请上传一个zip压缩格式的模板安装包。';
$lang['top_image_replaced_ok']	= 'Top image has been replaced successfully';//'顶部图片更换成功';
$lang['top_image_deleted_ok']	= 'Top image removed successfully.';//'头像删除成功';
$lang['image_crop_failed']	= 'Failed to crop image';//'裁剪图片失败';
$lang['top_image_damaged']	= 'The top picture currently in use has been deleted or damaged. Please select another picture.';//'当前使用的顶部图片已被删除或损坏，请选择其它图片。';
$lang['image_optional']		= 'Optional image';//'可选图片';
$lang['use_this_image']		= 'Click to use this image';//'点击使用该图片';
$lang['custom_image']		= 'Custom image';//'自定义图片';
$lang['top_image_prompt']	= '(Upload a top image you like, support JPG, PNG format)';//'(上传一张你喜欢的顶部图片，支持JPG、PNG格式)';
$lang['alias_characters']	= 'Aliases can only consist of letters, numbers, underscores, and dashes';//'别名只能由字母、数字、下划线、短横线组成';
$lang['alias_unique']		= 'Alias cannot be repeated';//'别名不能重复';
$lang['alias_no_system']	= 'Alias must not contain system reserved keywords';//'别名不得包含系统保留关键字';
$lang['alias_no_numeric']	= 'The alias cannot be a pure number';//'别名不能为纯数字';
$lang['load_failed']		= ' failed to load.';//'加载失败。';
$lang['page_not_exists']	= 'Sorry, the page you requested does not exist!';//'抱歉，你所请求的页面不存在！';
$lang['admin_password_len']	= '(Not less than 6 digits)';//'(不小于6位)';

$lang['no_posts_yet']		= 'No posts yet';//'还没有日志';
$lang['no_pages_yet']		= 'No pages yet';//'还没有页';//'还没有页面';
$lang['no_backups_yet']		= 'No backups yet';'还没有备份';
$lang['select all']		= 'Select all';//'全选';
$lang['bulk_upload']		= 'Bulk upload';//'批量上传';
$lang['embed']			= 'Embed';//'插入';
$lang['show_perpage']		= 'Show per page';//'每页显示';
$lang['keyword_perpage_max']	= ' keywords max';//'条日志';
$lang['function_switch']	= 'Function switch';//'功能开关';
$lang['login_captcha']		= 'Login Verification Code (Captcha)';//'登录验证码';
$lang['attachment_thumb']	= 'Image attachment thumbnail';//'图片附件缩略图';
$lang['gzip_compression']	= 'Gzip compression';//'Gzip压缩';
$lang['offline_writing']	= 'Offline writing';//'离线写作';
$lang['site_title']		= 'Site META title';//'站点浏览器标题';
$lang['twitter_enable']		= 'Enable Twitter';//'开启微语';//'开启碎语';
$lang['upload_insert']		= 'Upload and insert';//'上传插入';
$lang['site_view']		= 'View the site';//'查看站点';
$lang['navbar']			= 'Navigation';//'导航';
$lang['site_info']		= 'Site Information';//'站点信息';
$lang['click_to_hide_link']	= 'Click to hide the link';//'点击隐藏链接';
$lang['click_to_show_link']	= 'Click to show the link';//'点击显示链接';
$lang['visible']		= 'Visible';//'显示';
$lang['no_links_yet']		= 'No links added yet';//'还没有添加链接';
$lang['nav_manage']		= 'Navigation management';//'导航管理';
$lang['nav_del_ok']		= 'Navigation successfully deleted';//'删除导航成功';
$lang['nav_edit_ok']		= 'Navigation successfully modified';//'修改导航成功';
$lang['nav_add_ok']		= 'Navigation added successfully';//'添加导航成功';
$lang['nav_empty']		= 'Navigation name and address cannot be empty';//'导航名称和地址不能为空';
$lang['nav_no_category']	= 'No navigation categories';//'没有可排序的导航';
$lang['nav_not_del']		= 'Default navigation cannot be deleted';//'默认导航不能删除';
$lang['category_select']	= 'Please select the category to add';//'请选择要添加的分类';
$lang['page_select']		= 'Please select the page to add';//'请选择要添加的页面';
$lang['url_redirect']		= 'Redirect address';//'跳转地址';
$lang['nav_edit']		= 'Edit navigation';//'修改导航';
$lang['nav_hide']		= 'Click to hide navigation';//'点击隐藏导航';
$lang['nav_show']		= 'Click to show navigation';//'点击显示导航';
$lang['nav_no_yet']		= 'No navigation added yet';//'还没有添加导航';
$lang['nav_add_custom']		= 'Add custom navigation';//'添加自定义导航';
$lang['nav_name']		= 'Navigation name';//'导航名称';
$lang['nav_url']		= 'Navigation address';//'导航地址';
$lang['open_new_window']	= 'Open in new window';//'在新窗口打开';
$lang['add']			= 'Add';//'添加';
$lang['nav_add_category']	= 'Add category to navigation';//'添加分类到导航';
$lang['category_no_yet']	= 'No categories yet';//'还没有分类';
$lang['nav_page_add']		= 'Add page to navigation';//'添加页面到导航';
$lang['no_plugin_yet']		= 'No plugins installed yet';//'还没有安装插件';
$lang['official_recommendation'] = 'Official recommendation';//'官方推荐';
$lang['plugin_more']		= 'More plugins';//'更多插件';
$lang['alias_prompt']		= 'Used to customize the link address of this page. It is required to ';//'用于自定义该页面的链接地址。';
$lang['need_for']		= 'It is required to ';//'需要';

$lang['no_tags_yet']		= 'No tags have been set yet!';//'还没有设置过标签！';
$lang['no_tags_yet_add']	= 'No tags yet. You can add tags when writing the post';//'还没有标签，写日志的时候可以给日志打标签';
$lang['template_upload_zip']	= '(Upload a template installation package in zip compression format)';//'(上传一个zip压缩格式的模板安装包)';
$lang['template_more']		= 'More templates';//'更多模板';
$lang['no_trackback_yet']	= 'No trackbacks yet';//'还没有收到引用';
$lang['from_cloud']		= 'From the cloud platform';//'来自云平台';
$lang['upload_bad_browser']	= 'The browser version you are using is too low to use the bulk upload feature. In order to better use emlog, it is recommended that you upgrade your browser or switch to another browser.';//'您正在使用的浏览器版本太低，无法使用批量上传功能。为了更好的使用emlog，建议您升级浏览器或者换用其他浏览器。';
$lang['file_select']		= 'Select file';//'选择文件';
$lang['administrator']		= 'Administrator';//'管理员';
$lang['no_author_yet']		= 'No authors added yet';//'还没有添加作者';

$lang['image_type_support']	= '(Support image format: JPG, PNG)';//'(支持JPG、PNG格式图片)';
$lang['comment_not_exist']	= 'The comment does not exist!';//'不存在该评论！';
$lang['backup_not_emlog']	= 'Import failed! The backup file is not an emlog backup file!';//'导入失败！该备份文件不是 emlog的备份文件!';
$lang['backup_bad_ver1']	= 'Import failed! The backup file does not correspond Emlog ';//'导入失败！该备份文件不是emlog';
$lang['backup_bad_ver2']	= '!';//'生成的备份!';
$lang['plugin_view']		= 'View plugin';//'查看插件';
$lang['image_share']		= 'Share image';//'分享图片';
$lang['404_title']		= 'Error message - page not found';//'错误提示-页面未找到';
$lang['not_found']		= 'Not found';//'未找到';
$lang['search_no_results']	= 'Sorry, there are no results that meet your query.';//'抱歉，没有符合您查询条件的结果。';
$lang['category_subscribe']	= 'Subscribe to this category';//'订阅该分类';
$lang['image_view']		= 'View image';//'查看图片';
$lang['article_write']		= 'Add article';//'写文章';
$lang['comment_too_fast']	= 'Comment failed: You submitted a comment too fast, please comment later.';//'评论失败：您提交评论的速度太快了，请稍后再发表评论';
$lang['comment_chinese']	= 'Comment failed: the content of the comment must contain Chinese characters';//'评论失败：评论内容需包含中文';
$lang['captcha_invalid']	= 'Invalid verification code, please re-enter';//'验证错误，请重新输入';
$lang['username_invalid']	= 'Username is wrong, please re-enter';//'用户名错误，请重新输入';
$lang['password_invalid']	= 'Wrong password, please re-enter';//'密码错误，请重新输入';
$lang['hot_articles']		= 'Popular articles';//'热门文章';
$lang['mobile_disabled']	= 'Mobile access version has been disabled!';//'手机访问版已关闭！';
$lang['reply_no_yet']		= 'No replies yet!';//'还没有回复！';
$lang['twitter_content']	= 'Twit content';//'微语内容';
$lang['image_select']		= 'Select the image to upload';//'选择要上传的图片';
$lang['home_hot_articles']	= 'Number of popular articles shown at the home page';//'首页显示热门文章数';
$lang['_users']			= ' users';//'位用户';
$lang['app_center']		= 'App Center';//'应用中心';
$lang['tag_empty']		= 'Tag cannot be empty';//'标签不能为空';
$lang['seo_settings']		= 'SEO settings';//'SEO设置';
$lang['password_forget']	= 'Forget the password?';//'忘记密码?';
$lang['image_original']		= 'Original image';//'原图';
$lang['image_original_insert']	= 'Insert original image';//'插入原图';
$lang['thumbnail_insert']	= 'Insert thumbnail';//'插入缩略图';
$lang['comment_content']	= 'Comment content';//'评论内容';
$lang['comment_edit']		= 'Edit comment';//'编辑评论';
$lang['comment_edit_ok']	= 'Comment modified successfully';//'修改评论成功';
$lang['comment_empty']		= 'Comment content cannot be empty';//'评论内容不能为空';
$lang['nav_format_error']	= 'The navigation address format is wrong (need to include a prefix such as http)';//'导航地址格式错误(需包含http等前缀)';
$lang['image_name']		= 'Image name';//'图片名称';
$lang['download_install']	= 'Downloading and installing';//'正在下载安装中';
$lang['back_to_appcenter']	= 'Back to App center';//'返回应用中心';
$lang['download_error_manually']	= 'The download failed, it may be a server network problem, please download and install manually,';//'下载失败，可能是服务器网络问题，请手动下载安装，';
$lang['decompression_error']	= 'Decompression failed. It may be that the server does not support the zip module. Please download and install it manually.';//'解压失败，可能是服务器不支持zip模块，请手动下载安装，';
$lang['install_error']		= 'Installation failed, ';//'安装失败，';
$lang['article_title']		= 'Article title';//'文章标题';//'输入文章标题';
$lang['tags_current']		= 'Current article tags';//'已有标签';
$lang['article_summary']	= 'Article Summary';//'文章摘要';
$lang['article_link_alias']	= 'Article link alias';//'文章链接别名';
$lang['trackback_1_perline']	= '(1 address per line)';//'(每行一条引用地址)';
$lang['mobile_version']		= 'Mobile version';//'手机访问版';
$lang['mobile_use']		= 'Use your mobile phone to visit your site';//'用手机访问你的站点';
$lang['_twits']			= ' twits';//'条微语';
$lang['twitter_reply_enable']	= 'Enable Twitter replies';//'开启微语回复';
$lang['comment_enable']		= 'Enable comments';//'开启评论';
$lang['comment_delay']		= 'Comment time interval';//'发表评论间隔';
$lang['_seconds']		= ' seconds';//'秒';
$lang['comment_need_chinese']	= 'Comment content must contain Chinese characters';//'评论内容必须包含中文';
$lang['server_zip_nosupport']	= 'The server does not support zip and cannot import zip backup';//'服务器不支持zip，无法导入zip备份';
$lang['backup_upload_error']	= 'Failed to upload backup';//'上传备份失败';
$lang['zip_export_error']	= 'The server does not support zip and cannot export zip backup';//'服务器不支持zip，无法导出zip备份';
$lang['backup_export_to']	= 'Export backup file to';//'导出备份文件到';
$lang['backup_compress']	= 'Compression (zip format)';//'压缩(zip格式)';
$lang['backup_format_support']	= '(Supported emlog backup files in sql and zip format)';//'(支持emlog导出的sql及zip格式备份)';
$lang['extensions']		= 'Extensions';//'扩展功能';
$lang['link_settings']		= 'Article link settings';//'文章链接设置';
$lang['meta_settings']		= 'Meta settings';//'Meta设置';
$lang['meta_keywords']		= 'Site meta keywords';//'站点关键字';
$lang['meta_description']	= 'Site meta description';//'站点浏览器描述';
$lang['meta_title_scheme']	= 'Article meta title scheme';//'文章浏览器标题方案';
$lang['article_title_site_title']	= 'Article Title - Site Title';//'文章标题 - 站点标题';
$lang['article_title_site_meta_title']	= 'Article Title - Site Meta Title';//'文章标题 - 站点浏览器标题 ';
$lang['article']		= 'Article';//'文章';
$lang['none']			= 'None';//'无';
$lang['category_parent']	= 'Parent category';//'父分类';
$lang['category_description']	= 'Category Description';//'分类描述';
$lang['alias_bad_format']	= 'Alias format error';//'别名格式错误';
$lang['category_edit']		= 'Edit category';//'编辑分类';

$lang['type']		= 'Type';//'类型';
$lang['system']		= 'System';//'系统';
$lang['custom']		= 'Custom';//'自定';

$lang['login_name']	= 'Login name';//'登陆名';
$lang['founder']	= 'Founder';//'创始人';
$lang['article_need_premod']	= '(Article needs to be reviewed)';//'(文章需审核)';
$lang['navigation_generated']	= 'The navigation address is generated by the system and cannot be modified';//'该导航地址由系统生成，无法修改';
$lang['comment_hide_ok']	= 'Comment was hide successfully';//'隐藏评论成功';
$lang['comment_del_from_ip']	= 'Delete all comments from this IP';//'删除来自该IP的所有评论';

$lang['_pebding_articles']	= ' pending articles';//'篇文章待审';
$lang['top_image_no']		= 'Do not use top image';//'不使用顶部图片';
$lang['founder_no_delete']	= 'Cannot delete founder';//'不能删除创始人';
$lang['founder_no_edit']	= 'Cannot modify founder information';//'不能修改创始人信息';
$lang['article_no_review']	= 'Article does not need to be reviewed';//'文章不需要审核';
$lang['article_to_review']	= 'Article needs to be reviewed';//'文章需要审核';
