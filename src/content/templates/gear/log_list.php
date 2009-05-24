			<div class="content span-24">
				<div class="posts span-17 last">

					<div class="paddings">
						<ul class="items">





<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>

																					<li>
																<h2>
<?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a>
																	</h2>
								<div class="info">
                                								<span class="cat"><?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?></span>
																	</div>

								<div class="paddings-p"><?php echo $value['log_description']; ?></div>
								<p><?php blog_att($value['logid']); ?></p>
								<div class="clear"></div>
								<div class="info">
                                <span class="tag "><?php blog_tag($value['logid']); ?></span><br />
                                <span class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></span>
									<span class="comment">
											<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>

									</span>

							</div>								
															</li>	
   <div class="clear"></div>    
<?php endforeach; ?>
											
<li>
<div class="navigation">
<?php echo $page_url;?>
<div class="clear"></div>
</div>
</li>


</ul>
</div>
</div>

<div class="sidebar span-7 last">
<div class="paddings">
                
<?php
include getViews('side');
include getViews('footer'); ?>