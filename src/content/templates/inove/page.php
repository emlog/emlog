<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post" id="post-1">
		<h2><?php echo $log_title;?></h2>
		<div class="content">
<?php echo $log_content; ?>
<p><?php blog_att($logid); ?></p>
</div>
</div>

<div id="comments">
<div class="fixed"></div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div>
<?php 
include getViews('side');
include getViews('footer');
 ?>