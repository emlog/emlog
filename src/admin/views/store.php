<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle"><b><?=lang('app_center')?></b>
<div class=line></div>
<iframe src="<?php echo OFFICIAL_SERVICE_HOST;?>store/<?php echo Option::EMLOG_VERSION; ?>/<?php echo $site_url_encode; ?>" id="main" name="main" width="100%" height="910" frameborder="0" scrolling="yes" style="overflow: visible;display:"></iframe>
<script>
$("#menu_category_sys").addClass('active');
$("#menu_sys").addClass('in');
$("#menu_store").addClass('active');
</script>
