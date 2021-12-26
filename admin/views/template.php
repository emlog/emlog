<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('template_change_ok')?></div><?php endif ?>
<?php if (isset($_GET['activate_install'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('template_upload_ok')?></div><?php endif ?>
<?php if (isset($_GET['activate_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('template_delete_ok')?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_delete_failed')?></div><?php endif ?>
<?php if (!$nonce_templet_data): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_current_use')?>(<?= $nonce_templet ?>) <?=lang('template_damaged')?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_zip_support')?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_not_writable')?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_select_zip')?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('template_non_standard')?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">
<!--vot-->  <?=lang('template_no_zip')?>
<!--vot-->  <?=lang('template_install_prompt1')?>
<!--vot-->  <?=lang('template_install_prompt2')?>
    </div>
<?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('template_manager')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?=lang('template_add')?></a>
</div>
<div class="row">
	<?php foreach ($tpls as $key => $value): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header <?php if ($nonce_templet == $value['tplfile']) {
					echo "bg-success text-white font-weight-bold";
				} ?>">
					<?= $value['tplname'] ?>
                </div>
                <div class="card-body">
                    <a href="template.php?action=usetpl&tpl=<?= $value['tplfile'] ?>&token=<?= LoginAuth::genToken() ?>">
                        <img class="card-img-top" src="<?= TPLS_URL . $value['tplfile'] ?>/preview.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card-footer">
					<?php if ($value['author']): ?>
<!--vot-->          <div class="small"><?=lang('template_author')?>:
							<?php if ($value['author_url']): ?>
                                <a href="<?= $value['author_url'] ?>" target="_blank"><?= $value['author'] ?></a>
							<?php else: ?>
								<?= $value['author'] ?>
							<?php endif ?>
                    </div>
					<?php endif ?>
                    <div class="small">
						<?= $value['tpldes'] ?>
						<?php if ($value['tplurl']): ?>
<!--vot-->              <a href="<?= $value['tplurl'] ?>" target="_blank"><?=lang('more_info')?></a>
						<?php endif ?>
                    </div>
                    <div class="mt-3">
<!--vot-->              <a class="badge badge-danger" href="javascript: em_confirm('<?= $value['tplfile'] ?>', 'tpl', '<?= LoginAuth::genToken() ?>');"><?=lang('delete')?></a>
                    </div>
                </div>
            </div>
        </div>
	<?php endforeach ?>
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
                            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
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
