<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success"><?= lang('deleted_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_fb'])): ?>
    <div class="alert alert-success"><?= lang('user_ban_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_unfb'])): ?>
    <div class="alert alert-success"><?= lang('user_unban_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_update'])): ?>
    <div class="alert alert-success"><?= lang('user_modify_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success"><?= lang('user_add_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_email'])): ?>
    <div class="alert alert-danger"><?= lang('email_in_use') ?></div><?php endif ?>
<?php if (isset($_GET['error_exist_email'])): ?>
    <div class="alert alert-danger"><?= lang('email_empty') ?></div><?php endif ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger"><?= lang('password_length_short') ?></div><?php endif ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger"><?= lang('passwords_not_equal') ?></div><?php endif ?>
<?php if (isset($_GET['error_del_a'])): ?>
    <div class="alert alert-danger"><?= lang('founder_not_delete') ?></div><?php endif ?>
<?php if (isset($_GET['error_del_b'])): ?>
    <div class="alert alert-danger"><?= lang('founder_not_edit') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= lang('user_management') ?></h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?= lang('user_add') ?></a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <h6 class="m-0 font-weight-bold"><?= lang('users_total') ?> (<?= $usernum ?>)</h6>

            </div>
            <form action="user.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="email" value="<?= $email ?>" class="form-control m-1 small" placeholder="<?= lang('search_by_email') ?>">
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
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable no-footer" id="adm_comment_list">
                <thead>
                <tr>
                    <th></th>
                    <th><?= lang('user_name') ?></th>
                    <th><?= lang('email') ?></th>
                    <th><?= lang('user_id') ?></th>
                    <th><?= lang('posts') ?></th>
                    <th><?= lang('login_ip') ?></th>
                    <th><?= lang('last_login_time') ?></th>
                    <th><?= lang('create_time') ?></th>
                    <th><?= lang('operation') ?></th>
                </tr>
                </thead>
                <tbody>
				<?php
				foreach ($users as $key => $val):
					$avatar = empty($user_cache[$val['uid']]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[$val['uid']]['avatar'];
					$forbid = $val['state'] == 1;
					$user_log_num = isset($sta_cache[$val['uid']]['lognum']) ? $sta_cache[$val['uid']]['lognum'] : 0;
					?>
                    <tr>
                        <td><img src="<?= $avatar ?>" height="35" width="35" class="rounded-circle"/></td>
                        <td>
							<?php if (UID != $val['uid']): ?>
                                <a href="user.php?action=edit&uid=<?= $val['uid'] ?>"><?= empty($val['name']) ? $val['login'] : $val['name'] ?></a>
							<?php else: ?>
                                <a href="blogger.php"><?= empty($val['name']) ? $val['login'] : $val['name'] ?></a>
							<?php endif ?>
                            <span class="small"><?= "<br/>" . $val['role'] ?></span>
							<?php if ($forbid): ?>
                                <span class="badge badge-warning"><?= lang('disabled') ?></span>
							<?php endif ?>
                        </td>
                        <td><?= $val['email'] ?></td>
                        <td><?= $val['uid'] ?></td>
                        <td><a href="article.php?uid=<?= $val['uid'] ?>"><?= $user_log_num ?></a></td>
                        <td><?= $val['ip'] ?></td>
                        <td><?= $val['update_time'] ?></td>
                        <td><?= $val['create_time'] ?></td>
                        <td>
							<?php if (UID != $val['uid']): ?>
                                <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'del_user', '<?= LoginAuth::genToken() ?>');"
                                   class="badge badge-danger"><?= lang('delete') ?></a>
								<?php if ($forbid): ?>
                                    <a href="user.php?action=unforbid&uid=<?= $val['uid'] ?>&token=<?= LoginAuth::genToken() ?>"
                                       class="badge badge-success"><?= lang('unban') ?></a>
								<?php else: ?>
                                    <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'forbid_user', '<?= LoginAuth::genToken() ?>');"
                                       class="badge badge-warning"><?= lang('ban') ?></a>
								<?php endif ?>
							<?php endif ?>
                        </td>
                    </tr>
				<?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="page"><?= $pageurl ?></div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('user_add') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="user.php?action=new" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname"><?= lang('role') ?></label>
                        <select name="role" id="role" class="form-control">
                            <option value="writer"><?= lang('registered_user') ?></option>
                            <option value="editor"><?= lang('editor') ?></option>
                            <option value="admin"><?= lang('admin') ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username"><?= lang('email') ?></label>
                        <input class="hidden-auto-filling" name="email" style="width: 0;border: 0;opacity: 0">
                        <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><?= lang('password_min_length') ?></label>
                        <input class="hidden-auto-filling" type="password" name="psw" style="width: 0;border: 0;opacity: 0">
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password2"><?= lang('password_repeat') ?></label>
                        <input class="form-control" id="password2" name="password2" type="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?= lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= lang('save') ?></button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#role").change(function () {
            $("#ischeck").toggle()
        })
    });
    setTimeout(hideActived, 2600);
    $("#menu_user").addClass('active');
</script>
