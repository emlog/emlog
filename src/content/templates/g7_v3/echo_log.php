<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<h2><?php topflg($top); ?><?php echo $log_title;?></h2>
<p class="postdata">
post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?>
<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
</p>
<div id="content_post">	
<div class="post_p"><?php echo $log_content;?></div>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
<p><?php neighbor_log(); ?></p>
</div>
		<?php blog_trackback(); ?>
<div id="comments"><div class="content_c">

	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>


</div>
</div>
</div>
<?php
include getViews('side');
include getViews('footer');
?>