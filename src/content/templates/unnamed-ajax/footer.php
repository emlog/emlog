<?php 
/*
* 底部信息
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
if(!$_) {
	//$ajax['content'] = preg_replace('|<img([^>]+)src="([^>\"]+)"([^>]*?)>|is','<img$1src="'.TEMPLATE_URL.'images/grey.gif" original="$2"$3>',$ajax['content']);
	ob_start();
	echo json_encode($ajax);
	View::output();
}
?>
</div>
<div style="clear:both;"></div>
<div id="footer">
Powered by <a href="http://www.emlog.net" title="emlog <?php echo Option::EMLOG_VERSION;?>" target="_blank">emlog</a> Designed by <a href="http://www.qiyuuu.com" target="_blank">奇遇</a> <?php if($icp): ?><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a><?php endif; ?> <?php echo $footer_info; ?>
<?php doAction('index_footer'); ?>
</div>
</div>
<script src="<?php echo TEMPLATE_URL; ?>js.php" type="text/javascript"></script>
</body>
</html>