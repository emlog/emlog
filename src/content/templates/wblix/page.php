<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
<div class="entry single">
<h1>
<?php echo $log_title;?>
</h1>
<div class="post"><?php echo $log_content;?></div>
<p><?php blog_att($logid); ?></p>
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
<?php
include getViews('side');
include getViews('footer');
?>