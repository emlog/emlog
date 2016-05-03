<?php
/**
 * Blog settings
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
    $options_cache = $CACHE->readCache('options');
    extract($options_cache);

    $conf_login_code = $login_code == 'y' ? 'checked="checked"' : '';
    $conf_comment_code = $comment_code == 'y' ? 'checked="checked"' : '';
    $conf_comment_needchinese = $comment_needchinese == 'y' ? 'checked="checked"' : '';
    $conf_iscomment = $iscomment == 'y' ? 'checked="checked"' : '';
    $conf_ischkcomment = $ischkcomment == 'y' ? 'checked="checked"' : '';
    $conf_isexcerpt = $isexcerpt == 'y' ? 'checked="checked"' : '';
    $conf_isthumbnail = $isthumbnail == 'y' ? 'checked="checked"' : '';
    $conf_isgravatar = $isgravatar == 'y' ? 'checked="checked"' : '';
    $conf_comment_paging = $comment_paging == 'y' ? 'checked="checked"' : '';
    $conf_istreply = $istreply == 'y' ? 'checked="checked"' : '';
    $conf_reply_code = $reply_code == 'y' ? 'checked="checked"' : '';
    $conf_ischkreply = $ischkreply == 'y' ? 'checked="checked"' : '';
    $conf_detect_url = $detect_url == 'y' ? 'checked="checked"' : '';

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

/*vot*/ $tzlist = array(
        'Etc/GMT'		=>	lang('Etc/GMT'),
        'Africa/Casablanca'	=>	lang('Africa/Casablanca'),
        'Atlantic/Reykjavik'	=>	lang('Atlantic/Reykjavik'),
        'Europe/London'		=>	lang('Europe/London'),
        'Africa/Lagos'		=>	lang('Africa/Lagos'),
        'Europe/Paris'		=>	lang('Europe/Paris'),
        'Africa/Windhoek'	=>	lang('Africa/Windhoek'),
        'Europe/Warsaw'		=>	lang('Europe/Warsaw'),
        'Europe/Budapest'	=>	lang('Europe/Budapest'),
        'Europe/Berlin'		=>	lang('Europe/Berlin'),
        'Europe/Istanbul'	=>	lang('Europe/Istanbul'),
        'Europe/Kaliningrad'	=>	lang('Europe/Kaliningrad'),
        'Africa/Johannesburg'	=>	lang('Africa/Johannesburg'),
        'Asia/Damascus'		=>	lang('Asia/Damascus'),
        'Asia/Amman'		=>	lang('Asia/Amman'),
        'Africa/Cairo'		=>	lang('Africa/Cairo'),
        'Africa/Tripoli'	=>	lang('Africa/Tripoli'),
        'Asia/Jerusalem'	=>	lang('Asia/Jerusalem'),
        'Asia/Beirut'		=>	lang('Asia/Beirut'),
        'Europe/Kiev'		=>	lang('Europe/Kiev'),
        'Europe/Bucharest'	=>	lang('Europe/Bucharest'),
        'Africa/Nairobi'	=>	lang('Africa/Nairobi'),
        'Asia/Baghdad'		=>	lang('Asia/Baghdad'),
        'Europe/Minsk'		=>	lang('Europe/Minsk'),
        'Asia/Riyadh'		=>	lang('Asia/Riyadh'),
        'Europe/Moscow'		=>	lang('Europe/Moscow'),
        'Asia/Tehran'		=>	lang('Asia/Tehran'),
        'Europe/Samara'		=>	lang('Europe/Samara'),
        'Asia/Yerevan'		=>	lang('Asia/Yerevan'),
        'Asia/Baku'		=>	lang('Asia/Baku'),
        'Asia/Tbilisi'		=>	lang('Asia/Tbilisi'),
        'Indian/Mauritius'	=>	lang('Indian/Mauritius'),
        'Asia/Dubai'		=>	lang('Asia/Dubai'),
        'Asia/Kabul'		=>	lang('Asia/Kabul'),
        'Asia/Karachi'		=>	lang('Asia/Karachi'),
        'Asia/Yekaterinburg'	=>	lang('Asia/Yekaterinburg'),
        'Asia/Tashkent'		=>	lang('Asia/Tashkent'),
        'Asia/Colombo'		=>	lang('Asia/Colombo'),
        'Asia/Calcutta'		=>	lang('Asia/Calcutta'),
        'Asia/Katmandu'		=>	lang('Asia/Katmandu'),
        'Asia/Novosibirsk'	=>	lang('Asia/Novosibirsk'),
        'Asia/Dhaka'		=>	lang('Asia/Dhaka'),
        'Asia/Almaty'		=>	lang('Asia/Almaty'),
        'Asia/Rangoon'		=>	lang('Asia/Rangoon'),
        'Asia/Krasnoyarsk'	=>	lang('Asia/Krasnoyarsk'),
        'Asia/Bangkok'		=>	lang('Asia/Bangkok'),
        'Asia/Ulaanbaatar'	=>	lang('Asia/Ulaanbaatar'),
        'Asia/Irkutsk'		=>	lang('Asia/Irkutsk'),
        'Asia/Shanghai'		=>	lang('Asia/Shanghai'),
        'Asia/Taipei'		=>	lang('Asia/Taipei'),
        'Asia/Singapore'	=>	lang('Asia/Singapore'),
        'Australia/Perth'	=>	lang('Australia/Perth'),
        'Asia/Tokyo'		=>	lang('Asia/Tokyo'),
        'Asia/Yakutsk'		=>	lang('Asia/Yakutsk'),
        'Asia/Seoul'		=>	lang('Asia/Seoul'),
        'Australia/Darwin'	=>	lang('Australia/Darwin'),
        'Australia/Adelaide'	=>	lang('Australia/Adelaide'),
        'Pacific/Port_Moresby'	=>	lang('Pacific/Port_Moresby'),
        'Australia/Sydney'	=>	lang('Australia/Sydney'),
        'Australia/Brisbane'	=>	lang('Australia/Brisbane'),
        'Asia/Vladivostok'	=>	lang('Asia/Vladivostok'),
        'Australia/Hobart'	=>	lang('Australia/Hobart'),
        'Asia/Magadan'		=>	lang('Asia/Magadan'),
        'Asia/Srednekolymsk'	=>	lang('Asia/Srednekolymsk'),
        'Pacific/Guadalcanal'	=>	lang('Pacific/Guadalcanal'),
        'Etc/GMT-12'		=>	lang('Etc/GMT-12'),
        'Pacific/Auckland'	=>	lang('Pacific/Auckland'),
        'Pacific/Fiji'		=>	lang('Pacific/Fiji'),
        'Asia/Kamchatka'	=>	lang('Asia/Kamchatka'),
        'Pacific/Tongatapu'	=>	lang('Pacific/Tongatapu'),
        'Pacific/Apia'		=>	lang('Pacific/Apia'),
        'Pacific/Kiritimati'	=>	lang('Pacific/Kiritimati'),
        'Atlantic/Azores'	=>	lang('Atlantic/Azores'),
        'Atlantic/Cape_Verde'	=>	lang('Atlantic/Cape_Verde'),
        'Etc/GMT+2'		=>	lang('Etc/GMT+2'),
        'America/Cayenne'	=>	lang('America/Cayenne'),
        'America/Sao_Paulo'	=>	lang('America/Sao_Paulo'),
        'America/Buenos_Aires'	=>	lang('America/Buenos_Aires'),
        'America/Godthab'	=>	lang('America/Godthab'),
        'America/Bahia'		=>	lang('America/Bahia'),
        'America/Montevideo'	=>	lang('America/Montevideo'),
        'America/St_Johns'	=>	lang('America/St_Johns'),
        'America/La_Paz'	=>	lang('America/La_Paz'),
        'America/Asuncion'	=>	lang('America/Asuncion'),
        'America/Halifax'	=>	lang('America/Halifax'),
        'America/Cuiaba'	=>	lang('America/Cuiaba'),
        'America/Caracas'	=>	lang('America/Caracas'),
        'America/New_York'	=>	lang('America/New_York'),
        'America/Indianapolis'	=>	lang('America/Indianapolis'),
        'America/Bogota'	=>	lang('America/Bogota'),
        'America/Guatemala'	=>	lang('America/Guatemala'),
        'America/Chicago'	=>	lang('America/Chicago'),
        'America/Mexico_City'	=>	lang('America/Mexico_City'),
        'America/Regina'	=>	lang('America/Regina'),
        'America/Phoenix'	=>	lang('America/Phoenix'),
        'America/Chihuahua'	=>	lang('America/Chihuahua'),
        'America/Denver'	=>	lang('America/Denver'),
        'America/Santa_Isabel'	=>	lang('America/Santa_Isabel'),
        'America/Los_Angeles'	=>	lang('America/Los_Angeles'),
        'America/Anchorage'	=>	lang('America/Anchorage'),
        'Pacific/Honolulu'	=>	lang('Pacific/Honolulu'),
        'Etc/GMT+11'		=>	lang('Etc/GMT+11'),
        'Etc/GMT+12'		=>	lang('Etc/GMT+12'),
    );

    include View::getView('header');
    require_once(View::getView('configure'));
    include View::getView('footer');
    View::output();
}

if ($action == 'mod_config') {
    LoginAuth::checkToken();
    $getData = array(
    'blogname' => isset($_POST['blogname']) ? addslashes($_POST['blogname'])  : '',
    'blogurl' => isset($_POST['blogurl']) ? addslashes($_POST['blogurl']) : '',
    'bloginfo' => isset($_POST['bloginfo']) ? addslashes($_POST['bloginfo']) : '',
    'icp' => isset($_POST['icp']) ? addslashes($_POST['icp']):'',
    'footer_info' => isset($_POST['footer_info']) ? addslashes($_POST['footer_info']):'',
    'index_lognum' => isset($_POST['index_lognum']) ? intval($_POST['index_lognum']) : '',
    'timezone' => isset($_POST['timezone']) ? addslashes($_POST['timezone']) : '',
    'login_code'   => isset($_POST['login_code']) ? addslashes($_POST['login_code']) : 'n',
    'comment_code' => isset($_POST['comment_code']) ? addslashes($_POST['comment_code']) : 'n',
    'comment_needchinese' => isset($_POST['comment_needchinese']) ? addslashes($_POST['comment_needchinese']) : 'n',
    'comment_interval' => isset($_POST['comment_interval']) ? intval($_POST['comment_interval']) : 15,
    'iscomment' => isset($_POST['iscomment']) ? addslashes($_POST['iscomment']) : 'n',
    'ischkcomment' => isset($_POST['ischkcomment']) ? addslashes($_POST['ischkcomment']) : 'n',
    'isexcerpt' => isset($_POST['isexcerpt']) ? addslashes($_POST['isexcerpt']) : 'n',
    'excerpt_subnum' => isset($_POST['excerpt_subnum']) ? intval($_POST['excerpt_subnum']) : '300',
    'isthumbnail' => isset($_POST['isthumbnail']) ? addslashes($_POST['isthumbnail']) : 'n',
    'rss_output_num' => isset($_POST['rss_output_num']) ? intval($_POST['rss_output_num']) : 10,
    'rss_output_fulltext' => isset($_POST['rss_output_fulltext']) ? addslashes($_POST['rss_output_fulltext']) : 'y',
    'isgravatar' => isset($_POST['isgravatar']) ? addslashes($_POST['isgravatar']) : 'n',
    'comment_paging' => isset($_POST['comment_paging']) ? addslashes($_POST['comment_paging']) : 'n',
    'comment_pnum' => isset($_POST['comment_pnum']) ? intval($_POST['comment_pnum']) : '',
    'comment_order' => isset($_POST['comment_order']) ? addslashes($_POST['comment_order']) : 'newer',
    'istreply' => isset($_POST['istreply']) ? addslashes($_POST['istreply']) : 'n',
    'ischkreply' => isset($_POST['ischkreply']) ? addslashes($_POST['ischkreply']) : 'n',
    'reply_code' => isset($_POST['reply_code']) ? addslashes($_POST['reply_code']) : 'n',
    'index_twnum' => isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : 10,
    'att_maxsize' => isset($_POST['att_maxsize']) ? intval($_POST['att_maxsize']) : 20480,
    'att_type' => isset($_POST['att_type']) ? str_replace('php', 'x', strtolower(addslashes($_POST['att_type']))) : '',
    'att_imgmaxw' => isset($_POST['att_imgmaxw']) ? intval($_POST['att_imgmaxw']) : 420,
    'att_imgmaxh' => isset($_POST['att_imgmaxh']) ? intval($_POST['att_imgmaxh']) : 460,
    'detect_url' => isset($_POST['detect_url']) ? addslashes($_POST['detect_url']) : 'n',
    );

    if ($getData['login_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
/*vot*/ emMsg(lang('verification_code_not_supported'),"configure.php");
    }
    if ($getData['comment_code'] == 'y' && !function_exists("imagecreate") && !function_exists('imagepng')) {
/*vot*/ emMsg(lang('verification_code_comment_not_supported'),"configure.php");
    }
    if ($getData['blogurl'] && substr($getData['blogurl'], -1) != '/') {
        $getData['blogurl'] .= '/';
    }
    if ($getData['blogurl'] && strncasecmp($getData['blogurl'],'http',4)) {
        $getData['blogurl'] = 'http://'.$getData['blogurl'];
    }

    foreach ($getData as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache(array('tags', 'options', 'comment', 'record'));
    emDirect("./configure.php?activated=1");
}
