<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
			<div class="post" id="post-1">
				
				<div class="post-title">
					<h2><?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a></h2>
					<h3>Posted on <?php echo date('Y-n-j G:i l', $value['date']); ?> 
					  | <?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?></h3>
				</div>

				<div class="post-content">
					<?php echo $value['log_description']; ?>
				</div>
	<p><?php blog_att($value['logid']); ?></p>
	<span><?php blog_tag($value['logid']); ?></span>
	<div class="post-p"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a></div>
			</div>
<?php endforeach; ?>
<div id="pageurl">
<?php echo $page_url;?></div>
</div>
<ul id="sidebar">
<?php
include getViews('side');
 include getViews('footer'); ?>