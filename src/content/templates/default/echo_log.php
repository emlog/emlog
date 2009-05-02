<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="content">
<ul>
<li>
	<h2 class="content_h2"><?php echo $log_title; ?></h2>
	<?php if($log_cache_sort[$logid]): ?>
	<div class="act">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</div>
	<?php endif;?>
	<div class="clear"></div>
	<div class="post"><?php echo $log_content; ?></div>
	<div><?php blog_att($logid); ?></div>

	<div class="under">
		<div class="top"></div>
		<div class="under_p">
		<div class="tag"><?php blog_tag($logid); ?></div>
		<div class="date"><span>作者:</span><a href="#">小抽风</a> <?php echo date('Y-n-j G:i l', $date); ?></div>
		<div>&nbsp;</div>
		</div>
		<div class="bottom"></div>
	</div>
	<?php neighbor_log(); ?>
	<?php blog_trackback(); ?>

	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</li>
</ul>
</div>
<!--end content-->
<?php 
include getViews('side');
include getViews('footer'); 
?>