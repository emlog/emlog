<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
 <div id="main"><div id="main-block">
 <div id="content">
    	  <ul>
  	    <li class="post" id="post-1">
      		<div class="content">
        <div class="title">
    	    <h2><?php echo $log_title; ?></h2>
        </div>
		<div class="entry">
		    <p><div class="log_desc"> <?php echo $log_content; ?></div>
			<p><?php blog_att($logid); ?></p>
		</div>
     		  </div>
      		<div class="footer"></div>
	</li>
  	<li class="post">
	<div class="content">
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
	</div>
  	<div class="footer"></div>
  	</li>
</ul>
  </div><!--#content-->
</div><!--#main-block-->

<?php
include getViews('side'); 
include getViews('footer');
?>