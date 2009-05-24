 <div id="main"><div id="main-block">
    <div id="content">
    	            <ul>
<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value):
?>
            	                	
                                    
                                    <li class="post" id="post-1">
                		<div class="content">
                            <div class="title">
                        	    <h2><?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a></h2>
                            </div>
                            <div class="postdata">
                                <span class="category">	<?php if($log_cache_sort[$value['logid']]): ?>
	<span>[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sortid']; ?>"><?php echo $log_cache_sort[$value['logid']]; ?></a>]</span>
	<?php endif;?></span>
                                
                                <span class="comments">
                                <a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>
                                <a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                                <a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a></span>
                                <span class="date"><?php echo date('Y-n-j G:i l', $value['date']); ?></span>
                            </div><!--.postdata-->
                    		<div class="entry">
                    		   	<p id="date"></p>
	<div class="log_desc"><?php echo $value['log_description']; ?></div>
	<p><?php blog_att($value['logid']); ?></p>
	<p><?php blog_tag($value['logid']); ?></p>
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