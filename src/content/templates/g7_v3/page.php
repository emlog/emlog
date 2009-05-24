<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<h2><?php echo $log_title;?></h2>
<div id="content_post">	
<div class="post_p"><?php echo $log_content;?></div>
<p><?php blog_att($logid); ?></p>
</div>
<div id="comments"><div class="content_c">
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