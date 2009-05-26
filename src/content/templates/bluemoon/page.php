<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
	<div class="left"><div class="lpadding">
		<?php include getViews('side'); ?>
	</div></div>
	<div class="right">
		<div class="title">
			<h1><?php echo $log_title; ?></a></h1>
			</h4>
		</div>
		<div class="logdes"><?php echo $log_content; ?>
		<p><?php blog_att($logid); ?></p>
		</div>
		<div class="clear"></div>
		<div class="permalink">
		<?php 
		if ($allow_remark == 'y'){
			blog_comments();
			blog_comments_post();
		}
		?>
		</div>
		<div class="div1"></div>
	</div>
	
	<div class="clear"></div>
</div>
<?php include getViews('footer'); ?>
