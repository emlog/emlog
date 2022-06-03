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
    <div class="card-body">
        <div>
			<?php if ($tags): ?>
				<?php foreach ($tags as $key => $value): ?>
                    <a href="#" class="badge badge-primary m-2" data-toggle="modal" data-target="#editModal" data-tid="<?= $value['tid'] ?>"
                       data-tagname="<?= $value['tagname'] ?>">
						<?= $value['tagname'] ?>
                    </a>
				<?php endforeach ?>
			<?php else: ?>
                <p style="margin:20px 30px">还没有标签，写文章的时候可以给文章打标签</p>
			<?php endif ?>
        </div>
        <div class="page"><?= $pageurl ?> （有 <?= $tags_count ?> 个标签）</div>
    </div>
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
        if (!confirm('确定要删除所选标签吗？')) {
            return;
        }
        window.open("./tag.php?action=del_tag&token=<?= LoginAuth::genToken() ?>&tid=" + tid, "_self");
    }
</script>
