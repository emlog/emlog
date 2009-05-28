<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!--博客说明或者当前所在位置-->
<div id="center_small">
	<div class="clear"></div>
	<div id="day_text">
        您的位置：<a href="<?php echo BLOG_URL; ?>">首页</a>>
		<?php if($log_cache_sort[$logid]): ?>
         <a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sortid; ?>"><?php echo $log_cache_sort[$logid]; ?></a>
		<?php endif;?> > 
        <?php echo $log_title; ?>
    </div>
    <div id="header_right_bottom">
    </div>
</div>
<div class="clear"></div>
<!--页面中部-->
<div id="center_box">
<!--页面左侧日志部分-->
	<div id="left_box">
    	<div class="note_box">
    		<div class="note_title">
        	<?php topflg($top); ?><?php echo $log_title; ?>
        	</div>
        	<div class="note_content">
       			<?php echo $log_content; ?>
			<p><?php blog_att($logid); ?></p>
			<p><?php blog_tag($logid); ?></p>
			<?php doAction('log_related'); ?>
        	</div>
            <div class="note_tag">
                <div class="note_tag_text1">
            	post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?> 
				<?php blog_sort($sortid, $logid); ?>
            	</div>           
        	</div>
			<?php blog_trackback(); ?>
            <div class="note_tag_2" style="margin-top:10px;"><?php neighbor_log(); ?></div>
        </div>
<!--评论-->       
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>       
       
    </div>
<!--页面右侧部分-->
    <div id="right_box">
        <div id="sear_box">
         <form id="searchform" name="keyform" method="get" action="<?php echo BLOG_URL; ?>">
         <div id="sear_box_left">
        	<input type="text" name="keyword" style="width:195px; height:15px; border:#E2E5EA solid 1px;" />
         </div>
         <div id="sear_box_right">
         <input type="submit" style="width:50px; height:20px; border:#E2E5EA solid 1px; font-size:12px; background-color:#f1f1f1;" value="搜索" />
         </div>
        </form>
        </div>
        <div id="side_box">
        <?php include getViews('side'); ?>
        </div>
    </div>
<div class="clear"></div>
</div>
<div class="clear"></div>
<?php include getViews('footer'); ?>