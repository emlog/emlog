<?php 
/**
 * Page Bottom Information
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
</div><!--end #content-->
<div style="clear:both;"></div>
<div id="footerbar">
<!--vot--> <?=lang('powered_by')?> <a href="http://www.emlog.net" title="<?=lang('powered_by_emlog')?>">emlog</a> v.<?=Option::get('EMLOG_VERSION')?>
<!--vot--> <? if($icp) {?><a href="http://www.miibeian.gov.cn" target="_blank"><?= $icp; ?></a> <?}?><?=$footer_info?>
	<?php doAction('index_footer'); ?>
</div><!--end #footerbar-->
</div><!--end #wrap-->
<script>prettyPrint();</script>
</body>
</html>