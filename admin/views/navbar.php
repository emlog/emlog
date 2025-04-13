<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改导航成功</div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加导航成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">导航名称和地址不能为空</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">默认导航不能删除</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">请选择要添加的分类</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">请选择要添加的页面</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">导航</h1>
    <div class="mt-4">
        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#customNavModal">
            <i class="icofont-plus mr-1"></i>自定义导航
        </a>
        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#sortNavModal">
            <i class="icofont-plus mr-1"></i>添加分类
        </a>
        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#pageNavModal">
            <i class="icofont-plus mr-1"></i>添加页面
        </a>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="navbar.php?action=taxis" id="navi_form" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTable">
                    <thead>
                        <tr>
                            <th>导航</th>
                            <th>类型</th>
                            <th>查看</th>
                            <th>地址</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($navis):
                            foreach ($navis as $key => $value):
                                if ($value['pid'] != 0) {
                                    continue;
                                }
                                $value['type_name'] = '';
                                switch ($value['type']) {
                                    case Navi_Model::navitype_home:
                                    case Navi_Model::navitype_t:
                                    case Navi_Model::navitype_admin:
                                        $value['type_name'] = '系统';
                                        $value['url'] = '/' . $value['url'];
                                        break;
                                    case Navi_Model::navitype_sort:
                                        $value['type_name'] = '<span class="text-primary">分类</span>';
                                        break;
                                    case Navi_Model::navitype_page:
                                        $value['type_name'] = '<span class="text-success">页面</span>';
                                        break;
                                    case Navi_Model::navitype_custom:
                                        $value['type_name'] = '<span class="text-danger">自定</span>';
                                        break;
                                }
                                doAction('adm_navi_display');

                        ?>
                                <tr style="cursor: move">
                                    <td>
                                        <input type="hidden" name="navi[]" value="<?= $value['id'] ?>" />
                                        <a href="navbar.php?action=mod&amp;navid=<?= $value['id'] ?>"><?= $value['naviname'] ?></a>
                                    </td>
                                    <td><?= $value['type_name'] ?></td>
                                    <td>
                                        <a href="<?= $value['url'] ?>" target="_blank">
                                            <img src="./views/images/<?= $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif' ?>" />
                                        </a>
                                    </td>
                                    <td><?= $value['url'] ?></td>
                                    <td>
                                        <?php if ($value['hide'] == 'n'): ?>
                                            <a href="navbar.php?action=hide&amp;id=<?= $value['id'] ?>"
                                                class="badge badge-primary">显示</a>
                                        <?php else: ?>
                                            <a href="navbar.php?action=show&amp;id=<?= $value['id'] ?>"
                                                class="badge badge-warning">隐藏</a>
                                        <?php endif ?>
                                        <?php if ($value['isdefault'] == 'n'): ?>
                                            <a href="javascript: em_confirm(<?= $value['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');"
                                                class="badge badge-danger">删除</a>
                                        <?php endif ?>
                                    </td>
                                </tr>
                                <?php
                                if (!empty($value['childnavi'])):
                                    foreach ($value['childnavi'] as $val):
                                ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="navi[]" value="<?= $val['id'] ?>" />
                                                ----
                                                <a href="navbar.php?action=mod&amp;navid=<?= $val['id'] ?>"><?= $val['naviname'] ?></a>
                                            </td>
                                            <td><?= $value['type_name'] ?></td>
                                            <td>
                                                <a href="<?= $val['url'] ?>" target="_blank">
                                                    <img src="./views/images/<?= $val['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif' ?>" /></a>
                                            </td>
                                            <td><?= $val['url'] ?></td>
                                            <td>
                                                <?php if ($val['hide'] == 'n'): ?>
                                                    <a href="navbar.php?action=hide&amp;id=<?= $val['id'] ?>"
                                                        class="badge badge-primary">显示</a>
                                                <?php else: ?>
                                                    <a href="navbar.php?action=show&amp;id=<?= $val['id'] ?>"
                                                        class="badge badge-warning">隐藏</a>
                                                <?php endif ?>
                                                <?php if ($val['isdefault'] == 'n'): ?>
                                                    <a href="javascript: em_confirm(<?= $val['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');"
                                                        class="badge badge-danger">删除</a>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                <?php endforeach;
                                endif ?>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="5">还没有添加导航</td>
                            </tr>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <button type="submit" class="btn btn-sm btn-success">保存拖动排序</button>
            </div>
        </form>
    </div>
</div>

<!-- 自定义导航模态窗口 -->
<div class="modal fade" id="customNavModal" tabindex="-1" role="dialog" aria-labelledby="customNavModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="customNavModalLabel">添加自定义导航</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="navbar.php?action=add" method="post" name="navi" id="navi">
                    <div class="form-group">
                        <label for="naviname">导航名称</label>
                        <input class="form-control" name="naviname" id="naviname" placeholder="导航名称" required />
                    </div>
                    <div class="form-group">
                        <label for="url">导航网址</label>
                        <textarea maxlength="512" class="form-control" placeholder="导航网址" name="url" id="url" required></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" value="y" name="newtab" id="newtab">
                        <label class="form-check-label" for="newtab">新窗口打开</label>
                    </div>
                    <div class="form-group">
                        <label for="pid">父导航</label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0">无</option>
                            <?php
                            foreach ($navis as $key => $value):
                                if ($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                                    continue;
                                }
                            ?>
                                <option value="<?= $value['id'] ?>"><?= $value['naviname'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-sm btn-success">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 分类导航模态窗口 -->
<div class="modal fade" id="sortNavModal" tabindex="-1" role="dialog" aria-labelledby="sortNavModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="sortNavModalLabel">添加分类到导航</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="navbar.php?action=add_sort" method="post" name="navi_sort" id="navi_sort">
                    <?php if ($sorts): ?>
                        <div class="form-group">
                            <?php foreach ($sorts as $key => $value):
                                if ($value['pid'] != 0) {
                                    continue;
                                }
                            ?>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" name="sort_ids[]" value="<?= $value['sid'] ?>" id="sort_<?= $value['sid'] ?>">
                                    <label class="custom-control-label" for="sort_<?= $value['sid'] ?>"><?= $value['sortname'] ?></label>
                                </div>
                                <?php
                                $children = $value['children'];
                                foreach ($children as $key):
                                    $value = $sorts[$key];
                                ?>
                                    <div class="custom-control custom-checkbox mb-2 ml-4">
                                        <input type="checkbox" class="custom-control-input" name="sort_ids[]" value="<?= $value['sid'] ?>" id="sort_<?= $value['sid'] ?>">
                                        <label class="custom-control-label" for="sort_<?= $value['sid'] ?>"><?= $value['sortname'] ?></label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer border-0">
                            <a class="btn btn-sm btn-link mr-auto" href="sort.php">+新建分类</a>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-sm btn-success">保存</button>
                        </div>
                    <?php else: ?>
                        <div>
                            还没有分类，<a href="sort.php">新建分类</a>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 页面导航模态窗口 -->
<div class="modal fade" id="pageNavModal" tabindex="-1" role="dialog" aria-labelledby="pageNavModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="pageNavModalLabel">添加页面到导航</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="navbar.php?action=add_page" method="post" name="navi_page" id="navi_page">
                    <?php if ($pages): ?>
                        <div class="form-group">
                            <?php foreach ($pages as $key => $value): ?>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" name="pages[<?= $value['gid'] ?>]" value="<?= $value['title'] ?>" id="page_<?= $value['gid'] ?>">
                                    <label class="custom-control-label" for="page_<?= $value['gid'] ?>"><?= $value['title'] ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer border-0">
                            <a class="btn btn-sm btn-link mr-auto" href="page.php?action=new">+新建页面</a>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">取消</button>
                            <button type="submit" class="btn btn-sm btn-success">保存</button>
                        </div>
                    <?php else: ?>
                        <div>
                            还没有页面，<a href="page.php?action=new">新建页面</a>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_navi").addClass('active');

        // 提交表单
        $("#navi_form").submit(function(event) {
            event.preventDefault();
            submitForm("#navi_form");
        });

        // 拖动排序
        $('#dataTable tbody').sortable().disableSelection();
    });
</script>