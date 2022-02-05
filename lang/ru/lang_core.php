<?php
// LANG_CORE
$lang = array(

//---------------------------
//include/controller/comment_controller.php
'mail_test_header'	=> 'Тема тестового письма',//'测试邮件发送标题',
'mail_test_content'	=> 'Содержание тестового письма',//'测试邮件发送内容',
'mail_send_ok'		=> 'Письмо успешно отправлено',//'邮件发送成功',
'mail_send_error'	=> 'Ошибка отправки письма',//'邮件发送失败',

//---------------------------
//include/lib/cache.php
 'cache_date_format'	=> 'm.Y',//'Y年n月',
 'cache_read_error'	=> 'Ошибка чтения кэша',//'读取缓存失败',
 'cache_not_writable'	=> 'Нет прав записи в папку кэша: content/cache.',//'写入缓存失败，缓存目录 (content/cache) 不可写',

//---------------------------
//include/lib/calendar.php

 'weekday1'	=> 'Пн',//'Monday',//'一',
 'weekday2'	=> 'Вт',//'Tuesday',//'二',
 'weekday3'	=> 'Ср',//'Wednesday',//'三',
 'weekday4'	=> 'Чт',//'Thursday',//'四',
 'weekday5'	=> 'Пт',//'Friday',//'五',
 'weekday6'	=> 'Сб',//'Saturday',//'六',
 'weekday7'	=> 'Вс',//'Sunday',//'日',

 'month_1'	=> 'Январь',
 'month_2'	=> 'Февраль',
 'month_3'	=> 'Март',
 'month_4'	=> 'Апрель',
 'month_5'	=> 'Май',
 'month_6'	=> 'Июнь',
 'month_7'	=> 'Июль',
 'month_8'	=> 'Август',
 'month_9'	=> 'Сентябрь',
 'month_10'	=> 'Октябрь',
 'month_11'	=> 'Ноябрь',
 'month_12'	=> 'Декабрь',

//---------------------------
//include/lib/function.base.php
 '_load_failed'	=> ' сбой загрузки.',//'加载失败。',
 '_bytes'	=> ' байт',//'字节',
 'home'		=> 'На главную',//'首页',
 'first_page'	=> 'Первая',//'首页',
 'last_page'	=> 'Последняя',//'尾页',
 'read_more'	=> 'Читать далее&gt;&gt;',//'阅读全文&gt;&gt;',
 '_sec_ago'	=> ' сек. назад.',//'秒前',
 '_min_ago'	=> ' мин. назад.',//'分钟前',
 'about_'	=> '~ ',//'约 ',
 '_hour_ago'	=> ' час(ов) назад.',//' 小时前',
 'file_size_exceeds_system'	=> 'Размер файла превышает системный лимит: ',//'文件大小超过系统 ',
 '_limit'			=> '',//' limit',//'限制',//LEAVE THIS EMPTY???
 'upload_failed_error_code'	=> 'Ошибка загрузки. Код ошибки: ',//'上传文件失败,错误码: ',
 'file_type_not_supported'	=> 'Данный тип файлов не поддерживается.',//'错误的文件类型',
 'file_size_exceeds_'		=> 'Размер файла превышает лимит: ',//'文件大小超出',
 '_of_limit'			=> '',//' limit',//'的限制',
 'upload_folder_create_error'	=> 'Ошибка создания папки для загрузки.',//'创建文件上传目录失败',
 'upload_folder_unwritable'	=> 'Ошибка загрузки. Нет прав на запись в папке "content/uploadfile".',//'上传失败。文件上传目录(content/uploadfile)不可写',
 '404_description'		=> 'Извините, указанная станица не существует.',//'抱歉，你所请求的页面不存在！',
 'prompt'			=> 'Подсказка',//'提示信息',
 'click_return'			=> 'Вернуться назад',//'点击返回',
 'upload_ok'			=> 'Загрузка успешно завершена',//'上传成功',

//---------------------------
//include/lib/loginauth.php
 'captcha'			=> 'Проверочный код',//'验证码',
 'captcha_error_reenter'	=> 'Пожалуйста, повторите проверочный код.',//'验证错误，请重新输入',
 'user_name_wrong_reenter'	=> 'Недопустимое имя. Введите другой вариант.',//'用户名错误，请重新输入',
 'password_wrong_reenter'	=> 'Недопустимый пароль. Введите другой вариант.',//'密码错误，请重新输入',
// 'no_permission'		=> 'Insufficient permissions!',//'权限不足！',
 'token_error'			=> 'Неверный токен',

//---------------------------
//include/lib/option.php
 'blogger'		=> 'Персональная информация',//'个人资料',
 'categories'		=> 'Категории',//'分类',
 'category'		=> 'Категория',//'分类',
 'calendar'		=> 'Календарь',//'日历',
 'twitter_latest'	=> 'Последние твиты',//'最新微语',
 'tags'			=> 'Тэги',//'标签',
 'archive'		=> 'Архив',//'存档',
 'new_comments'		=> 'Последние комментарии',//'最新评论',
 'new_posts'		=> 'Последние статьи',//'最新文章',
 'random_post'		=> 'Случайная статья',//'随机文章',
 'hot_posts'		=> 'Популярные статьи',//'热门文章',
 'links'		=> 'Ссылки',//'链接',
 'search'		=> 'Поиск',//'搜索',
 'widget_custom'	=> 'Произвольный виджет',//'自定义组件',
 'search_placeholder'	=> 'Искомые слова... и Enter',//'Search...and Enter',
 'pro_unregistered'	=> ' Незарегистрированная PRO версия',//' 未注册的PRO版本',

//---------------------------
//include/lib/sendmail.php
 'smtp_test'		=> 'Отправка тестового письма через STMP',//'测试邮件STMP发送',

//---------------------------
//include/lib/view.php
 'template_not_found'	=> 'Текущий шаблон удалён или разрушен. Обратитесь к администратору для замены текущего шаблона.',//'当前使用的模板已被删除或损坏，请登录后台更换其他模板。',
 'template_corrupted'	=> 'Шаблон разрушен',//'后台模板已损坏',

//---------------------------------------
//include/lib/mysql.php
 'mysql_not_supported'		=> 'Сервер не поддерживает MySql базы данных',//'服务器空间PHP不支持MySql数据库',
 'db_database_unavailable'	=> 'Ошибка: Не удалось подключиться к серверу или к БД.',//'连接数据库失败，数据库地址错误或者数据库服务器不可用',
 'db_port_invalid'		=> 'Ошибка: Недопустимый порт базы данных.',//'连接数据库失败，数据库端口错误',
 'db_server_unavailable'	=> 'Ошибка: Сервер баз данных недоступен.',//'连接数据库失败，数据库服务器不可用',
 'db_credential_error'		=> 'Ошибка: Неверное имя пользователя или пароль.',//'连接数据库失败，数据库用户名或密码错误',
 'db_error_code'		=> 'Ошибка: Проверьте введённую информацию. Error code: ',//'连接数据库失败，请检查数据库信息。错误编号：',
 'db_not_found'			=> 'Ошибка: Указанная база данных не найдена.',//'连接数据库失败，未找到您填写的数据库',
 'db_sql_error'			=> 'Ошибка выполнения SQL запроса',//'SQL语句执行错误',

//---------------------------------------
//include/lib/mysqlii.php
 'mysqli_not_supported'		=> 'Сервер не поддерживает функционал mysqli',//'服务器PHP不支持mysqli函数',
 'db_credential_error'		=> 'Ошибка: Неверное имя пользователя или пароль.',//'连接MySQL数据库失败，数据库用户名或密码错误',
 'db_not_found'			=> 'Ошибка: Указанная база данных не найдена.',//'连接MySQL数据库失败，未找到你填写的数据库',
// 'db_port_invalid'		=> 'Ошибка: The database port is invalid.',//'连接数据库失败，数据库端口错误',
 'db_unavailable'		=> 'Ошибка: Не удалось подключиться к серверу или к БД.',//'连接MySQL数据库失败，数据库地址错误或者数据库服务器不可用',
// 'db_server_unavailable'	=> 'Ошибка: The database server is unavailable.',//'连接数据库失败，数据库服务器不可用',
 'db_error_code'		=> 'Ошибка: Проверьте введённую информацию. Error code: ',//'连接MySQL数据库失败，请检查数据库信息。错误编号：',
 'db_error_name'		=> 'Ошибка: Пожалуйста, укажите имя базы данных',//'连接数据库失败，请填写数据库名',
// 'db_sql_error'		=> 'SQL statement execution error',//'SQL语句执行错误',

//---------------------------------------
//include/lib/mysqlpdo.php
'pdo_not_supported'		=> 'Сервер не поддерживает функционал PDO',//'服务器空间PHP不支持PDO函数',
'pdo_connect_error'		=> 'Ошибка: Проверьте введённую информацию. Error message: ',//'连接数据库失败，请检查数据库信息。错误原因：',

//---------------------------------------
//include/lib/twitter_model.php
// 'no_permission'	=> 'Insufficient permissions!',//'权限不足！',

//---------------------------------------
//include/model/media_model.php
'del_failed'	=> 'Ошибка удаления!',//'删除失败!',

//---------------------------------------
//include/service/user.php
'reset_password_code'	=> 'Восстановление пароля с помощью проверочного кода',//'找回密码邮件验证码',
'email_verify_code'	=> 'Проверочный код из Email сообщения',//'邮件验证码是: ',

//---------------------------
//content/templates/default/404.php
 '404_error'		=> 'Ошибка: страница не найдена.',//'错误提示-页面未找到',
 '404_description'	=> 'Извините, указанная Вами страница не существует.',//'抱歉，你所请求的页面不存在！',
 'click_return'		=> '&laquo;Вернуться назад',//'&laquo;点击返回',

//---------------------------
//content/templates/default/footer.php
 'powered_by'		=> 'Powered by',
 'powered_by_emlog'	=> 'Powered by Emlog',//'采用emlog系统',

//---------------------------
//content/templates/default/module.php
// '_posts'			=> 'posts',//'篇文章',
// 'subscribe_category'	=> 'Subscribe this category',//'订阅该分类',
// 'subscribe_category'	=> 'Subscribe this category',//'订阅该分类',
 'view_image'		=> 'Показать изображение',//'查看图片',
 'more'			=> 'Подробнее &raquo;',//'更多&raquo;',
 'site_management'	=> 'Управление сайтом',//'管理',
 'logout'		=> 'Выход',//'退出',
 'top_posts'		=> 'Популярные статьи',//'置顶文章',
 'cat_top_posts'	=> 'Популярные статьи в категории',//'分类置顶文章',
 'edit'			=> 'Редактировать',//'编辑',
// 'category'		=> 'Category',//'分类',
// 'tags'		=> 'Tags',//'标签',
// 'comments'		=> 'Comments',//'评论',
// 'reply'		=> 'Reply',//'回复',
// 'reply'		=> 'Reply',//'回复',
 'cancel_reply'		=> 'Отменить ответ',//'取消回复',
 'comment_leave'	=> 'Оставить комментарий',//'发表评论',
 'nickname'		=> 'Псевдоним',//'昵称',
 'email_optional'	=> 'E-Mail адрес (не обязательно)',//'邮件地址 (选填)',
 'email'		=> 'E-Mail адрес',//'邮件地址',
 'homepage'		=> 'Домашняя страница',//'个人主页',
 'homepage_optional'	=> 'Домашняя страница (не обязательно)',//'个人主页 (选填)',
 'comment_leave'	=> 'Опубликовать комментарий',//'发布评论',

//---------------------------
//content/templates/default/side.php
 'rss_feed'	=> 'RSS лента',//'RSS订阅',
 'feed_rss'	=> 'Лента RSS',//'订阅Rss',


);
