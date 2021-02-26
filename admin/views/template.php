<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
<!--vot--><?php if (isset($_GET['activated'])): ?><div class="alert alert-success"><?=lang('template_change_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['activate_install'])): ?><div class="alert alert-success"><?=lang('template_upload_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['activate_del'])): ?><div class="alert alert-success"><?=lang('template_delete_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger"><?=lang('template_delete_failed')?></div><?php endif; ?>
<!--vot--><?php if (!$nonceTplData): ?><div class="alert alert-danger"><?=lang('template_current_use')?>(<?php echo $nonce_templet; ?>) <?=lang('template_damaged')?></div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('template_manager')?></h1>
<!--vot--><a href="./template.php?action=install" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="far fa-edit"></i> <?=lang('template_add')?></a>
    </div>
    <div class="card-columns">
        <?php foreach ($tpls as $key => $value): ?>
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

<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
    $("#menu_tpl").addClass('active');
</script>
