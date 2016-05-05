<?php 
/**
 * Self-built page template
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="col-md-7">
	<h2><?= $log_title ?></h2>
	<?= $log_content ?>
	<?php blog_comments($comments); ?>
	<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
	<div style="clear:both;"></div>
</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>