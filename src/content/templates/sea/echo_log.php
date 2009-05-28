<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
<h2>
<?php topflg($top); ?><?php echo $log_title;?>
<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
</h2>
post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?>
<div class="entry">
<?php echo $log_content;?>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
<?php doAction('log_related'); ?>
<p><?php neighbor_log(); ?></p>
</div>
	<?php blog_trackback(); ?>
<div class="comments-template">
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>