<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
		<div id="content" class="single">
			<div class="post" id="post-<?php echo $logid; ?>">
				<p class="details_small">
					on <?php echo date('Y-n-j G:i l', $date); ?> 
					by <?php blog_author($author); ?>
					<?php blog_sort($sortid, $logid); ?>
					 <?php editflg($logid,$author); ?>
				</p>
				<h1><?php echo $log_title; ?></h1>
				<div class="post_content">
				<?php echo $log_content; ?>
				<?php blog_att($logid); ?>
				<?php doAction('log_related'); ?>
				</div>
				<p><?php blog_tag($logid); ?></p>
			</div>
			<div class="comments">
			<?php blog_trackback(); ?>
			<?php blog_comments(); ?>
			<?php if ($allow_remark == 'y'){blog_comments_post();}?>
			</div>
			<div class="navigation">
				<?php neighbor_log(); ?>
			</div>
		</div>
<?php include getViews('footer');  ?>
