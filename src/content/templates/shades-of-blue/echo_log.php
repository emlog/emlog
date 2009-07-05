<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="content">
	<div id="contentleft">
		<div class="postarea">
			<h1><?php topflg($top); ?><?php echo $log_title; ?></h1>
                <div class="postauthor">
            		<p>Posted by <?php blog_author($author); ?> on <?php echo date('l, F j, Y', $date); ?>&nbsp;<?php editflg($logid,$author); ?></p>
                </div>
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
			<?php doAction('log_related'); ?>
			<div style="clear:both;"></div>
			<?php blog_sort_and_tag($sortid, $logid); ?>
		</div>
		<p align="center"><?php neighbor_log(); ?></p>
        <div class="postcomments">
			<?php blog_trackback(); ?>
			<?php blog_comments(); ?>
			<?php if ($allow_remark == 'y'){blog_comments_post();}?>
        </div>
	</div>
	<?php include getViews('sidebar');?>
</div>
<!-- The main column ends  -->
<?php include getViews('footer');?>