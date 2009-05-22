<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
    <div class="post" id="post">
        <h1><?php echo $log_title; ?></h1>
       <div class="post_p"> <?php echo $log_content; ?></div>
		<p><?php blog_att($logid); ?></p>
    </div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
</div>
<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>