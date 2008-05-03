<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->

			<div class="sidebar">
<ul>

<li><h2 onclick="showhidediv('blogger')">个人档</h2>
		<ul id="blogger">
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
		</ul>
</li>

<li><h2 onclick="showhidediv('calendar')">日历</h2>
		<ul>
			<div id="calendar"></div>
		</ul>
</li>

<li><h2 onclick="showhidediv('tag')">标签</h2>
		<ul id="tag">
		<li>
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
		</li>
		</ul>
</li>
<!--
EOT;
if($index_twnum>0){
echo <<<EOT
-->
<li><h2 onclick="showhidediv('twitter')">Twitter</h2>
<ul id="twitter">
<!--
EOT;
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value)
{
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = date("Y-m-d H:i",$value['date']);
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
<textarea name="tw" id="tw" style="width:150px;" style="height:50px;"></textarea><br />
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
<li><h2 onclick="showhidediv('music')">音乐</h2>
		<ul id="music">
			<li>$musicdes<object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="150" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</li>
		</ul>
</li>
<!--
EOT;
}
echo <<<EOT
-->
<li><h2 onclick="showhidediv('comm')">评论</h2>
		<ul id="comm">
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

<li><h2 onclick="showhidediv('ser')">搜索</h2>
		<ul id="ser">
			<li>
				<form name="keyform" method="get" action="index.php">
    <input name="keyword"  type="text" id="s" value="" size="15" maxlength="30" />
	<input name="action" type="hidden" value="search" size="12" />
    <input type="submit" value="Go" id="searchsubmit" onclick="return keyw()" />
   </form>
			</li>
		</ul>
</li>

<li><h2 onclick="showhidediv('dang')">存档</h2>
		<ul id="dang">
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

<li><h2 onclick="showhidediv('links')">BlogRoll</h2>
		<ul id="links">
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
<li><h2 onclick="showhidediv('sta')">其他</h2>
		<ul id="sta">
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./rss.php"><img src="{$tpl_dir}sea/images/rss.gif" alt="订阅Rss"/></a></li>
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
</li>
$exarea
</ul>
</div>			
<!--
EOT;
?>-->