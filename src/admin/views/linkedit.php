<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
<!--vot--><h1 class="h3 mb-2 text-gray-800"><?=lang('link_edit')?></h1>
    <form action="link.php?action=update_link" method="post">
        <div class="item_edit">
<!--vot-->  <li><input size="40" value="<?= $sitename ?>" class="form-control" name="sitename"> <?=lang('name')?><span class="required">*</span></li>
<!--vot-->  <li><input size="40" value="<?= $siteurl ?>" class="form-control" name="siteurl"> <?=lang('address')?><span class="required">*</span></li>
<!--vot-->  <li><?=lang('link_description')?><br><textarea name="description" rows="3" class="form-control" cols="42"><?= $description ?></textarea></li>
            <li>
               <input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
<!--vot-->     <input type="submit" value="<?=lang('save')?>" class="btn btn-primary">
<!--vot-->     <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();"></li>
        </div>
    </form>
</div>
<script>
    $("#menu_link").addClass('active');
</script>
