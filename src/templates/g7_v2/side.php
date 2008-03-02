<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div id="sidebar">
<div id="search">
<form name="keyform" method="get" action="index.php">
<div><input type="text" name="keyword" id="s" value="输入搜索" onfocus="this.value=''" onfocus="this.value='输入搜索';this.style.color='gray';" /><input name="action" type="hidden" value="search" size="12" />
<input type="submit" id="go" value="" onclick="return keyw()"/>
</div>
</form></div>
<ul>
<li>
		<ul style="text-align:center">
		<p>$photo</p>
		<p><b>$name</b> $blogger_des</p>
		</ul>
</li>

<li>
		<ul>
			<p id="calendar"></p>
		</ul>
</li>
<li><h2>标签</h2>
		<ul>
		<p>
<!--
EOT;
foreach($tag_cache as $value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</p>
		</ul>
</li>
<!--
EOT;
if($ismusic){
echo <<<EOT
-->
<li><h2>音乐</h2>
<ul>
<p><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="160" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</p>
</ul>
</li>
<!--
EOT;
}
echo <<<EOT
-->

<li><h2>评论</h2>
		<ul>
			<!--
EOT;
foreach($com_cache as $value){
echo <<<EOT
-->
		<li>$value[name]<br /><a href="$value[url]">$value[content]</a></li>
<!--
EOT;
}echo <<<EOT
-->
		</ul>
</li>
<li><h2>存档</h2>
		<ul>
<!--
EOT;
foreach($dang_cache as $value){
echo <<<EOT
-->
		<li><a href="$value[url]">$value[record]($value[lognum])</a></li>
<!--
EOT;
}echo <<<EOT
-->	
		</ul>
</li>
<li><h2>友情链接</h2>
<ul>
<!--
EOT;
foreach($link_cache as $value){
echo <<<EOT
-->     	
		<li><a href="{$value['url']}" title="{$value['des']}" target="_blank">{$value['link']}</a></li>
<!--
EOT;
}echo <<<EOT
-->	
</ul>
</li>

<li><h2>其他</h2>
		<ul>
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		</ul>
</li>

<a href="./rss.php"><img src="{$tpl_dir}g7_v3/rss.gif" alt="订阅Rss"/></a>
$exarea
</ul>
</div>
EOT;
?>