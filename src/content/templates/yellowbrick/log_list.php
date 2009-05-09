<div id="blog">
	<table cellpadding="0" cellspacing="2" width="100%">
		<tr>
			<td valign="top" id="blog_left">
				<div class="item_class">

<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"置顶日志\" />" : '';
?>
		
				<table cellpadding="0" cellspacing="0" width="540">
							<tr>
								<td valign="top" class="item_date">
									<div class="date_month">
										<?php echo date('n月',$value['date']); ?></div>
									<div class="date_day">
									<?php echo date('j',$value['date']); ?></div>
								</td>
								<td width="10"></td>
								<td valign="top" class="item_titles">
									<div class="item_title1">
										<?php echo $topFlg; ?><a href="./?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a>
									</div>
									<div class="item_title2">
									<?php if($log_cache_sort[$value['logid']]): ?>
									Filed Under <span class="sort"><a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a></span>

	<?php endif;?>
										Post on <?php echo date('Y-n-j G:i l', $value['date']); ?></i>
									</div>
									<div class="item_text">
										<?php echo $value['log_description']; ?>
		<p>
		<?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?></p>
		<p>
		<?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?>
	</p>
		
									</div>
									<div style="clear:both"></div>
									<div class="item_panel">
										<div class="panel_links">
											<table>
												<tr>
													<td width="330">
														<span class="read">
															<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
														</span>
														&nbsp;&nbsp;
														<span class="comm">
															<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 					</span>
													</td>
													<td>
														<span class="comm">
															<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a></span>
													</td>
												</tr>
											</table>
										</div>
									</div>
								</td>
							</tr>
						</table>
				<br />
				<br />
<?php endforeach; ?>
	<div class="navigation">
		<div id="pageurl"><?php echo $page_url;?></div>
		</div>
				</div>
                <br />
			</td>
		<td valign="top" id="blog_right">
						<div id="blog_right_top">
				</div>
				<div id="blog_right_pad">
						<div id="sidebar">
		<ul>
<?php 
include getViews('side');
include getViews('footer'); ?>