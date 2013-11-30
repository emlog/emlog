<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="header single">
	<div class="container">
		<h2><?php echo $log_title; ?></h2>
		<div class="post-meta"><?php echo gmdate('Y-n-j G:i l', $date); ?> 作者：<?php blog_author($author); ?> <?php blog_sort($logid); ?> <a href="#comments">评论(<?php echo $comnum; ?>)</a> <a href="#">阅读(<?php echo $views; ?>)</a></div>
	</div>
</div>
<div class="main">
	<div class="content">
		<div class="post">
			<div class="entry">
				<?php echo $log_content; ?>
				<?php blog_att($logid); ?>
			</div>
			<?php blog_tag($logid); ?>
			<?php blog_trackback_url($tb_url, $allow_tb); ?>
			<div class="neighborlog"><?php neighbor_log($neighborLog); ?></div>
			<div class="log-related"><?php doAction('log_related',$logData); ?></div>
			<div class="clear"></div>
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
			<?php blog_trackback($tb); ?>
			<?php blog_comments($comments,$params,$logid); ?>
			<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		</div>
		<?php include View::getView('side'); ?>
	</div>
</div>
<?php include View::getView('footer');?>