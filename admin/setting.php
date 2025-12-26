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
    $conf_iscomment = $iscomment == 'y' ? 'checked="checked"' : '';
    $conf_login_comment = $login_comment == 'y' ? 'checked="checked"' : '';
    $conf_ischkcomment = $ischkcomment == 'y' ? 'checked="checked"' : '';
    $conf_isthumbnail = $isthumbnail == 'y' ? 'checked="checked"' : '';
    $conf_comment_paging = $comment_paging == 'y' ? 'checked="checked"' : '';
    $conf_detect_url = $detect_url == 'y' ? 'checked="checked"' : '';
    $conf_isfullsearch = $isfullsearch == 'y' ? 'checked="checked"' : '';

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
        'Etc/GMT' => _lang('tz_Etc_GMT'),
        'Africa/Casablanca' => _lang('tz_Africa_Casablanca'),
        'Atlantic/Reykjavik' => _lang('tz_Atlantic_Reykjavik'),
        'Europe/London' => _lang('tz_Europe_London'),
        'Africa/Lagos' => _lang('tz_Africa_Lagos'),
        'Europe/Paris' => _lang('tz_Europe_Paris'),
        'Africa/Windhoek' => _lang('tz_Africa_Windhoek'),
        'Europe/Warsaw' => _lang('tz_Europe_Warsaw'),
        'Europe/Budapest' => _lang('tz_Europe_Budapest'),
        'Europe/Berlin' => _lang('tz_Europe_Berlin'),
        'Europe/Istanbul' => _lang('tz_Europe_Istanbul'),
        'Europe/Kaliningrad' => _lang('tz_Europe_Kaliningrad'),
        'Africa/Johannesburg' => _lang('tz_Africa_Johannesburg'),
        'Asia/Damascus' => _lang('tz_Asia_Damascus'),
        'Asia/Amman' => _lang('tz_Asia_Amman'),
        'Africa/Cairo' => _lang('tz_Africa_Cairo'),
        'Africa/Tripoli' => _lang('tz_Africa_Tripoli'),
        'Asia/Jerusalem' => _lang('tz_Asia_Jerusalem'),
        'Asia/Beirut' => _lang('tz_Asia_Beirut'),
        'Europe/Kiev' => _lang('tz_Europe_Kiev'),
        'Europe/Bucharest' => _lang('tz_Europe_Bucharest'),
        'Africa/Nairobi' => _lang('tz_Africa_Nairobi'),
        'Asia/Baghdad' => _lang('tz_Asia_Baghdad'),
        'Europe/Minsk' => _lang('tz_Europe_Minsk'),
        'Asia/Riyadh' => _lang('tz_Asia_Riyadh'),
        'Europe/Moscow' => _lang('tz_Europe_Moscow'),
        'Asia/Tehran' => _lang('tz_Asia_Tehran'),
        'Europe/Samara' => _lang('tz_Europe_Samara'),
        'Asia/Yerevan' => _lang('tz_Asia_Yerevan'),
        'Asia/Bak' => _lang('tz_Asia_Bak'),
        'Asia/Tbilisi' => _lang('tz_Asia_Tbilisi'),
        'Indian/Mauritius' => _lang('tz_Indian_Mauritius'),
        'Asia/Dubai' => _lang('tz_Asia_Dubai'),
        'Asia/Kabu' => _lang('tz_Asia_Kabu'),
        'Asia/Karachi' => _lang('tz_Asia_Karachi'),
        'Asia/Yekaterinburg' => _lang('tz_Asia_Yekaterinburg'),
        'Asia/Tashkent' => _lang('tz_Asia_Tashkent'),
        'Asia/Colombo' => _lang('tz_Asia_Colombo'),
        'Asia/Calcutta' => _lang('tz_Asia_Calcutta'),
        'Asia/Katmandu' => _lang('tz_Asia_Katmandu'),
        'Asia/Novosibirsk' => _lang('tz_Asia_Novosibirsk'),
        'Asia/Dhaka' => _lang('tz_Asia_Dhaka'),
        'Asia/Almaty' => _lang('tz_Asia_Almaty'),
        'Asia/Rangoon' => _lang('tz_Asia_Rangoon'),
        'Asia/Krasnoyarsk' => _lang('tz_Asia_Krasnoyarsk'),
        'Asia/Bangkok' => _lang('tz_Asia_Bangkok'),
        'Asia/Ulaanbaatar' => _lang('tz_Asia_Ulaanbaatar'),
        'Asia/Irkutsk' => _lang('tz_Asia_Irkutsk'),
        'Asia/Shanghai' => _lang('tz_Asia_Shanghai'),
        'Asia/Taipei' => _lang('tz_Asia_Taipei'),
        'Asia/Singapore' => _lang('tz_Asia_Singapore'),
        'Australia/Perth' => _lang('tz_Australia_Perth'),
        'Asia/Tokyo' => _lang('tz_Asia_Tokyo'),
        'Asia/Yakutsk' => _lang('tz_Asia_Yakutsk'),
        'Asia/Seoul' => _lang('tz_Asia_Seoul'),
        'Australia/Darwin' => _lang('tz_Australia_Darwin'),
        'Australia/Adelaide' => _lang('tz_Australia_Adelaide'),
        'Pacific/Port_Moresby' => _lang('tz_Pacific_Port_Moresby'),
        'Australia/Sydney' => _lang('tz_Australia_Sydney'),
        'Australia/Brisbane' => _lang('tz_Australia_Brisbane'),
        'Asia/Vladivostok' => _lang('tz_Asia_Vladivostok'),
        'Australia/Hobart' => _lang('tz_Australia_Hobart'),
        'Asia/Magadan' => _lang('tz_Asia_Magadan'),
        'Asia/Srednekolymsk' => _lang('tz_Asia_Srednekolymsk'),
        'Pacific/Guadalcanal' => _lang('tz_Pacific_Guadalcanal'),
        'Etc/GMT-12' => _lang('tz_Etc_GMT_plus_12'),
        'Pacific/Auckland' => _lang('tz_Pacific_Auckland'),
        'Pacific/Fiji' => _lang('tz_Pacific_Fiji'),
        'Asia/Kamchatka' => _lang('tz_Asia_Kamchatka'),
        'Pacific/Tongatapu' => _lang('tz_Pacific_Tongatapu'),
        'Pacific/Apia' => _lang('tz_Pacific_Apia'),
        'Pacific/Kiritimati' => _lang('tz_Pacific_Kiritimati'),
        'Atlantic/Azores' => _lang('tz_Atlantic_Azores'),
        'Atlantic/Cape_Verde' => _lang('tz_Atlantic_Cape_Verde'),
        'Etc/GMT+2' => _lang('tz_Etc_GMT_minus_2'),
        'America/Cayenne' => _lang('tz_America_Cayenne'),
        'America/Sao_Paulo' => _lang('tz_America_Sao_Paulo'),
        'America/Buenos_Aires' => _lang('tz_America_Buenos_Aires'),
        'America/Godthab' => _lang('tz_America_Godthab'),
        'America/Bahia' => _lang('tz_America_Bahia'),
        'America/Montevideo' => _lang('tz_America_Montevideo'),
        'America/St_Johns' => _lang('tz_America_St_Johns'),
        'America/La_Paz' => _lang('tz_America_La_Paz'),
        'America/Asuncion' => _lang('tz_America_Asuncion'),
        'America/Halifax' => _lang('tz_America_Halifax'),
        'America/Cuiaba' => _lang('tz_America_Cuiaba'),
        'America/Caracas' => _lang('tz_America_Caracas'),
        'America/New_York' => _lang('tz_America_New_York'),
        'America/Indianapolis' => _lang('tz_America_Indianapolis'),
        'America/Bogota' => _lang('tz_America_Bogota'),
        'America/Guatemala' => _lang('tz_America_Guatemala'),
        'America/Chicago' => _lang('tz_America_Chicago'),
        'America/Mexico_City' => _lang('tz_America_Mexico_City'),
        'America/Regina' => _lang('tz_America_Regina'),
        'America/Phoenix' => _lang('tz_America_Phoenix'),
        'America/Chihuahua' => _lang('tz_America_Chihuahua'),
        'America/Denver' => _lang('tz_America_Denver'),
        'America/Santa_Isabel' => _lang('tz_America_Santa_Isabel'),
        'America/Los_Angeles' => _lang('tz_America_Los_Angeles'),
        'America/Anchorage' => _lang('tz_America_Anchorage'),
        'Pacific/Honolulu' => _lang('tz_Pacific_Honolulu'),
        'Etc/GMT+11' => _lang('tz_Etc_GMT_minus_11'),
        'Etc/GMT+12' => _lang('tz_Etc_GMT_minus_12'),
    ];

    include View::getAdmView('header');
    require_once(View::getAdmView('setting'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'save') {
    LoginAuth::checkToken();
    $getData = [
        'blogname'            => Input::postStrVar('blogname'),
        'blogurl'             => Input::postStrVar('blogurl'),
        'bloginfo'            => Input::postStrVar('bloginfo'),
        'icp'                 => Input::postStrVar('icp'),
        'footer_info'         => Input::postStrVar('footer_info'),
        'index_lognum'        => Input::postIntVar('index_lognum'),
        'timezone'            => Input::postStrVar('timezone'),
        'comment_code'        => Input::postStrVar('comment_code', 'n'),
        'comment_interval'    => Input::postIntVar('comment_interval', 15),
        'iscomment'           => Input::postStrVar('iscomment', 'n'),
        'login_comment'       => Input::postStrVar('login_comment', 'n'),
        'ischkcomment'        => Input::postStrVar('ischkcomment', 'n'),
        'isthumbnail'         => Input::postStrVar('isthumbnail', 'n'),
        'rss_output_num'      => Input::postIntVar('rss_output_num', 10),
        'rss_output_fulltext' => Input::postStrVar('rss_output_fulltext', 'y'),
        'isfullsearch'        => Input::postStrVar('isfullsearch', 'n'),
        'comment_paging'      => Input::postStrVar('comment_paging', 'n'),
        'comment_pnum'        => Input::postIntVar('comment_pnum'),
        'comment_order'       => Input::postStrVar('comment_order', 'newer'),
        'att_imgmaxw'         => Input::postIntVar('att_imgmaxw', 420),
        'att_imgmaxh'         => Input::postIntVar('att_imgmaxh', 460),
        'detect_url'          => Input::postStrVar('detect_url', 'n'),
        'panel_menu_title'    => Input::postStrVar('panel_menu_title'),
    ];

    if ($getData['comment_code'] == 'y' && !checkGDSupport()) {
        Output::error(_lang('comment_captcha_gd_error'));
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
    Output::ok();
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
    $is_sample_url = $is_sample_url == 'y' ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_seo'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'seo_save') {
    LoginAuth::checkToken();

    $permalink = Input::postStrVar('permalink', '0');
    $isalias = Input::postStrVar('isalias', 'n');
    $isalias_html = Input::postStrVar('isalias_html', 'n');
    $is_sample_url = Input::postStrVar('is_sample_url', 'n');

    $getData = [
        'site_title'       => Input::postStrVar('site_title', ''),
        'site_description' => Input::postStrVar('site_description', ''),
        'site_key'         => Input::postStrVar('site_key', ''),
        'isurlrewrite'     => Input::postStrVar('permalink', '0'),
        'isalias'          => Input::postStrVar('isalias', 'n'),
        'isalias_html'     => Input::postStrVar('isalias_html', 'n'),
        'log_title_style'  => Input::postStrVar('log_title_style', '0'),
        'is_sample_url'    => Input::postStrVar('is_sample_url', 'n'),
    ];

    if ($permalink != '0' || $isalias == 'y') {
        $t = parse_url(BLOG_URL);
        $rw_rule = '<IfModule mod_rewrite.c>
                       RewriteEngine on
                       RewriteCond %{REQUEST_FILENAME} !-f
                       RewriteCond %{REQUEST_FILENAME} !-d
                       RewriteBase ' . $t['path'] . '
                       RewriteRule . ' . $t['path'] . 'index.php [L]
                    </IfModule>';
        if (!file_put_contents(EMLOG_ROOT . '/.htaccess', $rw_rule)) {
            Output::error(_lang('htaccess_write_error'));
        }
    }

    foreach ($getData as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache(array('options', 'navi'));
    Output::ok();
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
    $mail_template = isset($options_cache['mail_template']) ? $options_cache['mail_template'] : '';

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
        'smtp_mail'           => Input::postStrVar('smtp_mail'),
        'smtp_pw'             => Input::postStrVar('smtp_pw'),
        'smtp_from_name'      => Input::postStrVar('smtp_from_name'),
        'smtp_server'         => Input::postStrVar('smtp_server'),
        'smtp_port'           => Input::postStrVar('smtp_port'),
        'mail_notice_comment' => Input::postStrVar('mail_notice_comment', 'n'),
        'mail_notice_post'    => Input::postStrVar('mail_notice_post', 'n'),
        'mail_template'       => Input::postStrVar('mail_template'),
    ];

    foreach ($data as $key => $val) {
        Option::updateOption($key, $val);
    }

    $CACHE->updateCache(array('options'));
    Output::ok();
}

if ($action == 'mail_test') {
    $data = [
        'smtp_mail'      => Input::postStrVar('smtp_mail'),
        'smtp_pw'        => Input::postStrVar('smtp_pw'),
        'smtp_from_name' => Input::postStrVar('smtp_from_name'),
        'smtp_server'    => Input::postStrVar('smtp_server'),
        'smtp_port'      => Input::postIntVar('smtp_port'),
        'testTo'         => Input::postStrVar('testTo'),
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
    $mail->isHTML();
    $mail->Body = Notice::getMailTemplate('这是一封测试邮件');

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
    $article_uneditable = isset($options_cache['article_uneditable']) ? $options_cache['article_uneditable'] : '';
    $forbid_user_upload = isset($options_cache['forbid_user_upload']) ? $options_cache['forbid_user_upload'] : '';
    $posts_per_day = isset($options_cache['posts_per_day']) ? $options_cache['posts_per_day'] : '';
    $posts_name = isset($options_cache['posts_name']) ? $options_cache['posts_name'] : '';
    $email_code = isset($options_cache['email_code']) ? $options_cache['email_code'] : '';
    $att_maxsize = isset($options_cache['att_maxsize']) ? $options_cache['att_maxsize'] : '';
    $att_type = isset($options_cache['att_type']) ? $options_cache['att_type'] : '';

    $conf_is_signup = $is_signup == 'y' ? 'checked="checked"' : '';
    $conf_login_code = $login_code == 'y' ? 'checked="checked"' : '';
    $conf_email_code = $email_code == 'y' ? 'checked="checked"' : '';
    $conf_ischkarticle = $ischkarticle == 'y' ? 'checked="checked"' : '';
    $conf_forbid_user_upload = $forbid_user_upload == 'y' ? 'checked="checked"' : '';
    $conf_article_uneditable = $article_uneditable == 'y' ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_user'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'user_save') {
    LoginAuth::checkToken();
    $data = [
        'is_signup'          => Input::postStrVar('is_signup', 'n'),
        'login_code'         => Input::postStrVar('login_code', 'n'),
        'email_code'         => Input::postStrVar('email_code', 'n'),
        'ischkarticle'       => Input::postStrVar('ischkarticle', 'n'),
        'article_uneditable' => Input::postStrVar('article_uneditable', 'n'),
        'forbid_user_upload' => Input::postStrVar('forbid_user_upload', 'n'),
        'posts_per_day'      => Input::postIntVar('posts_per_day', 0),
        'posts_name'         => Input::postStrVar('posts_name'),
        'att_maxsize'        => Input::postIntVar('att_maxsize'),
        'att_type'           => str_replace(['php', 'phtml', 'pht'], 'x', strtolower(Input::postStrVar('att_type', ''))),
    ];

    if ($data['login_code'] == 'y' && !checkGDSupport()) {
        Output::error(_lang('login_captcha_gd_error'));
    }

    foreach ($data as $key => $val) {
        Option::updateOption($key, $val);
    }

    $CACHE->updateCache('options');
    Output::ok();
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

    $isOpenapiEnabled = Input::postStrVar('is_openapi', 'n');
    Option::updateOption('is_openapi', $isOpenapiEnabled);
    $CACHE->updateCache('options');
    Output::ok();
}

if ($action == 'api_reset') {
    LoginAuth::checkToken();

    $apikey = md5(getRandStr(32));

    Option::updateOption('apikey', $apikey);
    $CACHE->updateCache('options');
    header('Location: ./setting.php?action=api&ok_reset=1');
}

if ($action == 'ai') {
    $aiModel = AI::model();
    $aiModels = AI::models();
    $currentModelKey = Option::get('ai_model');
    $currentImageModelKey = Option::get('ai_image_model');

    include View::getAdmView('header');
    require_once(View::getAdmView('setting_ai'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'ai_save') {
    LoginAuth::checkToken();

    $aiApiUrl = Input::postStrVar('ai_api_url');
    $aiApiKey = Input::postStrVar('ai_api_key');
    $aiModel = Input::postStrVar('ai_model');
    $aiModelType = Input::postStrVar('ai_model_type', 'chat'); // 默认为文本对话模型

    $aiModels = AI::models();
    $key = md5($aiModel . $aiApiUrl . $aiModelType);
    $aiModels[$key] = [
        'api_url' => $aiApiUrl,
        'api_key' => $aiApiKey,
        'model' => $aiModel,
        'type' => $aiModelType,
    ];

    Option::updateOption('ai_models', json_encode($aiModels));

    // 根据模型类型设置当前模型
    if ($aiModelType === 'image') {
        // 如果是图像生成模型且没有当前图像生成模型，设置为当前图像生成模型
        $currentImageModel = Option::get('ai_image_model');
        if (empty($currentImageModel)) {
            Option::updateOption('ai_image_model', $key);
        }
    } else {
        // 如果是对话模型且没有当前对话模型，设置为当前对话模型
        $currentChatModel = Option::get('ai_model');
        if (empty($currentChatModel)) {
            Option::updateOption('ai_model', $key);
        }
    }

    $CACHE->updateCache('options');
    emDirect("./setting.php?action=ai");
}

if ($action == 'ai_model') {
    $aiModelKey = Input::getStrVar('ai_model_key');
    $modelType = Input::getStrVar('model_type', 'chat');
    if (empty($aiModelKey)) {
        emDirect("./setting.php?action=ai");
    }

    // 根据模型类型设置相应的当前模型
    if ($modelType === 'image') {
        Option::updateOption('ai_image_model', $aiModelKey);
    } else {
        Option::updateOption('ai_model', $aiModelKey);
    }

    $CACHE->updateCache('options');
    emDirect("./setting.php?action=ai");
}

if ($action == 'delete_model') {
    $aiModelKey = Input::getStrVar('ai_model_key');
    $aiModels = AI::models();
    $currentAiModelKey = AI::model();
    if (is_array($aiModels) && isset($aiModels[$aiModelKey])) {
        unset($aiModels[$aiModelKey]);
        Option::updateOption('ai_models', json_encode($aiModels));
        if ($currentAiModel == $aiModelKey) {
            Option::updateOption('ai_model', '');
        }
        $CACHE->updateCache('options');
        emDirect("./setting.php?action=ai");
    } else {
        emDirect("./setting.php?action=ai");
    }
}

if ($action == 'ai_update') {
    LoginAuth::checkToken();

    $aiModelKey = Input::postStrVar('ai_model_key');
    $aiModel = Input::postStrVar('edit_ai_model');
    $aiModelType = Input::postStrVar('ai_model_type', 'chat');

    $aiModels = AI::models();
    if (!isset($aiModels[$aiModelKey])) {
        emDirect("./setting.php?action=ai");
    }
    $aiModels[$aiModelKey]['model'] = $aiModel;
    // 确保模型类型字段存在
    if (!isset($aiModels[$aiModelKey]['type'])) {
        $aiModels[$aiModelKey]['type'] = $aiModelType;
    }

    Option::updateOption('ai_models', json_encode($aiModels));
    $CACHE->updateCache('options');
    emDirect("./setting.php?action=ai");
}
