<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?= FlashMsg::renderSortAlerts(); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('category') ?></h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#sortModal"><i class="icofont-plus"></i> <?= _lang('add_category') ?></a>
</div>
<form method="post" id="sort_form" action="sort.php?action=taxis">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive" id="adm_sort_list">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th width="40"><input type="checkbox" id="checkAllItem" /></th>
                            <th><?= _lang('name') ?></th>
                            <th><?= _lang('image') ?></th>
                            <th><?= _lang('description') ?></th>
                            <th><?= _lang('sort_id') ?></th>
                            <th><?= _lang('alias') ?></th>
                            <th><?= _lang('article') ?></th>
                            <th><?= _lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php
                        /**
                         * 递归渲染分类树节点（支持任意多层级展示与管理）
                         *
                         * @param array $sorts 全量分类缓存/模型数据
                         * @param array $value 当前分类节点数据
                         * @param int $depth 深度层级（0为顶级，1为二级，2为三级...）
                         * @param bool $is_last_child 是否为同级最后一个节点
                         * @param array $ancestors_has_next 祖先层级是否有后续兄弟节点的布尔数组
                         * @return void
                         */
                        function renderSortRow($sorts, $value, $depth = 0, $is_last_child = false, $ancestors_has_next = [])
                        {
                            $sid = $value['sid'];
                            $pid = $value['pid'];
                            $children = isset($value['children']) && is_array($value['children']) ? $value['children'] : [];
                            $hasChildren = !empty($children);
                            $isTop = ($depth === 0);
                            $rowClass = $isTop ? 'tree-parent' : ('tree-child' . ($is_last_child ? ' last-child' : ''));
                            // 每层缩进 1.3rem，首层基础 padding-left 为 2.6rem
                            $paddingLeft = $isTop ? '' : ' style="padding-left: ' . (1.3 + $depth * 1.3) . 'rem !important;"';
                        ?>
                            <tr class="<?= $rowClass ?>" <?= $isTop ? 'data-id="' . $sid . '"' : 'data-pid="' . $pid . '"' ?>>
                                <td>
                                    <input type="checkbox" name="sort_ids[]" class="ids" value="<?= $sid ?>" />
                                </td>
                                <td class="tree-name"<?= $paddingLeft ?>>
                                    <input type="hidden" value="<?= $sid ?>" class="sort_id" />
                                    <input type="hidden" name="sort[]" value="<?= $sid ?>" />
                                    <?php if (!$isTop): ?>
                                        <?php for ($i = 0; $i < $depth - 1; $i++): ?>
                                            <?php if (!empty($ancestors_has_next[$i])): ?>
                                                <span class="tree-branch-wire" style="left: <?= (1.3 + $i * 1.3) ?>rem;"></span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="tree-branch-wire is-joint <?= $is_last_child ? '' : 'has-next' ?>" style="left: <?= (1.3 + ($depth - 1) * 1.3) ?>rem;"></span>
                                        <span class="tree-branch-elbow" style="left: <?= (1.3 + ($depth - 1) * 1.3) ?>rem;"></span>
                                    <?php endif; ?>
                                    <span class="drag-handle text-muted mr-2" style="cursor: move;" title="拖动排序"><i class="icofont-navigation-menu"></i></span>
                                    <?php if ($hasChildren): ?>
                                        <span class="fold-btn text-muted mr-1" style="cursor: pointer;" data-id="<?= $sid ?>">
                                            <i class="icofont-simple-down"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="fold-btn-placeholder mr-1" style="display: inline-block; width: 12px;"></span>
                                    <?php endif; ?>
                                    <a href="#" data-toggle="modal" data-target="#sortModal"
                                        data-sid="<?= $sid ?>"
                                        data-sortname="<?= $value['sortname'] ?>"
                                        data-alias="<?= $value['alias'] ?>"
                                        data-description="<?= $value['description'] ?>"
                                        data-kw="<?= $value['kw'] ?>"
                                        data-title="<?= $value['title_origin'] ?>"
                                        data-pid="<?= $pid ?>"
                                        data-sortimg="<?= $value['sortimg'] ?>"
                                        data-page_count="<?= $value['page_count'] ?>"
                                        data-allow_user_post="<?= $value['allow_user_post'] ?>"
                                        data-template="<?= $value['template'] ?>">
                                        <?= $value['sortname'] ?>
                                    </a>
                                    <a href="<?= Url::sort($sid) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                                    <?php if ($value['allow_user_post'] == 'n'): ?>
                                        <br><span class="badge small badge-orange"><?= _lang('no_contribute') ?></span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <div class="flex-shrink-0">
                                        <?php if ($value['sortimg']): ?>
                                            <img src="<?= $value['sortimg'] ?>" height="55" class="rounded" />
                                        <?php else: ?>
                                            <img src="<?= './views/images/null.png' ?>" height="55" class="rounded" />
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?= subString($value['description'], 0, 100) ?></td>
                                <td><?= $sid ?></td>
                                <td class="alias"><?= $value['alias'] ?></td>
                                <td><a href="article.php?sid=<?= $sid ?>"><?= $value['lognum'] ?></a></td>
                                <td>
                                    <a href="javascript: em_confirm(<?= $sid ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= _lang('delete') ?></a>
                                </td>
                            </tr>
                            <?php
                            if ($hasChildren) {
                                $total_children = count($children);
                                $child_index = 0;
                                foreach ($children as $child_key) {
                                    if (!isset($sorts[$child_key])) {
                                        continue;
                                    }
                                    $child_value = $sorts[$child_key];
                                    $child_index++;
                                    $child_is_last = ($child_index === $total_children);
                                    $next_ancestors = $ancestors_has_next;
                                    if ($depth > 0) {
                                        $next_ancestors[$depth - 1] = !$is_last_child;
                                    }
                                    renderSortRow($sorts, $child_value, $depth + 1, $child_is_last, $next_ancestors);
                                }
                            }
                        }

                        foreach ($sorts as $key => $value) {
                            if ($value['pid'] != 0) {
                                continue;
                            }
                            renderSortRow($sorts, $value, 0, false, []);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="list_footer">
        <input type="submit" value="<?= _lang('save_sort') ?>" class="btn btn-sm btn-success mr-2 shadow-sm" />
        <a href="javascript: sort_batch_delete();" class="btn btn-sm btn-outline-danger"><?= _lang('delete') ?></a>
    </div>
</form>

<style>
    /* 树形分类多层级连线与精准缩进 */
    #adm_sort_list .tree-child td.tree-name {
        position: relative;
    }
    #adm_sort_list .tree-child td.tree-name::before,
    #adm_sort_list .tree-child td.tree-name::after {
        display: none !important;
    }
    .tree-branch-wire {
        position: absolute;
        top: 0;
        bottom: 0;
        border-left: 2px solid #cbd5e1;
    }
    .tree-branch-wire.is-joint {
        bottom: 50%;
    }
    .tree-branch-wire.is-joint.has-next {
        bottom: 0;
    }
    .tree-branch-elbow {
        position: absolute;
        top: 50%;
        width: 14px;
        border-bottom: 2px solid #cbd5e1;
    }
    #sortModal .modal-body {
        max-height: 78vh;
        overflow-y: auto;
    }
</style>
<div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('category') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="sort.php?action=save" method="post" id="sort_new">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname"><?= _lang('sort_name') ?> <span class="text-danger">*</span></label>
                        <input class="form-control" id="sortname" name="sortname" required>
                    </div>
                    <div class="form-group">
                        <label for="alias"><?= _lang('alias_desc') ?></label>
                        <input class="form-control" id="alias" name="alias">
                    </div>
                    <div class="form-group">
                        <label for="pid"><?= _lang('parent_sort') ?></label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0"><?= _lang('none') ?></option>
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
                        <label for="sortimg"><?= _lang('sort_image') ?></label>
                        <div class="input-group">
                            <input class="form-control" id="sortimg" name="sortimg" type="url" placeholder="https://">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#mediaModal" data-mode="category"><?= _lang('select') ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title"><?= _lang('sort_title_desc') ?></label>
                        <input class="form-control" id="title" name="title">
                        <small class="form-text text-muted"><?= _lang('support_variable') ?>: {{site_title}}, {{site_name}}, {{sort_name}}</small>
                    </div>
                    <div class="form-group">
                        <label for="description"><?= _lang('sort_desc_desc') ?></label>
                        <textarea name="description" id="description" type="text" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kw"><?= _lang('sort_kw_desc') ?></label>
                        <input class="form-control" id="kw" name="kw">
                    </div>
                    <div class="form-group">
                        <label for="page_count"><?= _lang('sort_per_page_desc') ?></label>
                        <input class="form-control" value="" name="page_count" id="page_count" type="number" min="0" />
                    </div>
                    <div class="form-group mt-2">
                        <label for="template"><?= _lang('sort_template') ?></label>
                        <?php if ($customTemplates): ?>
                            <?php
                            $sortListHtml = '<option value="">' . _lang('default') . '</option>';
                            foreach ($customTemplates as $v) {
                                $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '">' . ($v['comment']) . '</option>';
                            }
                            ?>
                            <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                        <?php else: ?>
                            <input class="form-control" id="template" name="template">
                            <small class="form-text text-muted"><?= _lang('sort_template_desc') ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="custom-control custom-switch">
                        <input class="custom-control-input" type="checkbox" name="allow_user_post" id="allow_user_post" value="y">
                        <label class="custom-control-label" for="allow_user_post"><?= _lang('allow_contribute') ?></label>
                    </div>
                    <?php doAction('adm_sort_add') ?>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" value="" name="sid" id="sid" />
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    <span id="alias_msg_hook"></span>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" id="save_btn" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include View::getAdmView('media_lib'); ?>

<script>
    function issortalias(a) {
        const validChars = /^[\w-]*$/;
        const validDigits = /^\d+$/;
        const reservedKeywords = ['post', 'record', 'sort', 'tag', 'author', 'page', 'posts'];

        if (!validChars.test(a)) return 1;
        if (validDigits.test(a)) return 2;
        if (reservedKeywords.includes(a)) return 3;

        return 0;
    }

    function checksortalias() {
        const alias = $.trim($("#alias").val());
        const saveButton = $("#save_btn");
        const aliasMsgHook = $("#alias_msg_hook");

        const errorMessages = {
            1: '<?= _lang('alias_char_error') ?>',
            2: '<?= _lang('alias_number_error') ?>',
            3: '<?= _lang('alias_system_error') ?>'
        };

        const result = issortalias(alias);
        if (result !== 0) {
            saveButton.attr("disabled", "disabled");
            aliasMsgHook.html('<span id="input_error">' + errorMessages[result] + '</span>');
        } else {
            aliasMsgHook.html('');
            $("#msg").html('');
            saveButton.attr("disabled", false);
        }
    }

    // 提交表单
    $("#sort_form").submit(function(event) {
        event.preventDefault();
        submitForm("#sort_form");
    });

    $(function() {
        setTimeout(hideActived, 3600);
        $("#alias").keyup(function() {
            checksortalias();
        });

        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_sort").addClass('active');

        // 初始化树形拖拽排序与折叠
        initTreeSortable({
            hasHierarchy: true,
            storagePrefix: 'em_sort_folded_'
        });

        // 修复多层模态窗口关闭导致的滚动失效问题
        $('#mediaModal').on('hidden.bs.modal', function() {
            if ($('#sortModal').hasClass('show')) {
                $('body').addClass('modal-open');
            }
        });

        // 分类编辑
        $('#sortModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var sid = button.data('sid')
            var sortname = button.data('sortname')
            var alias = button.data('alias')
            var description = button.data('description')
            var kw = button.data('kw')
            var title = button.data('title')
            var pid = button.data('pid')
            var template = button.data('template')
            var sortimg = button.data('sortimg')
            var page_count = button.data('page_count')
            var allow_user_post = button.data('allow_user_post')
            var modal = $(this)
            modal.find('.modal-body #sortname').val(sortname)
            modal.find('.modal-body #alias').val(alias)
            modal.find('.modal-body #description').val(description)
            modal.find('.modal-body #kw').val(kw)
            modal.find('.modal-body #title').val(title)
            modal.find('.modal-body #pid').val(pid)
            modal.find('.modal-body #template').val(template)
            modal.find('.modal-body #sortimg').val(sortimg)
            modal.find('.modal-body #page_count').val(page_count)
            modal.find('.modal-body #allow_user_post').prop('checked', !sid || allow_user_post === 'y')
            modal.find('.modal-footer #sid').val(sid)
        })
    });

    /**
     * 批量删除分类
     */
    window.sort_batch_delete = function() {
        if (getChecked('ids') === false) {
            infoAlert('<?= _lang('select_operate_sort') ?>');
            return;
        }
        delAlert2('', '<?= _lang('delete_sort_confirm') ?>', function() {
            var form = $("#sort_form");
            form.attr("action", "sort.php?action=del&token=<?= LoginAuth::genToken() ?>");
            form.off("submit");
            form.submit();
        });
    };
</script>