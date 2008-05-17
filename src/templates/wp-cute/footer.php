<!--<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
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
  <H2 onClick="showhidediv('bloggerinfo')">About</H2>
    	<ul style="text-align:left" id="bloggerinfo" >
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
		</ul>
  <H2 onClick="showhidediv('calendar')">Calendar</H2>
    	<div id="calendar">
		<!--calendar-->
		</div>
	<script>sendinfo('$calendar_url','calendar');</script>

<!--
EOT;
if($index_twnum>0){
echo <<<EOT
-->
<h2 onclick="showhidediv('twitter')">Twitter</h2>
<ul id="twitter">
<!--
EOT;
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value)
{
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = SmartyDate($localdate,$value['date']);
echo <<<EOT
-->
<li> {$value['content']} $delbt<br><span>{$value['date']}</span></li>
<!--
EOT;
}
echo <<<EOT
-->
$morebt
</ul>
<!--
EOT;
if(ISLOGIN === true)
{
echo <<<EOT
-->
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:180px;" style="height:50px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" value="提交">
</li>
</ul>
<!--
EOT;
}
}
if($ismusic){
echo <<<EOT
-->
  <H2 onClick="showhidediv('music')">Music</H2>
		<ul id="music">
		<li>$musicdes<object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="145" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</li>
		</ul>
<!--
EOT;
}
echo <<<EOT
-->
  <LI>
  <H2 onClick="showhidediv('sort')">Tags</H2>
		<ul id="sort">
<!--
EOT;
foreach($tag_cache as $key=>$value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="./?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</ul>
  <LI id=linkcat-1>
  <H2 onClick="showhidediv('record')">Archives</H2>
		<ul id="record">
<!--
EOT;
foreach($dang_cache as $key=>$value){
echo <<<EOT
-->
		<li><a href="$value[url]">$value[record]($value[lognum])</a></li>
<!--
EOT;
}echo <<<EOT
-->	
		</ul>
   <H2 onClick="showhidediv('newcomment')">Comments</H2>
		<ul id="newcomment">
<!--
EOT;
foreach($com_cache as $key=>$value){
echo <<<EOT
-->
		<li id="comment"><a href="$value[url]">$value[content]</a></li>
		<li id="comment"> &raquo; $value[name]</li>
<!--
EOT;
}echo <<<EOT
-->
		</ul>
 <H2 onClick="showhidediv('frlink')">Blogroll</H2>
    	<ul id="frlink">
<!--
EOT;
foreach($link_cache as $key=>$value){
echo <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}echo <<<EOT
-->
		</ul>
<H2 onClick="showhidediv('bloginfo')">Info</H2>
		<ul id="bloginfo">
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./rss.php" target="_blank"><img src="{$tpl_dir}wp/images/em_rss.gif" alt="Rss" border="0" /></a></li>
 <!--
EOT;
if(ISLOGIN === false){
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
echo <<<EOT
--> 
<li><span onclick="showlogin('loginfm')" style="cursor:pointer;">登录</span>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
$ckcode <br>
<input type="submit" value=" 登录">
</li>
</form>
</ul>
<!--
EOT;
}else{
echo <<<EOT
-->
<li><span onclick="showlogin('loginfm')" >管理</span>
<ul id="loginfm">
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
	</ul>
<!--
EOT;
}
echo <<<EOT
-->   	
		</ul>
		$exarea
</LI></UL></DIV>
<HR>

<DIV id=footer>
<P>&copy; 2008 <a href="http://www.emlog.net" target="_blank">emlog</a><br />
&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank">$icp</a></P>
</DIV>
</DIV>
</BODY>
</HTML>
<!--
EOT;
?>-->