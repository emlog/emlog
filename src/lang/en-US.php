<?php
//emlog ENGLISH language PHP file

// : = ：
// ! ！
// , ，
// ( （
// ) ）
// 

$lang['install']	= 'install';//安装程序
$lang['install_step1']	= '1. the database settings (MySQL database)';//1、数据库设置 （MySQL数据库）
$lang['install_step2']	= '2. Administrator settings (for logon to the blog after the successful installation)';//2、博主设置 （用于安装成功后登录博客）
$lang['install_seems_installed'] = 'Your emlog seem to have installed before. Continue the installation may overwrite the original data, you want to continue? ';//你的emlog看起来已经安装过了。继续安装可能会覆盖掉原有的数据，你要继续吗？
$lang['install_continue']  = 'Continue';//继续
$lang['install_post_body'] = 'Welcome to emlog! Start your blog journey now.';//欢迎使用emlog开始你的博客之旅。
$lang['install_slogan'] = 'A happy life need to be carefullly recored.';//美好的生活需要用心记录
$lang['install_twitter'] = 'With a simple written records of your life';//用简单的文字记录你的生活
$lang['install_ok']	= 'added successfully.<br />Congratulations! emlog installed successfully.<br /><span style=\"color:red;\"><b>Please delete the installation file (install.php) from the root directory!</b></span><br /><br /><a href=\"./\"> Enter the emlog </a>';//
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
$lang['db_connect_error'] = 'Connect to database failed. Check the database username or password.';//"连接数据库失败,可能是数据库用户名或密码错误"
$lang['db_not_found']	= 'Specified database not found.';//未找到指定数据库
$lang['admin_settings'] = 'Administrator settings (for the installation of sign after the success of blog use)';
$lang['admin_name']	= 'Administrator Name';//博主登录名
$lang['admin_password'] = 'Administrator Password';//博主登录密码
$lang['admin_password_repeat'] = 'Re-enter the Administrator Password';//再次输入博主登录密码
$lang['admin_password_empty'] = 'Administrator Name and password should not be empty!';//'博主登录名和密码不能为空!'
$lang['admin_name_added'] = 'added successfully';//添加成功


$lang['with'] = 'There are';//有
$lang['items'] = 'items';//条
$lang['data'] = 'Data';//数据
$lang['extensions'] = 'Extensions';//功能扩展

$lang['plugins'] = 'Plug-ins';//插件
$lang['plugin_management'] = 'Plugin Management';//插件管理
$lang['plugin_activated_ok'] = 'Plugin activated successfully!';//插件激活成功
$lang['plugin_deactivated_ok'] = 'Plugin deactivated successfully!';//插件禁用成功
$lang['plugin_name'] = 'Plugin';//插件
$lang['plugin_version'] = 'Version';//版本
$lang['plugin_status'] = 'Status';//状态
$lang['plugin_active'] = 'Active';//已激活
$lang['plugin_inactive'] = 'Inactive';//未激活
$lang['plugin_page'] = 'Plugin page';//插件主页
$lang['plugin_repository'] = 'Emlog Plugin Repository';//获取更多插件

$lang['return_to_admin_center'] = 'Return to Admin Center';//返回管理首页
$lang['blog_view_in_new_window'] = 'Show the Blog in a New Window';//在新窗口浏览我的blog



$lang['posts'] = 'Posts';//日志 //篇日志
$lang['blog_posts'] = 'Blog posts';//'篇日志';
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
$lang['post_publish'] = 'Publish the Post';//发布日志
$lang['post_published_ok'] = 'The post published successfully!';//'日志发布成功!'//发布日志成功
$lang['post_saved_ok'] = 'The post saved successfully!';//'页面保存成功!'//'日志保存成功!'
$lang['post_author_changed_ok'] = 'The post author changed successfully!';//更改 作者成功
$lang['post_view_in_new_window'] = 'Show the Post in a New Window';//在新窗口查看
$lang['post_delete_sure'] = 'Are you sure you want to delete the selected posts?';//'你确定要删除所选日志吗？'
$lang['post_password'] = 'Post Access Password';//日志访问密码
$lang['post_password_leave_empty'] = 'Leave Password empty if not required';//留空则不加访问密码
$lang['post_add'] = 'Add Post';//写日志
$lang['post_add_new'] = 'Add New Post';//新建页面
$lang['post_not_exists'] = 'The entry does not exist';//不存在该日志
$lang['post_time'] = 'Post Time';//发布时间：
$lang['post_abstract'] = 'Abstract';//日志摘要
$lang['post_edit'] = 'Edit Post';//编辑日志
$lang['posted_by'] = 'Posted by';


$lang['publish'] = 'Publish';//发布
$lang['unpublish'] = 'Make Draft';//转入草稿箱





$lang['yes'] = 'Yes';//否
$lang['no'] = 'No';//

$lang['mail_to'] = 'Mail to';//发邮件给
$lang['go_to'] = 'Go to';//访问
$lang['homepage'] = 'homepage';//'的主页';
$lang['author_homepage'] = 'homepage';//的主页 //作者主页
$lang['rss_feed'] = 'RSS Feed';//订阅Rss
$lang['bytes'] = 'bytes';//字节
$lang['access_disabled'] = 'Insufficient privileges!';//权限不足!
$lang['enter'] = 'Enter';//进入



$lang['parameter_invalid'] = 'Submitted parameters error';//提交参数错误
$lang['calendar'] = 'Calendar';//日历

$lang['sort'] = 'Sort';
$lang['archive'] = 'Archive';//归档 //存档
$lang['submit'] = 'Submit';//提交 //确 定
$lang['reset'] = 'Reset';//重 置




$lang['blog'] = 'Blog';
$lang['no_blogs_yet'] = 'No logs yet!';
$lang['blog_view'] = 'View Blog';//浏览日志
$lang['blog_view_link'] = 'View the Blog';//查看该日志
$lang['blog_delete'] = 'Delete Blog';
$lang['blog_enter_password'] = 'Please enter a Password to Access the Blog';//输入日志访问密码 //请输入该日志的访问密码
$lang['blog_password_protected'] = 'The blog is password protected';
$lang['blog_password_protected_info'] = 'The blog is password protected. Click on the title to enter a password to access.';//该日志已设置加密，请点击标题输入密码访问
$lang['blog_tags'] = 'Blog tags';//日志标签

$lang['management'] = 'Manage';//博客管理
$lang['blog_author'] = 'Blog Author';//日志作者


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
$lang['emlog_homepage'] = 'emlog Official Home Page';//emlog官方主页
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


$lang['home'] = 'Home';//首页 //返回 首页
$lang['back_home'] = 'Back to Homepage';//返回主页
$lang['time'] = 'Time';//时间
$lang['back_to_list'] = 'Back to blog list';//返回日志列表

$lang['twitter'] = 'Twitter';//博主唠叨
$lang['twitter_first_text'] = 'Simple language Record your life';
$lang['no_twitter_yet'] = 'No twitter yet!';
$lang['twitters_number'] = 'Number of twitters to show';//首页显示twitter数
$lang['twitter_add'] = 'Add twitter';//唠叨两句 //我要唠叨
$lang['content'] = 'Content';//内容

$lang['user_name'] = 'User Name';//用户 //用户名
$lang['users'] = 'Users';//作者
$lang['user_management'] = 'User Management';//作者管理
$lang['user_deleted_ok'] = 'Users deleted successfully';//删除作者成功
$lang['user_edited_ok'] = 'User edited successfully';//修改作者资料成功
$lang['user_added_ok'] = 'User added successfully';//添加作者成功
$lang['user_name_empty'] = 'User name should not be empty';//用户名不能为空
$lang['user_allready_exists'] = 'This username allready exists';//该用户名已存在
$lang['user_add_info'] = 'Add the user (co-writer)';//添加作者(联合撰写人)
$lang['user_add'] = 'Add user';//添加作者
$lang['login_modified_ok'] = 'Login modified successfully! Please Log in.';//'后台登录名修改成功!请重新登录'
$lang['login_and_password_modified_ok'] = 'Login and Password modified successfully! Please Log in.';//'密码和后台登录名修改成功!请重新登录'
$lang['password'] = 'Password';//密码
$lang['password_length'] = '(Not less than 5 characters)';
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
$lang['visit'] = 'Visit';
$lang['poster_homepage'] = 'The Home Page';
$lang['reply'] = 'Reply';//博主回复 //回复
$lang['blog_reply'] = 'Blog reply';//'博主回复';
$lang['cancel'] = 'Cancel';//取消
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

$lang['admin_center'] = 'Admin';//管理中心 //管理首页
$lang['you_are'] = 'You are';//你好
$lang['no_title'] = 'No Title';

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
$lang['category_add'] = 'Add New Category';//添加新分类
$lang['category_feed'] = 'Category Feed';//订阅该 分类



$lang['advanced_options'] = 'Advanced Options';//高级选项

$lang['save'] = 'Save';//保 存
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

$lang['settings'] = 'Settings';//博客设置
$lang['save_settings'] = 'Save Settings';//保存设置
$lang['settings_saved_ok'] = 'Settings saved successfully.';//设置保存成功

$lang['posts_manage'] = 'Posts';
$lang['data_manage'] = 'Data';
$lang['draft'] = 'Draft';//草稿 //隐藏
$lang['drafts'] = 'Drafts';//'草稿箱'
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
$lang['backup_extension_invalid'] = 'Database Backup File Extension is invalid. Can only restore *.sql file.';//'读取数据库文件失败, 只能恢复 *.sql 文件'
$lang['backup_format_invalid'] = 'Import failed! The backup file does not correspond emlog version ';//"导入失败! 该备份文件不是 emlog "
$lang['backup_prefix_invalid'] = 'Import failed! Database Backup file prefix does not match the configured Database Prefix.';//"导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配"
$lang['backup_filename'] = 'Backup File name';//备份文件名
$lang['backup_filename_info'] = 'Backup File name can consist only latin alphabet characters, numbers, defis and underscores.';//由英文字母、数字、下划线组成
$lang['backup_filename_invalid'] = 'Error! Wrong backup file name.';//错误的备份文件名
$lang['backup_place'] = 'Backup lplace';//备份文件保存在
$lang['backup_local'] = 'Local computer';//本地
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

$lang['enter_modifications'] = 'Please enter the modifications in the project parameters';
$lang['verification_code_not_supported'] = 'Open Verification Code failure! Server does not support this feature.';//"开启登录验证码失败!服务器不支持该功能"
$lang['phpinfo_disabled'] = 'phpinfo function is disabled!';//"phpinfo函数被禁用!"
$lang['logout_ok'] = 'Log out success!';//'退出成功！'
$lang['supported'] = 'Supported';//'支持'
$lang['not_supported'] = 'NOT supported';//'不支持'
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
$lang['photo_info'] = 'Photo (Recommended size is 185x230 pixels, in the format of jpg or png image)';//头像 (推荐上传大小为185 X 230，格式为jpg或png的图片)
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
$lang['unapprove'] = 'Unapprove';
$lang['approved'] = 'Approved';
$lang['approve'] = 'Approve';
$lang['author'] = 'Author';//作者 //未分类

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
$lang['link_name'] = 'Site name';//名称
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

$lang['templates'] = 'Templates';//换模板
$lang['template_admin_not_found'] = 'the Admin-Center template not found!';
$lang['template_current'] = 'Current template';//当前模板
$lang['template_changed_successfully'] = 'Template changed successfully';//模板更换成功
$lang['templates_are_available'] = 'Available templates';//可用模板
$lang['templates_available'] = 'Total templates available';//当前共有 个可用模板
$lang['templates_more'] = 'More templates (Templates Repository)';//获取更多模板
$lang['template_click'] = 'Click to use the template';//点击使用该模板
$lang['template_path_error'] = 'The Template Path Error';


$lang['upload'] = 'Start Upload!';//上传
$lang['uploads'] = 'Uploads';
$lang['upload_failed_code'] = 'Upload failed. Error code';//上传文件失败,错误码
$lang['uploads_not_written'] = 'Upload failed. File Upload Directory (content/uploadfile) can not be written';//上传失败。文件上传目录(content/uploadfile)不可写

$lang['attachment_manager'] = 'Attachment Manager';//附件管理
$lang['attachment_create_failed'] = 'Create file upload directory failed';//创建文件上传目录失败
$lang['attachment'] = 'Attachment';
$lang['attachments'] = 'Attachments';//文件 附件
$lang['attachment_upload'] = 'Upload attachment';//上传附件
$lang['attachment_library'] = 'Attachment gallery';//附件库
$lang['attachment_no'] = 'No attachment here';//该日志没有附件
$lang['attachment_exceed_system_limit'] = 'Attachment size exceeds the system Restriction';//附件大小超过系统
$lang['attachment_delete_error'] = 'Attachment Delete failure';//"删除附件失败!"
$lang['attachment_increase'] = 'Increase attachment fields';//增加附件
$lang['attachment_decrease'] = 'Decrease attachment fields';//减少附件
$lang['attachment_max_size'] = 'Max enabled upload file size';//单个附件最大
$lang['attachment_max_system_size'] = 'Max enabled upload file size';//服务器允许上传最大文件
$lang['attachment_types'] = 'Enabled attachment types';//允许类型
$lang['attachment_type_archive'] = 'Archive';//'压缩包'
$lang['compressed_package'] = 'Compressed package';
$lang['attachment_embed'] = 'Embed';//嵌入

$lang['widgets'] = 'Widgets';//Widgets
$lang['widgets_custom'] = 'Custom Widgets';//自定义组件
$lang['widget_custom'] = 'Custom widget';//未命名组件
$lang['widgets_list'] = 'Widget List';
$lang['widgets_order'] = 'Widgets Order (drag-n-drop)';
$lang['widgets_order_save'] = 'Save Widgets Order)';//保存组件排序
$lang['widget_delete'] = 'Delete the Widget';//删除该组件
$lang['widget_name'] = 'Widget Name';//组件名
$lang['widget_content'] = 'Widget Content (html supported)';//内容 （支持html）
$lang['widget_new'] = 'New Custom Widget';//自定义一个新的组件
$lang['widget_repository'] = 'Wiget Repository';//获取更多有趣的组件
$lang['widget_add'] = 'Add New Widget';//添加组件
$lang['widgets_saved_ok'] = 'Widgets Settings saved successfuly';//设置保存成功
$lang['widget_blogger'] = 'Blogger';//blogger
$lang['widget_blogger_info'] = 'Modify User Personal Data';//修改个人资料...
$lang['widget_change'] = 'Change';//更改

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


$lang['trackbacks'] = 'Trackbacks';//引用通告 //引用
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
$lang['trackback_management'] = 'Trackback Management';//引用管理
$lang['trackback_delete_selected'] = 'Delete Selected Trackbacks';
$lang['trackback_delete_sure'] = 'Are you sure you want to delete the selected trackbacks?';//你确定要删除所选引用吗？
$lang['trackback_deleted_ok'] = 'Trackback deleted successfully.';//删除引用成功
$lang['trackback_select'] = 'Please select the trackback to operate with.';//请选择要执行操作的引用
$lang['trackbacks_per_page'] = '/ 15 per page';
$lang['trackbacks_articles'] = 'article references / trackbacks';//条引用


$lang['comments'] = 'Comments';//评论 //条评论
$lang['comment'] = 'Comment';//发表评论
$lang['comment_add'] = 'Add a Comment';
$lang['comment_posted_ok'] = 'Comment published successfully!';
$lang['comment_posted_premod'] = 'Your comment saved successfully! Please wait for the administrator review and approve this!';
$lang['comments_no_yet'] = 'No comments yet!';
$lang['comment_reply'] = 'Comment reply';//回复评论
$lang['comments_disabled'] = 'Add Comment Failed. Comments for this Blog disabled.';
$lang['comment_allready_exists'] = 'Error. A Comment with the same content already exists.';
$lang['comment_invalid'] = 'Error! Comment text entered is invalid.';

$lang['comments_enable'] = 'Accept Comments';//接受评论？是
$lang['comments_approve'] = 'Approve';//审核
$lang['comments_approved'] = 'Approved';//已审核
$lang['comments_unapproved'] = 'Unapproved';//未审核
$lang['comments_replied'] = 'Replied';//已回复
$lang['comments_management'] = 'Comments Management';//评论管理
$lang['comments_delete_sure'] = 'Are you sure you want to delete the selected comment?';//你确定要删除所选评论吗？
$lang['comments_deleted_ok'] = 'Comments deleted successfully.';//删除评论成功
$lang['comments_approved_ok'] = 'Comments approved successfully.';//审核评论成功
$lang['comments_hide'] = 'Hide';//屏蔽
$lang['comments_hide_ok'] = 'Comments hide successfully.';//屏蔽评论成功
$lang['comments_select'] = 'Please select the comments to perform the operation.';//请选择要执行操作的评论 //请选择要操作的评论
$lang['comments_select_operation'] = 'Please select the operation to perform.';//请选择要执行的操作
$lang['comment_replied_ok'] = 'Comment replied successfully.';//回复评论成功
$lang['comment_author'] = 'From';//所属日志 //评论人
$lang['from'] = 'From';//来自

$lang['comments_with_selected'] = 'With seclected comments';
$lang['comments_per_page'] = '/ 15 per page';
$lang['comments_require_approving'] = 'Require approvement for new comments';//开启评论审核
$lang['comments_require_verification_code'] = 'Require verification code for new comments';//开启评论验证码
$lang['comments_require_approving_info'] = 'Comments will be shown after approving only.';//开启后评论需通过审核才能显示
$lang['comments_latest_number'] = 'Number of latest comments at homepage';//首页最新评论数
$lang['comments_trim_length'] = 'Trim comment length to N characters';//新近评论截取字节数
$lang['comment_error_disabled'] = 'Error. Comments for this post are disabled!';//发表评论失败:该日志已关闭评论
$lang['comment_error_allready_exists'] = 'Error. The same comment content already exists!';//发表评论失败:已存在相同内容评论
$lang['comment_error_invalid_name'] = 'Error. UserName does not meet specifications!';//'发表评论失败:姓名不符合规范'
$lang['comment_error_invalid_email'] = 'Error. Email does not meet specifications!';//'发表评论失败:邮件地址不符合规范'
$lang['comment_error_invalid_content'] = 'Error. Comment content does not meet specifications!';//'发表评论失败:内容不符合规范'
$lang['comment_error_nocode'] = 'Error. You have to enter the verification code!';//'发表评论失败:验证码不能为空'
$lang['comment_error_invalid_code'] = 'Error. You have entered invalid verification code!';//'发表评论失败:验证码错误'
$lang['comment_error_'] = 'Error. !';//

$lang['pages']	= 'Pages';//个页面
$lang['page_add']	= 'Add new page';//新建一个页面
$lang['page_management']	= 'Page Management';//页面管理
$lang['page_url']	= 'External page URL';//转向地址
$lang['page_url_info']	= 'If you fill out, the page title will point to this URL';//如果填写，页面标题将指向该地址
$lang['page_comments_enable']	= 'Enable comments for this page';//页面是否接受评论
$lang['page_new_window']	= 'Open the page in a new window';//在新窗口打开页面
$lang['page_publish']	= 'Publish page';//发布页面
$lang['page_save']	= 'Save';//保存
$lang['page_published_ok'] = 'Page published successfully!';//'页面发布成功！' //'发布页面成功';
$lang['page_unpublished_ok'] = 'Page unpublished successfully!';//禁用页面成功
$lang['page_saved_ok']	= 'Page saved successfully!';//'页面保存成功！'
$lang['page_deleted_ok']	= 'Page deleted successfully!';//删除页面成功
$lang['page_select_to_deal']	= 'Please select the page to deal with';//请选择要操作的页面
$lang['page_delete_sure']	= 'Are you sure you want to delete the selected page?';//你确定要删除所选页面吗?
$lang['page_edit']	= 'Edit page';//编辑页面

$lang['username_allready_exists'] = 'The username already exists';//'用户名已存在'
$lang['enter_items'] = 'Please enter the items you want to modify';//'请输入要修改的项目'

$lang['tz-12:00'] = '[-12:00] Dateline West';//'(标准时-12:00) 日界线西'
$lang['tz-11:00'] = '[-11:00] Midway Island, Samoa';//'(标准时-11:00) 中途岛、萨摩亚群岛'
$lang['tz-10:00'] = '[-10:00] Hawaii';//'(标准时-10:00) 夏威夷'
$lang['tz-09:00'] = '[-09:00] Alaska';//'(标准时-9:00) 阿拉斯加'
$lang['tz-08:00'] = '[-08:00] Pacific Time (U.S. & Canada)';//'(标准时-8:00) 太平洋时间(美国和加拿大)'
$lang['tz-07:00'] = '[-07:00] Mountain Time (U.S. & Canada)';//'(标准时-7:00) 山地时间(美国和加拿大)'
$lang['tz-06:00'] = '[-06:00] Central Time (U.S. & Canada), Mexico City';//'(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城'
$lang['tz-05:00'] = '[-05:00] Eastern Time (U.S. & Canada), Bogota';//'(标准时-5:00) 东部时间(美国和加拿大)、波哥大'
$lang['tz-04:00'] = '[-04:00] Atlantic Time (Canada), Caracas';//'(标准时-4:00) 大西洋时间(加拿大)、加拉加斯'
$lang['tz-03:30'] = '[-03:30] Newfoundland';//'(标准时-3:30) 纽芬兰'
$lang['tz-03:00'] = '[-03:00] Brazil, Buenos Aires, Georgetown';//'(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦'
$lang['tz-02:00'] = '[-02:00] Mid-Atlantic';//'(标准时-2:00) 中大西洋'
$lang['tz-01:00'] = '[-01:00] Azores, Cape Verde Islands';//'(标准时-1:00) 亚速尔群岛、佛得角群岛'
$lang['tz 00:00'] = '[ 00:00] Western European Time, London, Casablanca';//(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡'
$lang['tz+01:00'] = '[+01:00] Central European Time, Angola, Libya';//'(标准时+1:00) 中欧时间、安哥拉、利比亚'
$lang['tz+02:00'] = '[+02:00] Eastern European Time, Cairo, Athens';//'(标准时+2:00) 东欧时间、开罗，雅典'
$lang['tz+03:00'] = '[+03:00] Baghdad, Kuwait, Moscow';//'(标准时+3:00) 巴格达、科威特、莫斯科'
$lang['tz+03:30'] = '[+03:30] Tehran';//'(标准时+3:30) 德黑兰'
$lang['tz+04:00'] = '[+04:00] Abu Dhabi, Muscat, Baku';//'(标准时+4:00) 阿布扎比、马斯喀特、巴库'
$lang['tz+04:30'] = '[+04:30] Kabul';//'(标准时+4:30) 喀布尔'
$lang['tz+05:00'] = '[+05:00] Ekaterinburg, Islamabad, Karachi';//'(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇'
$lang['tz+05:30'] = '[+05:30] Bombay, Calcutta, New Delhi';//'(标准时+5:30) 孟买、加尔各答、新德里'
$lang['tz+06:00'] = '[+06:00] Almaty, Dhaka, New????';//'(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚'
$lang['tz+07:00'] = '[+07:00] Bangkok, Hanoi, Jakarta';//(标准时+7:00) 曼谷、河内、雅加达'
$lang['tz+08:00'] = '[+08:00] Beijing, Chongqing, Hong Kong, Singapore';//'(标准时+8:00) 北京、重庆、香港、新加坡'
$lang['tz+09:00'] = '[+09:00] Tokyo, Seoul, Osaka, Yakutsk';//'(标准时+9:00) 东京、汉城、大阪、雅库茨克'
$lang['tz+09:30'] = '[+09:30] Adelaide, Darwin';//'(标准时+9:30) 阿德莱德、达尔文'
$lang['tz+10:00'] = '[+10:00] Sydney, Guam';//'(标准时+10:00) 悉尼、关岛'
$lang['tz+11:00'] = '[+11:00] Magadan, Solomon Islands';//'(标准时+11:00) 马加丹、索罗门群岛'
$lang['tz+12:00'] = '[+12:00] Auckland, Wellington, Kamchatka';//'(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛'
