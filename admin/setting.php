<?php
/**
 * setting
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
    $options_cache = $CACHE->readCache('options');
    extract($options_cache);

    $conf_comment_code = $comment_code == 'y' ? 'checked="checked"' : '';
    $conf_comment_needchinese = $comment_needchinese == 'y' ? 'checked="checked"' : '';
    $conf_iscomment = $iscomment == 'y' ? 'checked="checked"' : '';
    $conf_ischkcomment = $ischkcomment == 'y' ? 'checked="checked"' : '';
    $conf_isthumbnail = $isthumbnail == 'y' ? 'checked="checked"' : '';
    $conf_isgravatar = $isgravatar == 'y' ? 'checked="checked"' : '';
    $conf_comment_paging = $comment_paging == 'y' ? 'checked="checked"' : '';
    $conf_detect_url = $detect_url == 'y' ? 'checked="checked"' : '';
    $conf_accept_app_recs = $accept_app_recs == 'y' ? 'checked="checked"' : '';

    $ex1 = $ex2 = $ex3 = $ex4 = '';
    if ($rss_output_fulltext == 'y') {
        $ex1 = 'selected="selected"';
    } else {
        $ex2 = 'selected="selected"';
    }
    if ($comment_order == 'newer') {
        $ex3 = 'selected="selected"';
    } else {
        $ex4 = 'selected="selected"';
    }

    $tzlist = [
        'Etc/GMT'              => '(UTC)协调世界时',
        'Africa/Casablanca'    => '(UTC)卡萨布兰卡',
        'Atlantic/Reykjavik'   => '(UTC)蒙罗维亚，雷克雅未克',
        'Europe/London'        => '(UTC)都柏林，爱丁堡，里斯本，伦敦',
        'Africa/Lagos'         => '(UTC+01:00)中非西部',
        'Europe/Paris'         => '(UTC+01:00)布鲁塞尔，哥本哈根，马德里，巴黎',
        'Africa/Windhoek'      => '(UTC+01:00)温得和克',
        'Europe/Warsaw'        => '(UTC+01:00)萨拉热窝，斯科普里，华沙，萨格勒布',
        'Europe/Budapest'      => '(UTC+01:00)贝尔格莱德，布拉迪斯拉发，布达佩斯，卢布尔雅那，布拉格',
        'Europe/Berlin'        => '(UTC+01:00)阿姆斯特丹，柏林，伯尔尼，罗马，斯德哥尔摩，维也纳',
        'Europe/Istanbul'      => '(UTC+02:00)伊斯坦布尔',
        'Europe/Kaliningrad'   => '(UTC+02:00)加里宁格勒(RTZ 1)',
        'Africa/Johannesburg'  => '(UTC+02:00)哈拉雷，比勒陀利亚',
        'Asia/Damascus'        => '(UTC+02:00)大马士革',
        'Asia/Amman'           => '(UTC+02:00)安曼',
        'Africa/Cairo'         => '(UTC+02:00)开罗',
        'Africa/Tripoli'       => '(UTC+02:00)的黎波里',
        'Asia/Jerusalem'       => '(UTC+02:00)耶路撒冷',
        'Asia/Beirut'          => '(UTC+02:00)贝鲁特',
        'Europe/Kiev'          => '(UTC+02:00)赫尔辛基，基辅，里加，索非亚，塔林，维尔纽斯',
        'Europe/Bucharest'     => '(UTC+02:00)雅典，布加勒斯特',
        'Africa/Nairobi'       => '(UTC+03:00)内罗毕',
        'Asia/Baghdad'         => '(UTC+03:00)巴格达',
        'Europe/Minsk'         => '(UTC+03:00)明斯克',
        'Asia/Riyadh'          => '(UTC+03:00)科威特，利雅得',
        'Europe/Moscow'        => '(UTC+03:00)莫斯科，圣彼得堡，伏尔加格勒(RTZ 2)',
        'Asia/Tehran'          => '(UTC+03:30)德黑兰',
        'Europe/Samara'        => '(UTC+04:00)伊热夫斯克，萨马拉(RTZ 3)',
        'Asia/Yerevan'         => '(UTC+04:00)埃里温',
        'Asia/Bak'             => '(UTC+04:00)巴库',
        'Asia/Tbilisi'         => '(UTC+04:00)第比利斯',
        'Indian/Mauritius'     => '(UTC+04:00)路易港',
        'Asia/Dubai'           => '(UTC+04:00)阿布扎比，马斯喀特',
        'Asia/Kabu'            => '(UTC+04:30)喀布尔',
        'Asia/Karachi'         => '(UTC+05:00)伊斯兰堡，卡拉奇',
        'Asia/Yekaterinburg'   => '(UTC+05:00)叶卡捷琳堡(RTZ 4)',
        'Asia/Tashkent'        => '(UTC+05:00)阿什哈巴德，塔什干',
        'Asia/Colombo'         => '(UTC+05:30)斯里加亚渥登普拉',
        'Asia/Calcutta'        => '(UTC+05:30)钦奈，加尔各答，孟买，新德里',
        'Asia/Katmandu'        => '(UTC+05:45)加德满都',
        'Asia/Novosibirsk'     => '(UTC+06:00)新西伯利亚(RTZ 5)',
        'Asia/Dhaka'           => '(UTC+06:00)达卡',
        'Asia/Almaty'          => '(UTC+06:00)阿斯塔纳',
        'Asia/Rangoon'         => '(UTC+06:30)仰光',
        'Asia/Krasnoyarsk'     => '(UTC+07:00)克拉斯诺亚尔斯克(RTZ 6)',
        'Asia/Bangkok'         => '(UTC+07:00)曼谷，河内，雅加达',
        'Asia/Ulaanbaatar'     => '(UTC+08:00)乌兰巴托',
        'Asia/Irkutsk'         => '(UTC+08:00)伊尔库茨克(RTZ 7)',
        'Asia/Shanghai'        => '(UTC+08:00)北京，重庆，香港特别行政区，乌鲁木齐',
        'Asia/Taipei'          => '(UTC+08:00)台北',
        'Asia/Singapore'       => '(UTC+08:00)吉隆坡，新加坡',
        'Australia/Perth'      => '(UTC+08:00)珀斯',
        'Asia/Tokyo'           => '(UTC+09:00)大阪，札幌，东京',
        'Asia/Yakutsk'         => '(UTC+09:00)雅库茨克(RTZ 8)',
        'Asia/Seoul'           => '(UTC+09:00)首尔',
        'Australia/Darwin'     => '(UTC+09:30)达尔文',
        'Australia/Adelaide'   => '(UTC+09:30)阿德莱德',
        'Pacific/Port_Moresby' => '(UTC+10:00)关岛，莫尔兹比港',
        'Australia/Sydney'     => '(UTC+10:00)堪培拉，墨尔本，悉尼',
        'Australia/Brisbane'   => '(UTC+10:00)布里斯班',
        'Asia/Vladivostok'     => '(UTC+10:00)符拉迪沃斯托克，马加丹(RTZ 9)',
        'Australia/Hobart'     => '(UTC+10:00)霍巴特',
        'Asia/Magadan'         => '(UTC+10:00)马加丹',
        'Asia/Srednekolymsk'   => '(UTC+11:00)乔库尔达赫(RTZ 10)',
        'Pacific/Guadalcanal'  => '(UTC+11:00)所罗门群岛，新喀里多尼亚',
        'Etc/GMT-12'           => '(UTC+12:00)协调世界时+12',
        'Pacific/Auckland'     => '(UTC+12:00)奥克兰，惠灵顿',
        'Pacific/Fiji'         => '(UTC+12:00)斐济',
        'Asia/Kamchatka'       => '(UTC+12:00)阿纳德尔，彼得罗巴甫洛夫斯克-堪察加(RTZ 11)',
        'Pacific/Tongatapu'    => '(UTC+13:00)努库阿洛法',
        'Pacific/Apia'         => '(UTC+13:00)萨摩亚群岛',
        'Pacific/Kiritimati'   => '(UTC+14:00)圣诞岛',
        'Atlantic/Azores'      => '(UTC-01:00)亚速尔群岛',
        'Atlantic/Cape_Verde'  => '(UTC-01:00)佛得角群岛',
        'Etc/GMT+2'            => '(UTC-02:00)协调世界时-02',
        'America/Cayenne'      => '(UTC-03:00)卡宴，福塔雷萨',
        'America/Sao_Paulo'    => '(UTC-03:00)巴西利亚',
        'America/Buenos_Aires' => '(UTC-03:00)布宜诺斯艾利斯',
        'America/Godthab'      => '(UTC-03:00)格陵兰',
        'America/Bahia'        => '(UTC-03:00)萨尔瓦多',
        'America/Montevideo'   => '(UTC-03:00)蒙得维的亚',
        'America/St_Johns'     => '(UTC-03:30)纽芬兰',
        'America/La_Paz'       => '(UTC-04:00)乔治敦，拉巴斯，马瑙斯，圣胡安',
        'America/Asuncion'     => '(UTC-04:00)亚松森',
        'America/Halifax'      => '(UTC-04:00)大西洋时间(加拿大)',
        'America/Cuiaba'       => '(UTC-04:00)库亚巴',
        'America/Caracas'      => '(UTC-04:30)加拉加斯',
        'America/New_York'     => '(UTC-05:00)东部时间(美国和加拿大)',
        'America/Indianapolis' => '(UTC-05:00)印地安那州(东部)',
        'America/Bogota'       => '(UTC-05:00)波哥大，利马，基多，里奥布朗库',
        'America/Guatemala'    => '(UTC-06:00)中美洲',
        'America/Chicago'      => '(UTC-06:00)中部时间(美国和加拿大)',
        'America/Mexico_City'  => '(UTC-06:00)瓜达拉哈拉，墨西哥城，蒙特雷',
        'America/Regina'       => '(UTC-06:00)萨斯喀彻温',
        'America/Phoenix'      => '(UTC-07:00)亚利桑那',
        'America/Chihuahua'    => '(UTC-07:00)奇瓦瓦，拉巴斯，马萨特兰',
        'America/Denver'       => '(UTC-07:00)山地时间(美国和加拿大)',
        'America/Santa_Isabel' => '(UTC-08:00)下加利福尼亚州',
        'America/Los_Angeles'  => '(UTC-08:00)太平洋时间(美国和加拿大)',
        'America/Anchorage'    => '(UTC-09:00)阿拉斯加',
        'Pacific/Honolulu'     => '(UTC-10:00)夏威夷',
        'Etc/GMT+11'           => '(UTC-11:00)协调世界时-11',
        'Etc/GMT+12'           => '(UTC-12:00)国际日期变更线西',
    ];

    include View::getAdmView('header');
    require_once(View::getAdmView('setting'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'save') {
    LoginAuth::checkToken();
    $getData = [
        'blogname'            => isset($_POST['blogname']) ? addslashes($_POST['blogname']) : '',
        'blogurl'             => isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '',
        'bloginfo'            => isset($_POST['bloginfo']) ? addslashes($_POST['bloginfo']) : '',
        'icp'                 => isset($_POST['icp']) ? addslashes($_POST['icp']) : '',
        'footer_info'         => isset($_POST['footer_info']) ? addslashes($_POST['footer_info']) : '',
        'index_lognum'        => isset($_POST['index_lognum']) ? (int)$_POST['index_lognum'] : '',
        'timezone'            => isset($_POST['timezone']) ? addslashes($_POST['timezone']) : '',
        'comment_code'        => isset($_POST['comment_code']) ? addslashes($_POST['comment_code']) : 'n',
        'comment_needchinese' => isset($_POST['comment_needchinese']) ? addslashes($_POST['comment_needchinese']) : 'n',
        'comment_interval'    => isset($_POST['comment_interval']) ? (int)$_POST['comment_interval'] : 15,
        'iscomment'           => isset($_POST['iscomment']) ? addslashes($_POST['iscomment']) : 'n',
        'ischkcomment'        => isset($_POST['ischkcomment']) ? addslashes($_POST['ischkcomment']) : 'n',
        'isthumbnail'         => isset($_POST['isthumbnail']) ? addslashes($_POST['isthumbnail']) : 'n',
        'rss_output_num'      => isset($_POST['rss_output_num']) ? (int)$_POST['rss_output_num'] : 10,
        'rss_output_fulltext' => isset($_POST['rss_output_fulltext']) ? addslashes($_POST['rss_output_fulltext']) : 'y',
        'isgravatar'          => isset($_POST['isgravatar']) ? addslashes($_POST['isgravatar']) : 'n',
        'comment_paging'      => isset($_POST['comment_paging']) ? addslashes($_POST['comment_paging']) : 'n',
        'comment_pnum'        => isset($_POST['comment_pnum']) ? (int)$_POST['comment_pnum'] : '',
        'comment_order'       => isset($_POST['comment_order']) ? addslashes($_POST['comment_order']) : 'newer',
        'att_maxsize'         => isset($_POST['att_maxsize']) ? (int)$_POST['att_maxsize'] : 20480,
        'att_type'            => isset($_POST['att_type']) ? str_replace('php', 'x', strtolower(addslashes($_POST['att_type']))) : '',
        'att_imgmaxw'         => isset($_POST['att_imgmaxw']) ? (int)$_POST['att_imgmaxw'] : 420,
        'att_imgmaxh'         => isset($_POST['att_imgmaxh']) ? (int)$_POST['att_imgmaxh'] : 460,
        'detect_url'          => isset($_POST['detect_url']) ? addslashes($_POST['detect_url']) : 'n', // 自动检测站点地址
        'admin_perpage_num'   => Input::postIntVar('admin_perpage_num'),
        'accept_app_recs'     => isset($_POST['accept_app_recs']) ? addslashes($_POST['accept_app_recs']) : 'n',
    ];

    if ($getData['login_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
        emMsg("开启登录验证码失败!服务器空间不支持GD图形库", "setting.php");
    }
    if ($getData['comment_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
        emMsg("开启评论验证码失败!服务器空间不支持GD图形库", "setting.php");
    }
    if ($getData['blogurl'] && substr($getData['blogurl'], -1) != '/') {
        $getData['blogurl'] .= '/';
    }
    if ($getData['blogurl'] && strncasecmp($getData['blogurl'], 'http', 4)) {
        $getData['blogurl'] = 'http://' . $getData['blogurl'];
    }

    foreach ($getData as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache(array('tags', 'options', 'comment', 'record'));
    emDirect("./setting.php?activated=1");
}

if ($action == 'seo') {
    $options_cache = $CACHE->readCache('options');
    extract($options_cache);

    $ex0 = $ex1 = $ex2 = $ex3 = '';
    $t = 'ex' . $isurlrewrite;
    $$t = 'checked="checked"';

    $opt0 = $opt1 = $opt2 = '';
    $t = 'opt' . $log_title_style;
    $$t = 'selected="selected"';

    $isalias = $isalias == 'y' ? 'checked="checked"' : '';
    $isalias_html = $isalias_html == 'y' ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_seo'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'seo_save') {
    LoginAuth::checkToken();
    $permalink = isset($_POST['permalink']) ? addslashes($_POST['permalink']) : '0';
    $isalias = isset($_POST['isalias']) ? addslashes($_POST['isalias']) : 'n';
    $isalias_html = isset($_POST['isalias_html']) ? addslashes($_POST['isalias_html']) : 'n';

    $getData = array(
        'site_title'       => isset($_POST['site_title']) ? addslashes($_POST['site_title']) : '',
        'site_description' => isset($_POST['site_description']) ? addslashes($_POST['site_description']) : '',
        'site_key'         => isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '',
        'isurlrewrite'     => isset($_POST['permalink']) ? addslashes($_POST['permalink']) : '0',
        'isalias'          => isset($_POST['isalias']) ? addslashes($_POST['isalias']) : 'n',
        'isalias_html'     => isset($_POST['isalias_html']) ? addslashes($_POST['isalias_html']) : 'n',
        'log_title_style'  => isset($_POST['log_title_style']) ? addslashes($_POST['log_title_style']) : '0',
    );

    if ($permalink != '0' || $isalias == 'y') {
        $fp = @fopen(EMLOG_ROOT . '/.htaccess', 'w');
        $t = parse_url(BLOG_URL);
        $rw_rule = '<IfModule mod_rewrite.c>
                       RewriteEngine on
                       RewriteCond %{REQUEST_FILENAME} !-f
                       RewriteCond %{REQUEST_FILENAME} !-d
                       RewriteBase ' . $t['path'] . '
                       RewriteRule . ' . $t['path'] . 'index.php [L]
                    </IfModule>';
        if (!@fwrite($fp, $rw_rule)) {
            header('Location: ./setting.php?action=seo&error=1');
            exit;
        }
        fclose($fp);
    }

    foreach ($getData as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache(array('options', 'navi'));
    header('Location: ./setting.php?action=seo&activated=1');
}

if ($action == 'mail') {
    $options_cache = $CACHE->readCache('options');
    $smtp_mail = isset($options_cache['smtp_mail']) ? $options_cache['smtp_mail'] : '';
    $smtp_pw = isset($options_cache['smtp_pw']) ? $options_cache['smtp_pw'] : '';
    $smtp_from_name = isset($options_cache['smtp_from_name']) ? $options_cache['smtp_from_name'] : '';
    $smtp_server = isset($options_cache['smtp_server']) ? $options_cache['smtp_server'] : '';
    $smtp_port = isset($options_cache['smtp_port']) ? $options_cache['smtp_port'] : '';
    $mail_notice_comment = isset($options_cache['mail_notice_comment']) ? $options_cache['mail_notice_comment'] : '';
    $mail_notice_post = isset($options_cache['mail_notice_post']) ? $options_cache['mail_notice_post'] : '';

    $conf_mail_notice_comment = $mail_notice_comment == 'y' ? 'checked="checked"' : '';
    $conf_mail_notice_post = $mail_notice_post == 'y' ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_mail'));
    include View::getAdmView('footer');
    View::output();

}

if ($action == 'mail_save') {
    LoginAuth::checkToken();
    $data = [
        'smtp_mail'           => isset($_POST['smtp_mail']) ? addslashes($_POST['smtp_mail']) : '',
        'smtp_pw'             => isset($_POST['smtp_pw']) ? addslashes($_POST['smtp_pw']) : '',
        'smtp_from_name'      => isset($_POST['smtp_from_name']) ? addslashes($_POST['smtp_from_name']) : '',
        'smtp_server'         => isset($_POST['smtp_server']) ? addslashes($_POST['smtp_server']) : '',
        'smtp_port'           => isset($_POST['smtp_port']) ? addslashes($_POST['smtp_port']) : '',
        'mail_notice_comment' => isset($_POST['mail_notice_comment']) ? $_POST['mail_notice_comment'] : 'n',
        'mail_notice_post'    => isset($_POST['mail_notice_post']) ? $_POST['mail_notice_post'] : 'n',
    ];
    foreach ($data as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache(array('options'));
    header('Location: ./setting.php?action=mail&activated=1');
}

if ($action == 'mail_test') {
    $data = [
        'smtp_mail'      => isset($_POST['smtp_mail']) ? addslashes($_POST['smtp_mail']) : '',
        'smtp_pw'        => isset($_POST['smtp_pw']) ? addslashes($_POST['smtp_pw']) : '',
        'smtp_from_name' => isset($_POST['smtp_from_name']) ? addslashes($_POST['smtp_from_name']) : '',
        'smtp_server'    => isset($_POST['smtp_server']) ? addslashes($_POST['smtp_server']) : '',
        'smtp_port'      => isset($_POST['smtp_port']) ? (int)$_POST['smtp_port'] : '',
        'testTo'         => isset($_POST['testTo']) ? $_POST['testTo'] : '',
    ];

    if (!checkMail($data['testTo'])) {
        exit("<small class='text-info'>请正确填写邮箱</small>");
    }

    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = $data['smtp_port'] == '587' ? 'STARTTLS' : 'ssl';
    $mail->Port = $data['smtp_port'];
    $mail->Host = $data['smtp_server'];
    $mail->Username = $data['smtp_mail'];
    $mail->Password = $data['smtp_pw'];
    $mail->From = $data['smtp_mail'];
    $mail->FromName = $data['smtp_from_name'];
    $mail->AddAddress($data['testTo']);
    $mail->Subject = '测试邮件';
    $mail->Body = '这是一封测试邮件';

    try {
        return $mail->Send();
    } catch (Exception $exc) {
        exit("<small class='text-danger'>发送失败</small>");
    }
}

if ($action == 'user') {
    $options_cache = $CACHE->readCache('options');
    $is_signup = isset($options_cache['is_signup']) ? $options_cache['is_signup'] : '';
    $login_code = isset($options_cache['login_code']) ? $options_cache['login_code'] : '';
    $ischkarticle = isset($options_cache['ischkarticle']) ? $options_cache['ischkarticle'] : '';
    $posts_per_day = isset($options_cache['posts_per_day']) ? $options_cache['posts_per_day'] : '';
    $email_code = isset($options_cache['email_code']) ? $options_cache['email_code'] : '';

    $conf_is_signup = $is_signup == 'y' ? 'checked="checked"' : '';
    $conf_login_code = $login_code == 'y' ? 'checked="checked"' : '';
    $conf_email_code = $email_code == 'y' ? 'checked="checked"' : '';
    $conf_ischkarticle = $ischkarticle == 'y' ? 'checked="checked"' : '';
    $conf_posts_per_day = $posts_per_day;

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_user'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'user_save') {
    LoginAuth::checkToken();
    $data = [
        'is_signup'     => Input::postStrVar('is_signup', 'n'),
        'login_code'    => Input::postStrVar('login_code', 'n'),
        'email_code'    => Input::postStrVar('email_code', 'n'),
        'ischkarticle'  => Input::postStrVar('ischkarticle', 'n'),
        'posts_per_day' => Input::postStrVar('posts_per_day', 0),
    ];
    foreach ($data as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache('options');
    header('Location: ./setting.php?action=user&activated=1');
}

if ($action == 'api') {
    $apikey = Option::get('apikey');
    $is_openapi = Option::get('is_openapi');
    $conf_is_openapi = $is_openapi == 'y' ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_api'));
    include View::getAdmView('footer');
    View::output();

}

if ($action == 'api_save') {
    LoginAuth::checkToken();

    $is_openapi = isset($_POST['is_openapi']) ? addslashes($_POST['is_openapi']) : 'n';
    Option::updateOption('is_openapi', $is_openapi);
    $CACHE->updateCache('options');
    header('Location: ./setting.php?action=api&ok=1');
}

if ($action == 'api_reset') {
    LoginAuth::checkToken();

    $apikey = md5(getRandStr(32));

    Option::updateOption('apikey', $apikey);
    $CACHE->updateCache('options');
    header('Location: ./setting.php?action=api&ok_reset=1');
}
