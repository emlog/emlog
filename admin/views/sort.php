<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('category_update_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('category_deleted_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('category_modify_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('category_add_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('category_name_empty')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('category_no_order')?></div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('alias_format_invalid')?></div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('alias_unique')?></div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('alias_no_keywords')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('category_management')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?=lang('category_add')?></a>
</div>
<form method="post" action="sort.php?action=taxis">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive" id="adm_sort_list">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
<!--vot-->              <th><?=lang('order')?></th>
<!--vot-->              <th><?=lang('name')?></th>
<!--vot-->              <th><?=lang('description')?></th>
<!--vot-->              <th><?=lang('alias')?></th>
<!--vot-->              <th><?=lang('template')?></th>
<!--vot-->              <th><?=lang('view')?></th>
<!--vot-->              <th><?=lang('articles')?></th>
<!--vot-->              <th><?=lang('operation')?></th>
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
                                <input type="hidden" value="<?php echo $value['sid']; ?>" class="sort_id"/>
                                <input class="form-control em-small" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>"/>
                            </td>
                            <td class="sortname">
                                <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a>
                            </td>
                            <td><?php echo $value['description']; ?></td>
                            <td class="alias"><?php echo $value['alias']; ?></td>
                            <td class="alias"><?php echo $value['template']; ?></td>
                            <td>
                                <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                            </td>
                            <td><a href="article.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                            <td>
<!--vot-->                      <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger"><?=lang('delete')?></a>
                            </td>
                        </tr>
						<?php
						$children = $value['children'];
						foreach ($children as $key):
							$value = $sorts[$key];
							?>
                            <tr>
                                <td>
                                    <input type="hidden" value="<?php echo $value['sid']; ?>" class="sort_id"/>
                                    <input class="form-control em-small" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>"/>
                                </td>
                                <td class="sortname">---- <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a></td>
                                <td><?php echo $value['description']; ?></td>
                                <td class="alias"><?php echo $value['alias']; ?></td>
                                <td class="alias"><?php echo $value['template']; ?></td>
                                <td>
                                    <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                                </td>
                                <td><a href="article.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                                <td>
<!--vot-->                          <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');"
                                       class="badge badge-danger"><?=lang('delete')?></a>
                                </td>
                            </tr>
						<?php endforeach; ?>
					<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="list_footer">
<!--vot--><input type="submit" value="<?=lang('order_change')?>" class="btn btn-sm btn-success"/>
    </div>
</form>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('tag_add')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="sort.php?action=add" method="post" id="sort_new">
                <div class="modal-body">
                    <div class="form-group">
<!--vot-->              <label for="sortname"><?=lang('category_name')?></label>
                        <input class="form-control" id="sortname" name="sortname" required>
                    </div>
                    <div class="form-group">
<!--vot-->              <label for="alias"><?=lang('alias_info')?></label>
                        <input class="form-control" id="alias" name="alias">
<!--vot-->              <small class="form-text text-muted"><?=lang('alias_prompt')?></small>
                    </div>
                    <div class="form-group">
<!--vot-->              <label><?=lang('category_parent')?></label>
                        <select name="pid" id="pid" class="form-control">
<!--vot-->                  <option value="0"><?=lang('no')?></option>
							<?php
							foreach ($sorts as $key => $value):
								if ($value['pid'] != 0) {
									continue;
								}
								?>
                                <option value="<?php echo $key; ?>"><?php echo $value['sortname']; ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
<!--vot-->              <label for="template"><?=lang('template')?></label>
                        <input class="form-control" id="template" name="template">
<!--vot-->              <small class="form-text text-muted"><?=lang('template_info')?></small>
                    </div>
                    <div class="form-group">
<!--vot-->              <label for="alias"><?=lang('category_description')?></label>
                        <textarea name="description" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                    <span id="alias_msg_hook"></span>
<!--vot-->          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('save')?></button>
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
<!--vot-->  $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_invalid_characters')?></span>');
        } else if (2 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
<!--vot-->  $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_only_digits')?></span>');
        } else if (3 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
<!--vot-->  $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_system_link')?></span>');
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
