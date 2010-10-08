<?php
/**
 * Widgets 侧边栏目管理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

//显示组件管理面板
if($action == '')
{
	$wgNum = isset($_GET['wg']) ? intval($_GET['wg']) : 1;
	$widgets = Options::get('widgets'.$wgNum) ? @unserialize(Options::get('widgets'.$wgNum)) : array();
	$widgetTitle = Options::get('widget_title') ? @unserialize(Options::get('widget_title')) : array();
	$custom_widget = Options::get('custom_widget') ? @unserialize(Options::get('custom_widget')) : array();
	$widgetTitle = array_map('htmlspecialchars', $widgetTitle);
	$tpl_sidenum = Options::get('tpl_sidenum');

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

	include View::getView('header');
	require_once View::getView('widgets');
	include View::getView('footer');
	View::output();
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

	updateOption('widget_title', $widgetTitle);

	switch ($widget)
	{
		case 'newcomm':
			$index_comnum = isset($_POST['index_comnum']) ? intval($_POST['index_comnum']) : 10;
			$comment_subnum = isset($_POST['comment_subnum']) ? intval($_POST['comment_subnum']) : 20;
			updateOption('index_comnum', $index_comnum);
			updateOption('comment_subnum', $comment_subnum);
			$CACHE->updateCache('comment');
			break;
		case 'twitter':
			$index_newtwnum = isset($_POST['index_newtwnum']) ? intval($_POST['index_newtwnum']) : 10;
			updateOption('index_newtwnum', $index_newtwnum);
			$CACHE->updateCache('newtw');
			break;
		case 'newlog':
			$index_newlog = isset($_POST['index_newlog']) ? intval($_POST['index_newlog']) : 10;
			updateOption('index_newlognum', $index_newlog);
			$CACHE->updateCache('newlog');
			break;
		case 'random_log':
			$index_randlognum = isset($_POST['index_randlognum']) ? intval($_POST['index_randlognum']) : 20;
			updateOption('index_randlognum', $index_randlognum);
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
				updateOption('custom_widget', $custom_widget_str);
			}elseif ($content){
				$custom_widget[$custom_wg_id] = array('title'=>$title,'content'=>$content);
				$custom_widget_str = addslashes(serialize($custom_widget));
				updateOption('custom_widget', $custom_widget_str);
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
						updateOption("widgets$i", $widgets_str);
					}
				}
				unset($custom_widget[$rmwg]);
				$custom_widget_str = addslashes(serialize($custom_widget));
				updateOption('custom_widget', $custom_widget_str);
			}
			break;
	}
	$CACHE->updateCache('options');
	header("Location: ./widgets.php?activated=true");
}

//保存组件排序
if($action == 'compages') {
	$wgNum = isset($_POST['wgnum']) ? intval($_POST['wgnum']) : 1;//侧边栏编号 1、2、3 ……
	$widgets = isset($_POST['widgets']) ? serialize($_POST['widgets']) : '';
	updateOption("widgets{$wgNum}", $widgets);
	$CACHE->updateCache('options');
	header("Location: ./widgets.php?activated=true&wg=$wgNum");
}

//恢复组件设置到初始安装状态
if($action == 'reset') {
	$widget_title = array(
    	'blogger' => 'blogger',
    	'calendar' => '日历',
    	'twitter' => '最新碎语',
    	'tag' => '标签',
    	'sort' => '分类',
    	'archive' => '存档',
    	'newcomm' => '最新评论',
    	'newlog' => '最新日志',
    	'random_log' => '随机日志',
    	'link' => '链接',
    	'search' => '搜索',
    	'custom_text' => '自定义组件'
	);
	$default_widget = array('calendar','archive','newcomm','link','search','bloginfo');

	$widget_title = serialize($widget_title);
	$default_widget = serialize($default_widget);

	updateOption("widget_title", $widget_title);
	updateOption("custom_widget", 'a:0:{}');
	updateOption("widgets1", $default_widget);

	$CACHE->updateCache('options');
	header("Location: ./widgets.php?activated=true");
}
