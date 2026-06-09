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
                            <th><?= _lang('name') ?></th>
                            <th><?= _lang('image') ?></th>
                            <th><?= _lang('description') ?></th>
                            <th><?= _lang('sort_id') ?></th>
                            <th><?= _lang('alias') ?></th>
                            <th><?= _lang('article') ?></th>
                            <th><?= _lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($sorts as $key => $value):
                            if ($value['pid'] != 0) {
                                continue;
                            }
                        ?>
                            <tr class="parent-sort" data-sid="<?= $value['sid'] ?>">
                                <td class="sortname">
                                    <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id" />
                                    <input type="hidden" name="sort[]" value="<?= $value['sid'] ?>" />
                                    <span class="drag-handle text-muted mr-2" style="cursor: move;" title="拖动排序"><i class="icofont-navigation-menu"></i></span>
                                    <?php if (!empty($value['children'])): ?>
                                        <span class="fold-btn text-muted mr-1" style="cursor: pointer;" data-sid="<?= $value['sid'] ?>">
                                            <i class="icofont-simple-down"></i>
                                        </span>
                                    <?php else: ?>
                                        <span class="fold-btn-placeholder mr-1" style="display: inline-block; width: 12px;"></span>
                                    <?php endif; ?>
                                    <a href="#" data-toggle="modal" data-target="#sortModal"
                                        data-sid="<?= $value['sid'] ?>"
                                        data-sortname="<?= $value['sortname'] ?>"
                                        data-alias="<?= $value['alias'] ?>"
                                        data-description="<?= $value['description'] ?>"
                                        data-kw="<?= $value['kw'] ?>"
                                        data-title="<?= $value['title_origin'] ?>"
                                        data-pid="<?= $value['pid'] ?>"
                                        data-sortimg="<?= $value['sortimg'] ?>"
                                        data-page_count="<?= $value['page_count'] ?>"
                                        data-allow_user_post="<?= $value['allow_user_post'] ?>"
                                        data-template="<?= $value['template'] ?>">
                                        <?= $value['sortname'] ?>
                                    </a>
                                    <a href="<?= Url::sort($value['sid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
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
                                <td><?= $value['sid'] ?></td>
                                <td class="alias"><?= $value['alias'] ?></td>
                                <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                                <td>
                                    <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= _lang('delete') ?></a>
                                </td>
                            </tr>
                            <?php
                            $children = $value['children'];
                            $total_children = count($children);
                            $child_index = 0;
                            foreach ($children as $key):
                                $value = $sorts[$key];
                                $child_index++;
                                $is_last_child = ($child_index === $total_children);
                            ?>
                                <tr class="child-sort <?= $is_last_child ? 'last-child' : '' ?>" data-pid="<?= $value['pid'] ?>">
                                    <td class="sortname">
                                        <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id" />
                                        <input type="hidden" name="sort[]" value="<?= $value['sid'] ?>" />
                                        <span class="drag-handle text-muted mr-2" style="cursor: move;" title="拖动排序"><i class="icofont-navigation-menu"></i></span>
                                        <a href="#" data-toggle="modal" data-target="#sortModal"
                                            data-sid="<?= $value['sid'] ?>"
                                            data-sortname="<?= $value['sortname'] ?>"
                                            data-alias="<?= $value['alias'] ?>"
                                            data-description="<?= $value['description'] ?>"
                                            data-kw="<?= $value['kw'] ?>"
                                            data-title="<?= $value['title_origin'] ?>"
                                            data-pid="<?= $value['pid'] ?>"
                                            data-sortimg="<?= $value['sortimg'] ?>"
                                            data-page_count="<?= $value['page_count'] ?>"
                                            data-allow_user_post="<?= $value['allow_user_post'] ?>"
                                            data-template="<?= $value['template'] ?>"><?= $value['sortname'] ?></a>
                                        <a href="<?= Url::sort($value['sid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
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
                                    <td><?= $value['sid'] ?></td>
                                    <td class="alias"><?= $value['alias'] ?></td>
                                    <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                                    <td>
                                        <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= _lang('delete') ?></a>
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
        <input type="submit" value="<?= _lang('save_sort') ?>" class="btn btn-sm btn-success" />
    </div>
</form>

<style>
    #sortModal .modal-body {
        max-height: 78vh;
        overflow-y: auto;
    }

    .sortname {
        white-space: nowrap;
    }

    /* 树形层级连线样式 */
    .parent-sort td.sortname a {
        font-weight: 600;
        color: #1e293b;
    }

    .child-sort {
        background-color: #fafbfc;
    }

    .child-sort td.sortname {
        position: relative;
        padding-left: 2.6rem !important;
    }

    .child-sort td.sortname::after {
        content: '';
        position: absolute;
        left: 1.3rem;
        top: 0;
        bottom: 0;
        border-left: 2px solid #cbd5e1;
    }

    .child-sort.last-child td.sortname::after {
        bottom: 50%;
    }

    .child-sort td.sortname::before {
        content: '';
        position: absolute;
        left: 1.3rem;
        top: 0;
        height: 50%;
        width: 14px;
        border-bottom: 2px solid #cbd5e1;
    }

    .child-sort td.sortname a {
        font-weight: 500;
        color: #475569;
    }

    .fold-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 4px;
        transition: all 0.15s ease;
    }

    .fold-btn:hover {
        background-color: #e2e8f0;
        color: #0f172a !important;
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

        // 拖拽主分类时连带子分类一起移动，子分类也支持在列表内上下排序
        $('#dataTable tbody').sortable({
            items: '> tr.parent-sort, > tr.child-sort',
            handle: '.drag-handle',
            /**
             * 拖拽开始回调函数
             */
            start: function(e, ui) {
                if (ui.item.hasClass('parent-sort')) {
                    var sid = ui.item.data('sid');
                    $('.child-sort[data-pid="' + sid + '"]').hide();
                }
            },
            /**
             * 拖拽结束后，处理主分类连带移动，以及子分类出界智能弹回纠偏，保持父子级物理顺序
             */
            stop: function(e, ui) {
                if (ui.item.hasClass('parent-sort')) {
                    var sid = ui.item.data('sid');
                    var children = $('.child-sort[data-pid="' + sid + '"]');
                    ui.item.after(children);
                    // 仅在主分类未折叠的情况下显示子分类
                    if (ui.item.attr('data-folded') !== 'true') {
                        children.show();
                    }
                } else if (ui.item.hasClass('child-sort')) {
                    var pid = ui.item.data('pid');
                    // 寻找拖拽放置后，其上方的第一个主分类
                    var currentParent = ui.item.prevAll('.parent-sort').first();
                    var currentParentSid = currentParent.data('sid');

                    if (currentParentSid !== pid) {
                        // 如果移出了原本父分类的地盘，执行智能吸附纠偏
                        var realParent = $('.parent-sort[data-sid="' + pid + '"]');
                        if (ui.item.index() < realParent.index()) {
                            // 往上拖出界，移回父分类正下方首位
                            realParent.after(ui.item);
                        } else {
                            // 往下拖出界，移回父分类子列表末尾
                            var siblings = $('.child-sort[data-pid="' + pid + '"]').not(ui.item);
                            if (siblings.length > 0) {
                                siblings.last().after(ui.item);
                            } else {
                                realParent.after(ui.item);
                            }
                        }
                    }
                }
            }
        }).disableSelection();

        /**
         * 主分类折叠/展开点击事件
         * 作用：点击分类前方的三角/方向箭头，折叠或展开属于该主分类的子分类，并将状态持久化到 localStorage 中
         */
        $('#dataTable').on('click', '.fold-btn', function() {
            var btn = $(this);
            var sid = btn.data('sid');
            var parentRow = btn.closest('.parent-sort');
            var children = $('.child-sort[data-pid="' + sid + '"]');
            var icon = btn.find('i');

            if (icon.hasClass('icofont-simple-down')) {
                // 折叠
                children.hide();
                icon.removeClass('icofont-simple-down').addClass('icofont-simple-right');
                parentRow.attr('data-folded', 'true');
                localStorage.setItem('em_sort_folded_' + sid, 'true');
            } else {
                // 展开
                children.show();
                icon.removeClass('icofont-simple-right').addClass('icofont-simple-down');
                parentRow.removeAttr('data-folded');
                localStorage.removeItem('em_sort_folded_' + sid);
            }
        });

        /**
         * 初始化分类的折叠状态
         * 作用：读取 localStorage 中保存的折叠记录，对需要折叠的分类进行收起初始化
         */
        $('.fold-btn').each(function() {
            var btn = $(this);
            var sid = btn.data('sid');
            var parentRow = btn.closest('.parent-sort');
            var children = $('.child-sort[data-pid="' + sid + '"]');
            var icon = btn.find('i');

            if (localStorage.getItem('em_sort_folded_' + sid) === 'true') {
                children.hide();
                icon.removeClass('icofont-simple-down').addClass('icofont-simple-right');
                parentRow.attr('data-folded', 'true');
            }
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
</script>