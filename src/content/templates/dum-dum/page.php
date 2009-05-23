<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="content">
<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_08.jpg" alt="" />
	<div class="contenttext">
		<div class="post">
			<div class="postheader">
				
				<div class="posttitle">
					<h3><?php echo $log_title; ?></h3>
				</div> 
			</div> 
			<div style=" clear:both;"></div>
			<div class="posttext">
			<?php echo $log_content; ?>
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
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/img_09.jpg" style="vertical-align: bottom;" alt="" />
		</div> 
<?php 
include getViews('side');
include getViews('footer'); 
?>