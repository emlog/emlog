<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
</DIV>
<DIV id=sidebar>
<UL>
  <LI>
  	<form name="keyform" method="get" action="index.php"><p>
    <input name="keyword"  type="text" class="input" value="" size="12" maxlength="30" />
    <input type="submit" value="Search" class="button" onClick="return keyw()" /></p>
   </form>
  <LI>
  <LI class=pagenav>
  <H2 onClick="showhidediv('bloggerinfo')">About</H2>
   <ul style="text-align:left" id="bloggerinfo" >
	<li><?php echo $photo;?></li>
	<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
	<?php if(ISLOGIN === true): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo $em_tpldir; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态" border="0"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:50px;"><?php echo $blogger_des; ?></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
	</li>
		</ul>
  <H2 onClick="showhidediv('calendar')">Calendar</H2>
    	<div id="calendar">
		
		</div>
<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>

<?php if($index_twnum>0): ?>
<h2 onclick="showhidediv('twitter')">Twitter</h2>
<ul id="twitter">
<?php  if(isset($tw_cache) && is_array($tw_cache)):
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value):
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = smartyDate($localdate,$value['date']);
?>
<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
<?php endforeach; ?>
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
  <H2 onClick="showhidediv('music')">Music</H2>
		<ul id="music">
		<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="145" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
</li>
		</ul>
<?php endif; ?>
  <LI>
  <H2 onClick="showhidediv('sort')">Tags</H2>
		<ul id="sort">
<?php foreach($tag_cache as $key=>$value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php endforeach; ?>

		</ul>
  <LI id=linkcat-1>
  <H2 onClick="showhidediv('record')">Archives</H2>
		<ul id="record">
<?php foreach($dang_cache as $key=>$value): ?>
		<li><a href="<?php echo $value['url'];?>"><?php echo $value['record'];?>(<?php echo $value['lognum'];?>)</a></li>
<?php endforeach; ?>	
		</ul>
   <H2 onClick="showhidediv('newcomment')">Comments</H2>
		<ul id="newcomment">
<?php foreach($com_cache as $key=>$value): ?>
		<li id="comment"> &raquo; <?php echo $value['name'];?>
		<?php if($value['reply']): ?>
		<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
		<img src="<?php echo $em_tpldir; ?>/images/reply.gif" align="absmiddle" border="0"/>
		</a>
		<?php endif;?>
		<br /></li>
		<li id="comment"><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php endforeach; ?>
		</ul>
 <H2 onClick="showhidediv('frlink')">Blogroll</H2>
    	<ul id="frlink">
<?php foreach($link_cache as $key=>$value): ?>     	
		<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
<?php endforeach; ?>
		</ul>
<H2 onClick="showhidediv('bloginfo')">Info</H2>
		<ul id="bloginfo">
		<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
		<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count'];?></li>
		<li>总访问量：<?php echo $sta_cache['view_count'];?></li>
		<li><a href="./rss.php" target="_blank"><img src="<?php echo $em_tpldir; ?>/images/em_rss.gif" alt="Rss" border="0" /></a></li>
 <?php
if(ISLOGIN === false):
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?> 
<li><span onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</span>
<ul id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
<li>
用户名:<br>
<input name="user" id="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
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
		<?php echo $exarea;?>
</LI></UL></DIV>
<HR>

<DIV id=footer>Powered by 
<a href="http://www.emlog.net" title="emlog <?php echo $edition;?>">emlog</a><br />
&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp;?></a></P>
</DIV>
</DIV>
</BODY>
</HTML>