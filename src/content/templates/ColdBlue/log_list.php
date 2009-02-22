<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
			<div class="post" id="post-1">
				
				<div class="post-title">
					<h2><?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a></h2>
					<h3>Posted on <?php echo $value['post_time']; ?> 
					  | <?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?></h3>
				</div>

				<div class="post-content">
					<?php echo $value['log_description']; ?>
				</div>
	<p>
		<?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?>
	</p>
	<span><?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?></span>
		<div class="post-p"><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a></div>
			</div>
<?php endforeach; ?>
<div id="pageurl">
<?php echo $page_url;?></div>
</div>
<ul id="sidebar">
<?php
include getViews('side');
 include getViews('footer'); ?>