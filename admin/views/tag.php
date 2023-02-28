<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除标签成功</div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改标签成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">请选择标签</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">文章标签</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <h6 class="m-2 font-weight-bold">总标签数 (<?= $tags_count ?>)</h6>
            </div>
            <form action="tag.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control m-1 small" placeholder="搜索标签名...">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="icofont-search-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form action="tag.php?action=operate_tag" method="post" name="form_tag" id="form_tag">
        <div class="card-body">
            <div>
				<?php if ($tags): ?>
					<?php foreach ($tags as $key => $v):
						$count = count(explode(',', $v['gid']));
						$count_style = $count > 0 ? 'text-muted' : 'text-danger';
						?>
                        <a href="#" class="badge badge-light m-4 p-1" data-toggle="modal" data-target="#editModal" data-tid="<?= $v['tid'] ?>"
                           data-tagname="<?= $v['tagname'] ?>">
                            <h5><?= $v['tagname'] ?></h5>
                            <small class="<?= $count_style ?>">
                                文章<?= $count ?>篇
                            </small>
                            <input type="checkbox" name="tids[]" value="<?= $v['tid'] ?>" class="tids align-top"/>
                        </a>
					<?php endforeach ?>
				<?php else: ?>
                    <p class="m-3">还没有标签，写文章的时候可以给文章打标签</p>
				<?php endif ?>
            </div>
        </div>
        <div class="form-row align-items-center mx-4">
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
            <input name="operate" id="operate" value="" type="hidden"/>
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="checkAllCard">
                    <label class="custom-control-label" for="checkAllCard">全选</label>
                </div>
            </div>
            <div class="col-auto my-1 form-inline">
                <a href="javascript:tagact('del');" class="btn btn-sm btn-danger">删除</a>
            </div>
        </div>
        <div class="page"><?= $pageurl ?></div>
    </form>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">修改标签</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="tag.php?action=update_tag">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="tagname" name="tagname" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" id="tid" name="tid"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                    <a class="btn btn-sm btn-outline-danger" href="javascript:deltags();">删除</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_tag").addClass('active');
    setTimeout(hideActived, 2600);

    function tagact(act) {
        if (getChecked('tids') === false) {
            swal("", "请选择要删除的标签", "info");
            return;
        }

        if (act == 'del') {
            swal({
                title: '确定要删除所选标签吗',
                text: '删除后可能无法恢复',
                icon: 'warning',
                buttons: ['取消', '确定'],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    $("#operate").val(act);
                    $("#form_tag").submit();
                }
            });
            return;
        }
        $("#operate").val(act);
        $("#form_media").submit();
    }

    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var tagname = button.data('tagname')
        var tid = button.data('tid')
        var modal = $(this)
        modal.find('.modal-body input').val(tagname)
        modal.find('.modal-footer input').val(tid)
    })

    function deltags() {
        var tid = $('#tid').val()
        swal({
            title: '确定要删除所选标签吗',
            text: '删除后可能无法恢复',
            icon: 'warning',
            buttons: ['取消', '确定'],
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                window.open("./tag.php?action=del_tag&token=<?= LoginAuth::genToken() ?>&tid=" + tid, "_self");
            }
        });
    }
</script>
