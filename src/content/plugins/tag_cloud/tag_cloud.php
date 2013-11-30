<?php
/*
Plugin Name: 3D标签云
Version:1.1
Plugin URL:http://mouselife.cn/?post=50
Description: 移植WP的经典3D标签云插件，使其完美支持EMLOG，对SEO无影响
Author:原始作者：scofier，全面增强：Kuma
Author Email: artmemory@qq.com
Author URL: http://mouselife.cn
*/
if(!defined('EMLOG_ROOT')) {exit('error!');};
addAction('save_log', 'tag_cloud_update');
include_once(EMLOG_ROOT.'/content/plugins/tag_cloud/tag_cloud_config.php');
function xml_menu()//写入插件导航
{
	echo '<div class="sidebarsubmenu" id="tag_cloud"><a href="./plugin.php?plugin=tag_cloud">3D标签云设置</a></div>';
}
addAction('adm_sidebar_ext', 'xml_menu');
if(isset($_GET['tag_cloud_widgets']))//widgets调用的JS
{
	echo 'document.write(\'<embed tplayername="SWF" splayername="SWF" type="application/x-shockwave-flash" src="'.BLOG_URL.'content/plugins/tag_cloud/tagcloud.swf" mediawrapchecked="true" pluginspage="http://www.macromedia.com/go/getflashplayer" id="tagcloudflash" name="tagcloudflash" bgcolor="'.tag_cloud_bgcolor.'" quality="high" wmode="'.tag_cloud_trans.'" allowscriptaccess="always" flashvars="tcolor='.tag_cloud_tcolor.'&amp;tcolor2='.tag_cloud_tcolor2.'&amp;hicolor='.tag_cloud_hicolor.'&amp;tspeed='.tag_cloud_tspeed.'&amp;" width="'.tag_cloud_width.'" height="'.tag_cloud_height.'"></embed>\');';
	exit;
}
function tag_cloud_update(){
	global $CACHE;
	$tag_cloud_tags = $CACHE->readCache('tags');
	$tag_cloud_data = "<tags>";
	foreach($tag_cloud_tags as $key => $value)
	{
		$tag_cloud_data .= '<a href="'. Url::tag($value['tagurl']).'" class="tag-link-'.$key.'" title="'.$value['usenum'].' topics" rel="tag" style="font-size:'.$value['fontsize'].'pt;">'.$value['tagname'].'</a>';
	}
	$tag_cloud_data .= "</tags>";
	$tag_cloud_fp = @fopen("../content/plugins/tag_cloud/tagcloud.xml","w");
	if(!@fwrite($tag_cloud_fp,$tag_cloud_data))
	{
		emMsg('更新文件/content/plugins/tag_cloud/tagcloud.xml失败，请检查权限');
	}
    @fclose($tag_cloud_fp);
}
?>
