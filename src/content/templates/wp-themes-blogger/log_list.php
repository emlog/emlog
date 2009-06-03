<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
 <div class="excrept_post">
    <div class="excrept_in">
    <!-- Thumbnail from Custom Field, Post first image or default thumbnail -->
            <div class="the_excrept">
            <h2 class="hte_excrept_h2">
			<?php topflg($value['top']); ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
			</h2>
	<span class="sort"><?php blog_sort($value['sortid'], $value['logid']); ?> <?php editflg($value['logid'],$value['author']); ?></span> 
    <div class="clear"></div>
            <div class="excrept_post_p"><?php echo $value['log_description']; ?></div>
            	<div><?php blog_att($value['logid']); ?></div>
				<div><?php blog_tag($value['logid']); ?></div>
        </div>
        <div class="clear"></div>
        <div class="excrept_data">
            <div class="excrept_left">
				post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?>
			   </div>
            <div class="excrept_right">
                <div class="excrept_but">
                   <a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>  </div>
                <div class="excrept_but">
                   <a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
                </div>
                <div class="excrept_but">
                  <a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                </div>
            </div>
        <div class="clear"></div>
        </div>
    </div>
</div>


    
<?php endforeach; ?>
    
    <div class="pagenavigation">
		<div class="navleft"><?php echo $page_url;?></div>
    <div class="clear"></div>
    </div>

            </div>

                            <div id="sidebar"><!-- Sidebar Start Here -->
                <div id="sidebar_in">
<?php 
	include getViews('side');
	include getViews('footer'); 
?>