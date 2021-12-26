<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activate_install'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('plugin_upload_ok')?></div><?php endif ?>
<?php if (isset($_GET['active'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('plugin_active_ok')?></div><?php endif ?>
<?php if (isset($_GET['activate_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif ?>
<?php if (isset($_GET['active_error'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_active_failed')?></div><?php endif ?>
<?php if (isset($_GET['inactive'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('plugin_disable_ok')?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_delete_failed')?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_not_writable')?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_zip_nonsupport')?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_zip_select')?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_wrong_format')?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('plugin_zipped_only')?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('plugin_manage')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?=lang('plugin_new_install')?></a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                <tr>
<!--vot-->          <th><?=lang('plugin_name')?></th>
<!--vot-->          <th><?=lang('plugin_status')?></th>
<!--vot-->          <th><?=lang('description')?></th>
<!--vot-->          <th><?=lang('version')?></th>
<!--vot-->          <th><?=lang('operation')?></th>
                </tr>
                </thead>
                <tbody>
				<?php
				if ($plugins):
					$i = 0;
					foreach ($plugins as $key => $val):
						$plug_state = 'inactive';
						$plug_action = 'active';
/*vot*/                                 	$plug_state_des = lang('plugin_active_click');
						if (in_array($key, $active_plugins)) {
							$plug_state = 'active';
							$plug_action = 'inactive';
/*vot*/                                         	$plug_state_des = lang('plugin_disable_click');
						}
						$i++;
						if (TRUE === $val['Setting']) {
/*vot*/                                         	$val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"".lang('plugin_settings_click')."\">{$val['Name']}</a>";
						}
						?>
                        <tr>
                            <td><?= $val['Name'] ?></td>
                            <td id="plugin_<?= $i ?>">
                                <a href="./plugin.php?action=<?= $plug_action ?>&plugin=<?= $key ?>&token=<?= LoginAuth::genToken() ?>"><img
                                            src="./views/images/plugin_<?= $plug_state ?>.gif" title="<?= $plug_state_des ?>"></a>
                            </td>
                            <td>
								<?= $val['Description'] ?>
<!--vot-->                      <?php if ($val['Url'] != ''): ?><a href="<?= $val['Url'] ?>" target="_blank"><?=lang('more_info')?></a><?php endif ?>
                                <div class="small mt-3">
<!--vot-->                          <?php if ($val['ForEmlog'] != ''): ?><?=lang('ok_for_emlog')?>: <?= $val['ForEmlog'] ?>&nbsp | &nbsp<?php endif ?>
									<?php if ($val['Author'] != ''): ?>
<!--vot-->                              <?=lang('user')?>: <?php if ($val['AuthorUrl'] != ''): ?>
                                            <a href="<?= $val['AuthorUrl'] ?>" target="_blank"><?= $val['Author'] ?></a>
										<?php else: ?>
											<?= $val['Author'] ?>
										<?php endif ?>
									<?php endif ?>
                                </div>
                            </td>
                            <td><?= $val['Version'] ?></td>
                            <td>
<!--vot-->                      <a href="javascript: em_confirm('<?= $key ?>', 'plu', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?=lang('delete')?></a>
                            </td>
                        </tr>
					<?php endforeach; else: ?>
                    <tr>
<!--vot-->              <td colspan="5"><?=lang('plugin_no_installed')?></td>
                    </tr>
				<?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('plugin_install')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="plugin_new" class="form-group">
<!--vot-->              <li><?=lang('upload_install_info')?></li>
                        <li>
                            <input name="pluzip" type="file"/>
                        </li>
                    </div>
                </div>
                <div class="modal-footer">
<!--vot-->          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('upload')?><button>
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_ext").addClass('active');
    $("#menu_ext").addClass('show');
    $("#menu_plug").addClass('active');
</script>
