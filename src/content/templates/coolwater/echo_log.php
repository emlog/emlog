<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
	<div id="content-wrap">
		<div id="main">				
			<h2><?php topflg($top); ?><?php echo $log_title; ?></h2>
			<p class="post-by">Posted by <?php blog_author($author); ?></p>
			<div class="post">
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
			<?php blog_tag($logid); ?>
			</div>
			<p class="post-footer align-left">					
			<?php blog_sort($sortid, $logid); ?>
			<span class="date"><?php echo date('Y-n-j G:i l', $date); ?> <?php editflg($logid,$author); ?></span>	
			</p>
			<br />
			<?php doAction('log_related'); ?>
			<p align="center"><?php neighbor_log(); ?></p>
			<?php blog_trackback(); ?>
			<?php blog_comments(); ?>
			<?php if ($allow_remark == 'y'){blog_comments_post();}?>
		</div>
<?php
include getViews('side');
include getViews('footer'); 
?>