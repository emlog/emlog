<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<ul>
<li>
	<h2 class="content_h2"><?php topflg($top); ?><?php echo $log_title; ?></h2>
	<div class="act"><?php blog_sort($sortid, $logid); ?></div>
	<div class="editor"><?php editflg($logid,$author); ?></div>
	<div class="clear line"></div>
    <div class="bloger">post by <?php blog_author($author); ?> / <?php echo gmdate('Y-n-j G:i l', $date); ?></div>
	<div class="post"><?php echo $log_content; ?></div>
	<div class="fujian"><?php blog_att($logid); ?></div>
	<div class="tag echo_tag"><?php blog_tag($logid); ?></div>
	<?php doAction('log_related'); ?>
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