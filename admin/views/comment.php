<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>

<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['active_show'])): ?>
    <div class="alert alert-success">审核成功</div><?php endif ?>
<?php if (isset($_GET['active_hide'])): ?>
    <div class="alert alert-success">隐藏成功</div><?php endif ?>
<?php if (isset($_GET['active_top'])): ?>
    <div class="alert alert-success">置顶成功</div><?php endif ?>
<?php if (isset($_GET['active_untop'])): ?>
    <div class="alert alert-success">取消置顶成功</div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改成功</div><?php endif ?>
<?php if (isset($_GET['active_rep'])): ?>
    <div class="alert alert-success">回复成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">请选择要执行操作的评论</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">请选择要执行的操作</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">回复内容不能为空</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">内容过长</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">评论内容不能为空</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">评论</h1>
</div>
<?php if ($hideCommNum > 0) : ?>
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link <?php if ($hide == '') {
					echo 'active';
				} ?>" href="./comment.php?<?= $addUrl_1 ?>">全部</a></li>
            <li class="nav-item"><a class="nav-link <?php if ($hide == 'y') {
					echo 'active';
				} ?>" href="./comment.php?hide=y&<?= $addUrl_1 ?>">待审<?php
					$hidecmnum = User::isAdmin() ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
					if ($hidecmnum > 0) echo '(' . $hidecmnum . ')';
					?></a>
            </li>
        </ul>
    </div>
<?php endif ?>
<form action="comment.php?action=batch_operation" method="post" name="form_com" id="form_com">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th>内容</th>
                        <th>评论人</th>
                        <th>时间</th>
                        <th>文章</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ($comment as $key => $value):
						$ishide = $value['hide'] == 'y' ? '<span class="text-danger">[待审]</span>' : '';
						$mail = $value['mail'] ? "({$value['mail']})" : '';
						$ip = $value['ip'];
						$gid = $value['gid'];
						$cid = $value['cid'];
						$ip_info = $ip ? "<br />来自IP：{$ip}" : '';
						$comment = $value['comment'];
						$poster = $value['poster'] ?: '';
						$title = subString($value['title'], 0, 42);
						$hide = $value['hide'];
						$date = $value['date'];
						$top = $value['top'];
						doAction('adm_comment_display');
						?>
                        <tr>
                            <td style="width: 19px;"><input type="checkbox" value="<?= $cid ?>" name="com[]" class="ids"/></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#replyModal"
                                   data-cid="<?= $cid ?>"
                                   data-comment="<?= $comment ?>"
                                   data-hide="<?= $value['hide'] ?>"
                                   data-gid="<?= $gid ?> ">
									<?= $comment ?>
                                </a>
								<?= $ishide ?>
								<?php if ($top == 'y'): ?><span class="flag-indexTop" title="置顶">置顶</span><?php endif ?>
                            </td>
                            <td class="small">
                                <?= $poster ?><?= $mail ?><?= $ip_info ?>
								<?php if (User::isAdmin()): ?>
                                    <a href="javascript: em_confirm('<?= $ip ?>', 'commentbyip', '<?= LoginAuth::genToken() ?>');"
                                       class="badge badge-pill badge-warning">按IP删除</a>
								<?php endif ?>
                            </td>
                            <td class="small"><?= $date ?></td>
                            <td class="small">
                                <a href="<?= Url::log($gid) ?>" target="_blank"><?= $title ?></a><br>
                                <a href="comment.php?gid=<?= $gid ?>" class="badge badge-info">该文所有评论</a>
                            </td>
                        </tr>
					<?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="javascript:commentact('top');" class="btn btn-sm btn-secondary">置顶</a>
                    <a href="javascript:commentact('untop');" class="btn btn-sm btn-secondary">取消置顶</a>
                    <a href="javascript:commentact('hide');" class="btn btn-sm btn-success">隐藏</a>
                    <a href="javascript:commentact('pub');" class="btn btn-sm btn-success">审核</a>
                    <a href="javascript:commentact('del');" class="btn btn-sm btn-danger">删除</a>
                </div>
                <input name="operate" id="operate" value="" type="hidden"/>
            </div>
            <div class="page"><?= $pageurl ?> （有 <?= $cmnum ?> 条评论）</div>
        </div>
    </div>
</form>
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">回复评论</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="comment.php?action=doreply" method="post">
                <div class="modal-body">
                    <p></p>
                    <div class="form-group">
                        <input type="hidden" value="" name="cid" id="cid"/>
                        <input type="hidden" value="" name="gid" id="gid"/>
                        <input type="hidden" value="" name="hide" id="hide"/>
                        <textarea class="form-control" id="reply" name="reply" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">回复</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#menu_cm").addClass('active');
    setTimeout(hideActived, 2600);

    function commentact(act) {
        if (getChecked('ids') == false) {
            alert('请选择要操作的评论');
            return;
        }
        if (act == 'del' && !confirm('确定要删除所选评论吗？')) {
            return;
        }
        $("#operate").val(act);
        $("#form_com").submit();
    }

    $('#replyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var comment = button.data('comment')
        var cid = button.data('cid')
        var gid = button.data('gid')
        var hide = button.data('hide')
        var modal = $(this)
        modal.find('.modal-body p').html(removeHTMLTag(comment))
        modal.find('.modal-body #cid').val(cid)
        modal.find('.modal-body #gid').val(gid)
        modal.find('.modal-body #hide').val(hide)
    })
</script>
