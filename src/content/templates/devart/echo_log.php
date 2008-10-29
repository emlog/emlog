<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="content">
    <div class="post" id="post">
        <h1><?php echo $log_title; ?></h1>
		<p>发布时间 <?php echo $post_time; ?></p>
        <?php echo $log_content; ?>
        <p><?php echo $attachment; ?></p>	
        <p><?php echo $tag; ?></p>
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