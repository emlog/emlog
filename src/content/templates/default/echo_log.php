<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
<div id="contentleft">
	<h2><?php topflg($top); ?><?php echo $log_title; ?></h2>
	<p class="date">作者：<?php blog_author($author); ?> 发布于：<?php echo gmdate('Y-n-j G:i l', $date); ?> 
	<?php blog_sort($sortid, $logid); ?> <?php editflg($logid,$author); ?>
	</p>
	<?php echo $log_content; ?>
	<p class="att"><?php blog_att($logid); ?></p>
	<p class="tag"><?php blog_tag($logid); ?></p>
	<?php doAction('log_related'); ?>
	<div class="nextlog"><?php neighbor_log($neighborLog); ?></div>
	<?php blog_trackback($tb, $tb_url, $allow_tb); ?>
	<?php blog_comments($comments); ?>
	<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
	<div style="clear:both;"></div>
</div>
<!--end content-->
<?php
 include View::getView('side');
 include View::getView('footer');
?>