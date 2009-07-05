<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="content">
	<div id="contentleft">
		<div class="postarea">
			<h1><?php echo $log_title; ?></h1>
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
			<div style="clear:both;"></div>
		</div>
        <div class="postcomments">
			<?php blog_comments(); ?>
			<?php if ($allow_remark == 'y'){blog_comments_post();}?>
        </div>
	</div>
	<?php include getViews('sidebar');?>
</div>
<!-- The main column ends  -->
<?php include getViews('footer');?>