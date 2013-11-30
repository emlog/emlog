<?php 
/*
* 自建页面模板
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
	<div class="post">
		<h2><?php echo $log_title; ?></h2>
		<div class="log">
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
		</div>
	</div>
	<?php if($allow_remark == 'y' || $comments): ?>
	<div class="post" id="comments">
		<?php blog_comments($comments); ?>
		<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
	</div>
	<?php endif; ?>
</div><!--end content-->
<?php include View::getView('side'); include View::getView('footer'); ?>