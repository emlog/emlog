<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<!-- Article begin -->
<div class="article">
	<div class="post single">
		<h2><a href="<?php echo Url::log($logid); ?>" title="<?php echo $log_title; ?>"><?php echo $log_title; ?></a></h2>
		<div class="pmeta">
			<?php echo gmdate('Y-m-d', $date); ?> / <?php blog_author($author); ?> / <?php blog_sort($sortid, $logid); ?> 浏览次数:<?php echo $views; ?> / <a href="#comments" class="anchorLink"><?php echo $comnum; ?>个评论</a> / <a href="#respond" class="anchorLink">发表评论</a> <?php editflg($logid,$author); ?>
		</div>
		<!-- Entry begin -->
		<div class="entry">
			<?php echo $log_content; ?>
			<?php blog_att($logid); ?>
		</div>
		<!-- Entry end -->
		<!-- Post Function begin -->
		<div class="postmeta">
			<?php blog_tag($logid); ?>
		</div>
		<!-- Post Function end -->
		<div class="clear"></div>
		<!-- Navigation begin -->
		<div class="postnavi">
			<?php neighbor_log($neighborLog); ?>
			<?php blog_trackback_url($tb_url, $allow_tb); ?>
		</div>
		<!-- Navigation end -->
		<!-- Related Content begin -->
		<div class="related">
			<div class="related_post">
				<h3>相关文章</h3>
				<ul>
				<?php
					$related_logs = related_log_get($logid,$sortid);
					foreach($related_logs as $key=>$value):
					?>
					<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="related_post">
				<h3>随机文章</h3>
				<ul>
				<?php
					$index_randlognum = Option::get('index_randlognum');
					$Log_Model = new Log_Model();
					$randLogs = $Log_Model->getRandLog($index_randlognum);?>
				<?php foreach($randLogs as $value): ?>
				<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php blog_trackback($tb); ?>
			<?php doAction('log_related',$logData); ?>
		</div>
		<!-- Related Content end -->
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
		<!-- Post Comment begin -->
		<div class="post_comment">
			<?php blog_comments($comments,$commentStack,$logid,$params); ?>
			<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
		</div>
		<!-- Post Comment end -->
	</div>
</div>
<!-- Article end -->
<!-- Sidebar begin -->
	<?php  include View::getView('side'); ?>
<!-- Sidebar end -->
<?php include View::getView('footer'); ?>