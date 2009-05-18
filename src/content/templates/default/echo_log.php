<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="content">
<ul>
<li>
	<h2 class="content_h2"><?php topflg($top); ?><?php echo $log_title; ?></h2>
	<?php if($log_cache_sort[$logid]): ?>
	<div class="act"><?php blog_sort($sortid, $logid); ?></div>
	<?php endif;?>
	<div class="editor"><?php editflg($logid); ?></div>
	<div class="clear line"></div>
    <div class="bloger">post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?></div>
	<div class="post"><?php echo $log_content; ?></div>
	<div class="fujian"><?php blog_att($logid); ?></div>
	<div class="tag echo_tag"><?php blog_tag($logid); ?></div>
	<div class="nextlog"><?php neighbor_log(); ?></div>
	<?php blog_trackback(); ?>

	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</li>
</ul>
</div>
<!--end content-->
<?php 
include getViews('side');
include getViews('footer'); 
?>