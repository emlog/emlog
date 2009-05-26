<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="narrowcolumn">
<div class="post">
<h2><?php echo $log_title;?></h2>
<div class="entry">
<?php echo $log_content;?>
<p><?php blog_tag($logid); ?></p>
</div>
<div class="comments-template">
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
include getViews('obar');
include getViews('footer');
?>