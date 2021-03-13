<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['active_taxis'])): ?>
        <div class="alert alert-success">排序更新成功</div><?php endif; ?>
    <?php if (isset($_GET['active_del'])): ?>
        <div class="alert alert-success">删除分类成功</div><?php endif; ?>
    <?php if (isset($_GET['active_edit'])): ?>
        <div class="alert alert-success">修改分类成功</div><?php endif; ?>
    <?php if (isset($_GET['active_add'])): ?>
        <div class="alert alert-success">添加分类成功</div><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?>
        <div class="alert alert-danger">分类名称不能为空</div><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?>
        <div class="alert alert-danger">没有可排序的分类</div><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div class="alert alert-danger">别名格式错误</div><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?>
        <div class="alert alert-danger">别名不能重复</div><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?>
        <div class="alert alert-danger">别名不得包含系统保留关键字</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('category_management')?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> 添加分类</a>
    </div>
    <form method="post" action="sort.php?action=taxis">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="badge badge-secondary">已创建的分类</h6>
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
                                <td class="tdcenter"><a href="admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                                <td>
                                    <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">编辑</a>
                                    <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
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
                                    <td class="tdcenter"><a href="admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                                    <td>
                                        <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">编辑</a>
                                        <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
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
            <input type="submit" value="改变排序" class="btn btn-success"/>
        </div>
    </form>
    <!--Add Category popup-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
<!--vot-->          <h5 class="modal-title" id="exampleModalLabel"><?=lang('tag_add')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="sort.php?action=add" method="post" id="sort_new">
                    <div class="modal-body">
                        <div class="form-group">
<!--vot-->                  <label for="sortname"><?=lang('category_name')?></label>
                            <input class="form-control" id="sortname" name="sortname">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('alias_info')?></label>
                            <input class="form-control" id="alias" name="alias">
<!--vot-->                  <small class="form-text text-muted"><?=lang('alias_prompt')?></small>
                        </div>
                        <div class="form-group">
<!--vot-->                  <label><?=lang('category_parent')?></label>
                            <select name="pid" id="pid" class="form-control">
<!--vot-->                      <option value="0"><?=lang('no')?></option>
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
<!--vot-->                  <label for="template"><?=lang('template')?></label>
                            <input class="form-control" id="template" name="template">
<!--vot-->                  <small class="form-text text-muted"><?=lang('template_info')?></small>
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('category_description')?></label>
                            <textarea name="description" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                        <span id="alias_msg_hook"></span>
<!--vot-->              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                </form>
            </div>
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
