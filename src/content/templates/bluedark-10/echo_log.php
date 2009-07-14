<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>

<div id="blog"> 
	<div id="blog_top"> 
	<table cellpadding="0" cellspacing="0" width="100%"> 
		<tr> 
			<td valign="top" id="blog_left"> 
				<div id="blog_left_bg"> 
			
				<div class="blog_item"> 
				<table cellpadding="0" cellspacing="0" width="96%" class="blog_item_t"> 
					<tr> 
						<td class="3" height="20">&nbsp;</td> 
					</tr> 
					<tr> 
						<td class="date" valign="top"> 
 
							<div class="datetext"> 
								<?php echo date('n月', $date); ?>	<div class="datetext_number"><?php echo date('j', $date); ?></div> 
							</div> 
						</td> 
						<td valign="top"> 
							<table cellpadding="0" cellspacing="0" width="100%"> 
								<tr> 
 
									<td valign="top" class="titles_bg"> 
										<div class="title" style="font-size:16px;"><?php topflg($top); ?><?php echo $log_title; ?></div> 
										<div class="subtitle">post by <?php blog_author($author); ?> / <?php echo date('Y-n-j G:i l', $date); ?></div> 
									</td> 
								</tr> 
								<tr> 
									<td class="item_line"> 
									</td> 
								</tr> 
								<tr> 
									<td> 
										<div class="text"> 
										<?php echo $log_content; ?> 
                                        	<div class="fujian" style="color:#FF6600;">
											<?php blog_att($logid); ?></div>
	                                           <div class="tag echo_tag" style="color:#FF6600;"><?php blog_tag($logid); ?></div>
										</div> 
									</td> 
								</tr> 
 
								<tr> 
									<td class="panel"> 
										<table class="panel_links" width="100%"> 
											<tr> 
												<td align="left"> 
													&nbsp;&nbsp;
													
		
													&nbsp;&nbsp;
													<span class="comm"> 
														<?php editflg($logid,$author); ?>
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
 
		<?php doAction('log_related'); ?>
	<div class="nextlog" style="clear:both; text-align:center;"><?php neighbor_log(); ?></div>
    	<?php blog_trackback(); ?>
<!-- You can start editing here. --> 
 	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>

 
 
 
 

 
							</div> 
                            </div> 
				
                
                <div class="navigation"> 
					<table width="80%"> 
						<tr> 
							<td width="50%" align="left" class="alignleft_bg"> 
								<div class="alignleft"></div> 
							</td> 
							<td width="50%" align="right" class="alignright_bg"> 
								<div class="alignright"></div> 
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