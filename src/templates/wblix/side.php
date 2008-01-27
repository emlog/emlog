<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->

<hr class="low" />

<div id="subcontent">

<h4><em>个人档</em></h4>

<ul>
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
</ul>

<h4><em>日历</em></h4>
<ul>
<p id="calendar"></p>
</ul>

<h4><em>标签</em></h4>

<ul>
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
</ul>

<!--
EOT;
if($ismusic){
print <<<EOT
-->
<h4><em>音乐</em></h4>

<ul>
<p><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</p>
</ul>
<!--
EOT;
}
print <<<EOT
-->

<h4><em>评论</em></h4>

<ul class="posts">
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

<h4><em>存档</em></h4>

<ul class="record">
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

<h4><em>Blogroll</em></h4>

<ul class="links">
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
<h4><em>统计</em></h4>
<ul class="months">
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./rss.php"><img src="{$tpl_dir}wblix/images/rss.gif" alt="订阅Rss"/></a></li>
</ul>
$exarea
</div>
<!--
EOT;
?>-->