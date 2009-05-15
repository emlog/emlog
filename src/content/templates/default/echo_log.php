<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="content">
<ul>
<li>
	<h2 class="content_h2"><?php echo $log_title; ?></h2>
	<?php if($log_cache_sort[$logid]): ?>
	<div class="act">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</div>
	<?php endif;?>
	<div class="editor"><a href="#">编辑</a></div>
	<div class="clear line"></div>
    <div class="date">post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?></div>
	<div class="post"><?php echo $log_content; ?></div>
	<div class="fujian"><?php blog_att($logid); ?></div>
	<div class="tag echo_tag"><?php blog_tag($logid); ?></div>
	<?php neighbor_log(); ?>
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