<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
	<?php if (empty($_GET) && isset($logs[0])) : ?>
	<div class="latest" id="post-<?php $logs[0]['logid']; ?>">
		<p class="details_small">
			on <?php echo date('Y-n-j G:i l', $logs[0]['date']); ?> 
			by <?php blog_author($logs[0]['author']); ?>
			<?php blog_sort($logs[0]['sortid'], $logs[0]['logid']); ?>, 
			<?php blog_tag($logs[0]['logid']); ?>
			<a href="./?post=<?php echo $logs[0]['logid']; ?>#comment">评论(<?php echo $logs[0]['comnum']; ?>)</a>
			<a href="./?post=<?php echo $logs[0]['logid']; ?>#tb">引用(<?php echo $logs[0]['tbcount']; ?>)</a> 
			<a href="./?post=<?php echo $logs[0]['logid']; ?>">浏览(<?php echo $logs[0]['views']; ?>)</a>
		</p>
		<h2><a href="./?post=<?php echo $logs[0]['logid']; ?>" rel="bookmark"><?php echo $logs[0]['log_title']; ?></a></h2>
		<div class="post_content">
		<?php echo $logs[0]['log_description']; ?>
		</div>
	</div>
	<?php
		array_shift($logs);
		endif;
	?>
	<div id="content"<?php if (empty($_GET)) { ?> class="home"<?php }else{ ?> class="archive"<?php } ?>>
		<?php foreach($logs as $value): ?>

		<div class="post list" id="post-<?php echo $value['logid']; ?>">
			<h2><a href="./?post=<?php echo $value['logid']; ?>" rel="bookmark"><?php echo $value['log_title']; ?></a></h2>
			<p class="details_small">
				on <?php echo date('Y-n-j G:i l', $value['date']); ?> 
				by <?php blog_author($value['author']); ?>
				<?php blog_sort($value['sortid'], $value['logid']); ?>
				<?php blog_tag($value['logid']); ?>
				 <?php editflg($value['logid'],$value['author']); ?>
				<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
				<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
				<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
			</p>
			<?php echo $value['log_description']; ?>
			<?php blog_att($value['logid']); ?>
		</div>
		<?php endforeach; ?>
		<div class="navigation">
			<?php echo $page_url;?>
		</div>
	</div>
<?php include getViews('footer'); ?>