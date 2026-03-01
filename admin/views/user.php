<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_unfb'])): ?>
    <div class="alert alert-success"><?= _lang('active_unforbid') ?></div><?php endif ?>
<?php if (isset($_GET['active_update'])): ?>
    <div class="alert alert-success"><?= _lang('edit_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success"><?= _lang('active_add_user') ?></div><?php endif ?>
<?php if (isset($_GET['error_email'])): ?>
    <div class="alert alert-danger"><?= _lang('error_email_empty') ?></div><?php endif ?>
<?php if (isset($_GET['error_exist_email'])): ?>
    <div class="alert alert-danger"><?= _lang('error_exist_email') ?></div><?php endif ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger"><?= _lang('password_min_length') ?></div><?php endif ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger"><?= _lang('password_inconsistent') ?></div><?php endif ?>
<?php if (isset($_GET['error_del_a'])): ?>
    <div class="alert alert-danger"><?= _lang('error_del_founder') ?></div><?php endif ?>
<?php if (isset($_GET['error_del_b'])): ?>
    <div class="alert alert-danger"><?= _lang('error_edit_founder') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('user') ?></h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?= _lang('add_user') ?></a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <div id="f_t_order" class="mx-1">
                    <select name="order" id="order" onChange="selectOrder(this);" class="form-control">
                        <option value="date" <?= (empty($order)) ? 'selected' : '' ?>><?= _lang('order_date') ?></option>
                        <option value="update" <?= ($order === 'update') ? 'selected' : '' ?>><?= _lang('order_update') ?></option>
                        <option value="admin" <?= ($order === 'admin') ? 'selected' : '' ?>><?= _lang('order_admin') ?></option>
                        <option value="forbid" <?= ($order === 'forbid') ? 'selected' : '' ?>><?= _lang('order_forbid') ?></option>
                    </select>
                </div>
            </div>
            <form action="user.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control m-1 small" placeholder="<?= _lang('search_user_placeholder') ?>">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="icofont-search-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <form action="user.php?action=operate_user" method="post" name="form_user" id="form_user">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer" id="adm_comment_list">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAllItem" /></th>
                            <th><?= _lang('avatar') ?></th>
                            <th><?= _lang('nickname') ?></th>
                            <th><?= _lang('email') ?></th>
                            <th><?= _lang('login_ip') ?></th>
                            <th><?= _lang('active_time') ?></th>
                            <th><?= _lang('create_time') ?></th>
                            <th><?= _lang('operation') ?></th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php
                        foreach ($users as $key => $val):
                            $avatar = User::getAvatar($user_cache[$val['uid']]['avatar']);
                            $forbid = $val['state'] == 1;
                            $user_log_num = isset($sta_cache[$val['uid']]['lognum']) ? $sta_cache[$val['uid']]['lognum'] : 0;
                        ?>
                            <tr>
                                <td style="width: 19px;">
                                    <input type="checkbox" name="user_ids[]" value="<?= $val['uid'] ?>" class="ids" />
                                </td>
                                <td style="width: 25px;"><img src="<?= $avatar ?>" height="35" width="35" class="rounded-circle" /></td>
                                <td>
                                    <a href="user.php?action=edit&uid=<?= $val['uid'] ?>"><?= empty($val['name']) ? $val['login'] : $val['name'] ?></a>
                                    <span class="small"><?= $val['role'] ?></span>
                                    <?php if ($forbid): ?>
                                        <span class="badge badge-warning"><?= _lang('forbidden') ?></span>
                                    <?php endif ?>
                                    <br />
                                    <span class="small mr-2"> ID:<?= $val['uid'] ?></span>
                                    <span class="small mr-2"><?= _lang('article') ?>:<a href="article.php?uid=<?= $val['uid'] ?>"><?= $user_log_num ?></a></span>
                                    <span class="small"> <?= _lang('credits') ?>:<?= $val['credits'] ?></span>
                                </td>
                                <td><?= $val['email'] ?></td>
                                <td><?= $val['ip'] ?></td>
                                <td><?= $val['update_time'] ?></td>
                                <td><?= $val['create_time'] ?></td>
                                <td>
                                    <?php if (UID != $val['uid']): ?>
                                        <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'del_user', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger"><?= _lang('delete') ?></a>
                                        <?php if ($forbid): ?>
                                            <a href="user.php?action=unforbid&uid=<?= $val['uid'] ?>&token=<?= LoginAuth::genToken() ?>" class="badge badge-success"><?= _lang('unforbid') ?></a>
                                        <?php else: ?>
                                            <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'forbid_user', '<?= LoginAuth::genToken() ?>');" class="badge badge-warning"><?= _lang('forbid') ?></a>
                                        <?php endif ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <input name="operate" id="operate" value="" type="hidden" />
        </form>
        <div class="form-inline">
            <div class="btn-group">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?= _lang('operation') ?></button>
                <div class="dropdown-menu">
                    <a href="javascript:useract('forbid');" class="dropdown-item text-warning"><?= _lang('forbid') ?></a>
                    <a href="javascript:useract('unforbid');" class="dropdown-item"><?= _lang('unforbid') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page"><?= $pageurl ?></div>
<div class="d-flex justify-content-center mb-4 small">
    <form action="user.php" method="get" class="form-inline d-flex flex-wrap justify-content-center align-items-center">
        <label for="perpage_num" class="mr-2"><?= _lang('total') ?> <?= $userCount ?>, <?= _lang('per_page') ?></label>
        <select name="perpage_num" id="perpage_num" class="form-control form-control-sm w-auto" onChange="this.form.submit();">
            <option value="10" <?= ($perPage == 10) ? 'selected' : '' ?>>10</option>
            <option value="20" <?= ($perPage == 20) ? 'selected' : '' ?>>20</option>
            <option value="50" <?= ($perPage == 50) ? 'selected' : '' ?>>50</option>
            <option value="100" <?= ($perPage == 100) ? 'selected' : '' ?>>100</option>
            <option value="500" <?= ($perPage == 500) ? 'selected' : '' ?>>500</option>
        </select>
    </form>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('add_user') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="user.php?action=new" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role"><?= _lang('user_group') ?></label>
                        <select name="role" id="role" class="form-control">
                            <option value="writer"><?= _lang('role_writer') ?></option>
                            <option value="editor"><?= _lang('role_editor') ?></option>
                            <option value="admin"><?= _lang('role_admin') ?></option>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        <?= _lang('user_group_intro_1') ?><br>
                        <?= _lang('user_group_intro_2') ?><br>
                        <?= _lang('user_group_intro_3') ?><br>
                    </div>
                    <div class="form-group">
                        <label for="email"><?= _lang('login_email') ?></label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $email ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><?= _lang('password_min_6') ?></label>
                        <input class="form-control" id="password" minlength="6" name="password" autocomplete="new-password" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password2"><?= _lang('password_repeat') ?></label>
                        <input class="form-control" id="password2" minlength="6" name="password2" type="password" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                    <span id="alias_msg_hook"></span>
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
        setTimeout(hideActived, 3600);
        $("#menu_user").addClass('active');
        initCheckboxSelectAll('#checkAllItem', '.checkboxContainer');
        initShortcutBar();
    }

    function selectOrder(obj) {
        window.open("./user.php?order=" + obj.value, "_self");
    }

    function useract(act) {
        if (getChecked('ids') === false) {
            infoAlert('<?= _lang('select_user') ?>');
            return;
        }

        if (act === 'forbid') {
            delAlert2('', '<?= _lang('confirm_forbid_user') ?>', function() {
                    $("#operate").val("forbid");
                    $("#form_user").submit();
                },
                '<?= _lang('forbid') ?>')
            return;
        }

        if (act === 'unforbid') {
            delAlert2('', '<?= _lang('confirm_unforbid_user') ?>', function() {
                    $("#operate").val("unforbid");
                    $("#form_user").submit();
                },
                '<?= _lang('unforbid') ?>')
            return;
        }

        $("#operate").val(act);
        $("#form_user").submit();
    }
</script>