<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_t'])): ?>
    <div class="alert alert-success">发布成功</div><?php endif ?>
<?php if (isset($_GET['active_set'])): ?>
    <div class="alert alert-success">保存成功</div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">内容不能为空</div><?php endif ?>
<?php if (isset($_GET['error_forbid'])): ?>
    <div class="alert alert-danger">抱歉，系统限制用户发布微语笔记</div><?php endif ?>
<h1 class="h4 mb-2 text-gray-800">微语笔记</h1>
<p class="mb-4">捕捉稍纵即逝的想法，记录生活中的点点滴滴</p>
<form method="post" action="twitter.php?action=post">
    <div class="form-group">
        <div id="t"><textarea></textarea></div>
    </div>
    <div class="form-row align-items-center">
        <div class="col-auto">
            <button type="submit" class="btn btn-success btn-sm mb-2">发布</button>
        </div>
        <div class="col-auto">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="y" name="private" id="private">
                <label class="form-check-label small" for="private">私密</label>
            </div>
        </div>
    </div>
</form>
<div class="card-columns mt-5">
    <?php
    foreach ($tws as $val):
        $tid = (int)$val['id'];
        $author = $user_cache[$val['author']]['name'];
        $private = $val['private'] === 'y';
        ?>
        <div class="card p-3 <?= $private ? 'border-danger' : '' ?>">
            <div class="markdown t"><?= $val['t'] ?></div>
            <footer>
                <p class="text-muted small card-text d-flex justify-content-between">
                    <?= $val['date'] ?> | by <?= $author ?> <?= $private ? '｜ 私密' : '' ?>
                    <span>
                    <a href="#" class="text-muted" data-toggle="modal" data-target="#editModal" data-id="<?= $val['id'] ?>" data-t="<?= htmlspecialchars($val['t_raw']) ?>">编辑</a>
                    <a href="javascript: em_confirm(<?= $tid ?>, 'tw', '<?= LoginAuth::genToken() ?>');" class="care">删除</a>
                    </span>
                </p>
            </footer>
        </div>
    <?php endforeach ?>
</div>

<!--编辑弹窗-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">编辑微语</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="twitter.php?action=update" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="t" id="t" rows="20" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="id" id="id"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="page"><?= $pageurl ?> </div>
<div class="text-center small">有 <?= $twnum ?> 条微语</div>

<link rel="stylesheet" type="text/css" href="./views/css/markdown.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
<script src="./editor.md/editormd.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $("#menu_twitter").addClass('active');
    setTimeout(hideActived, 3600);

    var Editor;
    $(function () {
        Editor = editormd("t", {
            width: "100%",
            height: 260,
            toolbarIcons: function () {
                return ["bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "|",
                    "link", "image", "|", "preview"]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            htmlDecode: true,
            flowChart: false,
            autoFocus: false,
            lineNumbers: false,
            sequenceDiagram: false,
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png"],
            imageUploadURL: "media.php?action=upload&editor=1",
            syncScrolling: "single",
        });
        Editor.setToolbarAutoFixed(false);

        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var t = button.data('t')
            var modal = $(this)
            modal.find('.modal-body #t').val(t)
            modal.find('.modal-footer #id').val(id)
        })
    });
</script>
