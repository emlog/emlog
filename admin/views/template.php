<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('template_change_ok')?></div><?php endif; ?>
<?php if (isset($_GET['activate_install'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('template_upload_ok')?></div><?php endif; ?>
<?php if (isset($_GET['activate_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('template_delete_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_f'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_delete_failed')?></div><?php endif; ?>
<?php if (!$nonceTplData): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_current_use')?>(<?php echo $nonce_templet; ?>) <?=lang('template_damaged')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_zip_support')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_not_writable')?></div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_select_zip')?></div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_non_standard')?></div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">
<!--vot-->  <?=lang('template_no_zip')?>
<!--vot-->  <?=lang('template_install_prompt1')?>
<!--vot-->  <?=lang('template_install_prompt2')?>
    </div>
<?php endif; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('template_manager')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?=lang('template_add')?></a>
</div>
<div class="card-columns">
	<?php foreach ($tpls as $key => $value): ?>
        <div class="card">
            <div class="card-header <?php if ($nonce_templet == $value['tplfile']) {echo "bg-success text-white";} ?>">
                <?php echo $value['tplname']; ?>
            </div>
            <div class="card-body">
                <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>">
                    <img class="card-img-top" src="<?php echo TPLS_URL . $value['tplfile']; ?>/preview.jpg" alt="Card image cap">
                </a>
            </div>
            <div class="card-footer">
<!--vot-->      <a class="badge badge-danger" href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl', '<?php echo LoginAuth::genToken(); ?>');"><?=lang('delete')?></a>
            </div>
        </div>
	<?php endforeach; ?>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('template_install')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div>
<!--vot-->              <p><?=lang('template_upload_prompt')?></p>
                        <p>
                            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                            <input name="tplzip" type="file"/>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
<!--vot-->          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('upload')?></button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
    $("#menu_tpl").addClass('active');
</script>
