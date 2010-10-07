<?php 
/*
* 底部信息
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div class="clear"></div>
<div id="footer">
Powered by <a href="http://www.emlog.net" title="emlog <?php echo Options::EMLOG_VERSION;?>">emlog</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
<?php doAction('index_footer'); ?>
</div>
</div>
</body>
</html>