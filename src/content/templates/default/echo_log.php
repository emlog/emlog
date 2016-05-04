<?php 
/**
 * Read the Post page
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="col-md-7 content">
	<h2><?php topflg($top); ?><?= $log_title; ?></h2>
<!--vot--> <p class="date"><?=emdate($date)?>  <?php blog_author($author); ?> <?php blog_sort($logid); ?> <?php editflg($logid,$author); ?></p>
	<?= $log_content; ?>
	<p class="tag"><?php blog_tag($logid); ?></p>
	<?php doAction('log_related', $logData); ?>
	<div class="nextlog"><?php neighbor_log($neighborLog); ?></div>
	<?php blog_comments($comments); ?>
	<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
	<div style="clear:both;"></div>
</div>
<?php
 include View::getView('side');
 include View::getView('footer');
?>