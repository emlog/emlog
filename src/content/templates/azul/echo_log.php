<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post">
<h2><?php echo $log_title; ?></h2>
<div class="date"><?php echo date('Y-n-j G:i l', $date); ?></div>
<div class="entry">
	<p><?php echo $log_content; ?></p>
	<p>
		<?php 
		$attachment = !empty($log_cache_atts[$logid]) ? '<b>文件附件</b>:'.$log_cache_atts[$logid] : '';
		echo $attachment;
		?>
	</p>
	<p>
		<?php 
		$tag = !empty($log_cache_tags[$logid]) ? '标签:'.$log_cache_tags[$logid] : '';
		echo $tag;
		?>
	</p>
	<p class="postmetadata">
		Filed under&#58;<br />
		<?php if($log_cache_sort[$logid]): ?>
		<span class="sort">[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
		<?php endif;?>
	</p>
</div>

<div class="nextlog">
<?php if($prevLog):?>
	&laquo; <a href="<?php echo BLOG_URL; ?>?post=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
<?php endif;?>
<?php if($nextLog && $prevLog):?>
	|
<?php endif;?>
<?php if($nextLog):?>
	 <a href="<?php echo BLOG_URL; ?>?post=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
<?php endif;?>
</div>

<?php if($allow_tb == 'y'):?>	
<div id="tb_list">
<p><b>引用地址：</b> <input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
</div>
<?php endif; ?>

<?php foreach($tb as $key=>$value):?>
<div class="comments-template">
	<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
	<li>BLOG: <?php echo $value['blog_name'];?></li>
	<li><?php echo $value['date'];?></li>
</div>
<?php endforeach; ?>




</div>
</div>

<?php 
include getViews('side');
include getViews('footer'); 
?>