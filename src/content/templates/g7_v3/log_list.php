<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<h2>
<?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
</h2>
<p class="postdata">post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> 
<?php editflg($value['logid'],$value['author']); ?>
</p>
<div id="content_post">
	<p><?php echo $value['log_description'];?></p>
	<p><?php blog_att($value['logid']); ?></p>
	<p><?php blog_tag($value['logid']); ?></p>
	<p class="tags"><?php echo $value['tag'];?></p>
	<p class="postinfo" >				  
 	<a href="./?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
	</p>
</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>
</div>

<?php
include getViews('side');
include getViews('footer');
?>
