<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_show'])): ?>
    <div class="alert alert-success"><?= _lang('comment_audit_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_hide'])): ?>
    <div class="alert alert-success"><?= _lang('hide_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_top'])): ?>
    <div class="alert alert-success"><?= _lang('top_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_untop'])): ?>
    <div class="alert alert-success"><?= _lang('top_cancel_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success"><?= _lang('edit_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_rep'])): ?>
    <div class="alert alert-success"><?= _lang('reply_success') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= _lang('select_operate_comment') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= _lang('select_operation') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= _lang('reply_empty_error') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= _lang('content_too_long') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= _lang('comment_empty_error') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('comment') ?></h1>
</div>
<?php if ($hideCommNum > 0) : ?>
    <div class="panel-heading mb-3">
        <ul class="nav nav-pills justify-content-start mb-2 mb-md-0">
            <li class="nav-item">
                <a class="nav-link <?= $hide == '' ? 'active' : '' ?>" href="./comment.php?<?= $addUrl_1 ?>"><?= _lang('all') ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $hide == 'y' ? 'active' : '' ?>" href="./comment.php?hide=y&<?= $addUrl_1 ?>"><?= _lang('pending_audit') ?>
                    <?php
                    $hidecmnum = User::haveEditPermission() ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
                    if ($hidecmnum > 0)
                        echo '(' . $hidecmnum . ')';
                    ?>
                </a>
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
                            <th><input type="checkbox" id="checkAllItem" /></th>
                            <th><?= _lang('content') ?></th>
                            <th><?= _lang('commentator') ?></th>
                            <th><?= _lang('from_article') ?></th>
                            <th><?= _lang('post_time') ?></th>
                            <th><?= _lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php foreach ($comment as $key => $value):
                            $ishide = $value['hide'] == 'y' ? '<span class="text-danger">' . _lang('pending_audit') . '</span>' : '';
                            $mail = $value['mail'] ? " <br />email: {$value['mail']}" : '';
                            $ip = $value['ip'];
                            $gid = $value['gid'];
                            $cid = $value['cid'];
                            $ip_info = $ip ? "<br />IP：{$ip}" : '';
                            $comment = $value['comment'];
                            $comment_text = $value['comment_text'];
                            $poster = !empty($value['uid']) ? '<a href="./comment.php?uid=' . $value['uid'] . '">' . $value['poster'] . '</a>' : $value['poster'];
                            $title = subString($value['title'], 0, 42);
                            $hide = $value['hide'];
                            $date = $value['date'];
                            $top = $value['top'];
                            doAction('adm_comment_display');
                        ?>
                            <tr>
                                <td style="width: 19px;"><input type="checkbox" value="<?= $cid ?>" name="com[]" class="ids" /></td>
                                <td>
                                    <?= $comment ?>
                                    <?= $ishide ?>
                                    <?php if ($top == 'y'): ?><span class="text-success"><?= _lang('top') ?></span><?php endif ?>
                                </td>
                                <td class="small">
                                    <?= $poster ?>
                                    <?php if (User::haveEditPermission()): ?>
                                        <?= $mail ?>
                                        <?= $ip_info ?>
                                        <br><?= $value['os'] ?> - <?= $value['browse'] ?>
                                    <?php endif ?>
                                </td>
                                <td class="small">
                                    <a href="<?= Url::log($gid) ?>" target="_blank"><?= $title ?></a><br>
                                    <a href="comment.php?gid=<?= $gid ?>" class="badge badge-info"><?= _lang('this_article_comments') ?></a>
                                </td>
                                <td class="small"><?= $date ?></td>
                                <td>
                                    <?php if (User::haveEditPermission()): ?>
                                        <a href="javascript: em_confirm('<?= $ip ?>', 'commentbyip', '<?= LoginAuth::genToken() ?>');" class="badge badge-pill badge-danger"><?= _lang('delete_by_ip') ?></a>
                                        <a href="javascript: em_confirm(<?= $cid ?>, 'comment', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= _lang('delete') ?></a>
                                    <?php endif ?>
                                    <a href="#" data-toggle="modal" class="badge badge-success" data-target="#replyModal"
                                        data-cid="<?= $cid ?>"
                                        data-comment="<?= $comment_text ?>"
                                        data-hide="<?= $value['hide'] ?>"><?= _lang('reply') ?>
                                    </a>
                                    <?php if ($value['hide'] === 'y' && User::haveEditPermission()): ?>
                                        <a class="badge badge-warning" href="comment.php?action=pub&id=<?= $cid ?>&token=<?= LoginAuth::genToken() ?>"><?= _lang('audit') ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <div class="btn-group">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?= _lang('operation') ?></button>
                    <div class="dropdown-menu">
                        <?php if (User::haveEditPermission()): ?>
                            <a href="javascript:commentact('top');" class="dropdown-item"><?= _lang('top') ?></a>
                            <a href="javascript:commentact('untop');" class="dropdown-item"><?= _lang('cancel_top') ?></a>
                            <a href="javascript:commentact('hide');" class="dropdown-item text-primary"><?= _lang('hide') ?></a>
                            <a href="javascript:commentact('pub');" class="dropdown-item text-primary"><?= _lang('audit') ?></a>
                        <?php endif; ?>
                        <a href="javascript:commentact('del');" class="dropdown-item text-danger"><?= _lang('delete') ?></a>
                    </div>
                </div>
                <input name="operate" id="operate" value="" type="hidden" />
            </div>
        </div>
    </div>
    <div class="page"><?= $pageurl ?></div>
    <div class="d-flex justify-content-center mb-4 small">
        <div class="form-inline d-flex flex-wrap justify-content-center align-items-center">
            <label for="perpage_num" class="mr-2"><?= _lang('total') ?> <?= $cmnum ?>, <?= _lang('per_page') ?></label>
            <select name="perpage_num" id="perpage_num" class="form-control form-control-sm w-auto" onChange="changePerPage(this);">
                <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
                <option value="20" <?= ($perPage == 20) ? 'selected' : '' ?>>20</option>
                <option value="50" <?= ($perPage == 50) ? 'selected' : '' ?>>50</option>
                <option value="100" <?= ($perPage == 100) ? 'selected' : '' ?>>100</option>
                <option value="500" <?= ($perPage == 500) ? 'selected' : '' ?>>500</option>
            </select>
        </div>
        <script>
            function changePerPage(select) {
                const params = new URLSearchParams(window.location.search);
                params.set('perpage_num', select.value);
                params.set('page', '1');
                window.location.search = params.toString();
            }
        </script>
    </div>
</form>
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="replyModalLabel"><?= _lang('reply_comment') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="comment.php?action=doreply" method="post">
                <div class="modal-body">
                    <p class="comment-replay-content"></p>
                    <div class="form-group">
                        <input type="hidden" value="" name="cid" id="cid" />
                        <input type="hidden" value="" name="hide" id="hide" />
                        <textarea class="form-control" id="reply" name="reply" required></textarea>
                    </div>
                    <p><a href="javascript:void(0);" class="" id="ai_button_reply">✨</a></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('reply') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        initPageScripts();
    });

    function initPageScripts() {
        $("#menu_cm").addClass('active');
        setTimeout(hideActived, 3600);

        initCheckboxSelectAll('#checkAllItem', '.checkboxContainer');
        initShortcutBar();

        $('#replyModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var comment = button.data('comment')
            var cid = button.data('cid')
            var hide = button.data('hide')
            var modal = $(this)
            modal.find('.modal-body .comment-replay-content').html(comment)
            modal.find('.modal-body #cid').val(cid)
            modal.find('.modal-body #hide').val(hide)
        })

        $('#replyModal').on('shown.bs.modal', function() {
            $('#reply').focus();
        });

        // AI 生成评论回复
        $('#ai_button_reply').click(function() {
            var $button = $(this);
            var $reply = $('#reply');
            var comment = $('.comment-replay-content').html();

            // 禁用按钮，显示加载状态
            $button.prop('disabled', true).text('<?= _lang('ai_generating') ?>');

            $.ajax({
                url: 'ai.php?action=genReply',
                method: 'POST',
                data: {
                    comment: comment
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code === 0) {
                        $reply.val(response.data);
                    } else {
                        alert(response.msg || '<?= _lang('ai_generate_failed') ?>');
                    }
                },
                error: function(xhr) {
                    alert('<?= _lang('ai_request_failed') ?>');
                },
                complete: function() {
                    // 恢复按钮状态
                    $button.prop('disabled', false).text('✨');
                }
            });
        });
    }

    function commentact(act) {
        if (getChecked('ids') === false) {
            infoAlert('<?= _lang('select_operate_comment') ?>');
            return;
        }

        if (act === 'del') {
            delAlert2('', '<?= _lang('delete_selected_comments') ?>', function() {
                $("#operate").val(act);
                $("#form_com").submit();
            })
            return
        }
        $("#operate").val(act);
        $("#form_com").submit();
    }
</script>