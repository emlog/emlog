<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post" id="post-1">
<div class="post-title">
	<h2><?php topflg($top); ?><?php echo $log_title; ?></h2>
	<h3>post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?>  |   
	<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
	</h3>
</div>
<div class="post-content">
	<?php echo $log_content; ?>
</div>
	<p><?php blog_att($logid); ?></p>
	<span><?php blog_tag($logid); ?></span>
	<div class="nextlog"><?php neighbor_log(); ?></div>
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
	</div>	
	</div>
	<ul id="sidebar">
<?php
include getViews('side');
include getViews('footer'); 
?>