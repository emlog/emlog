<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<div class="post" id="post-1">
	<div class="post-title">
	<h2><?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
	<h3>post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> | 
	<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span> 
	<?php editflg($value['logid'],$value['author']); ?>
	</h3>
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