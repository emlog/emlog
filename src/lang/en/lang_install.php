<?php
$lang = array(

//---------------------------
//install.php

 'php5_required' => 'For normal functioning Emlog requires PHP5 or higher',//'您的php版本过低，请选用支持PHP5的环境安装emlog。',
 'install' => 'instal',//'安装程序',
 'mysql_settings' => 'MySQL settings',//'MySQL数据库设置',
 'db_hostname' => 'Database Hostname',//'数据库地址',
 'db_hostname_info' => '(default: localhost)',//'(通常为 localhost， 不必修改)',
 'db_user' => 'DB user',//'数据库用户名',
 'db_password' => 'DB password',//'数据库密码',
 'db_name' => 'DB name',//'数据库名',
 'db_name_info' => '(The program does not automatically create a database. Please create new one)',//'(程序不会自动创建数据库，请提前创建一个空数据库或使用已有数据库)',
 'db_prefix' => 'DB prefix',//'数据库前缀',
 'db_prefix_info' => '(Typically the default, without having to modify. By the letters of the alphabet, numbers, underscores, and must end with an underscore.)',//'(通常默认即可，不必修改。由英文字母、数字、下划线组成，且必须以下划线结束)',
 'admin_settings' => 'Administrator account',//'管理员设置',
 'admin_name' => 'User name',//'登录名',
 'admin_password' => 'Password',//'登录密码',
 'admin_password_info' => '(Minimum 5 characters)',//'(不小于5位)',
 'admin_password_repeat' => 'Confirm password',//再次输入登录密码',
 'install_emlog' => 'Install emlog!',//'开始安装emlog',
 'db_prefix_empty' => 'Database prefix can not be empty!',//'数据库前缀不能为空!',
 'db_prefix_invalid' => 'Database prefix is incorrect!',//'数据库前缀格式错误!',
 'username_password_empty' => 'Username and password can not be empty!',//'登录名和密码不能为空!',
 'password_short' => 'Password can not be less than 5 characters',//'登录密码不得小于5位',
 'password_not_equal' => 'Two passwords are not equal',//'两次输入的密码不一致',
 'already_installed' => 'It seems the Emlog is already installed! Continue this process will overwrite the original data. Are you sure?',//'你的emlog看起来已经安装过了。继续安装将会覆盖原有数据，确定要继续吗？',
 'continue' => 'Continue&raquo;',//'继续&raquo;',
 'return' => '&laquo;Return back',//'&laquo;点击返回',
 'config_not_writable' => 'Configuration file (config.php) is not writable. If you are using a Unix / Linux hosts, modify the file permissions to 777. If you are using a Windows host, please contact the administrator.',//'配置文件(config.php)不可写。如果您使用的是Unix/Linux主机，请修改该文件的权限为777。如果您使用的是Windows主机，请联系管理员，将此文件设为可写',
 'cache_not_writable' => 'Cache is not writable. If you are using a Unix / Linux host, modify the permissions of all files in the directory (content/cache) to 777.',//'缓存文件不可写。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为可写',
 'emlog_welcome' => 'Welcome to emlog',//'欢迎使用emlog',
 'emlog_install_congratulation' => 'Congratulations, you have successfully installed the emlog. The first entry is ready. Just edit or delete it and start a blog!',//'恭喜您成功安装了emlog，这是系统自动生成的演示文章。编辑或者删除它，然后开始您的创作吧！',
 'my_blog' => 'My blog',//'点滴记忆',
 'emlog_powered' => 'Powered by emlog',//'使用emlog搭建的站点',
 'emlog_official_site' => 'Official emlog website',//'emlog官方主页',
 'home' => 'Home',//'首页',
 'twits' => 'Twitts',//'微语',
 'login' => 'Login',//'登录',
 'test_tweet' => 'I heard some whispers last night... :)',//'使用微语记录您身边的新鲜事',
 'emlog_installed' => 'Congratulations, your blog is ready to use!',//'恭喜，安装成功！',
 'emlog_installed_info' => 'Now you can start to create your content. It\'s really simple!',//'您的emlog已经安装好了，现在可以开始您的创作了，就这么简单!',
 'user_name' => 'User name',//'用户名',
 'password_entered' => '<b>Password</b> that you created a two seconds ago',//'<b>密 码</b>：您刚才设定的密码',
 'delete_install' => 'Warning! Please delete the installation file install.php',//'警告：请手动删除根目录下安装文件：install.php',
 'go_to_front' => 'Visit Blog',//'访问首页',
 'go_to_admincp' => 'Go to Administration Control Panel',//'登录后台',

//---------------------------------------
//include/lib/mysql.php

 'db_not_found' => 'Database connection failed. The database you filled in was not found.',//'连接数据库失败，未找到您填写的数据库',
 'db_sql_error' => 'SQL statement execution error',//'SQL语句执行错误',
);
