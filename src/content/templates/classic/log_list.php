<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
foreach($logs as $value):
?>
	<div class="logcontent">
	<div id="t">
	<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a>
	<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
	</div>
	<p id="date">post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?></p>
	<div class="log_desc"><?php echo $value['log_description']; ?></div>
	<p><?php blog_att($value['logid']); ?></p>
	<p><?php blog_tag($value['logid']); ?></p>
	
	<div align="right">
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
	</div>
	</div>
<?php endforeach; ?>

<div id="pageurl"><?php echo $page_url;?></div>
<?php include getViews('footer'); ?>