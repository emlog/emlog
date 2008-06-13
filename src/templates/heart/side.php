<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="page">
<div class="contentA">
	<div class="lister"><span onclick="showhidediv('bloggerinfo')">博主信息</span></div>
    	<ul style="text-align:center" id="bloggerinfo">
		<li>$photo</li>
		<li class="other"><b>$name</b> $blogger_des</li>
		</ul>
	<div class="lister"><span onclick="showhidediv('calendar')">日历</span></a></div>
    	<div id="calendar">
			<!--日历-->
		</div>
	<div class="lister"><span onclick="showhidediv('blogtags')">标签</span></div>
		<ul id="blogtags"><li>
<!--
EOT;
foreach($tag_cache as $value){
echo <<<EOT
-->
<span style="font-size:{$value['fontsize']}px; height:30px;"><a href="index.php?action=taglog&tag={$value['tagurl']}">{$value['tagname']}</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->	
<a href="./index.php?action=tag" title="所有标签" >&gt;&gt;</a>
</li></ul>
<!--
EOT;
if($index_twnum>0){
echo <<<EOT
-->
<div class="lister"><span onclick="showhidediv('twitter')">Twitter</span></div>
<ul id="twitter">
<!--
EOT;
$morebt = count($tw_cache)>$index_twnum?"<li><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
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
<textarea name="tw" id="tw" style="width:200px;background:#c2f5f9;color:#fbab9c" style="height:50px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" style="background:#c2f5f9;color:#fbab9c" value="提交">
</li>
</ul>
<!--
EOT;
}
}
if($ismusic){
echo <<<EOT
-->
<div class="lister"><span onclick="showhidediv('blogmusic')">音乐</span></div>	
<ul id="blogmusic">
<li class="other">$musicdes<object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</li>
</ul>
<!--
EOT;
}
echo <<<EOT
-->
<div class="lister"><span onclick="showhidediv('newcomment')">最新评论</span></div>
		<ul id="newcomment">
<!--
EOT;
foreach($com_cache as $value){
echo <<<EOT
-->
		<li id="comment">{$value['name']}<br /><a href="{$value['url']}">{$value['content']}</a></li>
<!--
EOT;
}echo <<<EOT
-->
		</ul>
	<div class="lister"><span onclick="showhidediv('logserch')">日志搜索</span></div>
	<ul id="logserch">
  	<li>
	<form name="keyform" method="get" action="index.php"><p>
    <input name="keyword"  type="text" value="" style="width:130px;background:#c2f5f9;color:#fbab9c"/>
	<input name="action" type="hidden" value="search" />
    <input type="submit" value="搜索" style="background:#c2f5f9;color:#fbab9c"onclick="return keyw()" />
	</p>
   </form>
		</li>
		</ul>
	<div class="lister"><span onclick="showhidediv('record')">日志归档</span></div>
		<ul id="record">
<!--
EOT;
foreach($dang_cache as $value){
echo <<<EOT
-->
		<li><a href="{$value['url']}" style="color:#00ccff">{$value['record']}({$value['lognum']})</a></li>
<!--
EOT;
}echo <<<EOT
-->		
		</ul>
	<div class="lister"><span onclick="showhidediv('frlink')">友情链接</span></div>
    	<ul id="frlink">
<!--
EOT;
foreach($link_cache as $value){
echo <<<EOT
-->     	
		<li><a href="{$value['url']}" title="{$value['des']}" target="_blank" style="color:#00ccff">{$value['link']}</a></li>
<!--
EOT;
}echo <<<EOT
-->		
</ul>
	<div class="lister"><span onclick="showhidediv('bloginfo')">博客信息</span></div>
		<ul id="bloginfo">
		<li>日志数量：{$sta_cache['lognum']}</li>
		<li>评论数量：{$sta_cache['comnum']}</li>
		<li>引用数量：{$sta_cache['tbnum']}</li>
		<li>今日访问：{$sta_cache['day_view_count']}</li>
		<li>总访问量：{$sta_cache['view_count']}</li>
		</ul>
	<div class="lister">
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
<span onclick="showlogin('loginfm')">登录</span>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" type="text" style="width:150px;background:#c2f5f9;color:#fbab9c"><br />
密  码:<br>
<input name="pw" type="password" style="width:150px;background:#c2f5f9;color:#fbab9c"><br>
$ckcode <br>
<input type="submit" value="登录" style="background:#c2f5f9;color:#fbab9c">
</form>
</ul>
<!--
EOT;
}else{
echo <<<EOT
-->
<span onclick="showlogin('loginfm')" >管理</span>
<ul id="loginfm">
	<li><a href="./adm/add_log.php" style="color:#00ccff">写日志</a></li>
	<li><a href="./adm/" style="color:#00ccff">管理中心</a></li>
	<li><a href="./index.php?action=logout" style="color:#00ccff">退出</a></li>
	</ul>
<!--
EOT;
}
echo <<<EOT
-->		
		</ul>
	</div>
	$exarea
</div>
<div id="contentB">
<!--
EOT;
?>