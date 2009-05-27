<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
 <div id="main"><div id="main-block">
 <div id="content">
    	  <ul>
  	    <li class="post" id="post-1">
      		<div class="content">
        <div class="title">
    	    <h2><?php topflg($top); ?><?php echo $log_title;?></h2>
        </div>
	<div class="postdata">
  	post by <?php blog_author($author); ?> / <?php echo date('Y-n-j G:i l', $date); ?> <?php blog_sort($sortid, $logid); ?>
        </div><!--.postdata-->
		<div class="entry">
		    <p><div class="log_desc"> <?php echo $log_content; ?></div>
			<p><?php blog_att($logid); ?></p>
			<p><?php blog_tag($logid); ?></p></p>
		</div>
     		  </div>
      		<div class="footer"></div>
		<div class="nextlog"><?php neighbor_log(); ?></div>		
	</li>
  	<li class="post">
	<div class="content">
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
	</div>
  	<div class="footer"></div>
  	</li>
  	<?php blog_trackback(); ?>
</ul>
  </div>
</div>

<?php
include getViews('side'); 
include getViews('footer'); 
?>
