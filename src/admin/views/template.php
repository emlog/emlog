<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!--vot--><?php if (isset($_GET['activated'])): ?><span class="alert alert-success"><?=lang('template_change_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['activate_install'])): ?><span class="alert alert-success"><?=lang('template_upload_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['activate_del'])): ?><span class="alert alert-success"><?=lang('template_delete_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger"><?=lang('template_delete_failed')?></span><?php endif; ?>
<!--vot--><?php if (!$nonceTplData): ?><span class="alert alert-danger"><?=lang('template_current_use')?>(<?= $nonce_templet ?>) <?=lang('template_damaged')?></span><?php endif; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?=lang('template_manager')?></h1>
        <a href="./template.php?action=install" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="far fa-edit"></i> <?=lang('template_add')?></a>
    </div>
    <div class="card-columns">
        <?php foreach ($tpls as $key => $value):?>
            <div class="card">
                <img class="card-img-top" src="<?php echo TPLS_URL . $value['tplfile']; ?>/preview.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $value['tplname']; ?></h5>
<!--vot-->          <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>"
                       class="btn btn-primary"><?=lang('template_use_this')?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
