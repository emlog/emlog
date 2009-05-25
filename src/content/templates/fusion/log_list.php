<div id="main-content">
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>	
<div class="post hentry category-uncategorized" id="post-1">
<h2>
	<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
</h2>
<div class="postheader">
<div class="postinfo">
<p>
	post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?>
	<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
</p>
</div>
</div>
<div class="postbody entry">
	<div class="log_desc"><div style="width:610px; overflow:hidden;"><?php echo $value['log_description']; ?></div></div>
	<p><?php blog_att($value['logid']); ?></p>
	<p class="tags"><?php blog_tag($value['logid']); ?></p>
</div>
<p class="postcontrols">
<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
</p>
<br clear="all" />
</div>
<?php endforeach; ?>
<div id="pageurl"><?php echo $page_url;?></div>
</div>
</div>
</div>
<?php 
include getViews('side');
include getViews('footer'); 
?>