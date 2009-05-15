<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!--博客说明或者页面当前位置-->
<div id="center_small">
	<div class="clear"></div>
	<div id="day_text">
        <?php echo $bloginfo; ?>
    </div>
    <div id="header_right_bottom">
    </div>
</div>
<div class="clear"></div>
<!--页面中部-->
<div id="center_box">
<!--页面左侧日志部分-->
	<div id="left_box">
<?php
foreach($logs as $value):
$datetime = explode("-",$value['post_time']);
$year = $datetime['0']."/".$datetime['1'];
$day = substr($datetime['2'],0,2);
$topFlg = $value['toplog'] == 'y' ? "<img src=\"".CERTEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  alt=\"置顶日志\" />" : '';
?>
    	<div class="note_box">
    		<div class="note_title">
            <div class="p"></div>
       <?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a>
        	</div>
        	<div class="note_content">
       <?php echo $value['log_description']; ?>
        	</div>
        	<div class="note_tag">
            	<div class="note_tag_text1">
            	<?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort"><a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a></span>
	<?php endif;?>
            	</div>
                <div class="note_tag_text2">
            	<?php echo date('Y-n-j G:i l', $value['date']); ?>
            	</div>
                <div class="note_tag_text3">
            	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment"><?php echo $value['comnum']; ?></a>
            	</div>
                <div class="note_tag_text4">
            	<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['views']; ?></a>
            	</div>    
        	</div>
         </div>
       <?php endforeach; ?>
<!--页码样式--> 
       	<div id="note_page">
        <?php echo $page_url;?>
        </div> 
    </div>
<!--右侧部分sider-->
    <div id="right_box">
        <div id="sear_box">
         <form id="searchform" name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
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