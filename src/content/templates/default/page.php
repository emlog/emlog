<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="content">
<ul>
<li>
	<h2 class="content_h2"><?php echo $log_title; ?></h2>
	<div class="clear"></div>
	<div class="post"><?php echo $log_content; ?></div>

	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>

</li>
</ul>
</div>
<!--end content-->

<?php 
include getViews('side');
include getViews('footer');
?>