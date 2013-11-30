<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
if($_):
?>
<div id="content">
<?php endif; ?>
	<div class="post" id="post-<?php echo $logid; ?>">
		<h2><?php echo $log_title; ?></h2>
		<div class="post-meta"><?php blog_author($author); ?><?php blog_sort($logid); ?> / <?php echo gmdate('Y年n月j日 H:i', $date); ?> <?php editflg($logid,$author); ?></div>
		<div class="log">
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
		</div>
		<?php blog_tag($logid); ?>
		<div class="neighborlog"><?php neighbor_log($neighborLog); ?></div>
		<div style="clear:both"></div>
		<?php doAction('log_related', $logData); ?>
	</div>
	<div class="post" id="comments">
		<?php blog_comments($comments); ?>
		<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		<?php blog_trackback($tb, $tb_url, $allow_tb); ?>
	</div>
<?php if($_): ?>
</div>
<?php include View::getView('side'); else:$ajax['content']=ob_get_clean();ob_start();endif; include View::getView('footer');?>