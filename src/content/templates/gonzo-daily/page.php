<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
		<div id="content" class="single">
			<div class="post" id="post-<?php echo $logid; ?>">
				<p class="details_small">
				</p>
				<h1><?php echo $log_title; ?></h1>
				<div class="post_content">
				<?php echo $log_content; ?>
				<?php blog_att($logid); ?>
			</div>
		</div>
			<div class="comments">
			<?php blog_comments(); ?>
			<?php if ($allow_remark == 'y'){blog_comments_post();}?>
			</div>
		</div>
<?php include getViews('footer');  ?>
