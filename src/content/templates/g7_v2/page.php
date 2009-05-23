<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
	<div class="posttitle">
	<h2><?php echo $log_title;?></h2>
    </div>
	<div class="content">
		<p><?php echo $log_content;?></p>
		<p><?php blog_att($logid); ?></p>
	</div>				
<div id="comments">
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div>
</div>
</div>
</div>
</div>
<?php
include getViews('footer');
?>