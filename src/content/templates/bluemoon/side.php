<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
	<div class="title"><h1><span onclick="showhidediv('blogger')">Blogger</span></h1></div>
	<ul id="blogger">
		<?php echo $photo; ?>
		<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
		<?php if(ISLOGIN === true): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:60px;"><?php echo $blogger_des; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消l</a>
		<?php endif; ?>
		</li>
	</ul>
	<div class="title"><h1><span onclick="showhidediv('calendar')">Calendar</span></h1></div>
	<ul id="calendar">
		<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
	</ul>
	<div class="title"><h1><span onclick="showhidediv('tags')">Tags</span></h1></div>
	<ul id="tags">
		<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
		<a href="index.php?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a></span> 
		<?php endforeach; ?>
	</ul>
	<?php if($index_twnum>0): ?>
	<div class="title"><h1><span onclick="showhidediv('twitter')">Twitter</span></h1></div>
	<ul id="twitter">
		<?php
			if(isset($tw_cache) && is_array($tw_cache)):
			$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
			foreach (array_slice($tw_cache,0,$index_twnum) as $value):
			$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = smartyDate($localdate,$value['date']);
		?>
		<li><?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
		<?php endforeach;?>
		<?php echo $morebt;?>
		<?php endif;?>
	</ul>
	<?php if(ISLOGIN === true): ?>
	<ul>
	<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
		<li id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:170px;height:70px;" class="input"></textarea>
		<center>
		<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</center>
		</li>
	</ul>
	<?php endif;?>
	<?php endif;?>
	<?php if($ismusic): ?>
	<div class="title"><h1><span onclick="showhidediv('blogmusic')">Music</span></h1></div>
	<ul id="blogmusic">
		<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object></li>
	</ul>
	<?php endif; ?>
	<div class="title"><h1><span onclick="showhidediv('newcomment')">Comments</span></h1></div>
	<ul id="newcomment">
		<?php foreach($com_cache as $value): ?>
		<li id="comment"><?php echo $value['name']; ?> 
		<?php if($value['reply']): ?>
		<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
		<img src="<?php echo $em_tpldir; ?>images/reply.gif" align="absmiddle"/>
		</a>
		<?php endif;?>
		<br /><a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
		<?php endforeach; ?>
	</ul>
	<div class="title"><h1><span onclick="showhidediv('archives')">Archives</span></h1></div>
	<ul id="archives">
		<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
		<?php endforeach; ?>
	</ul>
	<div class="title"><h1><span onclick="showhidediv('frlink')">Blogroll</span></h1></div>
	<ul id="frlink">
		<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
		<?php endforeach; ?>
	</ul>
	<div class="title"><h1><span onclick="showhidediv('bloginfo')">Bloginfo</span></h1></div>
	<ul id="bloginfo">
		<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
		<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
		<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
	</ul>
	<div class="title"><h1><span onclick="showhidediv('meta')">Meta</span></h1></div>
	<ul id="meta">
		<li><a href="./rss.php" title="Syndicate this site using RSS">RSS</a></li>
	</ul>
	<?php
		if(ISLOGIN === false):
		$login_code=='y'?
		$ckcode = "<li>验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n</li><br/>":
		$ckcode = '';
	?>
	<div class="title"><h1><span onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</span></h1></div>
	<ul id="loginfm" style="display: none;">
		<form name="f" method="post" action="index.php?action=login" id="commentform">
		<li>用户名:<br>
		<input name="user" id="user" type="text"><br />
		</li>
		<li>密  码:<br>
		<input name="pw" type="password"><br>
		</li>
		<?php echo $ckcode;?>
		<input type="submit" value=" 登录">
		</form>
	</ul>
	<?php
		else:
	?>
	<div class="title"><h1><span onclick="showhidediv('adminin','user')" style="cursor:pointer;">管理</span></h1></div>
	<ul id="adminin">
		<li><a href="./admin/add_log.php">写日志</a></li>
		<li><a href="./admin/">管理中心</a></li>
		<li><a href="./index.php?action=logout">退出</a></li>
		<?php endif; ?>   	
	</ul>
	<?php echo $exarea;?>
	<div class="div1"></div>