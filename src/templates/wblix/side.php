<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

<hr class="low" />

<div id="subcontent">

<h4><em onclick="showhidediv('blogger')">个人档</em></h4>

<ul id="blogger">
	<li><?php echo $photo;?></li>
	<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
	<?php if(ISLOGIN === true): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:50px;"><?php echo $blogger_des; ?></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
	</li>
</ul>

<h4><em onclick="showhidediv('calendar')">日历</em></h4>
<ul>
<div id="calendar"></div>
</ul>
<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>

<h4><em onclick="showhidediv('tag')">标签</em></h4>

<ul id="tag">
<?php foreach($tag_cache as $value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php endforeach; ?>
		
</ul>

<?php if($index_twnum>0): ?>
<h4 onclick="showhidediv('twitter')"><em>twitter</em></h4>
<ul id="twitter" class="posts">
<?php if(isset($tw_cache) && is_array($tw_cache)):
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">更早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value):
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = smartyDate($localdate,$value['date']);
?>
<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
<?php  endforeach; ?>
<?php echo $morebt; ?>
<?php endif; ?>
</ul>
<?php if(ISLOGIN === true): ?>
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="overflow-y: hidden;width:180px;height:70px;" class="input"></textarea>
<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
</li>
</ul>
<?php endif; ?>
<?php endif; ?>
<?php if($ismusic): ?>
<h4><em onclick="showhidediv('music')">音乐</em></h4>
<ul id="music">
<?php echo $musicdes;?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
</p>
</ul>
<?php endif; ?>

<h4><em onclick="showhidediv('comm')">评论</em></h4>

<ul class="posts" id="comm">
<?php foreach($com_cache as $value): ?>
		<li><?php echo $value['name']; ?> 
<?php if($value['reply']): ?>
	<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
	<img src="<?php echo $em_tpldir; ?>images/reply.gif" align="absmiddle"/>
	</a>
<?php endif;?>
<br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php endforeach; ?>
</ul>

<h4><em onclick="showhidediv('record')">存档</em></h4>

<ul class="record" id="record">
<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url'];?>"><?php echo $value['record'];?>(<?php echo $value['lognum'];?>)</a></li>
<?php endforeach; ?>	

</ul>

<h4><em onclick="showhidediv('blogroll')">Blogroll</em></h4>

<ul class="links" id="blogroll">
<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
<?php endforeach; ?>

</ul>
<h4><em onclick="showhidediv('sta')">统计</em></h4>
<ul class="months" id="sta">
		<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
		<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count'];?></li>
		<li>总访问量：<?php echo $sta_cache['view_count'];?></li>
		<li><a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a></li>
<?php
if(ISLOGIN === false):
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?> 
<li><span onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</span>
<li id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login">
用户名:<br>
<input name="user" id="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
<?php echo $ckcode;?> <br>
<input type="submit" value=" 登录">
</form>
</li>
<?php endif; ?>
</ul>
<?php echo $exarea;?>
</div>
