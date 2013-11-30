<?php 
/*
* 自建页面模板
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<ul>
<li>
	<h2 class="content_h2"><?php echo $log_title; ?></h2>
	<div class="clear"></div>
	<div class="post"><?php echo $log_content; ?></div>
	<div><?php blog_att($logid); ?></div>
	<?php blog_comments($comments); ?>
	<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
</li>
</ul>
</div>
<!--end content-->
<?php 
include View::getView('side');
include View::getView('footer');
?>