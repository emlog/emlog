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
    <input name="keyword"  type="text" id="s" value="" size="14" maxlength="30" class="input" />
	<input name="action" type="hidden" value="search"/>
    <input type="submit" value="go" id="searchsubmit" onclick="return keyw()" class="button" />
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
		<li><a href="./rss.php"><img src="{$tpl_dir}half-life/images/rss.gif" alt="订阅Rss"/></a></li>
<!--
EOT;
if(ISLOGIN === false){
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\" id=\"input\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
echo <<<EOT
--> 
<li><span onclick="showlogin('loginfm')" style="cursor:pointer;">登录</span>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" type="text" id="input"><br />
密  码:<br>
<input name="pw" type="password" id="input"><br>
$ckcode <br>
<input type="submit" value=" 登录" >
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