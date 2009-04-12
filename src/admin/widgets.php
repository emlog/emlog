<?php
/**
 * Widgets 侧边栏目管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */

require_once('globals.php');

//显示组件管理面板
if($action == '')
{
	$wgNum = isset($_GET['wg']) ? intval($_GET['wg']) : 1;
	$widgets = $options_cache['widgets'.$wgNum] ? @unserialize($options_cache['widgets'.$wgNum]) : array();
	$widgetTitle = $options_cache['widget_title'] ? @unserialize($options_cache['widget_title']) : array();
	$custom_widget = $options_cache['custom_widget'] ? @unserialize($options_cache['custom_widget']) : array();
	$widgetTitle = array_map('htmlspecialchars', $widgetTitle);
	foreach ($custom_widget as $key => $val)
	{
		$custom_widget[$key] = array_map('htmlspecialchars', $val);
	}

	$customWgTitle = array();
	foreach ($widgetTitle as $key => $val)
	{
		if(preg_match("/^.*\s\((.*)\)/", $val, $matchs))
		{
			$customWgTitle[$key] = $matchs[1];
		}else{
			$customWgTitle[$key] = $val;
		}
	}

	//music
	$music = @unserialize($options_cache['music']);
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

//修改组件设置
if($action == 'setwg')
{
	$widgetTitle = @unserialize($options_cache['widget_title']);//当前所有组件标题
	$widget = isset($_GET['wg']) ? $_GET['wg'] : '';			//要修改的组件
	$wgTitle = isset($_POST['title']) ? $_POST['title'] : '';	//新组件名

	preg_match("/^(.*)\s\(.*/", $widgetTitle[$widget], $matchs);
	$realWgTitle = isset($matchs[1]) ? $matchs[1] : $widgetTitle[$widget];

	$widgetTitle[$widget] = $realWgTitle != $wgTitle ? $realWgTitle.' ('.$wgTitle.')' : $realWgTitle;
	$widgetTitle = addslashes(serialize($widgetTitle));

	$DB->query("update ".DB_PREFIX."options set option_value='$widgetTitle' where option_name='widget_title'");

	switch ($widget)
	{
		case 'newcomm':
			$index_comnum = isset($_POST['index_comnum']) ? intval($_POST['index_comnum']) : 10;
			$comment_subnum = isset($_POST['comment_subnum']) ? intval($_POST['comment_subnum']) : 20;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_comnum' where option_name='index_comnum'");
			$DB->query("update ".DB_PREFIX."options set option_value='$comment_subnum' where option_name='comment_subnum'");
			$CACHE->mc_comment();
			break;
		case 'twitter':
			$index_twnum = isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : 10;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_twnum' where option_name='index_twnum'");
			$CACHE->mc_twitter();
			break;
		case 'newlog':
			$index_newlog = isset($_POST['index_newlog']) ? intval($_POST['index_newlog']) : 10;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_newlog' where option_name='index_newlognum'");
			$CACHE->mc_newlog();
			break;
		case 'random_log':
			$index_randlognum = isset($_POST['index_randlognum']) ? intval($_POST['index_randlognum']) : 20;
			$DB->query("update ".DB_PREFIX."options set option_value='$index_randlognum' where option_name='index_randlognum'");
			break;
		case 'music':
			$links = isset($_POST['mlinks']) ? htmlspecialchars(trim($_POST['mlinks'])) : '';
			$randplay = isset($_POST['randplay']) ? intval($_POST['randplay']) : 0;
			$auto = isset($_POST['auto']) ? intval($_POST['auto']) : 0;
			$music = array(
			'mlinks'=>array(),
			'mdes'=>array(),
			'auto'=>$auto,
			'randplay'=>$randplay
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
						formMsg('有错误的音乐链接格式','javascript: window.history.back()',0);
					}
				}
			}
			$musicData = serialize($music);
			$DB->query("update ".DB_PREFIX."options set option_value='$musicData' where option_name='music'");
			break;
		case 'custom_text':
			$custom_widget = $options_cache['custom_widget'] ? @unserialize($options_cache['custom_widget']) : array();
			$title = isset($_POST['title']) ? $_POST['title'] : '';
			$content = isset($_POST['content']) ? $_POST['content'] : '';
			$custom_wg_id = isset($_POST['custom_wg_id']) ? $_POST['custom_wg_id'] : '';//要修改的组件id
			$new_title = isset($_POST['new_title']) ? $_POST['new_title'] : '';
			$new_content = isset($_POST['new_content']) ? $_POST['new_content'] : '';
			$rmwg = isset($_GET['rmwg']) ? addslashes($_GET['rmwg']) : '';//要删除的组件id
			//添加新自定义组件
			if($new_content)
			{
				//确定组件索引
				$i = 0;
				$maxKey = 0;
				if(is_array($custom_widget))
				{
					foreach ($custom_widget as $key => $val)
					{
						preg_match("/^custom_wg_(\d+)/", $key, $matches);
						$k = $matches[1];
						if($k > $i)
						{
							$maxKey = $k;
						}
						$i = $k;
					}
				}
				$custom_wg_index = $maxKey + 1;
				$custom_wg_index = 'custom_wg_'.$custom_wg_index;
				$custom_widget[$custom_wg_index] = array('title'=>$new_title,'content'=>$new_content);
				$custom_widget_str = addslashes(serialize($custom_widget));
				$DB->query("update ".DB_PREFIX."options set option_value='$custom_widget_str' where option_name='custom_widget'");
			}elseif ($content){
				$custom_widget[$custom_wg_id] = array('title'=>$title,'content'=>$content);
				$custom_widget_str = addslashes(serialize($custom_widget));
				$DB->query("update ".DB_PREFIX."options set option_value='$custom_widget_str' where option_name='custom_widget'");
			}elseif ($rmwg){
				for($i=1; $i<5; $i++)
				{
					$widgets = $options_cache['widgets'.$i] ? @unserialize($options_cache['widgets'.$i]) : array();
					if(is_array($widgets) && !empty($widgets))
					{
						foreach ($widgets as $key => $val)
						{
							if($val == $rmwg)
							{
								unset($widgets[$key]);
							}
						}
						$widgets_str = addslashes(serialize($widgets));
						$DB->query("update ".DB_PREFIX."options set option_value='$widgets_str' where option_name='widgets$i'");
					}
				}
				unset($custom_widget[$rmwg]);
				$custom_widget_str = addslashes(serialize($custom_widget));
				$DB->query("update ".DB_PREFIX."options set option_value='$custom_widget_str' where option_name='custom_widget'");
			}
			break;
	}
	$CACHE->mc_options();
	header("Location: ./widgets.php?activated=true");
}

//保存组件排序
if($action == 'compages')
{
	$wgNum = isset($_POST['wgnum']) ? intval($_POST['wgnum']) : 1;//侧边栏编号 1、2、3 ……
	$widgets = isset($_POST['widgets']) ? serialize($_POST['widgets']) : '';
	$DB->query("update ".DB_PREFIX."options set option_value='$widgets' where option_name='widgets{$wgNum}'");
	$CACHE->mc_options();
	header("Location: ./widgets.php?activated=true&wg=$wgNum");
}

?>