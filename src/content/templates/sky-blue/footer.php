<?php 
/*
* 底部信息
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="clear"></div>
	<div id="footer">
	<p>Powered by <a href="http://www.emlog.net" title="emlog <?php echo Option::EMLOG_VERSION;?>">emlog</a> <a href="<?php echo BLOG_URL; ?>" title="<?php echo $blogname; ?>"><?php echo $blogname; ?></a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> Designed By <a href="http://thinkclay.com" title="Clayton McIlrath">Clayton McIlrath</a> <?php doAction('index_footer'); ?></p>
	</div>
</body>
</html>