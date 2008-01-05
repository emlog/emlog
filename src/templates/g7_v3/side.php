<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div id="sidebar">
<div id="line_top"></div><div id="top"></div>
<div id="sidebar_frame">

<ul>
<li class="pagenav"><h2>个人档</h2>
		<ul>
		<p>$photo</p>
		<p><b>$name</b> $blogger_des</p>
		</ul>
</li>

<li class="categories"><h2>日历</h2>
		<ul>
			<p id="calendar"></p>
		</ul>
</li>
<li><h2>标签</h2>
		<ul>
		<li>
<!--
EOT;
foreach($tag_cache as $value){
print <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}print <<<EOT
-->
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</li>
		</ul>
$delflg_a
<li class="some"><h2>音乐</h2>
<ul>
<p><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="160" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</p>
</ul>
</li>
$delflg_b

<li class="r_comments"><h2>评论</h2>
		<ul>
			<!--
EOT;
foreach($com_cache as $value){
print <<<EOT
-->
		<li>$value[name]<br /><a href="$value[url]">$value[content]</a></li>
<!--
EOT;
}print <<<EOT
-->
		</ul>
</li>

<li class="archives"><h2>存档</h2>
		<ul>
<!--
EOT;
foreach($dang_cache as $value){
print <<<EOT
-->
		<li><a href="$value[url]">$value[record]($value[lognum])</a></li>
<!--
EOT;
}print <<<EOT
-->	
		</ul>
</li>

<li class="random"><h2>友情链接</h2>
		<ul>
<!--
EOT;
foreach($link_cache as $value){
print <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}print <<<EOT
-->	
		</ul>
</li>

<li><h2>搜索</h2>
		<ul>
			<li>
				<form name="keyform" method="get" action="index.php">
    <input name="keyword"  type="text" id="s" value="" size="15" maxlength="30" />
	<input name="action" type="hidden" value="search" size="12" />
    <input type="submit" value="Go" id="searchsubmit" onclick="return keyw()" />
   </form>
			</li>
		</ul>
</li>

<li class="statistics"><h2>统计</h2>
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
<div id="tail"></div><div id="line_tail"></div>
</div>
<!--
EOT;
?>-->