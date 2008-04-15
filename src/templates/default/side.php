<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="contentA">
	<div class="lister"><span onclick="showhidediv('bloggerinfo')"></span></div>
    	<ul style="text-align:center" id="bloggerinfo">
		<li>$photo</li>
		<li><b>$name</b> $blogger_des</li>
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
-->	<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
		</li></ul>

<div class="lister"><span onclick="showhidediv('twitter')">twitter</span></div>
<ul id="twitter">
<!--
EOT;
if(count($tw_cache)>$index_twnum)
{
	$morebt = "<a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">更早的</a>";
}
foreach (array_slice($tw_cache,0,5) as $value)
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
<li id="twdate">$morebt</li>
</ul>
<!--
EOT;
if(ISLOGIN === true)
{
echo <<<EOT
-->
<ul>
<li> <a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:200px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" value="提交">
</li>
</ul>
<!--
EOT;
}
if($ismusic){
echo <<<EOT
-->
<div class="lister"><span onclick="showhidediv('blogmusic')">音乐</span></div>	
<ul id="blogmusic">
<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
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
    <input name="keyword"  type="text" value="" size="15" maxlength="30" />
	<input name="action" type="hidden" value="search" size="12" />
    <input type="submit" value="搜索" onclick="return keyw()" />
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
		<li><a href="{$value['url']}">{$value['record']}({$value['lognum']})</a></li>
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
		<li><a href="{$value['url']}" title="{$value['des']}" target="_blank">{$value['link']}</a></li>
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
<div class="lister"><span onclick="showhidediv('loginfm')">登录</span></div>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login">
<li>
用户名:<br>
<input name="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
$ckcode <br>
<input type="submit" value=" 登录">
</li>
</form>
<!--
EOT;
}else{
echo <<<EOT
-->
<div class="lister"><span>管理捷径</span></div>
<ul id="loginfm">
<li><a href="./index.php?action=logout">注销</li>
<li><a href="./adm/add_log.php">写日志</li>
<li><a href="./adm/configure.php">博客设置</li>
</ul>
<!--
EOT;
}echo <<<EOT
-->
</ul>
	<div class="lister">
	<a href="./rss.php"><img src="{$tpl_dir}default/rss.gif" alt="订阅Rss"/></a>
	</div>
	$exarea
</div>
<div id="contentB">
<!--
EOT;
?>