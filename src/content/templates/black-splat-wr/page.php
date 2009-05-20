<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post">
<h2 class="postTitle"><?php echo $log_title; ?></h2>
    <div class="postContent"><?php echo $log_content; ?></div>
<p class="tags"><?php blog_att($logid); ?></p>
<div id="nextprevious"><?php neighbor_log(); ?></div>
</div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div></div>
<div class="sidebars">
<?php
include getViews('side');
 include getViews('footer'); ?>