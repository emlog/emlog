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
</li>
</ul>
</div>
<!--end content-->
<?php 
include getViews('side');
include getViews('footer'); 
?>