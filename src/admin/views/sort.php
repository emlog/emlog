<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<script>setTimeout(hideActived, 2600);</script>
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
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
<!--vot--><h1 class="h3 mb-2 text-gray-800"><?=lang('category_management')?></h1>
    <form method="post" action="sort.php?action=taxis">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
<!--vot-->      <h6 class="m-0 font-weight-bold text-primary"><?=lang('category_management')?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="adm_sort_list">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
<!--vot-->                  <th><?=lang('order')?></th>
<!--vot-->                  <th><?=lang('id')?></th>
<!--vot-->                  <th><?=lang('name')?></th>
<!--vot-->                  <th><?=lang('description')?></th>
<!--vot-->                  <th><?=lang('alias')?></th>
<!--vot-->                  <th><?=lang('template')?></th>
<!--vot-->                  <th><?=lang('views')?></th>
<!--vot-->                  <th><?=lang('posts')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($sorts):
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
                                    <td class="tdcenter">
                                        <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                                    </td>
                                    <td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                                    <td>
<!--vot-->                              <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?=lang('edit')?></a>
<!--vot-->                              <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken();` ?>');" class="care"><?=lang('delete')?></a>
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
                                        <td class="tdcenter">
                                            <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                                        </td>
                                        <td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                                        <td>
<!--vot-->                                  <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?=lang('edit')?></a>
<!--vot-->                                  <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach;
                        else: ?>
                            <tr>
<!--vot-->                      <td class="tdcenter" colspan="8"><?=lang('categories_no')?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="list_footer">
<!--vot-->  <input type="submit" value="<?=lang('order_change')?>" class="btn btn-primary">
<!--vot-->  <a href="javascript:displayToggle('sort_new', 2);" class="btn btn-success"><?=lang('category_add')?>+</a>
        </div>
    </form>
    <form action="sort.php?action=add" method="post" id="sort_new" style="margin-top: 30px;">
        <div class="form-group">
<!--vot-->  <label for="sortname"><?=lang('category_name')?></label>
            <input class="form-control" id="sortname" name="sortname">
        </div>
        <div class="form-group">
<!--vot-->  <label for="alias"><?=lang('alias_info')?></label>
            <input class="form-control" id="alias" name="alias">
<!--vot-->  <small class="form-text text-muted"><?=lang('alias_prompt')?></small>
        </div>
        <div class="form-group">
<!--vot-->  <label><?=lang('category_parent')?></label>
            <select name="pid" id="pid" class="form-control">
<!--vot-->      <option value="0"><?=lang('no')?></option>
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
<!--vot-->  <label for="template"><?=lang('template')?></label>
            <input class="form-control" id="template" name="template">
<!--vot-->  <small class="form-text text-muted"><?=lang('template_info')?></small>
        </div>
        <div class="form-group">
            <label for="alias"><?=lang('category_description')?></label>
            <textarea name="description" type="text" class="form-control"></textarea>
        </div>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot--><button type="submit" id="addsort" class="btn btn-primary"><?=lang('submit')?></button>
        <span id="alias_msg_hook"></span>
    </form>
</div>
<!-- /.container-fluid -->
<script>
    $("#sort_new").css('display', $.cookie('em_sort_new') ? $.cookie('em_sort_new') : 'none');
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
</script>
