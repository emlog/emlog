<?php 
/*
* 阅读日志页面
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
	<div id="content">
    <div class="top_post"></div>
    <div class="post" id="post-<?php echo $logid; ?>">
    	<div class="byline">
        	<div class="date"><p class="month"><?php echo gmdate('M', $date); ?></p><p class="day"><?php echo gmdate('j', $date); ?></p><p class="year"><?php echo gmdate('Y', $date); ?></p></div>
            <h2 class="title"><?php echo $log_title; ?></h2>
        </div>
        <div class="entry clear">
    		<div class="ad">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-9763798751971937";
/* 内页广告 */
google_ad_slot = "8861160406";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
    		</div>
    		<?php echo $log_content; ?>
    		<?php blog_att($logid); ?>
    		<?php doAction('log_related',$logData); ?>
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
        <div class="meta">
            <p class="tags clear"><?php blog_tag($logid,$params); ?></p>
            <p class="links taginfo"><?php blog_sort($sortid, $logid); ?></p>
    		<?php blog_trackback_url($tb_url, $allow_tb); ?>
    		<?php neighbor_log($neighborLog); ?>
    	</div>
    </div>
    <div class="bottom_post"></div>
	<?php blog_trackback($tb); ?>
	<?php blog_comments($logid,$params); ?>
	<?php blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark); ?>
	</div>
	<!-- end #content -->
	<?php include View::getView('side'); ?>
</div>
<?php include View::getView('footer'); ?>