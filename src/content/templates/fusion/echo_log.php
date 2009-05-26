<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!-- main content -->
<div id="main-content">
		<div class="navigation">
			<div class="alignleft"></div>
			<div class="alignright"></div>
            <br clear="all" />
		</div>
<div class="post hentry category-uncategorized" id="post-1">
	<h2><?php topflg($top); ?><?php echo $log_title; ?></h2>
<div class="entry">
post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?>
<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
<p><div style="width:610px; overflow:hidden;"><?php echo $log_content; ?></div>
</p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
</p>
<p class="postmetadata alt">
<small><?php neighbor_log(); ?></small>
</p>
</div>
	<?php blog_trackback(); ?>
</div>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</div>
</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>