<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div id="sidebar">


<ul>

<li id="archives"><h4>个人档</h4>
		<ul>
		<p>$photo<br /><b>$name</b> $blogger_des</p>
		</ul>
</li>

<li><h4>日历</h4>
		<ul>
			<p id="calendar"></p>
		</ul>
</li>

<li><h4>标签</h4>
		<ul>
		<p>
<!--
EOT;
foreach($tag_cache as $value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="./?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
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
<li><h4>音乐</h4>
		<ul>
			<p><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</p>
		</ul>
</li>
<!--
EOT;
}
echo <<<EOT
-->
<li><h4>评论</h4>
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

<li><h4>搜索</h4>
		<ul>
			<p>
<form name="keyform" method="get" action="index.php">
    <input name="keyword" type="text" id="s" value="" style=" width:120px;" maxlength="30" />
    <input name="action" type="hidden" value="search"/>
    <input type="submit" value="搜索" id="searchsubmit" onclick="return keyw()" />
   </form>
	</p>
		</ul>
</li>

<li><h4>存档</h4>
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

<li><h4>Blogroll</h4>
		<ul>
<!--
EOT;
foreach($link_cache as $value){
echo <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}echo <<<EOT
-->	
		</ul>
</li>

<li><h4>统计</h4>
		<ul>
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./adm/">登录</a></li>
		<li><a href="./rss.php"><img src="{$tpl_dir}spring/images/rss.gif" alt="订阅Rss"/></a></li>
		</ul>
</li>
$exarea
</ul>

</div>
<!--
EOT;
?>-->