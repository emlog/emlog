<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="maincolumn">
		<div class="clear"></div>		
		<div class="post" id="post-7"><div class="wrapper">

			<div class="postmeta">
				<ul>
					<li>post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?></li>
				</ul>
			</div>

			<h2>
			<?php echo $log_title;?>
			<span class="sort"><?php blog_sort($sortid, $logid); ?></span>
			</h2>

			<div class="entry">
				<p><?php echo $log_content;?></p>
				<p><?php blog_att($logid); ?></p>
				<p><?php blog_tag($logid); ?></p>
				<p><?php neighbor_log(); ?></p>
			</div>

		</div></div>
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div></div>
<div class="clear"></div>	
</div>
<?php
include getViews('side');
include getViews('footer');
?>