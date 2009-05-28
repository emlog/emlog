<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
    <div class="post" id="post">
        <h1><?php topflg($top); ?><?php echo $log_title; ?></h1>
       <div class="post_p"> <?php echo $log_content; ?></div>
		<p><?php blog_att($logid); ?></p>
		<p><?php blog_tag($logid); ?></p>
        <p><?php neighbor_log(); ?></p>
		<div class="post-info">
			post by <?php blog_author($author); ?> | <?php echo date('Y-n-j G:i l', $date); ?> | 
			<?php blog_sort($sortid, $logid); ?>
		</div>
    </div>
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>