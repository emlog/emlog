<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
    <div class="post" id="post">
        <h1><?php echo $log_title; ?> <?php blog_sort($sortid, $logid); ?></h1>
		<p>发布时间 <?php echo date('Y-n-j G:i l', $date); ?></p>
       <div class="post_p"> <?php echo $log_content; ?></div>
		<p><?php blog_att($logid); ?></p>
		<p><?php blog_tag($logid); ?></p>
        <div class="post-info"><?php neighbor_log(); ?></div>
    </div>
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>