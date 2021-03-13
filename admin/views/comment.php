<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['active_del'])): ?>
        <div class="alert alert-success">删除评论成功</div><?php endif; ?>
    <?php if (isset($_GET['active_show'])): ?>
        <div class="alert alert-success">审核评论成功</div><?php endif; ?>
    <?php if (isset($_GET['active_hide'])): ?>
        <div class="alert alert-success">隐藏评论成功</div><?php endif; ?>
    <?php if (isset($_GET['active_edit'])): ?>
        <div class="alert alert-success">修改评论成功</div><?php endif; ?>
    <?php if (isset($_GET['active_rep'])): ?>
        <div class="alert alert-success">回复评论成功</div><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?>
        <div class="alert alert-danger">请选择要执行操作的评论</div><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?>
        <div class="alert alert-danger">请选择要执行的操作</div><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div class="alert alert-danger">回复内容不能为空</div><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?>
        <div class="alert alert-danger">内容过长</div><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?>
        <div class="alert alert-danger">评论内容不能为空</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?= lang('comment_management') ?></h1>
    </div>
    <?php if ($hideCommNum > 0) : ?>
        <div class="panel-heading">
            <ul class="nav nav-tabs">
<!--vot-->      <li class="nav-item"><a class="nav-link <?php if ($hide == '') {
                        echo 'active';
/*vot*/             } ?>" href="./comment.php?<?php echo $addUrl_1 ?>"><?=lang('all')?></a></li>
<!--vot-->  <li class="nav-item"><a class="nav-link <?php if ($hide == 'y') {
                        echo 'active';
/*vot*/             } ?>" href="./comment.php?hide=y&<?php echo $addUrl_1 ?>"><?=lang('pending')?><?php
                        $hidecmnum = ROLE == ROLE_ADMIN ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
                        if ($hidecmnum > 0) echo '(' . $hidecmnum . ')';
                        ?></a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
    <form action="comment.php?action=admin_all_coms" method="post" name="form_com" id="form_com">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
<!--vot-->      <span class="badge badge-secondary"><?=lang('have')?><?php echo $cmnum; ?><?=lang('comments_pending')?></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"/></th>
<!--vot-->                  <th><?= lang('content') ?></th>
<!--vot-->                  <th><?= lang('comment_author') ?></th>
<!--vot-->                  <th><?= lang('time') ?></th>
<!--vot-->                  <th><?= lang('operation') ?></th>
<!--vot-->                  <th><?= lang('belongs_to_article') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($comment as $key => $value):
/*vot*/                         $ishide = $value['hide']=='y'?'<font color="red">[' . lang('pending') . ']</font>' : '';
                            $mail = !empty($value['mail']) ? "({$value['mail']})" : '';
/*vot*/                         $ip = !empty($value['ip']) ? '<br />' . lang('from_ip') . ': ' . $value['ip'] : '';
                            $poster = !empty($value['url']) ? '<a href="' . $value['url'] . '">' . $value['poster'] . '</a>' : $value['poster'];
                            $value['content'] = str_replace('<br>', ' ', $value['content']);
                            $sub_content = subString($value['content'], 0, 50);
                            $value['title'] = subString($value['title'], 0, 42);
                            doAction('adm_comment_display');
                            ?>
                            <tr>
                                <td width="19"><input type="checkbox" value="<?php echo $value['cid']; ?>" name="com[]" class="ids"/></td>
                                <td width="350">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal"
                                       data-cid="<?php echo $value['cid']; ?>"
                                       data-comment="<?php echo $value['content']; ?>"
                                       data-hide="<?php echo $value['hide']; ?>"
                                       data-gid="<?php echo $value['gid']; ?> ">
                                        <?php echo $sub_content; ?>
                                    </a>
                                    <?php echo $ishide; ?>
                                </td>
                                <td class="small"><?php echo $poster; ?> <?php echo $mail; ?> <?php echo $ip; ?>
                                    <?php if (ROLE == ROLE_ADMIN): ?>
                                        <a href="javascript: em_confirm('<?php echo $value['ip']; ?>', 'commentbyip', '<?php echo LoginAuth::genToken(); ?>');"
<!--vot-->                                     class="badge badge-pill badge-danger"><?=lang('del_from_ip')?></a>
                                    <?php endif; ?>
                                </td>
                                <td class="small"><?php echo $value['date']; ?></td>
                                <td>
<!--vot-->                              <a href="javascript: em_confirm(<?php echo $value['cid']; ?>, 'comment', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
                                    <?php if ($value['hide'] == 'y'): ?>
<!--vot-->                                  <a href="comment.php?action=show&amp;id=<?php echo $value['cid']; ?>"><?=lang('check')?></a>
                                    <?php else: ?>
<!--vot-->                                  <a href="comment.php?action=hide&amp;id=<?php echo $value['cid']; ?>"><?=lang('hide')?></a>
                                    <?php endif; ?>
<!--vot-->                              <a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>"><?=lang('reply')?></a>
                                </td>
                                <td class="small"><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="list_footer">
<!--vot-->          <a href="javascript:commentact('del');" class="care"><?=lang('delete')?></a>
<!--vot-->          <a href="javascript:commentact('hide');"><?=lang('hide')?></a>
<!--vot-->          <a href="javascript:commentact('pub');"><?=lang('approve')?></a>
                    <input name="operate" id="operate" value="" type="hidden"/>
                </div>
                <div class="page"><?php echo $pageurl; ?></div>
            </div>
        </div>
    </form>
    <!--  Modal window   -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
<!--vot-->          <h5 class="modal-title" id="exampleModalLabel"><?=lang('comment_reply')?></h5>
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
                            <textarea class="form-control" id="reply" name="reply"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
<!--vot-->              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->              <button type="submit" class="btn btn-primary"><?=lang('reply')?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#menu_cm").addClass('active');
    setTimeout(hideActived, 2600);

    function commentact(act) {
        if (getChecked('ids') == false) {
/*vot*/     alert('<?=lang('comment_operation_select')?>');
            return;
        }
/*vot*/ if (act == 'del' && !confirm('<?=lang('comment_selected_delete_sure')?>')) {
            return;
        }
        $("#operate").val(act);
        $("#form_com").submit();
    }

    //Reply the Comment modal window
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var comment = button.data('comment')
        var cid = button.data('cid')
        var gid = button.data('gid')
        var hide = button.data('hide')
        var modal = $(this)
        modal.find('.modal-body p').html(comment)
        modal.find('.modal-body #cid').val(cid)
        modal.find('.modal-body #gid').val(gid)
        modal.find('.modal-body #hide').val(hide)
    })
</script>
