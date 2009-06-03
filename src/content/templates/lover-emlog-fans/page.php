<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!--博客说明或者当前所在位置-->
<div id="center_small">
	<div class="clear"></div>
	<div id="day_text">
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
        	<?php echo $log_title; ?>
        	</div>
        	<div class="note_content">
       			<?php echo $log_content; ?>
			<p><?php blog_att($logid); ?></p>
        	</div>
        </div>
<!--评论-->       
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>   
       
    </div>
<!--页面右侧部分-->
    <div id="right_box">
        <div id="sear_box">
         <form id="searchform" name="keyform" method="get" action="./">
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