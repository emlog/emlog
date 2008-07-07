<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class="contentA" onmouseover="this.style.backgroundColor='#FFFFDD'" onmouseout="this.style.backgroundColor='#FFF'">
	<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/pofile.png) no-repeat 3px 3px;">博主信息</div>
    	<ul style="text-align:center" id="bloggerinfo" class="collapsed">
		<li><?php echo $photo;?></li>
		<li>
		<b><?php echo $name;?></b> 
		<br><span id="bloggerdes"><?php echo $blogger_des;?></span>
			<?php if(ISLOGIN === true): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo $tpl_dir; ?>be-evil/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:50px;"></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./adm/blogger.php?action=modintro&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
		</li>
		</ul>
		<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/search.png) no-repeat 3px 3px;">日志搜索</div>
		<ul id="logserch" class="collapsed">
  			<li>
			<form name="keyform" method="get" action="index.php"><p>
				<input name="keyword"  type="text" value="" style="width:130px;border:1px solid #E3E197;vertical-align:middle;"/>
				<input name="action" type="hidden" value="search" />
				<input type="submit" value="搜索" onclick="return keyw()" />
			</form>
			</li>
		</ul>
	<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/calendar.png) no-repeat 3px 3px;">日历</div>
    	<div id="calendar" class="collapsed">
			<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
		</div>
	<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/tag.png) no-repeat 3px 3px;">标签</div>
		<ul id="blogtags" class="collapsed">
			<li>
			<?php foreach($tag_cache as $value): ?>
				<span style="font-size:<?php echo $value['fontsize']; ?>px; height:30px;"><a href="index.php?action=taglog&tag=<?php echo $value['tagurl']; ?>"><?php echo $value['tagname']; ?></a></span>&nbsp;
			<?php endforeach; ?>
			</li>
		</ul>
<?php if($ismusic): ?>
<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/music.png) no-repeat 3px 3px;">音乐</div>	
<ul id="blogmusic" class="collapsed">
<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
</li>
</ul>	
<?php endif; ?>
<?php if($index_twnum > 0): ?>
<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/taotao.png) no-repeat 3px 3px;">Twitter</div>
	<div class="lister-my">
		<ul id="twitter">
		<?php
		if(isset($tw_cache) && is_array($tw_cache)):
		$morebt = count($tw_cache) > $index_twnum ? "<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value):
			$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = smartyDate($localdate,$value['date']);
		?>
		<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
		<?php  endforeach; ?> 
		<?php endif; ?>
		<?php echo $morebt;?>
	</ul>
	<?php if(ISLOGIN === true): ?>
		<ul>
		<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
			<li id='addtw' style="display: none;">
				<textarea name="tw" id="tw" style="width:200px;height:50px;"></textarea><br />
				<input type="button" onclick="postinfo('./twitter.php?action=add','tw','twitter');" value="提交">
			</li>
		</ul>
	<?php endif; ?>
</div>
<?php endif; ?>

<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/taotao.png) no-repeat 3px 3px;">博客广告</div>
	<div class="lister-my">
	<center>
	<table align="center">
		<tr>
		<td>
			
		</td>
		</tr>
	</table>
	</center>
</div>

<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/comments.png) no-repeat 3px 3px;">最新评论</div>
		<ul id="newcomment" class="collapsed">
<?php foreach($com_cache as $value): ?>
		<li id="comment"><?php echo $value['name']; ?><br /><a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
<?php endforeach; ?>
		</ul>
	
	<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/logs.png) no-repeat 3px 3px;">日志归档</div>
		<ul id="record" class="collapsed">
<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url'];?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
<?php  endforeach;  ?>		
		</ul>
	<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/links.png) no-repeat 3px 3px;">友情链接</div>
    	<ul id="frlink" class="collapsed">
<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
<?php  endforeach;  ?>	
</ul>
	<div class="lister" style="background:url(<?php echo $tpl_dir;?>be-evil/images/staic.png) no-repeat 3px 3px;">博客信息</div>
		<ul id="bloginfo" class="collapsed">
		<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
		<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count']; ?></li>
		<li>总访问量：<?php echo $sta_cache['view_count']; ?></li>
		</ul>
	
	<?php echo $exarea;?>
</div>
<div id="contentB">