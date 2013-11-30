<?php 
/*
* 底部信息
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div>
<div style="clear:both;"></div>
<div id="footer">
Powered by <a href="http://www.emlog.net" title="emlog <?php echo Option::EMLOG_VERSION;?>" target="_blank">emlog</a> Designed by <a href="http://www.qiyuuu.com" target="_blank">奇遇</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
<?php doAction('index_footer'); ?>
</div>
</div>
<?php loadJs(); ?>
</body>
</html>