<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
	<div class="left"><div class="lpadding">
		<?php include getViews('side'); ?>
	</div></div>
	<div class="right">
		<div class="title">
			<h1><?php topflg($top); ?><?php echo $log_title; ?></a></h1>
			<h4>post by <?php blog_author($author); ?> / <?php echo date('Y-n-j G:i l', $date); ?>
			<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
			</h4>
		</div>
		<div class="logdes"><?php echo $log_content; ?>
		<p><?php blog_att($logid); ?></p>
		<p><?php blog_tag($logid); ?></p>
		<?php doAction('log_related'); ?>

		</div>
		<div class="clear"></div>
		<div class="nextlog"><?php neighbor_log(); ?></div>
		<div class="permalink">
		<?php blog_trackback(); ?>
		<?php blog_comments(); ?>
		<?php if ($allow_remark == 'y'){blog_comments_post();}?>
		</div>
		<div class="div1"></div>
	</div>
	
	<div class="clear"></div>
</div>
<?php include getViews('footer'); ?>
