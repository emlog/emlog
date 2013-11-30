<?php
!defined('EMLOG_ROOT') && exit('access deined!');
$feeds_gatherer_data = feeds_gatherer_read('data');
$feeds_gatherer = feeds_gatherer_read('logs');
$CACHE = Cache::getInstance();
$options_cache = Option::getAll();
extract($options_cache);
$navibar = unserialize($navibar);
$description = $bloginfo;
if($feeds_gatherer_data['inited'] == 0)
	exit;
$emLink = new Link_Model();
$links = $emLink->getLinks();
$log_title = 'Feeds Gatherer';
$site_title = $log_title . ' - ' . $site_title;
$log_content = '<div class="related">';
foreach($links as $key=>$link)
{
	if(!isset($feeds_gatherer[$link['id']]))
	{
		feeds_gatherer_add($link['id'],$link['siteurl']);
	}
	if(!empty($feeds_gatherer[$link['id']]))
	{
		$log_content .= '<div class="related_post">';
		$log_content .= '<h3><a title="'.$link['sitename'].'" href="'.$link['siteurl'].'" target="_blank">'.$link['sitename'].'</a></h3>';
		$log_content .= '<ul id="feed-'.$link['id'].'">';
		foreach($feeds_gatherer[$link['id']] as $value)
		{
			$log_content .= '<li><a href="'.$value['url'].'" target="_blank" title="'.$value['title'].'">'.$value['title'].'</a></li>';
		}
		$log_content .= '</ul></div>';
	}else{
		$log_content .= '<div class="related_post">';
		$log_content .= '<h3><a title="'.$link['sitename'].'" href="'.$link['siteurl'].'" target="_blank">'.$link['sitename'].'</a></h3>';
		$log_content .= '<ul><li>';
		$log_content .= $link['description'];
		$log_content .= '</li></ul></div>';
	}
	if($key % 2 == 1) {
		$log_content .= '<div style="clear:both"></div>';
	}
}
$log_content .= '</div>';
$log_content .= '<div style="clear:both"></div>';
$allow_remark = 'n';
$logid = $ckname = $ckmail = $ckurl = $verifyCode = '';
$comments = array();
include View::getView('header');
include View::getView('page');
