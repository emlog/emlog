<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="logcontent">
<p id="tit"><b><?php topflg($top); ?><?php echo $log_title; ?></b><?php blog_sort($sortid, $logid); ?></p>
<p id="date">post by <?php blog_author($author); ?> /  <?php echo date('Y-n-j G:i l', $date); ?></p>

<div class="log_con">
<?php echo $log_content; ?>
<p><?php blog_att($logid); ?></p>
<p><?php blog_tag($logid); ?></p>
</div>
<div class="nextlog"><?php neighbor_log(); ?></div>
<?php blog_trackback(); ?>
<?php blog_comments(); ?>
<?php if ($allow_remark == 'y'){blog_comments_post();}?>
</div>
<?php include getViews('footer'); ?>