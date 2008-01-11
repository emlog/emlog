<!--<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
</DIV>
<DIV id=sidebar>
<UL>
  <LI>
  	<form name="keyform" method="get" action="index.php"><p>
    <input name="keyword"  type="text" class="input" value="" size="12" maxlength="30" />
	<input name="action" type="hidden" value="search" size="12" />
    <input type="submit" value="Search" class="button" onClick="return keyw()" /></p>
   </form>
  <LI>
  <LI class=pagenav>
  <H2 onClick="DoMenu('bloggerinfo')">About</H2>
    	<ul style="text-align:left" id="bloggerinfo" >
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
		</ul>
  <H2 onClick="DoMenu('calendar')">Calendar</H2>
    	<div id="calendar">
		<!--calendar-->
		</div>
$delflg_a
  <H2 onClick="DoMenu('music')">Music</H2>
		<ul id="music">
		<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="145" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</li>
		</ul>
$delflg_b
  <LI>
  <H2 onClick="DoMenu('sort')">tags</H2>
		<ul id="sort">
<!--
EOT;
foreach($tag_cache as $key=>$value){
print <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}print <<<EOT
-->
<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</ul>
  <LI id=linkcat-1>
  <H2 onClick="DoMenu('record')">Archives</H2>
		<ul id="record">
<!--
EOT;
foreach($dang_cache as $key=>$value){
print <<<EOT
-->
		<li><a href="$value[url]">$value[record]($value[lognum])</a></li>
<!--
EOT;
}print <<<EOT
-->	
		</ul>
   <H2 onClick="DoMenu('newcomment')">Comments</H2>
		<ul id="newcomment">
<!--
EOT;
foreach($com_cache as $key=>$value){
print <<<EOT
-->
		<li id="comment"><a href="$value[url]">$value[content]</a></li>
		<li id="comment"> &raquo; $value[name]</li>
<!--
EOT;
}print <<<EOT
-->
		</ul>
 <H2 onClick="DoMenu('frlink')">Blogroll</H2>
    	<ul id="frlink">
<!--
EOT;
foreach($link_cache as $key=>$value){
print <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}print <<<EOT
-->
		</ul>
<H2 onClick="DoMenu('bloginfo')">Info</H2>
		<ul id="bloginfo">
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./adm/">登录</a></li>
			<li><a href="./rss.php" target="_blank"><img src="{$tpl_dir}wp/images/em_rss.gif" alt="Rss" border="0" /></a></li>
    	</ul>
		$exarea
</LI></UL></DIV>
<HR>

<DIV id=footer>
<P>&copy; 2007 <a href="http://www.emlog.net" target="_blank">emlog</a><br />
&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank">$icp</a></P>
</DIV>
</DIV>
</BODY>
</HTML>
<!--
EOT;
?>-->