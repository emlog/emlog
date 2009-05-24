<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
<DIV class=post id=post-1>
<H2>
<?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</H2>
<p>| <?php echo date('Y-n-j G:i l', $value['date']); ?> 
	<?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?>
</p>
<DIV class="entry">
<P><?php echo $value['log_description'];?></P>
</DIV>
<p><?php blog_att($value['logid']); ?></p>
<p><?php blog_tag($value['logid']); ?></p>
<P class=postmetadata>  
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</P>
</DIV>
<?php endforeach; ?>
<div id="pageurl"> <?php echo $page_url;?></div>
<?php
include getViews('footer');
?>