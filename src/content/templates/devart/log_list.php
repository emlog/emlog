<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="content">

	<?php if (is_array($logs) && !empty($logs)) :?>

		<?php 
		foreach($logs as $value):  
		$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
		?>

			<div class="post" id="post-<?php echo $value['logid']; ?>">
				<h1>
				<?php echo $topFlg; ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
					<?php if($log_cache_sort[$value['logid']]): ?>
					<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
					<?php endif;?>
				</h1>

				<div class="post_p"><?php echo $value['log_description']; ?></div>
				<p>
					<?php 
					$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
					echo $attachment;
					?>
				</p>
				<p>
					<?php 
					$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
					echo $tag;
					?>
				</p>
				<div class="post-info">
					<?php echo date('Y-n-j G:i l', $value['date']); ?> | 
					<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
					<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
					<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
				</div>
			</div>
		<?php endforeach; ?>

		<div id="pages">
			<?php echo $page_url;?>
		</div>

	<?php else : ?>

		<h1>未找到</h1>
		<p class="center">对不起, 博客暂时还没有任何日志.</p>

	<?php endif; ?>
	
</div>
<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>