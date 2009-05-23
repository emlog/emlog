<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo date('j', $value['date']); ?>th</p>
	  <p class="year"><?php echo date('Y', $value['date']); ?></p>
	</div>
	<div class="posttitle">
    <h2>
	<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a>
	<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?></span>
	</h2>
    <p class="postmeta">
	作者:<?php blog_author($value['author']); ?>
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
	<?php editflg($value['logid'],$value['author']); ?>
</p>
</div>
<div class="content">
	<p><?php echo $value['log_description'];?></p>
	<p><?php blog_att($value['logid']); ?></p>
	<p><?php blog_tag($value['logid']); ?></p>
	<p class="postinfo">			
</div>
<p>
	
</p>				

</div>
<?php endforeach; ?>
<div class="nav">
<p><?php echo $page_url;?></p>
</div>
</div>
</div>
<?php
include getViews('footer');
?>