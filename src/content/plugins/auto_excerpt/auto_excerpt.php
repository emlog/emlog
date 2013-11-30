<?php
/*
Plugin Name: 自动摘要
Version: 1.0
Plugin URL:
Description: 自动为你的博文填写摘要，可设置摘要长度
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

function auto_excerpt_menu()
{
	echo '<div class="sidebarsubmenu" id="auto_excerpt"><a href="./plugin.php?plugin=auto_excerpt">摘要设置</a></div>';
}
addAction('adm_sidebar_ext', 'auto_excerpt_menu');
function auto_excerpt($blogid)
{
	global $logData,$Log_Model;
	$auto_excerpt_file = EMLOG_ROOT.'/content/plugins/auto_excerpt/data';
	if(@$auto_excerpt_fp = fopen($auto_excerpt_file, 'r'))
	{
		$auto_excerpt_data = unserialize(fread($auto_excerpt_fp,filesize($auto_excerpt_file)));
		fclose($auto_excerpt_fp);
	}
	$auto_excerpt_length = $auto_excerpt_data['length'];
	$auto_excerpt_paragraph = $auto_excerpt_data['paragraph'];
	$content = $logData['content'];
	$excerpt = '';
	$count = 0;
	$non_end_html_tags = array('br','hr','img','input','option','param');
	for($i = 0; $i < strlen($content); $i++)
	{
		if($content[$i] == '<')
		{
			$j = strpos($content,'>',$i);
			$curr_html_tag = array_shift(explode(' ',substr($content,$i + 1,$j - $i - 1)));
			$curr_html_tags = array();
			array_push($curr_html_tags,$curr_html_tag);
			while(!empty($curr_html_tags))
			{
				$k = strpos($content,'<',$j);
				if($k == FALSE)
				{
					break;
				}
				$j = strpos($content,'>',$k);
				$curr_html_tag = array_shift(explode(' ',substr($content,$k + 1,$j - $k - 1)));
				$last_html_tag = end($curr_html_tags);
				if(in_array($curr_html_tag,$non_end_html_tags))
				{
					continue;
				}
				if('/'.$last_html_tag == $curr_html_tag)
				{
					array_pop($curr_html_tags);
				}else{
					array_push($curr_html_tags,$curr_html_tag);
				}
			}
			$excerpt .= substr($content,$i,$j - $i + 1);
			$count++;
			if($count >= $auto_excerpt_paragraph || strlen($excerpt >= $auto_excerpt_length))
				break;
			$i = $j;
		}
	}
	$logData['excerpt'] = $excerpt;
	$Log_Model->updateLog($logData, $blogid);
}
addAction('save_log', 'auto_excerpt');
?>