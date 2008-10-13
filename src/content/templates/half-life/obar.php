<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$photo = getAttachment($photo ,600,500);
?>		
		<div class="obar">
<ul>

<li><h2 onclick="showhidediv('blogger')">个人档</h2>
<ul id="blogger">
<li><?php echo $photo;?></li>
	<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
	<?php if(ISLOGIN === true): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:130px;height:50px;"><?php echo $blogger_des; ?></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
	</li>

</ul>
</li>

<?php if($ismusic): ?>
<li><h2 onclick="showhidediv('music')">音乐</h2>
	<ul id="music">
	<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="140" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
</li>
		</ul>
</li>
<?php endif; ?>
<li><h2 onclick="showhidediv('comm')">评论</h2>
<ul id="comm">
<?php foreach($com_cache as $value): ?>
<li><b><?php echo $value['name'];?></b>
<?php if($value['reply']): ?>
	<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
	<img src="<?php echo $em_tpldir; ?>images/reply.gif" align="absmiddle"/>
	</a>
<?php endif;?>
<br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php endforeach; ?>
		</ul>
</li>
<li><h2 onclick="showhidediv('ss')">搜索</h2>
		<ul id="ss">
			<li>
	<form name="keyform" method="get" action="index.php">
    <input name="keyword"  type="text" id="s" value="" size="14" maxlength="30" class="input" />
    <input type="submit" value="go" id="searchsubmit" onclick="return keyw()" class="button" />
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
		<li><a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a></li>
<?php
if(ISLOGIN === false):
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\" id=\"input\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?> 
<li><span onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</span>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" type="text" id="input"><br />
密  码:<br>
<input name="pw" type="password" id="input"><br>
<?php echo $ckcode;?> <br>
<input type="submit" value=" 登录" >
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
<?php echo $exarea;?>
</div>