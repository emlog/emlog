<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
    <div class="alert alert-success">排序更新成功</div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除分类成功</div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改分类成功</div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加分类成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">分类名称不能为空</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">没有可排序的分类</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">别名格式错误</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">别名不能重复</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">别名不得包含系统保留关键字</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">文章分类</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#sortModal"><i class="icofont-plus"></i> 添加分类</a>
</div>
<form method="post" action="sort.php?action=taxis">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive" id="adm_sort_list">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>描述</th>
                        <th>分类ID</th>
                        <th>别名</th>
                        <th>查看</th>
                        <th>文章</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($sorts as $key => $value):
                        if ($value['pid'] != 0) {
                            continue;
                        }
                        ?>
                        <tr style="cursor: move">
                            <td class="sortname">
                                <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id"/>
                                <input type="hidden" name="sort[]" value="<?= $value['sid'] ?>"/>
                                <a href="#" data-toggle="modal" data-target="#sortModal"
                                   data-sid="<?= $value['sid'] ?>"
                                   data-sortname="<?= $value['sortname'] ?>"
                                   data-alias="<?= $value['alias'] ?>"
                                   data-description="<?= $value['description'] ?>"
                                   data-kw="<?= $value['kw'] ?>"
                                   data-pid="<?= $value['pid'] ?>"
                                   data-template="<?= $value['template'] ?>"><?= $value['sortname'] ?></a>
                            </td>
                            <td><?= $value['description'] ?></td>
                            <td><?= $value['sid'] ?></td>
                            <td class="alias"><?= $value['alias'] ?></td>
                            <td>
                                <a href="<?= Url::sort($value['sid']) ?>" target="_blank"><img src="./views/images/vlog.gif"/></a>
                            </td>
                            <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                            <td>
                                <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
                            </td>
                        </tr>
                        <?php
                        $children = $value['children'];
                        foreach ($children as $key):
                            $value = $sorts[$key];
                            ?>
                            <tr>
                                <td class="sortname">
                                    <input type="hidden" value="<?= $value['sid'] ?>" class="sort_id"/>
                                    <input type="hidden" name="sort[]" value="<?= $value['sid'] ?>"/>
                                    ---- <a href="#" data-toggle="modal" data-target="#sortModal"
                                            data-sid="<?= $value['sid'] ?>"
                                            data-sortname="<?= $value['sortname'] ?>"
                                            data-alias="<?= $value['alias'] ?>"
                                            data-description="<?= $value['description'] ?>"
                                            data-kw="<?= $value['kw'] ?>"
                                            data-pid="<?= $value['pid'] ?>"
                                            data-template="<?= $value['template'] ?>"><?= $value['sortname'] ?></a>
                                </td>
                                <td><?= $value['description'] ?></td>
                                <td><?= $value['sid'] ?></td>
                                <td class="alias"><?= $value['alias'] ?></td>
                                <td>
                                    <a href="<?= Url::sort($value['sid']) ?>" target="_blank"><img src="./views/images/vlog.gif"/></a>
                                </td>
                                <td><a href="article.php?sid=<?= $value['sid'] ?>"><?= $value['lognum'] ?></a></td>
                                <td>
                                    <a href="javascript: em_confirm(<?= $value['sid'] ?>, 'sort', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
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
        <input type="submit" value="保存拖动排序" class="btn btn-sm btn-success"/>
    </div>
</form>

<div class="modal fade" id="sortModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">文章分类</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="sort.php?action=save" method="post" id="sort_new">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname">分类名</label>
                        <input class="form-control" id="sortname" name="sortname" required>
                    </div>
                    <div class="form-group">
                        <label for="alias">别名</label>
                        <input class="form-control" id="alias" name="alias">
                        <small class="form-text text-muted">英文字母组成，用于seo设置，可不填</small>
                    </div>
                    <div class="form-group">
                        <label>父分类</label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0">无</option>
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
                        <label for="alias">描述（也用于分类页的 description）</label>
                        <textarea name="description" id="description" type="text" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kw">关键词（英文逗号分割，用于分类页的 keywords）</label>
                        <textarea name="kw" id="kw" type="text" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="template">分类模板</label>
                        <?php if ($customTemplates):
                            $sortListHtml = '<option value="">默认</option>';
                            foreach ($customTemplates as $v) {
                                $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '">' . ($v['comment']) . '</option>';
                            }
                            ?>
                            <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                            <small class="form-text text-muted">(选择当前模板支持的分类模板，可不选)</small>
                        <?php else: ?>
                            <input class="form-control" id="template" name="template">
                            <small class="form-text text-muted">(用于自定义分类页面模板，对应模板目录下xxx.php文件，xxx即为模板名，可不填)</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="sid" id="sid"/>
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                    <span id="alias_msg_hook"></span>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" id="save_btn" class="btn btn-sm btn-success">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
            1: '别名错误，应由字母、数字、下划线、短横线组成',
            2: '别名错误，不能为纯数字',
            3: '别名错误，与系统链接冲突'
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


    $(function () {
        setTimeout(hideActived, 3600);
        $("#alias").keyup(function () {
            checksortalias();
        });

        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_sort").addClass('active');

        // 初始化拖动排序
        $('#dataTable tbody').sortable().disableSelection();

        // 分类编辑
        $('#sortModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var sid = button.data('sid')
            var sortname = button.data('sortname')
            var alias = button.data('alias')
            var description = button.data('description')
            var kw = button.data('kw')
            var pid = button.data('pid')
            var template = button.data('template')
            var modal = $(this)
            modal.find('.modal-body #sortname').val(sortname)
            modal.find('.modal-body #alias').val(alias)
            modal.find('.modal-body #description').val(description)
            modal.find('.modal-body #kw').val(kw)
            modal.find('.modal-body #pid').val(pid)
            modal.find('.modal-body #template').val(template)
            modal.find('.modal-footer #sid').val(sid)
        })
    });
</script>
