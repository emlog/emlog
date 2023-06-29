<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
    <div class="alert alert-success">排序更新成功</div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改成功</div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">名称和地址不能为空</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">没有可排序的链接</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">友情链接</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 添加链接</a>
</div>
<form action="link.php?action=link_taxis" method="post">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>描述</th>
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
                                <input name="link[]" value="<?= $value['id'] ?>" type="hidden"/>
                                <a href="#" data-toggle="modal" data-target="#editModal"
                                   data-linkid="<?= $value['id'] ?>"
                                   data-sitename="<?= $value['sitename'] ?>"
                                   data-siteurl="<?= $value['siteurl'] ?>"
                                   data-description="<?= $value['description'] ?>"><?= $value['sitename'] ?></a>
                                <?php if ($value['hide'] === 'y'): ?>
                                    <br/><span class="badge badge-warning">已隐藏</span>
                                <?php endif ?>
                            </td>
                            <td><?= $value['description'] ?></td>
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
        <input type="submit" value="保存拖动排序" class="btn btn-sm btn-success shadow-sm"/>
    </div>
</form>
<!--添加链接弹窗-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">新建链接</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="link.php?action=addlink" method="post" name="link" id="link">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alias">名称</label>
                        <input class="form-control" id="sitename" maxlength="255" name="sitename" required>
                    </div>
                    <div class="form-group">
                        <label for="template">地址</label>
                        <input class="form-control" id="siteurl" name="siteurl" maxlength="255" placeholder="https://" required>
                    </div>
                    <div class="form-group">
                        <label for="alias">描述</label>
                        <textarea name="description" type="text" maxlength="512" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<!--编辑链接弹窗-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">编辑链接</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="link.php?action=update_link" method="post" name="link" id="link">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="alias">名称</label>
                        <input class="form-control" id="sitename" maxlength="255" name="sitename" required>
                    </div>
                    <div class="form-group">
                        <label for="template">地址</label>
                        <input class="form-control" id="siteurl" maxlength="255" name="siteurl" type="url" required>
                    </div>
                    <div class="form-group">
                        <label for="alias">描述</label>
                        <textarea name="description" id="description" maxlength="512" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="linkid" id="linkid"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_link").addClass('active');
        setTimeout(hideActived, 3600);
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var linkid = button.data('linkid')
            var sitename = button.data('sitename')
            var siteurl = button.data('siteurl')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #sitename').val(sitename)
            modal.find('.modal-body #siteurl').val(siteurl)
            modal.find('.modal-body #description').val(description)
            modal.find('.modal-footer #linkid').val(linkid)
        })

        // 拖动排序
        $('#dataTable tbody').sortable().disableSelection();
    });
</script>
