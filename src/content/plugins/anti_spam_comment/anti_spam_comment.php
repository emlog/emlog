<?php
/*
Plugin Name: 反垃圾评论
Version: 3.3
Plugin URL:
Description: 尝试判断垃圾评论并过滤之，可设置IP黑名单和屏蔽词汇
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function asc_time_limit($ip,$time_limit) {
	$DB = MySql::getInstance();
	if($time_limit <= 0) {
		return;
	}
	$time_line = time() - $time_limit;
	$sql = "SELECT ip FROM ".DB_PREFIX."comment WHERE ip='$ip' AND date > $time_line";
	$query = $DB->query($sql);
	$num = $DB->num_rows($query);
	if($num) {
		ascMsg("{$time_limit}秒内只能发表一次评论，评论发表失败");
	}
}
function asc_filter_keywords($keywords, $need_chinese) {
	$comment = isset($_POST['comment']) ? addslashes(trim($_POST['comment'])) : '';
	if($need_chinese && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $comment)) {
		ascMsg("您发表的评论未包含汉字，评论发表失败");
	}
	foreach($keywords as $keyword) {
		$keyword = asc_preg_quote($keyword);
		preg_match($keyword, stripslashes($comment), $matches);
		if(!empty($matches[0]))	{
			ascMsg("您发表的评论含有禁止内容".htmlspecialchars($matches[0])."，评论发表失败");
		}
	}
}
function asc_filter_name($keywords) {
	$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
	foreach($keywords as $keyword) {
		$keyword = asc_preg_quote($keyword);
		preg_match($keyword, stripslashes($comname), $matches);
		if(!empty($matches[0]))	{
			ascMsg("您的昵称含有禁止内容".htmlspecialchars($matches[0])."，评论发表失败");
		}
	}
}
function asc_filter_url($keywords) {
	$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
	foreach($keywords as $keyword) {
		$keyword = asc_preg_quote($keyword);
		preg_match($keyword, stripslashes($comurl), $matches);
		if(!empty($matches[0]))	{
			ascMsg("您填写的地址含有禁止内容".htmlspecialchars($matches[0])."，评论发表失败");
		}
	}
}
function asc_filter_blacklist($ip,$blacklist) {
	$ipArray = explode('.',$ip);
	$ip = $ipArray[0];
	if(in_array($ip, $blacklist, true)) {
		ascMsg("您的IP已被系统屏蔽，评论发表失败");
	}
	for($i = 1; $i < count($ipArray); $i++) {
		$ip .= '.'.$ipArray[$i];
		if(in_array($ip, $blacklist, true)) {
			ascMsg("您的IP已被系统屏蔽，评论发表失败");
		}
	}
}
function asc_add_to_blacklist($ip, $auto_blacklist, $max_attempt) {
	if($auto_blacklist) {
		$time = time();
		$temp = asc_read('temp');
		$key = array_search($ip,$temp['ip']);
		if($key !== false) {
			if($temp['time'][$key] < $time - 60) {
				$temp['time'][$key] = $time;
				$temp['attempt'][$key] = 1;
			} else {
				$temp['attempt'][$key]++;
				if($max_attempt > 0 && $temp['attempt'][$key] > $max_attempt) {
					$comname = isset($_POST['comname']) ? addslashes(trim($_POST['comname'])) : '';
					$comurl = isset($_POST['comurl']) ? addslashes(trim($_POST['comurl'])) : '';
					$data = asc_read();
					if(strstr($data['name_keywords'], $comname) === false) $data['name_keywords'] .= '|' . $comname;
					if(array_search($comurl, $data['url_keywords']) === false) $data['url_keywords'][] = $comurl;
					if(array_search($ip, $data['blacklist']) === false) $data['blacklist'][] = $ip;
					asc_write($data);
					ascMsg("您的IP已被系统屏蔽，评论发表失败");
				}
			}
		} else {
			$temp['ip'][] = $ip;
			$temp['time'][] = $time;
			$temp['attempt'][] = 1;
		}
		if(count($temp['time']) > 50) {
			foreach($temp['time'] as $key => $val) {
				if($val < $time - 60) {
					unset($temp['ip'][$key]);
					unset($temp['time'][$key]);
					unset($temp['attempt'][$key]);
				}
			}
		}
		asc_write($temp, 'temp');
	}
}
function ascMsg($msg, $url = 'javascript:history.back(-1);') {
	if(isset($_GET['gid'])) {
		define ('TEMPLATE_PATH', EMLOG_ROOT . '/m/view/');
		$url = BLOG_URL . 'm/?post='. intval($_GET['gid']);
		include View::getView('header');
		include View::getView('msg');
		include View::getView('footer');
		View::output();
		exit;
	} else {
		emMsg($msg,$url);
	}
}
function asc_preg_quote($keyword) {
	$keyword = str_replace('\*', '.*', preg_quote($keyword, "/"));
	$variable = array("asc_letter","asc_digit","asc_char","asc_star");
	$variable_to_be = array("^[a-zA-Z]+$","[0-9]+","^[\x01-\x7E]+$","\*");
	$keyword = str_replace($variable, $variable_to_be, $keyword);
	$keyword = '/' . $keyword . '/i';
	return $keyword;
}
function asc_read($type = 'data') {
	$file = EMLOG_ROOT.'/content/plugins/anti_spam_comment/'.$type;
	$data = unserialize(file_get_contents($file));
	return $data;
}
function asc_write($data, $type = 'data'){
	$file = EMLOG_ROOT.'/content/plugins/anti_spam_comment/'.$type;
	@$fp = fopen($file, 'w');
	@$fw = fwrite($fp,serialize($data));
	@fclose($fp);
}
function asc_adm_menu() {
	echo '<div class="sidebarsubmenu" id="anti_spam_comment"><a href="./plugin.php?plugin=anti_spam_comment">反垃圾评论</a></div>';
}
addAction('adm_sidebar_ext', 'asc_adm_menu');
$action = isset($_GET['action']) ? addslashes(trim($_GET['action'], '? ')) : '';
if($action == 'addcom' && ROLE == 'visitor') {
	$data = asc_read();
	extract($data);
	$keywords = explode("|",$keywords);
	$name_keywords = explode("|",$name_keywords);
	$ipaddr = getIp();
	asc_add_to_blacklist($ipaddr,$auto_blacklist,$max_attempt);
	asc_time_limit($ipaddr,$time_limit);
	asc_filter_blacklist($ipaddr,$blacklist);
	asc_filter_keywords($keywords, $need_chinese);
	asc_filter_name($name_keywords);
	asc_filter_url($url_keywords);
}
