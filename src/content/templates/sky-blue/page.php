<?php 
/*
* 自建页面模板
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
	<div id="single">
        <div class="top_post"></div>
		<div class="post" id="post-<?php echo $logid; ?>">
			<div class="byline">
            	<h2 class="title"><?php echo $log_title; ?></h2>
        	</div>
			<div class="entry clear">
				<?php echo $log_content; ?>
				<?php blog_att($logid); ?>
			</div>
		</div>
        <div class="bottom_post"></div>
    	<?php 
		if ($allow_remark == 'y'){
		blog_comments($logid,$params);
		blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark);
		}
		?>
	</div>
	</div>
	<?php include View::getView('side'); ?>
</div>
<?php include View::getView('footer'); ?>