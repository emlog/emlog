<?php
/**
 * Widgets 侧边栏目管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id: comment.php 654 2008-09-07 10:36:15Z emloog $
 */

require_once('./globals.php');


if($action == '')
{
	$widgets = @unserialize($options_cache['widgets']);
	$widgetTitle = @unserialize($options_cache['widget_title']);
	$custom_title = @unserialize($options_cache['custom_title']);
	$custom_content = @unserialize($options_cache['custom_content']);

	//music
	$music = $CACHE->readCache('musics');
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

	include getViews('header');
	require_once(getViews('widgets'));
	include getViews('footer');
	cleanPage();
}

if($action == 'setwg')
{
	$widgetTitle = @unserialize($options_cache['widget_title']);
	$widget = isset($_GET['wg']) ? $_GET['wg'] : '';
	$wgTitle = isset($_POST['title']) ? $_POST['title'] : '';

	preg_match("/^(.*)\s\(.*/", $widgetTitle[$widget], $matchs);
	$realWgTitle = $matchs[1] ? $matchs[1] : $widgetTitle[$widget];

	$widgetTitle[$widget] = $realWgTitle.' ('.$wgTitle.')';
	$widgetTitle = serialize($widgetTitle);

	$DB->query("update ".DB_PREFIX."options set option_value='$widgetTitle' where option_name='widget_title'");

	switch ($widget)
	{
		case 'newcomm':
			$index_comnum = isset($_POST['index_comnum']) ? intval($_POST['index_comnum']) : 10;
			$comment_subnum = isset($_POST['comment_subnum']) ? intval($_POST['comment_subnum']) : 20;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_comnum' where option_name='index_comnum'");
			$DB->query("update ".DB_PREFIX."options set option_value='$comment_subnum' where option_name='comment_subnum'");
			break;
		case 'twitter':
			$index_twnum = isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : 10;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_twnum' where option_name='index_twnum'");
			break;
		case 'newlog':
			$index_newlog = isset($_POST['index_newlog']) ? intval($_POST['index_newlog']) : 10;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_newlog' where option_name='index_newlognum'");
			break;
		case 'random_log':
			$index_randlognum = isset($_POST['index_randlognum']) ? intval($_POST['index_randlognum']) : 20;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_randlognum' where option_name='index_randlognum'");
			break;
		case 'music':
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
			$CACHE->cacheWrite($cacheData,'musics');
			break;
	}
	$CACHE->mc_options();
	header("Location: ./widgets.php?activated=true");
}

if($action == 'compages')
{
	$widgets = isset($_POST['widgets']) ? serialize($_POST['widgets']) : array();
	$customTextTitle = isset($_POST['custom_title']) ? serialize($_POST['custom_title']) : array();
	$customTextContent = isset($_POST['custom_text']) ? serialize($_POST['custom_text']) : array();

	$DB->query("update ".DB_PREFIX."options set option_value='$widgets' where option_name='widgets'");
	$DB->query("update ".DB_PREFIX."options set option_value='$customTextTitle' where option_name='custom_title'");
	$DB->query("update ".DB_PREFIX."options set option_value='$customTextContent' where option_name='custom_content'");
	$CACHE->mc_options();
	header("Location: ./widgets.php?activated=true");
}

?>