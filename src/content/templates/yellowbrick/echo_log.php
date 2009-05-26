<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="blog">
	<table cellpadding="0" cellspacing="2" width="100%">
		<tr>
			<td valign="top" id="blog_left">
				<div class="item_class">
					
				<table cellpadding="0" cellspacing="0" width="540">
							<tr>
								<td valign="top" class="item_date">
									<div class="date_month"><?php echo date('n月',$date); ?></div>
									<div class="date_day"><?php echo date('j',$date); ?></div>
								</td>
								<td width="10"></td>
								<td valign="top" class="item_titles">
									<div class="item_title1">
									<?php topflg($top); ?><?php echo $log_title; ?>
									</div>
									<div class="item_title2">
									<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
									post by <?php blog_author($author); ?> / <?php echo date('Y-n-j G:i l', $date); ?></i>
									</div>
									<div class="item_text">
									<?php echo $log_content; ?>
									<p><?php blog_att($logid); ?></p>
									<p><?php blog_tag($logid); ?></p>
</div>
<div class="item_panel">
<div class="panel_links">
<div class="nextlog"><?php neighbor_log(); ?></div>
</div>
</div>
								</td>
							</tr>
						</table>
				<br />
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>

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