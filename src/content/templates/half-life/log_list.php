<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="narrowcolumn">
<?php
foreach($logs as $value):
?>
<div class="post" id="post-<?php echo $value['logid'];?>">
<h2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>
<div class="postdate"><?php echo $value['post_time'];?></div>
<div class="entry">
<?php echo $value['log_description'];?>
<p>
	<?php 
	$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
	echo $attachment;
	?>
</p>
<p>
	<?php 
	$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
	echo $tag;
	?>
</p>

<p class="postinfo">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
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