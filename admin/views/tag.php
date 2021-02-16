<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?><span class="alert alert-success">删除标签成功</span><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?><span class="alert alert-success">修改标签成功</span><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">请选择要删除的标签</span><?php endif; ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">标签管理</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="badge badge-secondary">已创建的标签</span>
        </div>
        <div class="card-body">
            <div>
                <?php if ($tags): ?>
                    <li>
                        <?php foreach ($tags as $key => $value): ?>
                            <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#exampleModal" data-tid="<?php echo $value['tid']; ?>"
                               data-tagname="<?php echo $value['tagname']; ?>">
                                <?php echo $value['tagname']; ?>
                            </a>
                        <?php endforeach; ?>
                    </li>
                <?php else: ?>
                    <li style="margin:20px 30px">还没有标签，写文章的时候可以给文章打标签</li>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="tagname" name="tagname">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" id="tid" name="tid"/>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                        <a class="btn btn-outline-danger" href="javascript:deltags();">删除</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_tag").addClass('active');
    //修改标签模态窗
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('tagname')
        var tid = button.data('tid')
        var modal = $(this)
        modal.find('.modal-body input').val(recipient)
        modal.find('.modal-footer input').val(tid)
    })
    function deltags(){
        var tid = $('#tid').val()
        if(!confirm('你确定要删除所选标签吗？')){return;}
        window.open("./tag.php?action=del_tag&token=<?php echo LoginAuth::genToken(); ?>&tid=" + tid, "_self");
    }
</script>
