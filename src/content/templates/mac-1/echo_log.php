<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="nav">
<ul>
<li class="page_item current_page_item"><a href="./" title="Home">Home</a></li>
</ul>
</div>
<div id="content">
        <div class="post" id="post-$logid">
		  <div class="title">
          <h2><?php topflg($top); ?><?php echo $log_title;?><span class="sort"><?php blog_sort($sortid, $logid); ?></span></h2>
<div class="postdata">
post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?>
</div>
</div>
<div class="entry">
<?php echo $log_content;?>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
<?php doAction('log_related'); ?>
<p><?php neighbor_log(); ?></p>
</div>
	<?php blog_trackback(); ?>
	<?php blog_comments(); ?>
	<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a>
 Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
<?php doAction('index_footer'); ?></div>
</div>
<?php
include getViews('side');
?>