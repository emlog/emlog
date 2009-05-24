<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="maincolumn">
		<div class="clear"></div>		
		<div class="post" id="post-7"><div class="wrapper">

			<div class="postmeta">
				<ul>
					<li><?php echo $log_title;?></li>
				</ul>
			</div>

			<div class="entry">
				<p><?php echo $log_content;?></p>
				<p><?php blog_att($logid); ?></p>
			</div>

		</div></div>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div></div>
<div class="clear"></div>	
</div>
<?php
include getViews('side');
include getViews('footer');
?>