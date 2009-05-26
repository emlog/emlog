<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
<h2><?php topflg($top); ?><?php echo $log_title; ?></h2>
<div class="date">Post by <?php blog_author($author); ?> <?php echo date('Y-n-j G:i l', $date); ?> <?php blog_sort($sortid, $logid); ?> <?php editflg($logid,$author); ?></div>
<div class="entry">
	<p><?php echo $log_content; ?></p>
	<p><?php blog_att($logid); ?></p>
	<p><?php blog_tag($logid); ?></p>
</div>
<div class="nextlog"><?php neighbor_log(); ?></div>
<?php blog_trackback(); ?>
<?php blog_comments(); ?>
<?php if ($allow_remark == 'y'){blog_comments_post();}?>

</div>
</div>

<?php 
include getViews('side');
include getViews('footer'); 
?>