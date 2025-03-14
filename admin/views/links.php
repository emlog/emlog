<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_save'])): ?>
    <div class="alert alert-success">保存成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">名称和地址不能为空</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">链接</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#linkModel"><i class="icofont-plus"></i> 添加链接</a>
</div>
<form action="link.php?action=link_taxis" id="link_form" method="post">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>链接</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($links as $key => $value):
                            doAction('adm_link_display');
                        ?>
                            <tr style="cursor: move">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <?php if ($value['icon']): ?>
                                                <img src="<?= $value['icon'] ?>" height="35" width="35" class="rounded" />
                                            <?php else: ?>
                                                <img src="<?= './views/images/null.png' ?>" height="35" width="35" class="rounded" />
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="align-items-center mb-3">
                                                <p class="mb-0 m-2">
                                                    <input name="link[]" value="<?= $value['id'] ?>" type="hidden" />
                                                    <a href="#" data-toggle="modal" data-target="#linkModel"
                                                        data-linkid="<?= $value['id'] ?>"
                                                        data-sitename="<?= $value['sitename'] ?>"
                                                        data-siteurl="<?= $value['siteurl'] ?>"
                                                        data-icon="<?= $value['icon'] ?>"
                                                        data-description="<?= $value['description'] ?>"><?= $value['sitename'] ?></a>
                                                    <?php if ($value['hide'] === 'y'): ?>
                                                        <span class="badge badge-warning">已隐藏</span>
                                                    <?php endif ?>
                                                </p>
                                                <p class="mb-0 m-2 small"><?= $value['description'] ?></p>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <a href="<?= $value['siteurl'] ?>" target="_blank"><?= subString($value['siteurl'], 0, 39) ?></a>
                                </td>
                                <td>
                                    <?php if ($value['hide'] == 'n'): ?>
                                        <a href="link.php?action=hide&amp;linkid=<?= $value['id'] ?>" class="badge badge-primary">隐藏</a>
                                    <?php else: ?>
                                        <a href="link.php?action=show&amp;linkid=<?= $value['id'] ?>" class="badge badge-warning">显示</a>
                                    <?php endif ?>
                                    <a href="javascript: em_confirm(<?= $value['id'] ?>, 'link', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="list_footer">
        <input type="submit" value="保存拖动排序" class="btn btn-sm btn-success shadow-sm" />
    </div>
</form>

<!--编辑链接弹窗-->
<div class="modal fade" id="linkModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">链接</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="link.php?action=save" method="post" name="link" id="link">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sitename">名称</label>
                        <input class="form-control" id="sitename" maxlength="255" name="sitename" required>
                    </div>
                    <div class="form-group">
                        <label for="siteurl">地址</label>
                        <input class="form-control" id="siteurl" maxlength="255" name="siteurl" type="url" required>
                    </div>
                    <div class="form-group">
                        <label for="icon">图标URL</label>
                        <input class="form-control" id="icon" name="icon" type="url">
                    </div>
                    <div class="form-group">
                        <label for="description">描述</label>
                        <textarea name="description" id="description" maxlength="512" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="linkid" id="linkid" />
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_link").addClass('active');
        setTimeout(hideActived, 3600);

        // 编辑链接
        $('#linkModel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var linkid = button.data('linkid')
            var sitename = button.data('sitename')
            var siteurl = button.data('siteurl')
            var icon = button.data('icon')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #sitename').val(sitename)
            modal.find('.modal-body #siteurl').val(siteurl)
            modal.find('.modal-body #icon').val(icon)
            modal.find('.modal-body #description').val(description)
            modal.find('.modal-footer #linkid').val(linkid)
        })

        // 提交表单
        $("#link_form").submit(function(event) {
            event.preventDefault();
            submitForm("#link_form");
        });

        // 拖动排序
        $('#dataTable tbody').sortable().disableSelection();
    });
</script>