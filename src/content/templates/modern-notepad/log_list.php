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
                        	    <h2>
									<?php topflg($value['top']); ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
								</h2>
                            </div>
                            <div class="postdata">
							    post by <?php blog_author($value['author']); ?> / <?php echo date('Y-n-j G:i l', $value['date']); ?> 
                                <?php blog_sort($value['sortid'], $value['logid']); ?>
								<?php editflg($value['logid'],$value['author']); ?>
                            </div><!--.postdata-->
                    		<div class="entry">
                    		   	<p id="date"></p>
								<div class="log_desc"><?php echo $value['log_description']; ?></div>
								<p><?php blog_att($value['logid']); ?></p>
								<p><?php blog_tag($value['logid']); ?></p>
                    		</div>
							   <div class="postdata">
                                <a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>
                                <a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                                <a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
                            </div><!--.postdata-->
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