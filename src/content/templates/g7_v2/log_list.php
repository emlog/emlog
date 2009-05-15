<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"".CERTEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  alt=\"置顶日志\" />" : '';
?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo date('j', $value['date']); ?>th</p>
	  <p class="year"><?php echo date('Y', $value['date']); ?></p>
	</div>
	<div class="posttitle">
    <h2>
<?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
	</h2>
    <p class="postmeta">
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>">浏览人次(<?php echo $value['views'];?>)</a>
 	<?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort"><a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>">[<?php echo $log_cache_sort[$value['logid']]; ?>]</a></span>
	<?php endif;?>
	<span class="comment"><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid'];?>#comment">评论:<?php echo $value['comnum'];?></a></span>
</p>
</div>
<div class="content">
	<p><?php echo $value['log_description'];?></p>
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
	<p><?php echo $value['tag'];?></p>
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