<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class="contentA" onmouseover="this.style.backgroundColor='#FFFFDD'" onmouseout="this.style.backgroundColor='#FFF'">
	<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/pofile.png) no-repeat 3px 3px;">博主信息</div>
    	<ul style="text-align:center" id="bloggerinfo" class="collapsed">
		<li><?=$photo?></li>
		<li>
		<b><?=$name?></b> 
		<br><?=$blogger_des?>
		</li>
		</ul>
		<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/search.png) no-repeat 3px 3px;">日志搜索</div>
		<ul id="logserch" class="collapsed">
  			<li>
			<form name="keyform" method="get" action="index.php"><p>
				<input name="keyword"  type="text" value="" style="width:130px;border:1px solid #E3E197;vertical-align:middle;"/>
				<input name="action" type="hidden" value="search" />
				<input type="submit" value="搜索" onclick="return keyw()" />
			</form>
			</li>
		</ul>
	<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/calendar.png) no-repeat 3px 3px;">日历</div>
    	<div id="calendar" class="collapsed">
			<!--日历-->
		</div>
	<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/tag.png) no-repeat 3px 3px;">标签</div>
		<ul id="blogtags" class="collapsed">
			<li>
			<?php
			foreach($tag_cache as $value){
			?>
				<span style="font-size:<?=$value['fontsize']?>px; height:30px;"><a href="index.php?action=taglog&tag=?<?=$value['tagurl']?>"><?=$value['tagname']?></a></span>&nbsp;
			<?php }?>
				<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
			</li>
		</ul>
<?php if($ismusic){ ?>
<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/music.png) no-repeat 3px 3px;">音乐</div>	
<ul id="blogmusic" class="collapsed">
<li><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?=$music?><?=$autoplay?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?=$music?><?=$autoplay?>&autoreplay=1" /></object>
</li>
</ul>	
<?php }?>
<?php if($index_twnum>0){ ?>
<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/taotao.png) no-repeat 3px 3px;">Twitter</div>
	<div class="lister-my">
		<ul id="twitter">
		<?php
		$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value)
		{
			$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
			$value['date'] = SmartyDate($localdate,$value['date']);
		?>
		<li> <?= $value['content'] ?> <?= $delbt ?><br><span><?= $value['date'] ?></span></li>
		<?php } ?>
		<?=$morebt?>
	</ul>
	<?php if(ISLOGIN === true){ ?>
		<ul>
		<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
			<li id='addtw' style="display: none;">
				<textarea name="tw" id="tw" style="width:200px;height:50px;"></textarea><br />
				<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" value="提交">
			</li>
		</ul>
	<?php
	}
	?>
</div>
<?php 
}
?>
<!--预留广告位-->
<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/taotao.png) no-repeat 3px 3px;">博客广告</div>
	<div class="lister-my">
	<center>
	<table align="center">
		<tr>
		<td>
			<!--预留广告位 建议大小180 * 250 -->
		</td>
		</tr>
	</table>
	</center>
</div>
<!--预留广告位-->
<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/comments.png) no-repeat 3px 3px;">最新评论</div>
		<ul id="newcomment" class="collapsed">
<?php
foreach($com_cache as $value){
?>
		<li id="comment"><?=$value['name']?><br /><a href="<?=$value['url']?>"><?=$value['content']?></a></li>
<?php } ?>
		</ul>
	
	<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/logs.png) no-repeat 3px 3px;">日志归档</div>
		<ul id="record" class="collapsed">
<?php
foreach($dang_cache as $value){
?>
		<li><a href="{$value['url']}"><?=$value['record']?>(<?=$value['lognum']?>)</a></li>
<?php } ?>		
		</ul>
	<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/links.png) no-repeat 3px 3px;">友情链接</div>
    	<ul id="frlink" class="collapsed">
<?php
foreach($link_cache as $value){
?>     	
		<li><a href="<?=$value['url']?>" title="<?=$value['des']?>" target="_blank"><?=$value['link']?></a></li>
<?php } ?>	
</ul>
	<div class="lister" style="background:url(<?=$tpl_dir?>be-evil/images/staic.png) no-repeat 3px 3px;">博客信息</div>
		<ul id="bloginfo" class="collapsed">
		<li>日志数量：<?=$sta_cache['lognum']?></li>
		<li>评论数量：<?=$sta_cache['comnum']?></li>
		<li>引用数量：<?=$sta_cache['tbnum']?></li>
		<li>今日访问：<?=$sta_cache['day_view_count']?></li>
		<li>总访问量：<?=$sta_cache['view_count']?></li>
		</ul>
	
	<?=$exarea?>
</div>
<div id="contentB">