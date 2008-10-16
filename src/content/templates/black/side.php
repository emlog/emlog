<div id="sidebar">
	<div id="sbarheader">
	<div class="ti"><h1><a href="./"><?php echo $blogname; ?></a></h1></div>
			<div class="des"><?php echo $bloginfo; ?></div>
	<div class="rsssubscribe">
	<a href="./rss.php">
	<img style="vertical-align:middle" border="0" src="<?php echo $em_tpldir; ?>images/rss.gif" alt="Subscribe to <?php echo $blogname; ?>" /><br/>
	Subscribe via RSS</a>
	</div>
	</div>
	<div id="nav">
		<ul>
			<li><a href="./">首页</a></li>
			<li><a href="http://www.emlog.net" target="_blank">emlog</a></li>
			<?php if(ISLOGIN): ?>
			<li><a href="./admin/add_log.php">写日志</a></li>
			<li><a href="./admin/">管理中心</a></li>
			<li><a href="./index.php?action=logout">退出</a></li>
			<?php endif; ?>
		</ul>
	</div>
	<div id="sbarsearch">
	<form method="get" id="searchform" action="index.php">
	<input value="" type="text" name="keyword" class="s" />
	<input type="submit" class="sub" value="search" onclick="return keyw()"/>
	</form>
	</div>
		<div class="sbarright">
		<ul>
			<h2>标签</h2>
			<li>
			<?php foreach($tag_cache as $value): ?>
			<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="index.php?tag=<?php echo $value['tagurl']; ?>"><?php echo $value['tagname']; ?></a></span>&nbsp;
			<?php endforeach; ?>
			</li>
		</ul>
		<ul>
			<h2>日志归档</h2>
			<?php foreach($dang_cache as $value): ?>
			<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
			<?php endforeach; ?>
		</ul>
		<?php if($ismusic): ?>
		<ul>
			<h2>音乐</h2>
			<li>
			<?php echo $musicdes; ?>
			<object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="140" height="14">
			<param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" />
			</object>
			</li>
		</ul>
		<?php endif; ?>
		<ul>
			<h2>友情链接</h2>
			<ul>
			<?php foreach($link_cache as $value): ?>     	
			<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
			<?php endforeach; ?>
			</ul>
		</ul>
		<ul>
			<h2>博客信息</h2>
			<ul>
			<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
			<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
			<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
			<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
			</ul>
		</ul>
		<?php if(ISLOGIN==false): 
				$login_code=='y'?
				$ckcode= "<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"><input name=\"imgcode\" type=\"text\" class=\"input\" style=\"width:40px;\"><br //>":
				$ckcode = '';
		?>
		<ul>
			<h2 onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</h2>
			<li id="loginfm" style="display:none">
			<form name="f" method="post" action="index.php?action=login">
			用户:<input name="user" id="user" type="text" class="input" style="width:80px;"/><br/>
			密码:<input name="pw" type="password"  class="input" style="width:80px;"/><br />
			<?php echo $ckcode; ?> 
			<input type="submit" style="margin-left:30px;" class="sub" value="登录">
			<input type="button" class="sub" onclick="showhidediv('loginfm','user')" value="取消">
			</form>
			</li>
		</ul>
		<?php endif; ?>
		</div>
		<div class="sbarleft">
		<ul>
			<h2>博主信息</h2>
			<li><?php echo $photo; ?></li>
			<li><b><?php echo $name; ?></b></li>
			<li><span id="bloggerdes"><?php echo $blogger_des; ?></span>
			<?php if(ISLOGIN === true): ?>
			<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
			<img src="<?php echo $em_tpldir; ?>images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
			<li id='modbdes' style="display:none;">
			<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:50px;"><?php echo $blogger_des; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
			<?php endif; ?>
			</li>
		</ul>
		<ul>
			<h2>日历</h2>
			<li id="calendar">
			<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
			</li>
		</ul>
		<?php if($index_twnum>0): ?>
		<ul>
			<h2>Twitter</h2>
			<ul id="twitter">
			<?php if(isset($tw_cache) && is_array($tw_cache)):
			$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
			foreach (array_slice($tw_cache,0,$index_twnum) as $value):
			$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = smartyDate($localdate,$value['date']);
			?>
			<li> 
			<?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span>
			</li>
			<?php endforeach;?>
			<?php echo $morebt;?>
			<?php endif;?>
			</ul>
			<?php if(ISLOGIN === true): ?>
			<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
			<li id='addtw' style="display: none;">
			<textarea name="tw" id="tw" style="overflow-y: hidden;width:140px;height:70px;" class="input"></textarea>
			<p><a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">取消</a></p>
			</li>
			<?php endif;?>
		</ul>
		<?php endif;?>
		<ul>
			<h2>最新评论</h2>
			<ul>
			<?php foreach($com_cache as $value): ?>
			<li id="comment"><?php echo $value['name']; ?>
			<?php if($value['reply']): ?>
			<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
			<img src="<?php echo $em_tpldir; ?>images/reply.gif" align="absmiddle"/>
			</a>
			<?php endif;?>
			<br />
			<a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
			<?php endforeach; ?>
			</ul>
		</ul>
		</div>
</div>
