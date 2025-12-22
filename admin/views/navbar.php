<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success"><?= _lang('edit_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success"><?= _lang('add_success') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= _lang('navi_error_a') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">默认导航不能删除</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">请选择要添加的分类</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= _lang('navi_error_e') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('navbar') ?></h1>
    <div class="mt-4">
        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#customNavModal">
            <i class="icofont-plus mr-1"></i>自定义导航
        </a>
        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#sortNavModal">
            <i class="icofont-plus mr-1"></i><?= _lang('add_category_navi') ?>
        </a>
        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#pageNavModal">
            <i class="icofont-plus mr-1"></i>添加页面导航
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
                            <th><?= _lang('navbar') ?></th>
                            <th><?= _lang('type') ?></th>
                            <th><?= _lang('view') ?></th>
                            <th><?= _lang('address') ?></th>
                            <th><?= _lang('operation') ?></th>
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
                                        $value['type_name'] = EmLang::getInstance()->get('system');
                                        $value['url'] = '/' . $value['url'];
                                        break;
                                    case Navi_Model::navitype_sort:
                                        $value['type_name'] = '<span class="text-primary">' . EmLang::getInstance()->get('category') . '</span>';
                                        break;
                                    case Navi_Model::navitype_page:
                                        $value['type_name'] = '<span class="text-success">' . EmLang::getInstance()->get('page') . '</span>';
                                        break;
                                    case Navi_Model::navitype_custom:
                                        $value['type_name'] = '<span class="text-danger">' . EmLang::getInstance()->get('custom') . '</span>';
                                        break;
                                }
                                doAction('adm_navi_display');

                        ?>
                                <tr style="cursor: move">
                                    <td>
                                        <input type="hidden" name="navi[]" value="<?= $value['id'] ?>" />
                                        <a href="navbar.php?action=mod&amp;navid=<?= $value['id'] ?>"><?= $value['naviname'] ?></a>
                                        <?php if ($value['hide'] == 'y'): ?>
                                            <span class="badge badge-secondary ml-2"><?= _lang('hidden') ?></span>
                                        <?php endif ?>
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
                                                class="badge badge-primary"><?= _lang('hide') ?></a>
                                        <?php else: ?>
                                            <a href="navbar.php?action=show&amp;id=<?= $value['id'] ?>"
                                                class="badge badge-cyan"><?= _lang('show') ?></a>
                                        <?php endif ?>
                                        <?php if ($value['isdefault'] == 'n'): ?>
                                            <a href="javascript: em_confirm(<?= $value['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');"
                                                class="badge badge-danger"><?= _lang('delete') ?></a>
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
                                                <?php if ($val['hide'] == 'y'): ?>
                                                    <span class="badge badge-secondary ml-2"><?= _lang('hidden') ?></span>
                                                <?php endif ?>
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
                                                        class="badge badge-primary"><?= _lang('hide') ?></a>
                                                <?php else: ?>
                                                    <a href="navbar.php?action=show&amp;id=<?= $val['id'] ?>"
                                                        class="badge badge-cyan">显示</a>
                                                <?php endif ?>
                                                <?php if ($val['isdefault'] == 'n'): ?>
                                                    <a href="javascript: em_confirm(<?= $val['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');"
                                                        class="badge badge-danger"><?= _lang('delete') ?></a>
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
                <button type="submit" class="btn btn-sm btn-success"><?= _lang('save_sort') ?></button>
            </div>
        </form>
    </div>
</div>

<!-- 自定义导航模态窗口 -->
<div class="modal fade" id="customNavModal" tabindex="-1" role="dialog" aria-labelledby="customNavModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="customNavModalLabel"><?= _lang('add_custom_navi') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="navbar.php?action=add" method="post" name="navi" id="navi">
                    <div class="form-group">
                        <label for="naviname"><?= _lang('navi_name') ?></label>
                        <input class="form-control" name="naviname" id="naviname" placeholder="" required />
                    </div>
                    <div class="form-group">
                        <label for="url"><?= _lang('navi_url') ?></label>
                        <textarea maxlength="512" class="form-control" placeholder="https://" name="url" id="url" required></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" value="y" name="newtab" id="newtab">
                        <label class="form-check-label" for="newtab"><?= _lang('open_new_tab') ?></label>
                    </div>
                    <div class="form-group">
                        <label for="pid"><?= _lang('parent_navi') ?></label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0"><?= _lang('none') ?></option>
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
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                        <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
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
                <h5 class="modal-title" id="sortNavModalLabel"><?= _lang('add_category_navi') ?></h5>
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
                            <a class="btn btn-sm btn-link mr-auto" href="sort.php">+<?= _lang('new_category') ?></a>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                            <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                        </div>
                    <?php else: ?>
                        <div>
                            <?= _lang('no_category_yet') ?>，<a href="sort.php"><?= _lang('new_category') ?></a>
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
                <h5 class="modal-title" id="pageNavModalLabel"><?= _lang('add_page_navi') ?></h5>
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
                            <a class="btn btn-sm btn-link mr-auto" href="page.php?action=new">+<?= _lang('new_page') ?></a>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                            <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                        </div>
                    <?php else: ?>
                        <div>
                            <?= _lang('no_page_yet') ?>, <a href="page.php?action=new"><?= _lang('new_page') ?></a>
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