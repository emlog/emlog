<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
 <div class="excrept_post">
    <div class="excrept_in">
    <!-- Thumbnail from Custom Field, Post first image or default thumbnail -->
            <div class="the_excrept">
            <h2 class="hte_excrept_h2"><?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>"><b><?php echo $value['log_title']; ?></b></a></h2>
            <?php if($log_cache_sort[$value['logid']]): ?>
	<span class="sort">[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?>
    <div class="clear"></div>
            <div class="excrept_post_p"><?php echo $value['log_description']; ?></div>
            	<div>
		<?php 
		$attachment = !empty($log_cache_atts[$value['logid']]) ? '<b>文件附件：</b>'.$log_cache_atts[$value['logid']] : '';
		echo $attachment;
		?>
	</div>
	<div>
		<?php 
		$tag  = !empty($log_cache_tags[$value['logid']]) ? '标签:'.$log_cache_tags[$value['logid']] : '';
		echo $tag;
		?>
	</div>
        </div>
        <div class="clear"></div>
        <div class="excrept_data">
            <div class="excrept_left">
               <?php echo $value['post_time']; ?>            </div>
            <div class="excrept_right">
                <div class="excrept_but">
                   <a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>  </div>
                <div class="excrept_but">
                   <a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
                </div>
                <div class="excrept_but">
                  <a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
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