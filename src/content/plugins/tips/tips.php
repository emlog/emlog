<?php
/*
Plugin Name: tips
Version: 1.1
Plugin URL:
Description: 这是世界上第一个emlog插件，它会在你的管理页面送上一句温馨的小提示。
ForEmlog:4.2.1
Author: emlog
Author URL: http://www.emlog.net
*/

!defined('EMLOG_ROOT') && exit('access deined!');

$array_tips = array(
'你可以在日志中上传多个附件',
'试试给你的EM后台换个风格吧，就在设置里面',
'emlog支持灵活的标签(tag)功能',
'在撰写日志的时候你可以使用Tab键方便的缩进内容',
'你可以使用widgets功能对站点侧边栏组件排序并自定义侧边栏的组件',
'你可以修改日志的发布时间',
'你可以为你的日志写一段漂亮的摘要，这样仅让摘要显示在首页并出现阅读全文链接',
'为防日志丢失，emlog会在你书写日志的时候为你自动保存它们',
'你可以在日志中插入flash格式的多媒体文件',
'不一样的心情，日志表情图标为您传达',
'emlog支持引用通告（Trackback），你可以通知你所要评论的日志',
'你可以把你未写完的日志保存到草稿箱里，等下次有时间的时候再写',
'emlog会把太大的图片附件自动生产缩略图，从而加快页面加载速度',
'请关注后台首页的 官方信息 栏目，这里有最新的emlog动态',
'你可以把图片附件嵌入到内容中，让你的日志图文并茂',
'你可以在写日志的时候为日志设置访问密码，只让你授予密码的人访问',
'emlog支持多人联合撰写',
'emlog支持自建页面，并且可以上传照片，为自己做一个图文并茂的自我介绍页吧',
'新建一个允许发表评论的页面，你会发现其实它还是一个简单的留言板',
'后台左侧菜单可以折叠哦、而且可以记住折叠状态',
'检查你的站点目录下是否存在安装文件：install.php，有的话请删除它',
'及时升级浏览器，更好的体验emlog',
'今天你备份数据了吗？',
'从明天起，做一个幸福的人。喂马，砍柴，周游世界',
'如果你拥有爱，请在失去之前好好珍惜',
);

function tips()
{
	global $array_tips;
	$i = mt_rand(0, count($array_tips) - 1);
	$tip = $array_tips[$i];	
	echo "<div id=\"tip\"> $tip</div>";
}

addAction('adm_main_top', 'tips');

function tips_css()
{
	echo "
	<style type='text/css'>
	#tip{
		background:url(../content/plugins/tips/icon_tips.gif) no-repeat left 3px;
		padding:3px 18px;
		margin:5px 0px;
		font-size:12px;
		color:#999999;
	}
	</style>";
}

addAction('adm_head', 'tips_css');
