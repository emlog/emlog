<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$photo = getAttachment($photo ,600,500);
echo <<<EOT
-->		
		<div class="obar">
<ul>

<li><h2>个人档</h2>
		<ul>
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
		</ul>
</li>

<!--
EOT;
if($ismusic){
echo <<<EOT
-->
<li><h2>音乐</h2>
	<ul>
	<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="140" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</li>
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
		<li><b>$value[name]</b><br /><a href="$value[url]">$value[content]</a></li>
<!--
EOT;
}echo <<<EOT
-->
		</ul>
</li>
<li><h2>搜索</h2>
		<ul>
			<li>
				<form name="keyform" method="get" action="index.php">
    <input name="keyword"  type="text" id="s" value="" size="12" maxlength="30" />
	<input name="action" type="hidden" value="search" size="12" />
    <input type="submit" value="Go" id="searchsubmit" onclick="return keyw()" />
   </form>
			</li>
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
<li><h2>统计</h2>
		<ul>
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./adm/">登录</a></li>
		<li><a href="./rss.php"><img src="{$tpl_dir}half-life/images/rss.gif" alt="订阅Rss"/></a></li>
		</ul>
</li>
$exarea
</ul>
		</div>
<!--
EOT;
?>-->