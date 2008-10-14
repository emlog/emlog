<?php
/**
 * 背景音乐
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

$music = $CACHE->readCache('../cache/musics');

if($action == '')
{
	include getViews('header');
	
	$ismusic = isset($music['ismusic']) && $music['ismusic'] === 1 ? "checked=\"checked\"" : '';
	if(isset($music['auto']) && $music['auto'])
	{
		$auto1 = "checked=\"checked\"";
		$auto2 = '';
	}else{
		$auto2 = "checked=\"checked\"";
		$auto1 = '';		
	}
	if(isset($music['randplay']) && $music['randplay'])
	{
		$randplay1 = "checked=\"checked\"";
		$randplay2 = '';
	}else{
		$randplay2 = "checked=\"checked\"";
		$randplay1 = '';		
	}
	$content = '';
	if(isset($music['mlinks']) && $music['mlinks'])
	{
		foreach($music['mlinks'] as $key=>$val)
		{
			$content .= urldecode($val)."\t".$music['mdes'][$key]."\n";
		}
	}
	
	require_once(getViews('music'));
	include getViews('footer');cleanPage();
}

if($action== 'mod')
{
	$ismusic= isset($_POST['ismusic']) ? intval($_POST['ismusic']) : 0;
	$links = isset($_POST['mlinks']) ? htmlspecialchars(trim($_POST['mlinks'])) : '';
	$randplay = isset($_POST['randplay']) ? intval($_POST['randplay']) : 0;
	$auto = isset($_POST['auto']) ? intval($_POST['auto']) : 0;
	$music = array(
			'mlinks'=>array(),
			'mdes'=>array(),
			'auto'=>$auto,
			'randplay'=>$randplay,
			'ismusic'=>$ismusic
			);
	if($links)
	{
		$links = explode("\n",$links);
		foreach($links as $val)
		{
			$val = str_replace(array("\r","\n"),array('',''),$val);
			if(preg_match("/^(http:\/\/).+/i",$val)>0)
			{
				$mstr = preg_split ("/[\s,]+/", $val,2);
				$music['mlinks'][] = urlencode($mstr[0]);
				if(count($mstr) == 2)
				{
					$music['mdes'][] = $mstr[1];
				}else {
					$music['mdes'][] = '';
				}
			}else{
				formMsg('链接中有错误的音乐地址','javascript: window.history.back()',0);
			}
		}
	}
	$cacheData = serialize($music);
	$CACHE->cacheWrite($cacheData,'../cache/musics');
	formMsg('背景音乐设置成功','./music.php',1);
}

?>