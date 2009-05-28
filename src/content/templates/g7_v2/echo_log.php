<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo date('j', $date); ?>th</p>
	  <p class="year"><?php echo date('Y', $date); ?></p>
	</div>
	<div class="posttitle">
	<h2><?php topflg($top); ?><?php echo $log_title;?><span class="sort"><?php blog_sort($sortid, $logid); ?></span>
	</h2>
    <p class="postmeta">
	作者:<?php blog_author($author); ?> 时间:<?php echo date('Y-n-j G:i l', $date); ?>
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