 <div id="main"><div id="main-block">
    <div id="content">
    	            <ul>
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
            	                	
                                    
                                    <li class="post" id="post-1">
                		<div class="content">
                            <div class="title">
                        	    <h2><?php echo $topFlg; ?><a href="./?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
                            </div>
                            <div class="postdata">
                                <span class="category">	<?php if($log_cache_sort[$value['logid']]): ?>
	<span>[<a href="./?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?></span>
                                
                                <span class="comments">
                                <a href="./?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>
                                <a href="./?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                                <a href="./?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a></span>
                                <span class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></span>
                            </div><!--.postdata-->
                    		<div class="entry">
                    		   	<p id="date"></p>
	<div class="log_desc"><?php echo $value['log_description']; ?></div>
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
                    		</div>
                    		                		</div>
                		<div class="footer"></div>
                	</li>
                    <?php endforeach; ?>

            	             </ul>
             <div class="nav-entries">
        		<?php echo $page_url;?>
			 </div>
            </div><!--#content-->
</div><!--#main-block-->

<?php
include getViews('side');
 include getViews('footer');

 ?>