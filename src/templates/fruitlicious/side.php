<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="sidebar">

		<div id="description"><?php echo $bloginfo;?></div>


<ul>

<li><h2 onclick="showhidediv('blogger')">个人档</h2>
		<ul id="blogger">
		<li><?php echo $photo?></li>
		<li><b><?php echo $name;?></b><br>
	<span id="bloggerdes"><?php echo $blogger_des; ?></span>
	<?php if(ISLOGIN === true): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo $tpl_dir; ?>fruitlicious/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:50px;"></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
	
		</li>
		</ul>
</li>

<li><h2 onclick="showhidediv('calendar')">日历</h2>
		<ul>
			<div id="calendar"></div>
		</ul>
</li>
<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>

<li><h2 onclick="showhidediv('tags')">标签</h2>
		<ul id="tags">
		<li>
<?php foreach($tag_cache as $value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php endforeach; ?>
		
		</li>
		</ul>
</li>
<?php if($index_twnum>0): ?>
<li><h2 onclick="showhidediv('twitter')">Twitter</h2>
<ul id="twitter">
<?php if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
	foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
?>
<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
	<?php endforeach;?>
<?php endif; ?>
<?php echo $morebt;?>
</ul>
<?php if(ISLOGIN === true): ?>
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:190px;height:50px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','tw','twitter');" value="提交">
</li>
</ul>
<?php endif; ?>
<?php endif; ?>
<?php if($ismusic): ?>
<li><h2>音乐</h2>
		<ul>
			<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
</li>
		</ul>
</li>
<?php endif; ?>
<li><h2 onclick="showhidediv('comm')">评论</h2>
		<ul id="comm">
<?php foreach($com_cache as $value): ?>
		<li><?php echo $value['name'];?><br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php endforeach; ?>
		</ul>
</li>

<li><h2 onclick="showhidediv('ss')">搜索</h2>
		<ul id="ss">
			<li>
				<form name="keyform" method="get" action="index.php">
    <input name="keyword"  type="text" id="s" value="" size="15" maxlength="30" />
    <input type="submit" value="Search" id="searchsubmit" onclick="return keyw()" />
   </form>
			</li>
		</ul>
</li>

<li><h2 onclick="showhidediv('dang')">存档</h2>
		<ul id="dang">
<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url'];?>"><?php echo $value['record'];?>(<?php echo $value['lognum'];?>)</a></li>
<?php endforeach; ?>	
		</ul>
</li>
<li><h2 onclick="showhidediv('sta')">统计</h2>
		<ul id="sta">
		<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
		<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count'];?></li>
		<li>总访问量：<?php echo $sta_cache['view_count'];?></li>
<?php if(ISLOGIN === false):
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" id=\"s\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?> 
<li><span onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</span>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" type="text" id="s"><br />
密  码:<br>
<input name="pw" type="password" id="s"><br>
<?php echo $ckcode;?> <br>
<input type="submit" value=" 登录">
</li>
</form>
</ul>
<?php 
else:
?>
<li><span onclick="showhidediv('loginfm','user')" >管理</span>
<ul id="loginfm">
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
	</ul>
<?php endif; ?>
		</ul>
</li>

<li><h2 onclick="showhidediv('blogroll')">Blogroll</h2>
		<ul id="blogroll">
<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
<?php endforeach; ?>	

<li><a href="./rss.php"><img src="<?php echo $tpl_dir;?>fruitlicious/images/rss.gif" alt="订阅Rss"/></a></li>
		</ul>
</li>
<?php echo $exarea;?>
</ul>

</div>