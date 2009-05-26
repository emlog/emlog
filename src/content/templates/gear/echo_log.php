<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
			<div class="content span-24">
				<div class="posts span-18 last">

					<div class="paddings">
						<ul class="items">
																					<li>
<h2><?php topflg($top); ?><?php echo $log_title;?></h2>
<div class="info">
<span class="date">
post by <?php blog_author($author); ?> / <?php echo date('Y-n-j G:i l', $date); ?> <span class="sort"><?php blog_sort($sortid, $logid); ?></span>
</span>
</div>
<div class="paddings-p"><?php echo $log_content; ?></div>
<p><?php blog_att($logid); ?></p>
<div class="clear"></div>
<div class="info">
<span class="tag "><?php blog_tag($logid); ?></span>	
</div>
<div class="nextlog"><?php neighbor_log(); ?></div>                       
<div class="com">
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
<div class="reply">
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</li>
<li>
								<div class="navigation">
									<div class="fl"></div>
			                        <div class="fr"></div>
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