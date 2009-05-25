<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!-- main content -->
<div id="main-content">
		<div class="navigation">
			<div class="alignleft"></div>
			<div class="alignright"></div>
            <br clear="all" />
		</div>
<div class="post hentry category-uncategorized" id="post-1">
	<h2><?php echo $log_title; ?></h2>
<div class="entry">
<p><div style="width:610px; overflow:hidden;"><?php echo $log_content; ?></div>
</p><?php blog_att($logid); ?></p>
</p>
</div>
</div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div>
</div>
</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>