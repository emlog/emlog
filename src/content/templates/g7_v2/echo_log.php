<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo date('j', $date); ?>th</p>
	  <p class="year"><?php echo date('Y', $date); ?></p>
	</div>
	<div class="posttitle">
	<h2><?php echo $log_title;?></h2>
    <p class="postmeta">
	post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?>
	<?php blog_sort($sortid, $logid); ?>
    </p>
    </div>

	<div class="content">
		<p><?php echo $log_content;?></p>
		<p><?php blog_att($logid); ?></p>
		<p><?php blog_tag($logid); ?></p>
		<p><?php neighbor_log(); ?></p>			
	</div>				
<?php blog_trackback(); ?>
<div id="comments">
<?php blog_comments(); ?>
<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</div>
</div>
</div>
</div>
<?php
include getViews('footer');
?>