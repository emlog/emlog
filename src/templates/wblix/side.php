<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

<hr class="low" />

<div id="subcontent">

<h4><em onclick="showhidediv('blogger')">个人档</em></h4>

<ul id="blogger">
		<li><?php echo $photo;?></li>
		<li><b><?php echo $name;?></b> <?php echo $blogger_des;?></li>
</ul>

<h4><em onclick="showhidediv('calendar')">日历</em></h4>
<ul>
<div id="calendar"></div>
</ul>
<script>sendinfo('$calendar_url','calendar');</script>

<h4><em onclick="showhidediv('tag')">标签</em></h4>

<ul id="tag">
<?php
foreach($tag_cache as $value){
?>
<span style="font-size:<?php echo $value['fontsize'];?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php
}?>
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
</ul>

<?php
if($index_twnum>0){
?>
<h4 onclick="showhidediv('twitter')"><em>twitter</em></h4>
<ul id="twitter" class="posts">
<?php
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">更早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value)
{
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = SmartyDate($localdate,$value['date']);
?>
<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
<?php
}
?>
<?php echo $morebt;?></ul>
<?php
if(ISLOGIN === true)
{
?>
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:180p;height:50px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" value="提交">
</li>
</ul>
<?php
}
}
if($ismusic){
?>
<h4><em onclick="showhidediv('music')">音乐</em></h4>
<ul id="music">
<?php echo $musicdes;?><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music<?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music<?php echo $autoplay;?>&autoreplay=1" /></object>
</p>
</ul>
<?php
}
?>

<h4><em onclick="showhidediv('comm')">评论</em></h4>

<ul class="posts" id="comm">
<?php
foreach($com_cache as $value){
?>
		<li><?php echo $value['name'];?><br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php
}?>
</ul>

<h4><em onclick="showhidediv('record')">存档</em></h4>

<ul class="record" id="record">
<?php
foreach($dang_cache as $value){
?>
		<li><a href="<?php echo $value['url'];?>"><?php echo $value['record'];?>(<?php echo $value['lognum'];?>)</a></li>
<?php
}?>	

</ul>

<h4><em onclick="showhidediv('blogroll')">Blogroll</em></h4>

<ul class="links" id="blogroll">
<?php
foreach($link_cache as $value){
?>     	
		<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
<?php
}?>

</ul>
<h4><em onclick="showhidediv('sta')">统计</em></h4>
<ul class="months" id="sta">
		<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
		<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count'];?></li>
		<li>总访问量：<?php echo $sta_cache['view_count'];?></li>
		<li><a href="./rss.php"><img src="<?php echo $tpl_dir;?>wblix/images/rss.gif" alt="订阅Rss"/></a></li>
<?php
if(ISLOGIN === false){
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?> 
<li><span onclick="showlogin('loginfm')" style="cursor:pointer;">登录</span>
<li id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login">
用户名:<br>
<input name="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
<?php echo $ckcode;?> <br>
<input type="submit" value=" 登录">
</form>
</li>
<?php
}
?>
</ul>
<?php echo $exarea;?>
</div>
<?php
?>