<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
<h2 class="postTitle"><?php topflg($top); ?><?php echo $log_title; ?></h2>
<p class="postMeta"><?php if($log_cache_sort[$logid]): ?>
	<?php blog_sort($sortid, $logid); ?>
	<?php endif;?>post by <?php blog_author($author); ?> on<?php echo date('Y-n-j G:i l', $date); ?> <?php editflg($logid,$author); ?>
    </p>
    <div class="postContent"><?php echo $log_content; ?></div>
	<p class="tags"><?php blog_att($logid); ?></p>
	<p class="tags"><?php blog_tag($logid); ?></p>
	<?php doAction('log_related'); ?>

<div id="nextprevious"><?php neighbor_log(); ?></div>
</div>
<?php blog_trackback(); ?>
<?php blog_comments(); ?>
<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div></div>
<div class="sidebars">
<?php
include getViews('side');
 include getViews('footer'); ?>