<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?= FlashMsg::renderNavbarAlerts(); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('navbar') ?></h1>
    <div class="mt-4">
        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#customNavModal">
            <i class="icofont-plus mr-1"></i><?= _lang('custom_navi') ?>
        </a>
        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#sortNavModal">
            <i class="icofont-plus mr-1"></i><?= _lang('add_category_navi') ?>
        </a>
        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#pageNavModal">
            <i class="icofont-plus mr-1"></i><?= _lang('add_page_navi') ?>
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
                                        $value['type_name'] = _lang('system');
                                        $value['url'] = '/' . $value['url'];
                                        break;
                                    case Navi_Model::navitype_sort:
                                        $value['type_name'] = '<span class="text-primary">' . _lang('category') . '</span>';
                                        break;
                                    case Navi_Model::navitype_page:
                                        $value['type_name'] = '<span class="text-success">' . _lang('page') . '</span>';
                                        break;
                                    case Navi_Model::navitype_custom:
                                        $value['type_name'] = '<span class="text-danger">' . _lang('custom') . '</span>';
                                        break;
                                }
                                doAction('adm_navi_display');

                        ?>
                                <tr class="tree-parent" data-id="<?= $value['id'] ?>">
                                    <td class="tree-name">
                                        <input type="hidden" name="navi[]" value="<?= $value['id'] ?>" />
                                        <span class="drag-handle text-muted mr-2" style="cursor: move;" title="拖动排序"><i class="icofont-navigation-menu"></i></span>
                                        <?php if (!empty($value['childnavi'])): ?>
                                            <span class="fold-btn text-muted mr-1" style="cursor: pointer;" data-id="<?= $value['id'] ?>">
                                                <i class="icofont-simple-down"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="fold-btn-placeholder mr-1" style="display: inline-block; width: 12px;"></span>
                                        <?php endif; ?>
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
                                    $total_childnavi = count($value['childnavi']);
                                    $child_index = 0;
                                    foreach ($value['childnavi'] as $val):
                                        $child_index++;
                                        $is_last_child = ($child_index === $total_childnavi);
                                ?>
                                        <tr class="tree-child <?= $is_last_child ? 'last-child' : '' ?>" data-pid="<?= $val['pid'] ?>">
                                            <td class="tree-name">
                                                <input type="hidden" name="navi[]" value="<?= $val['id'] ?>" />
                                                <span class="drag-handle text-muted mr-2" style="cursor: move;" title="拖动排序"><i class="icofont-navigation-menu"></i></span>
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
                                <td colspan="5"><?= _lang('no_navi_yet') ?></td>
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
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold" id="sortNavModalLabel"><?= _lang('add_category_navi') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-2 pb-0">
                <form action="navbar.php?action=add_sort" method="post" name="navi_sort" id="navi_sort">
                    <?php if ($sorts): ?>
                        <div class="custom-control custom-checkbox mb-3 border-bottom pb-2">
                            <input type="checkbox" class="custom-control-input" id="selectAllSorts">
                            <label class="custom-control-label font-weight-bold" for="selectAllSorts"><?= _lang('select_all') ?></label>
                        </div>
                        <div id="sortsContainer" class="form-group mb-0" style="max-height: 260px; overflow-y: auto; padding-right: 5px;">
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
                        <div class="modal-footer border-0 px-0 mt-3 d-flex align-items-center">
                            <a class="btn btn-sm btn-outline-primary mr-auto" href="sort.php">
                                <i class="icofont-plus mr-1"></i><?= _lang('new_category') ?>
                            </a>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                            <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                        </div>
                    <?php else: ?>
                        <div class="py-3 text-center text-muted">
                            <?= _lang('no_category_yet') ?>, <a href="sort.php" class="btn btn-sm btn-outline-primary ml-2"><i class="icofont-plus mr-1"></i><?= _lang('new_category') ?></a>
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
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-weight-bold" id="pageNavModalLabel"><?= _lang('add_page_navi') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-2 pb-0">
                <form action="navbar.php?action=add_page" method="post" name="navi_page" id="navi_page">
                    <?php if ($pages): ?>
                        <div class="custom-control custom-checkbox mb-3 border-bottom pb-2">
                            <input type="checkbox" class="custom-control-input" id="selectAllPages">
                            <label class="custom-control-label font-weight-bold" for="selectAllPages"><?= _lang('select_all') ?></label>
                        </div>
                        <div id="pagesContainer" class="form-group mb-0" style="max-height: 260px; overflow-y: auto; padding-right: 5px;">
                            <?php foreach ($pages as $key => $value): ?>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" name="pages[<?= $value['gid'] ?>]" value="<?= $value['title'] ?>" id="page_<?= $value['gid'] ?>">
                                    <label class="custom-control-label" for="page_<?= $value['gid'] ?>"><?= $value['title'] ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer border-0 px-0 mt-3 d-flex align-items-center">
                            <a class="btn btn-sm btn-outline-primary mr-auto" href="page.php?action=new">
                                <i class="icofont-plus mr-1"></i><?= _lang('new_page') ?>
                            </a>
                            <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                            <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                        </div>
                    <?php else: ?>
                        <div class="py-3 text-center text-muted">
                            <?= _lang('no_page_yet') ?>, <a href="page.php?action=new" class="btn btn-sm btn-outline-primary ml-2"><i class="icofont-plus mr-1"></i><?= _lang('new_page') ?></a>
                        </div>
                    <?php endif ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * 初始化导航页面事件和拖动排序功能
     */
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

        // 初始化树形拖拽排序与折叠
        initTreeSortable({
            hasHierarchy: true,
            storagePrefix: 'em_navi_folded_'
        });

        // 绑定分类导航与页面导航的全选复选框联动逻辑
        initCheckboxSelectAll('#selectAllSorts', '#sortsContainer');
        initCheckboxSelectAll('#selectAllPages', '#pagesContainer');
    });
</script>
