<?php 
/*
* 自建页面模板
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<!-- Article begin -->
<div class="article">
	<div class="post single">
		<h2><?php echo $log_title; ?></h2>
		<!-- Entry begin -->
		<div class="entry">
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
		</div>
		<!-- Entry end -->
		<!-- Post Function begin -->
		<!-- Post Function end -->
		<div class="clear"></div>
		<!-- Post Comment begin -->
		<div class="post_comment">
			<?php blog_comments($comments,$commentStack,$logid,$params); ?>
			<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		</div>
		<!-- Post Comment end -->
	</div>
</div>
<!-- Article end -->
<!-- Sidebar begin -->
	<?php  include View::getView('side'); ?>
<!-- Sidebar end -->
<?php include View::getView('footer'); ?>