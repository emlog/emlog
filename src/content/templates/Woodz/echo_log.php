<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
	<div id="content" class="narrowcolumn">
	<div class="post" id="post-1">
	<div class="post-top">
     <div class="post-title">
	 <h2><?php echo $log_title; ?></h2>
	 <h4><?php echo $comnum; ?></h4>
	 <h3>
	 <span class="sort"><?php blog_sort($sortid, $logid); ?></span>
	 post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?><br />
	 </h3>
	</div>
	</div>
	<div class="entry clear">
	<p><?php echo $log_content; ?></p>
	<p><?php blog_att($logid); ?></p>
	<p><?php blog_tag($logid); ?></p>
	<p><?php neighbor_log(); ?></p>
	</div>
	<?php blog_trackback(); ?>
	</div>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>    
<?php 
include getViews('side');
include getViews('footer'); 
?>