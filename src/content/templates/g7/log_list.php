<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<div class="content">
<div class="post">
<h2>
	<?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
</h2>
</div>
<div class="date">
<span class="postdate">post by <?php blog_author($value['author']); ?> <?php echo date('Y-n-j G:i l', $value['date']); ?> <?php editflg($value['logid'],$value['author']); ?></span>
</div>
<div class="mypost">
<?php echo $value['log_description'];?>
	<p><?php blog_att($value['logid']); ?></p>
	<p><?php blog_tag($value['logid']); ?></p>
<p class="postinfo">				  
 	<a href="./?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</p>				
</div>
</div>
<?php endforeach; ?>
<div id="pagenavi"><div class="wp-pagenavi">
<span class="mypost"><?php echo $page_url;?></span>
</div>
</div>

</div>
<?php
include getViews('side');
include getViews('footer');
?>