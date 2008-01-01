<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div id="sidebar_tag">
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
</div>

<div id="sidebar">
        <div id="sidebar_1">
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

$delflg_a
<li class="some"><h2>音乐</h2>
<ul>
<p><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="150" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
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

<li class="statistics"><h2>统计</h2>
		<ul>
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./adm/">登录</a></li>
		</ul>
</li>
$exarea
</ul>
		</div>

<div id="sidebar_2">
<ul>

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

<li class="feed"><h2>feed</h2>
        <ul>
			<p><a href="./rss.php">all feed</a></p>
        </ul>
</li>
</ul>
  </div>

</div><!-- sidebar -->
</div><!-- page -->
</ul>
</div>			
<!--
EOT;
?>-->