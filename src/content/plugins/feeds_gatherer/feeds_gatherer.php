<?php
/*
Plugin Name: Feeds Gatherer
Version: 2.0
Plugin URL:
Description: 通过RSS获取友情链接的最新日志
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');
function feeds_gatherer_read($type = 'data')
{
	$file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/'.$type;
	if(@$fp = fopen($file, 'r'))
	{
		$data = unserialize(fread($fp,filesize($file)));
		fclose($fp);
	}
	return $data;
}
$feeds_gatherer_data = feeds_gatherer_read('data');
$feeds_gatherer = feeds_gatherer_read('logs');
if($feeds_gatherer_data['inited'] == 1)
{
	$feeds_gatherer_task = $feeds_gatherer_data['task'];
	if(time() - $feeds_gatherer_data['time'] > $feeds_gatherer_data['freq'])
	{
		feeds_gatherer_update_task($feeds_gatherer_data['num']);
	}
}
if(isset($_GET['feeds_gatherer_update']))
{
	$js_ids = array_slice($feeds_gatherer_task,0,$feeds_gatherer_data['num']);
	feeds_gatherer_update_task($feeds_gatherer_data['num']);
	foreach($js_ids as $value)
	{
		$content = '';
		if(!empty($feeds_gatherer[$value]))
		{
			foreach($feeds_gatherer[$value] as $value1)
			{
				$ext = '';
				$time = time() - strtotime($value1['date']);
				if($time < 86400)
				{
					$ext = ' class="lof-new"';
				}elseif($time < 172800){
					$ext = ' class="lof-new1"';
				}
				$content .= "<a href=\"".$value1['url']."\"{$ext} target=\"_blank\">".$value1['title']."</a><br />";
			}
			echo "document.getElementById('feed-$value').innerHTML = '$content';\n";
		}
	}
	exit;
}
function feeds_gatherer_menu0()
{
	echo '<div class="sidebarsubmenu" id="feeds_gatherer"><a href="./plugin.php?plugin=feeds_gatherer&act=init">Feeds Gatherer</a></div>';
}
function feeds_gatherer_menu1()
{
	echo '<div class="sidebarsubmenu" id="feeds_gatherer"><a href="./plugin.php?plugin=feeds_gatherer">Feeds Gatherer</a></div>';
}
if($feeds_gatherer_data['inited'] == 0)
{
	addAction('adm_sidebar_ext', 'feeds_gatherer_menu0');
}else{
	addAction('adm_sidebar_ext', 'feeds_gatherer_menu1');
}
function feeds_gatherer_update_task($num)
{
	global $feeds_gatherer_data,$feeds_gatherer;
	$id1 = $feeds_gatherer_data['task'];
	$id2 = array_slice($id1,0,$num);
	feeds_gatherer_update($id2);
	$id1 = array_diff($id1,$id2);
	$feeds_gatherer_data['time'] = time();
	$feeds_gatherer_data['task'] = array_merge($id1,$id2);
	$file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/data';
	@$fp = fopen($file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@fwrite($fp,serialize($feeds_gatherer_data)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
}
function feeds_gatherer_add($id,$url)
{
	global $feeds_gatherer_data,$feeds_gatherer_task;
	if(substr($url,-1) != '/')
		$url .= '/';
	$feeds_gatherer_data['rss'][$id] = $url.'rss.php';
	$feeds_gatherer_task[] = $id;
	$feeds_gatherer_data['task'] = $feeds_gatherer_task;
	$file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/data';
	@$fp = fopen($file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@fwrite($fp,serialize($feeds_gatherer_data)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
	feeds_gatherer_update(array($id));
	return $url.'rss.php';
}
function feeds_gatherer_get($url,$num)
{
	$header = '';
	//$header .= "GET ". $path ." HTTP/1.1\r\n";
	$header .= "ACCEPT: */*\r\n";
	$header .= "ACCEPT-LANGUAGE: zh-cn\r\n";
	$header .= "User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)\r\n";
	//$header .= "HOST: ". $host ."\r\n";
	$header .= "CONNECTION: close\r\n";
	//$header .= "COOKIE: $_COOKIE\r\n";
	//$header .= "\r\n";
	$header = explode("\r\n",$header);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HEADER, 0);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	curl_setopt($ch, CURLOPT_URL, $url);
	$data = curl_exec($ch);
	curl_close($ch);
	if($data) {
		preg_match_all("/<item>(.*?)<\/item>/is",$data,$items);
		$items = array_slice($items[1],0,$num);
		$logs = array();
		foreach($items as $key => $value)
		{
			preg_match("/<title>(.*)<\/title>/i",$value,$log_title);
			preg_match("/<!\[CDATA\[(.*)\]\]>/i",$log_title[1],$log_title1);
			if(!empty($log_title1))
				$log_title = $log_title1;
			preg_match("/<link>(.*)<\/link>/i",$value,$log_url);
			preg_match("/<pubDate>(.*)<\/pubDate>/i",$value,$log_date);
			$logs[] = array('title' => $log_title[1],'url' => $log_url[1], 'date' => $log_date[1]);
		}
    	return $logs;
	} else {
		return FALSE;
	}
}
function feeds_gatherer_update($id)
{
	global $feeds_gatherer_data,$feeds_gatherer;
	$emLink = new Link_Model();
	//set_time_limit(0);
	$rss = $feeds_gatherer_data['rss'];
	foreach($id as $value)
	{
		$linkData = $emLink->getOneLink($value);
		if(empty($linkData))
		{
			unset($feeds_gatherer[$value]);
			unset($feeds_gatherer_data['rss'][$value]);
			unset($feeds_gatherer_data['task'][array_search($value,$feeds_gatherer_data['task'])]);
			continue;
		}
		if($rss[$value] != '')
		{
			$new_data = feeds_gatherer_get($rss[$value],5);
			if(is_array($new_data))
				$feeds_gatherer[$value] = $new_data;
		}else{
			$feeds_gatherer[$value] = FALSE;
		}
	}
	$file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/data';
	@$fp = fopen($file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@fwrite($fp,serialize($feeds_gatherer_data)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
	$file = EMLOG_ROOT.'/content/plugins/feeds_gatherer/logs';
	@$fp = fopen($file, 'w') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/logs的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@fwrite($fp,serialize($feeds_gatherer)) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/feeds_gatherer/logs的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($fp);
}
function feeds_gatherer_log()
{
	global $feeds_gatherer;
	$out = '';
	$id = array_rand($feeds_gatherer,1);
	if(!empty($feeds_gatherer[$id]))
	{
		$out .= "<div class=\"related_post\">\r\n";
		$out .= "<h3>奇遇关注着：<small><a href=\"".BLOG_URL."plugin/feeds_gatherer\">more &raquo;</a></small></h3>\r\n<ul>\r\n";
		foreach($feeds_gatherer[$id] as $val)
		{
			$out .= "<li><a href=\"{$val['url']}\" target=\"_blank\">{$val['title']}</a></li>\r\n";
		}
		$out .= "</ul>\r\n</div>\r\n";
	}
	echo $out;
}
addAction('log_related','feeds_gatherer_log');
function mixch($str)
{
	return preg_replace_callback("/[\x{4e00}-\x{9fa5}]+/u",'ch2kuang',$str);
}
function ch2kuang($match)
{
	$str = $match[0];
	$length = strlen($str);
	$newstr = '̲̅';
	for($i = 0; $i < $length; $i++){
		$newstr .= $str{$i};
		if($i % 3 == 2)
			$newstr .= '̲̅';
	}
	return $newstr;
}