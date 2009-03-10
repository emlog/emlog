	<div id="content">
	<ul>
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
		<li>
		
		<h2 class="content_h2"><?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
			<?php if($log_cache_sort[$value['logid']]): ?>
			<div class="act">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</div>
	<?php endif;?>
		<div class="clear"></div>
		<div class="post"><?php echo $value['log_description']; ?></div>
		
		<div class="under">
		<div class="top"></div>
		<div class="under_p">
			<div>	<?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '文件附件：'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?></div>
			<div class="tag"><?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?></div>
			<div class="date"><?php echo $value['post_time']; ?></div>
			<div>	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a></div>
		</div>
		<div class="bottom"></div>
		</div>
		
		</li>

<?php endforeach; ?>
	</ul>
	<div id="pagenavi">
	<?php echo $page_url;?>
</div>
	</div>
	<!--end content-->
<?php
 include getViews('side');
 include getViews('footer'); ?>