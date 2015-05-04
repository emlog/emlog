<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>编辑链接</h1>
</section>
<section class="content">
<form action="link.php?action=update_link" method="post">
<div class="item_edit">
<!--vot--><li><input size="40" value="<?php echo $sitename; ?>" class="form-control" name="sitename" /> <?=lang('name')?><span class="required">*</span></li>
<!--vot--><li><input size="40" value="<?php echo $siteurl; ?>" class="form-control" name="siteurl" /> <?=lang('address')?><span class="required">*</span></li>
<!--vot--><li><?=lang('link_description')?><br /><textarea name="description" rows="3" class="form-control" cols="42"><?php echo $description; ?></textarea></li>
    <li>
    <input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
<!--vot--><input type="submit" value="<?=lang('save')?>" class="btn btn-primary" />
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();" /></li>
</div>
</form>
</section>
<script>
$("#menu_link").addClass('active');
</script>
