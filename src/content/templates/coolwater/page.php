<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
	<div id="content-wrap">
		<div id="main">				
			<h2><?php echo $log_title; ?></h2>
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
			<?php blog_comments(); ?>
			<?php if ($allow_remark == 'y'){blog_comments_post();}?>
		</div>
<?php
include getViews('side');
include getViews('footer'); 
?>