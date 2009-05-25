<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="body">
<div id="body_top">
	<div id="body_left">
    	<div id="body_left_content">
	<div id="content" class="narrowcolumn">
			<div class="post" id="post-1">
                <div class="post-top">
                    <div class="post-title">
                    	<h2><?php echo $log_title; ?></h2>
</div>
                </div>
	<div class="entry clear">
	<p><?php echo $log_content; ?></p>
	<p><?php blog_att($logid); ?></p>
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