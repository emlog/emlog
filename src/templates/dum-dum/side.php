<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class="sidebar">
	<form name="keyform" method="get" action="index.php" id="searchform">
	<div>
   	<input name="keyword"  type="text" value="" id="s" /><input type="image" src="<?php echo $tpl_dir; ?>dum-dum/images/search-button.jpg" id="searchsubmit" value="Search" />
	</div>
	</form>

	<div class="box1">
		<div class="box1text">
		<ul>
		<li><h2>资料</h2>
		<li style="text-align:center;"><?php echo $photo; ?></li>
		<li style="text-align:center;"><b><?php echo $name; ?></b></li>
			<li style="text-align:center;"><span id="bloggerdes"><?php echo $blogger_des; ?></span>
			<?php if(ISLOGIN === true): ?>
			<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
			<img src="<?php echo $tpl_dir; ?>default/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
			<li id='modbdes' style="display:none;">
			<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:60px;"><?php echo $blogger_des; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
			<?php endif; ?>
			</li>
		</ul>
		</div> <!-- BOX1 TEXT -->
	</div> <!-- BOX1 -->

	<div class="box2">
		<div class="box2text">
		<ul>
			<li><h2>日历</h2>
				<div id="calendar">
				</div>
			</li>
		</ul>
		</div> <!-- BOX2 TEXT -->
	</div> <!-- BOX2 -->
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>

	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2>标签</h2>
		<?php foreach($tag_cache as $value): ?>
			<a style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;" href="index.php?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a>
		<?php endforeach; ?>			
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->

	<div class="box2">
		<div class="box2text">
		<ul>
			<li><h2>Twitter</h2>
			<ul id="twitter">
			<?php
			if(isset($tw_cache) && is_array($tw_cache)):
				$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
				foreach (array_slice($tw_cache,0,$index_twnum) as $value):
					$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
					$value['date'] = smartyDate($localdate,$value['date']);
					?>
					<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
				<?php endforeach;?>
				<?php echo $morebt;?>
			<?php endif;?>
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
			<?php endif;?>
			</li>
		</ul>
		</div> <!-- BOX2 TEXT -->
	</div> <!-- BOX2 -->
	<?php if($ismusic): ?>
	<div class="box1">
		<div class="box1text">
		<ul>
		<li><h2>音乐</h2>
		<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
		</ul>
		</div> <!-- BOX1 TEXT -->
	</div> <!-- BOX1 -->
	<?php endif; ?>	
	
	<div class="box3">
		<div class="box3text">
		<ul>
		<li><h2>评论</h2>
		<?php foreach($com_cache as $value): ?>
		<li id="comment"><?php echo $value['name']; ?> 
		<?php if($value['reply']): ?>
			<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
			<img src="<?php echo $tpl_dir; ?>default/images/reply.gif" align="absmiddle"/>
			</a>
		<?php endif;?>
		<br /><a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
		<?php endforeach; ?>			
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->

	<div class="box2">
		<div class="box2text">
		<ul>
			<li><h2>存档</h2>
			<?php foreach($dang_cache as $value): ?>
			<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
			<?php endforeach; ?>
		</ul>
		</div> <!-- BOX2 TEXT -->
	</div> <!-- BOX2 -->

	<div class="box1">
		<div class="box1text">
		<ul>
			<li><h2>链接</h2>
			<?php foreach($link_cache as $value): ?>     	
			<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
			<?php endforeach; ?>
		</ul>
		</div> <!-- BOX1 TEXT -->
	</div> <!-- BOX1 -->
	

	<div class="box3">
		<div class="box3text">
		<ul>
			<li><h2>统计</h2>
			<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
			<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
			<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
			<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
		</ul>
		</div> <!-- BOX3 TEXT -->
	</div> <!-- BOX3 -->
	<?php echo $exarea; ?>
</div> <!-- SIDEBAR -->