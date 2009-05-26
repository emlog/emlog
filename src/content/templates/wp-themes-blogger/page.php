<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
   <div class="postcontent">
            <div class="postcontent_in">
<h2><?php echo $log_title;?></h2>
<div class="post">
	<div class="storycontent">
		<div class="excrept_post_p"><?php echo $log_content; ?></div>
        <p><?php blog_att($logid); ?></p>
    <div class="clear"></div>
	</div>
	<div class="feedback"></div>
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
			 <div id="sidebar"><!-- Sidebar Start Here -->
                <div id="sidebar_in">
<?php 
include getViews('side');
include getViews('footer'); 
?>