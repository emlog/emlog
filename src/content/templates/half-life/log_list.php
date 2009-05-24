<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="narrowcolumn">
<?php foreach($logs as $value):?>
<div class="post" id="post-<?php echo $value['logid'];?>">
<h2>
	<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
</h2>
<div class="postdate">
post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> 
<?php editflg($value['logid'],$value['author']); ?> 
<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
</div>
<div class="entry">
<?php echo $value['log_description'];?>
<p><?php blog_att($value['logid']); ?></p>
<p><?php blog_tag($value['logid']); ?></p>
<p class="postinfo">
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</p>
</div>
</div>
<?php endforeach; ?>
<div class="browse"><?php echo $page_url;?></div>

</div>
<?php
include getViews('obar');
include getViews('footer');
?>