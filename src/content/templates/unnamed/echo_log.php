<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="content">
	<div class="post" id="post-<?php echo $logid; ?>">
		<h2><?php echo $log_title; ?></h2>
		<div class="post-meta"><?php blog_author($author); ?><?php blog_sort($logid); ?> / <?php echo gmdate('Y年n月j日 H:i', $date); ?> <?php editflg($logid,$author); ?></div>
		<div class="log">
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
		</div>
		<?php blog_tag($logid); ?>
		<div class="neighborlog"><?php neighbor_log($neighborLog); ?></div>
		<?php doAction('log_related', $logData); ?>
		<div style="clear:both"></div>
		<div class="wumii-hook">
    		<input type="hidden" name="wurl" value="<?php echo Url::log($logid); ?>" />
    		<input type="hidden" name="wtitle" value="<?php echo $log_title; ?>" />
		</div>
		<script>
    		var wumiiSitePrefix = "<?php echo BLOG_URL; ?>";
		</script>
		<script type="text/javascript" id="wumiiRelatedItems" src="http://widget.wumii.com/ext/relatedItemsWidget.htm?type=1&amp;mode=1&amp;num=9"></script>
		<a href="http://www.wumii.com/widget/relatedItems.htm" style="border:0;">
    		<img src="http://static.wumii.com/images/pixel.png" alt="无觅相关文章插件" style="border:0;padding:0;margin:0;" />
		</a>
	</div>
	<div class="post" id="comments">
		<?php blog_comments($comments); ?>
		<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		<?php blog_trackback($tb, $tb_url, $allow_tb); ?>
	</div>
</div><!--end content-->
<?php include View::getView('side'); include View::getView('footer'); ?>