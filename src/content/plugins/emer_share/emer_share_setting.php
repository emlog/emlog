<?php

if (!defined('EMLOG_ROOT')) {
    exit('error!');
}

if (isset($_GET['do']) && $_GET['do'] == 'ractiv') {
    emer_share_ractive();
	exit;
}

if (isset($_GET['do']) && $_GET['do'] == 'activ') {
    emer_share_change();
	exit;
}

if (isset($_GET['do']) && $_GET['do'] == 'sync') {
    emer_share_sync();
	exit;
}

function plugin_setting_view() {
    include_once 'emer_share_view_base.php';
    if (defined('EMEER_SHARE_ID') && !isset($_GET['error'])) {
        include_once 'emer_share_view_sync.php';
    } else {
		if (isset($_GET['info']) && ($_GET['info'] == 1 || $_GET['info'] == 3)) {
			include_once 'emer_share_view_ractiv.php';
		}else{
			include_once 'emer_share_view_activ.php';
		}
	} 
}

function plugin_setting() {
    if (isset($_POST['sync'])) {
        $sync = htmlspecialchars($_POST['sync'], ENT_QUOTES);
		$category = htmlspecialchars($_POST['category'], ENT_QUOTES);
		$ralecount = htmlspecialchars($_POST['ralecount'], ENT_QUOTES);
		if($category != EMEER_SHARE_CATEGORY){
			emer_share_post("emer/update",array("categoryid"=>$category));
		}
		$rale = 'false';
		if(isset($_POST['rale'])){
			$rale = 'true';
		}
        $fso = fopen(EMLOG_ROOT . '/content/plugins/emer_share/emer_share_config.php', 'r');
        $config = fread($fso, filesize(EMLOG_ROOT . '/content/plugins/emer_share/emer_share_config.php'));
        fclose($fso);
		
        $pattern = array("/define\('EMEER_SHARE_SYNC',(.*)\)/","/define\('EMEER_SHARE_CATEGORY',(.*)\)/","/define\('EMEER_SHARE_RALATENUM',(.*)\)/","/define\('EMEER_SHARE_RALATE',(.*)\)/");
        $replace = array("define('EMEER_SHARE_SYNC','" . $sync . "')","define('EMEER_SHARE_CATEGORY','" . $category . "')","define('EMEER_SHARE_RALATENUM','" . $ralecount . "')","define('EMEER_SHARE_RALATE'," . $rale . ")");

        $new_config = preg_replace($pattern, $replace, $config);
        $fso = fopen(EMLOG_ROOT . '/content/plugins/emer_share/emer_share_config.php', 'w');
        fwrite($fso, $new_config);
        fclose($fso);
    } else {
        emer_share_active();
    }
}

function emer_share_active() {
    global $CACHE;
    $emer_user_cache = $CACHE->readCache('user');

   if (empty($emer_user_cache[1]['mail'])) emMsg("云平台错误提示：请先完善个人资料中的电子邮件一项！"); 
	
	$emer_share_post_url = EMER_API_URL."emer/active";
    $emer_share_ch = curl_init();
	$emer_post_data = array(
		'email' => $emer_user_cache[1]['mail'],
		'blogname' => Option::get('blogname'),
		'blogdes' => Option::get('bloginfo'),
		'blogurl' => BLOG_URL,
		'emername' => $emer_user_cache[1]['name'],
		'emer_avatar' => md5($emer_user_cache[1]['mail'])
	);

	curl_setopt($emer_share_ch, CURLOPT_URL, $emer_share_post_url);
	curl_setopt($emer_share_ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($emer_share_ch, CURLOPT_POST, 1);
	curl_setopt($emer_share_ch, CURLOPT_POSTFIELDS, $emer_post_data);

	$emer_share_output = curl_exec($emer_share_ch);
	if ($emer_share_output === FALSE) {
		emMsg("cURL Error: " . curl_error($emer_share_ch));
	}
	
	$emer_reslut = json_decode($emer_share_output, true);
	if(!$emer_reslut) emMsg($emer_share_output);
	
	if (!$emer_reslut["status"]){
		if($emer_reslut["info"] == "has"){
			header("Location: ./plugin.php?plugin=emer_share&error=true&info=3");
			exit;
		}
		emMsg("云平台错误提示：".$emer_reslut["info"]); 
	}  
	
	$profile = EMLOG_ROOT . '/content/plugins/emer_share/emer_share_profile.php';
	$emer_profile = "<?php\ndefine('EMEER_SHARE_ID','" . $emer_reslut["data"]['id'] . "');\ndefine('EMEER_SHARE_PW','" . $emer_reslut["data"]['pw'] . "');\n";
	$fp = @fopen($profile, 'wb');
	if (!$fp) {
		emMsg('操作失败，请确保插件目录(/content/plugins/emer_share/)可写');
	}
	fwrite($fp, $emer_profile);
	fclose($fp);
}

function emer_share_ractive() {
    $emer_share_post_url = EMER_API_URL."emer/ractive";
    $emer_post_data = array(
        'blogurl' => BLOG_URL
    );
    $emer_share_ch = curl_init();
    curl_setopt($emer_share_ch, CURLOPT_URL, $emer_share_post_url);
    curl_setopt($emer_share_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($emer_share_ch, CURLOPT_POST, 1);
    curl_setopt($emer_share_ch, CURLOPT_POSTFIELDS, $emer_post_data);

    $emer_share_output = curl_exec($emer_share_ch);

	if ($emer_share_output === FALSE) {
			emMsg("cURL Error: " . curl_error($emer_share_ch));
    }
    $emer_reslut = json_decode($emer_share_output, true);
	
	if(!$emer_reslut) emMsg($emer_share_output);
	
    if ($emer_reslut['status']) {
		header("Location: ./plugin.php?plugin=emer_share&error=true&info=1");//info=1。邮件发送成功！
		exit;
    }
	emMsg("云平台错误提示：".$emer_reslut["info"]); 
}

function emer_share_change() {
    $emer_mid = $_POST['mid'];
    $emer_pw = $_POST['pw'];
	if(empty($emer_mid) || empty($emer_pw)){
		emMsg('信息不完整！');
	}
    $profile = EMLOG_ROOT . '/content/plugins/emer_share/emer_share_profile.php';
    $emer_profile = "<?php\ndefine('EMEER_SHARE_ID','" . $emer_mid . "');\ndefine('EMEER_SHARE_PW','" .  $emer_pw . "');\n";
    $fp = @fopen($profile, 'wb');
    if (!$fp) {
        emMsg('操作失败，请确保插件目录(/content/plugins/emer_share/)可写');
    }
    fwrite($fp, $emer_profile);
    fclose($fp);
	header("Location: ./plugin.php?plugin=emer_share&setting=true");
	exit;
}

function emer_share_sync(){
	global $CACHE;
    $emer_user_cache = $CACHE->readCache('user');
	if (empty($emer_user_cache[1]['mail'])) emMsg("云平台错误提示：请先完善个人资料中的电子邮件一项！"); 
	
	$emer_post_data = array(
		'email' => $emer_user_cache[1]['mail'],
		'blogname' => Option::get('blogname'),
		'blogdes' => Option::get('bloginfo'),
		'emername' => $emer_user_cache[1]['name'],
		'emer_avatar' => md5($emer_user_cache[1]['mail'])
	);
	$reslut = emer_share_post("emer/update",$emer_post_data);
	header("Location: ./plugin.php?plugin=emer_share&info=2");
	exit;
}
?>