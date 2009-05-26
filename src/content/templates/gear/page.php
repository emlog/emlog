<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
			<div class="content span-24">
				<div class="posts span-18 last">

					<div class="paddings">
						<ul class="items">
																					<li>
<h2><?php echo $log_title;?></h2>
<div class="info">
</div>
<div class="paddings-p"><?php echo $log_content; ?></div>
<p><?php blog_att($logid); ?></p>
<div class="clear"></div>
<div class="info">
</div>
<div class="com">
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
	}
	?>
<div class="reply">
	<?php 
	if ($allow_remark == 'y'){
		blog_comments_post();
	}
	?>
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