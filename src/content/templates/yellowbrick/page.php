<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="blog">
	<table cellpadding="0" cellspacing="2" width="100%">
		<tr>
			<td valign="top" id="blog_left">
				<div class="item_class">
				<table cellpadding="0" cellspacing="0" width="540">
							<tr>
								<td valign="top" class="item_titles">
									<div class="item_title1">
										<b><?php echo $log_title; ?></b>
									</div>
									<div class="item_text">
									<?php echo $log_content; ?>
									<p><?php blog_att($logid); ?></p>
</div>
<div class="item_panel">
<div class="panel_links">
</div>
</div>
								</td>
							</tr>
						</table>
				<br />
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
	</div>
	</td>
	<td valign="top" id="blog_right">
		<div id="blog_right_top">
		</div>
		<div id="blog_right_pad">
		<div id="sidebar">
	<ul>
<?php
include getViews('side');
include getViews('footer'); 
?>