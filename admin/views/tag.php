<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改标签成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">请选择标签</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">文章标签</h1>
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
<div class="card shadow mb-4">
    <form action="tag.php?action=operate_tag" method="post" name="form_tag" id="form_tag">
        <div class="card-body checkboxContainer">
            <?php if ($tags): ?>
                <?php foreach ($tags as $key => $v):
                    $count = empty($v['gid']) ? 0 : count(explode(',', $v['gid']));
                    $count_style = $count > 0 ? 'text-muted' : 'text-danger';
                ?>
                    <div class="badge badge-light m-3 p-2">
                        <h5><a href="#" data-toggle="modal" data-target="#editModal" data-tid="<?= $v['tid'] ?>"
                                data-tagname="<?= $v['tagname'] ?>" data-kw="<?= $v['kw'] ?>" data-title="<?= $v['title'] ?>" data-desc="<?= $v['description'] ?>"><?= $v['tagname'] ?></a>
                        </h5>
                        <a href="<?= Url::tag($v['tagname']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                        <span class="<?= $count_style ?>">（<a href="./article.php?tagid=<?= $v['tid'] ?>" target="_blank"><?= $count ?>篇文章</a>）</span>
                        <input type="checkbox" name="tids[]" value="<?= $v['tid'] ?>" class="tids align-top" />
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p class="m-3">还没有标签，写文章时可以打标签</p>
            <?php endif ?>
        </div>
        <div class="form-row align-items-center mx-4 mb-4">
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input name="operate" id="operate" value="" type="hidden" />
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="checkAllItem">
                    <label class="custom-control-label" for="checkAllItem">全选</label>
                </div>
            </div>
            <div class="col-auto my-1 form-inline">
                <a href="javascript:tagact('del');" class="btn btn-sm btn-danger">删除</a>
            </div>
        </div>
    </form>
</div>
<div class="page"><?= $pageurl ?></div>
<div class="text-center small">有 <?= $tags_count ?> 个标签</div>

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
                        <label for="tagname">标签名</label>
                        <input type="text" class="form-control" id="tagname" name="tagname" required>
                    </div>
                    <div class="form-group">
                        <label for="title">标签页标题</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <small class="form-text text-muted">支持变量: {{site_title}}, {{site_name}}, {{tag_name}}</small>
                    </div>
                    <div class="form-group">
                        <label for="kw">标签页关键词（英文逗号分割）</label>
                        <input type="text" class="form-control" id="kw" name="kw">
                    </div>
                    <div class="form-group">
                        <label for="description">标签页描述</label>
                        <textarea name="description" id="description" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" id="tid" name="tid" />
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                    <a class="btn btn-sm btn-outline-danger" href="javascript:deltags();">删除</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_tag").addClass('active');
        setTimeout(hideActived, 3600);

        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var tagname = button.data('tagname')
            var kw = button.data('kw')
            var title = button.data('title')
            var desc = button.data('desc')
            var tid = button.data('tid')
            var modal = $(this)
            modal.find('.modal-body #tagname').val(tagname)
            modal.find('.modal-body #title').val(title)
            modal.find('.modal-body #kw').val(kw)
            modal.find('.modal-body #description').val(desc)
            modal.find('.modal-footer input').val(tid)
        })
    });

    function tagact(act) {
        if (getChecked('tids') === false) {
            infoAlert('请选择要删除的标签');
            return;
        }

        if (act === 'del') {
            delAlert2('', '删除所选标签？', function() {
                $("#operate").val(act);
                $("#form_tag").submit();
            })
            return;
        }
        $("#operate").val(act);
        $("#form_media").submit();
    }

    function deltags() {
        var tid = $('#tid').val()
        delAlert2('', '删除所选标签？', function() {
            window.open("./tag.php?action=del_tag&token=<?= LoginAuth::genToken() ?>&tid=" + tid, "_self");
        })
    }
</script>