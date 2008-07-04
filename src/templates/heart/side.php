<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="page">
<div class="contentA">
	<div class="lister"><span onclick="showhidediv('bloggerinfo')">博主信息</span></div>
    	<ul style="text-align:center" id="bloggerinfo">
		<li><?php echo $photo; ?></li>
		<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
	<?php if(ISLOGIN === true): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo $tpl_dir; ?>default/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:50px;"></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
	</li>
		</ul>
	<div class="lister"><span onclick="showhidediv('calendar')">日历</span></div>
    	<div id="calendar">
		</div>
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>

	<div class="lister"><span onclick="showhidediv('blogtags')">标签</span></div>
		<ul id="blogtags"><li>
<?php 
foreach($tag_cache as $value):
?>
<span style="font-size:<?php echo $value['fontsize']; ?>px; height:30px;"><a href="index.php?action=taglog&tag=<?php echo $value['tagurl']; ?>" style="color:#00ccff"><?php echo $value['tagname']; ?></a></span>&nbsp;
<?php endforeach; ?>
<a href="./index.php?action=tag" title="更多标签"  style="color:#00ccff">&gt;&gt;</a>
</li></ul>
<?php if($index_twnum>0): ?>
<div class="lister"><span onclick="showhidediv('twitter')">Twitter</span></div>
<ul id="twitter">
<?php
if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
?>
	<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
		<?php endforeach; ?>
		<?php echo $morebt;?>
	<?php endif;?>
</ul>
<?php if(ISLOGIN === true): ?>
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:200px;height:50px;background:#c2f5f9;color:#fbab9c"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','tw','twitter');"style="background:#c2f5f9;color:#fbab9c" value="提交">
</li>
</ul>
<?php endif;?>
<?php endif;?>
	
<?php if($ismusic): ?>
<div class="lister"><span onclick="showhidediv('blogmusic')">音乐</span></div>	
<ul id="blogmusic">
<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
</li>
</ul>
<?php endif; ?>
<div class="lister"><span onclick="showhidediv('newcomment')">最新评论</span></div>
		<ul id="newcomment">
<?php foreach($com_cache as $value): ?>
		<li id="comment"><?php echo $value['name']; ?><br /><a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
<?php endforeach; ?>
		</ul>
	<div class="lister"><span onclick="showhidediv('logserch')">日志搜索</span></div>
	<ul id="logserch">
  	<li>
	<form name="keyform" method="get" action="index.php"><p>
    <input name="keyword"  type="text" value="" style="width:130px;background:#c2f5f9;color:#fbab9c"/>
	<input name="action" type="hidden" value="search" />
    <input type="submit" value="搜索" style="background:#c2f5f9;color:#fbab9c" onclick="return keyw()" />
	</form>
		</li>
		</ul>
	<div class="lister"><span onclick="showhidediv('record')">日志归档</span></div>
		<ul id="record">
<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url']; ?>" style="color:#00ccff"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
<?php endforeach; ?>		
		</ul>
	<div class="lister"><span onclick="showhidediv('frlink')">友情链接</span></div>
    	<ul id="frlink">
<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank" style="color:#00ccff"><?php echo $value['link']; ?></a></li>
<?php endforeach; ?>		
		</ul>
	<div class="lister"><span onclick="showhidediv('bloginfo')">博客信息</span></div>
		<ul id="bloginfo">
		<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
		<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
		<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
		</ul>
	<?php echo $exarea; ?>

<?php if(ISLOGIN === false):
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?>
<div class="lister"><span onclick="showhidediv('loginfm','user')">登录</span></div>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" type="text" style="width:150px;background:#c2f5f9;color:#fbab9c"><br />
密  码:<br>
<input name="pw" type="password" style="width:150px;background:#c2f5f9;color:#fbab9c"><br>
<?php echo $ckcode;?><br>
<input type="submit" value="登录" style="background:#c2f5f9;color:#fbab9c">
</form>
</ul>
<?php 
else:
?>
<div class="lister"><span onclick="showhidediv('loginfm','user')" >管理</span></div>
<ul id="loginfm">
	<li><a href="./adm/add_log.php" style="color:#00ccff">写日志</a></li>
	<li><a href="./adm/" style="color:#00ccff">管理中心</a></li>
	<li><a href="./index.php?action=logout" style="color:#00ccff">退出</a></li>
	</ul>
<?php endif; ?>
		</ul>
</div>
<div id="contentB">