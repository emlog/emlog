<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="content">
    <div class="post" id="post">
        <h1>
		<?php echo $log_title; ?>
		<?php if($log_cache_sort[$logid]): ?>
		<span class="sort">[<a href="./?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>]</span>
		<?php endif;?>
		</h1>
		<p>发布时间 <?php echo date('Y-n-j G:i l', $date); ?></p>
       <div class="post_p"> <?php echo $log_content; ?></div>
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
        <div class="post-info">
          
            <?php if($prevLog):?>
                &laquo; <a href="./?action=showlog&gid=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
            <?php endif;?>
            <?php if($nextLog && $prevLog):?>
                |
            <?php endif;?>
            <?php if($nextLog):?>
                 <a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
            <?php endif;?>
        </div>
    </div>
    
	<?php include getViews('comments'); ?>

</div>

<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>