<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
    <div class="alert alert-success"><?= lang('category_update_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success"><?= lang('category_deleted_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success"><?= lang('category_modify_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success"><?= lang('category_add_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= lang('category_name_empty') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= lang('category_no_order') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= lang('alias_format_invalid') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= lang('alias_unique') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= lang('alias_no_keywords') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= lang('category_management') ?></h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?= lang('category_add') ?></a>
</div>
<form method="post" action="sort.php?action=taxis">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive" id="adm_sort_list">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><?= lang('name') ?></th>
                        <th><?= lang('description') ?></th>
                        <th><?= lang('category_id') ?></th>
                        <th><?= lang('alias') ?></th>
                        <th><?= lang('template') ?></th>
                        <th><?= lang('view') ?></th>
                        <th><?= lang('articles') ?></th>
                        <th><?= lang('operation') ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					foreach ($sorts as $key => $value):
						if ($value['pid'] != 0) {
							continue;
						}
						?>
                        <tr>
                            <td>
                                <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id"/>
                                <input class="form-control em-small" name="sort[<?= $value['sid'] ?>]" value="<?= $value['taxis'] ?>"/>
                            </td>
                            <td class="sortname">
                                <a href="sort.php?action=mod_sort&sid=<?= $value['sid'] ?>"><?= $value['sortname'] ?></a>
                            </td>
                            <td><?= $value['description'] ?></td>
                            <td><?= $value['sid'] ?></td>
                            <td class="alias"><?= $value['alias'] ?></td>
                            <td>
                                <a href="<?= Url::sort($value['sid']) ?>" target="_blank"><img src="./views/images/vlog.gif"/></a>
                            </td>
                            <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                            <td>
                                <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= lang('delete') ?></a>
                            </td>
                        </tr>
						<?php
						$children = $value['children'];
						foreach ($children as $key):
							$value = $sorts[$key];
							?>
                            <tr>
                                <td>
                                    <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id"/>
                                    <input class="form-control em-small" name="sort[<?= $value['sid'] ?>]" value="<?= $value['taxis'] ?>"/>
                                </td>
                                <td class="sortname">---- <a href="sort.php?action=mod_sort&sid=<?= $value['sid'] ?>"><?= $value['sortname'] ?></a></td>
                                <td><?= $value['description'] ?></td>
                                <td><?= $value['sid'] ?></td>
                                <td class="alias"><?= $value['alias'] ?></td>
                                <td>
                                    <a href="<?= Url::sort($value['sid']) ?>" target="_blank"><img src="./views/images/vlog.gif"/></a>
                                </td>
                                <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                                <td>
                                    <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');"
                                       class="badge badge-danger"><?= lang('delete') ?></a>
                                </td>
                            </tr>
						<?php endforeach ?>
					<?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="list_footer">
        <input type="submit" value="<?= lang('order_change') ?>" class="btn btn-sm btn-success"/>
    </div>
</form>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('tag_add') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="sort.php?action=add" method="post" id="sort_new">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname"><?= lang('category_name') ?></label>
                        <input class="form-control" id="sortname" name="sortname" required>
                    </div>
                    <div class="form-group">
                        <label for="alias"><?= lang('alias_info') ?></label>
                        <input class="form-control" id="alias" name="alias">
                        <small class="form-text text-muted"><?= lang('alias_prompt') ?></small>
                    </div>
                    <div class="form-group">
                        <label><?= lang('category_parent') ?></label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0"><?= lang('no') ?></option>
							<?php
							foreach ($sorts as $key => $value):
								if ($value['pid'] != 0) {
									continue;
								}
								?>
                                <option value="<?= $key ?>"><?= $value['sortname'] ?></option>
							<?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="template"><?= lang('template_name') ?></label>
                        <input class="form-control" id="template" name="template">
                        <small class="form-text text-muted"><?= lang('template_info') ?></small>
                    </div>
                    <div class="form-group">
                        <label for="alias"><?= lang('category_description') ?></label>
                        <textarea name="description" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                    <span id="alias_msg_hook"></span>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(hideActived, 2600);
    $("#alias").keyup(function () {
        checksortalias();
    });

    function issortalias(a) {
        var reg1 = /^[\w-]*$/;
        var reg2 = /^[\d]+$/;
        if (!reg1.test(a)) {
            return 1;
        } else if (reg2.test(a)) {
            return 2;
        } else if (a == 'post' || a == 'record' || a == 'sort' || a == 'tag' || a == 'author' || a == 'page') {
            return 3;
        } else {
            return 0;
        }
    }

    function checksortalias() {
        var a = $.trim($("#alias").val());
        if (1 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_invalid_characters')?></span>');
        } else if (2 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_only_digits')?></span>');
        } else if (3 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_system_link')?></span>');
        } else {
            $("#alias_msg_hook").html('');
            $("#msg").html('');
            $("#addsort").attr("disabled", false);
        }
    }

    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_sort").addClass('active');
</script>
