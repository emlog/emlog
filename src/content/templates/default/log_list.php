<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="blog"> 
	<div id="blog_top"> 
	<table cellpadding="0" cellspacing="0" width="100%"> 
		<tr> 
			<td valign="top" id="blog_left"> 
				<div id="blog_left_bg"> 
                
	<?php foreach($logs as $value): ?>
				
				<div class="blog_item"> 
				<table cellpadding="0" cellspacing="0" width="96%" class="blog_item_t"> 
					<tr> 
						<td class="3" height="20">&nbsp;</td> 
					</tr> 
					<tr> 
						<td class="date" valign="top"> 
 
							<div class="datetext"> 
								<?php echo date('n月',$value['date']); ?><div class="datetext_number"><?php echo date('j',$value['date']); ?></div> 
							</div> 
						</td> 
						<td valign="top"> 
							<table cellpadding="0" cellspacing="0" width="100%"> 
								<tr> 
 
									<td valign="top" class="titles_bg"> 
										<div class="title">	<?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></div> 
										<div class="subtitle">post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?></div> 
									</td> 
								</tr> 
								<tr> 
									<td class="item_line"> 
									</td> 
								</tr> 
								<tr> 
									<td> 
										<div class="text"> 
										<?php echo $value['log_description']; ?> 
										</div> 
									</td> 
								</tr> 
 
								<tr> 
									<td class="panel"> 
										<table class="panel_links" width="100%"> 
											<tr> 
												<td width="65%"> 
													<span class="comm"> 
															<a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>										
													</span> 
												</td> 
												<td align="right"> 
													<span class="comm"> 
													<?php editflg($value['logid'],$value['author']); ?>
													</span> 
												</td> 
											</tr> 
										</table> 
									</td> 
								</tr> 
							</table> 
						</td> 
					</tr> 
				</table> 
			</div> 
			<br /> 
			<br /> 
 
<?php endforeach; ?>

	</div> 
				<div class="navigation"> 
					<table width="80%"> 
						<tr> 
							<td width="100%" align="left" class="alignleft_bg"> 
								<div class="alignleft"><?php echo $page_url;?></div> 
							</td> 
						</tr> 
					</table> 
				</div> 
			</td> 
			<td valign="top" id="blog_right"> 
				<div id="blog_right_pad"> 


<?php
 include getViews('side');
 include getViews('footer'); 
?>