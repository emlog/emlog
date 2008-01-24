<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class="contentA">
	<div class="lister"><span onclick="DoMenu('bloggerinfo')">个人资料</span></div>
    	<ul style="text-align:center" id="bloggerinfo" class="collapsed">
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
		</ul>
	<div class="lister"><span onclick="DoMenu('calendar')">日历</span></a></div>
    	<div id="calendar" class="collapsed">
			<!--日历-->
		</div>
	<div class="lister"><span onclick="DoMenu('blogtags')">标签</span></div>
		<ul id="blogtags" class="collapsed"><li>
<!--
EOT;
foreach($tag_cache as $value){
print <<<EOT
-->
<span style="font-size:{$value['fontsize']}px; height:30px;"><a href="index.php?action=taglog&tag={$value['tagurl']}">{$value['tagname']}</a></span>&nbsp;
<!--
EOT;
}print <<<EOT
-->	<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</li></ul>
$delflg_a
<div class="lister"><span onclick="DoMenu('blogmusic')">音乐</span></div>	
<ul id="blogmusic" class="collapsed">
<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</li>
</ul>	
$delflg_b
<div class="lister"><span onclick="DoMenu('newcomment')">最新评论</span></div>
		<ul id="newcomment" class="collapsed">
<!--
EOT;
foreach($com_cache as $value){
print <<<EOT
-->
		<li id="comment">{$value['name']}<br /><a href="{$value['url']}">{$value['content']}</a></li>
<!--
EOT;
}print <<<EOT
-->
		</ul>
	<div class="lister"><span onclick="DoMenu('logserch')">日志搜索</span></div>
		<ul id="logserch" class="collapsed">
  			<li>
	<form name="keyform" method="get" action="index.php"><p>
    <input name="keyword"  type="text" class="input" value="" size="15" maxlength="30" />
	<input name="action" type="hidden" value="search" size="12" />
    <input type="submit" value="搜索" class="button" onclick="return keyw()" />
	</p>
   </form>
		</li>
		</ul>
	<div class="lister"><span onclick="DoMenu('record')">日志归档</span></div>
		<ul id="record" class="collapsed">
<!--
EOT;
foreach($dang_cache as $value){
print <<<EOT
-->
		<li><a href="{$value['url']}">{$value['record']}({$value['lognum']})</a></li>
<!--
EOT;
}print <<<EOT
-->		
		</ul>
	<div class="lister"><span onclick="DoMenu('frlink')">友情链接</span></div>
    	<ul id="frlink" class="collapsed">
<!--
EOT;
foreach($link_cache as $value){
print <<<EOT
-->     	
		<li><a href="{$value['url']}" title="{$value['des']}" target="_blank">{$value['link']}</a></li>
<!--
EOT;
}print <<<EOT
-->		
</ul>
	<div class="lister"><span onclick="DoMenu('bloginfo')">博客信息</span></div>
		<ul id="bloginfo" class="collapsed">
		<li>日志数量：{$sta_cache['lognum']}</li>
		<li>评论数量：{$sta_cache['comnum']}</li>
		<li>引用数量：{$sta_cache['tbnum']}</li>
		<li>今日访问：{$sta_cache['day_view_count']}</li>
		<li>总访问量：{$sta_cache['view_count']}</li>
		</ul>
	<div class="lister">
	<a href="./rss.php"><img src="{$tpl_dir}default/rss.gif" alt="订阅Rss"/></a>
	</div>
	$exarea
</div>
<div id="contentB">
<!--
EOT;
?>