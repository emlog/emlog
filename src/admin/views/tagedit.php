<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!-- Begin Page Content -->
<?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger"><?=lang('tag_empty')?></span><?php endif;?>
<div class="container-fluid">
    <!-- Page Heading -->
<!--vot--><h1 class="h3 mb-2 text-gray-800"><?=lang('tag_edit')?></h1>
    <form method="post" action="tag.php?action=update_tag" class="form-inline">
        <div class="form-group">
            <li><input size="40" value="<?php echo $tagname; ?>" name="tagname" class="form-control"/></li>
            <li style="margin:10px 0px">
                <input type="hidden" value="<?php echo $tagid; ?>" name="tid"/>
<!--vot-->      <input type="submit" value="<?=lang('save')?>" class="btn btn-primary">
<!--vot-->      <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.location='tag.php';">
            </li>
        </div>
    </form>
</div>
<script>
    $("#menu_tag").addClass('active');
</script>
