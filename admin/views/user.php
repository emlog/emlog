<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_unfb'])): ?>
    <div class="alert alert-success">解禁成功</div><?php endif ?>
<?php if (isset($_GET['active_update'])): ?>
    <div class="alert alert-success">修改成功</div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加用户成功</div><?php endif ?>
<?php if (isset($_GET['error_email'])): ?>
    <div class="alert alert-danger">邮箱不能为空</div><?php endif ?>
<?php if (isset($_GET['error_exist_email'])): ?>
    <div class="alert alert-danger">该邮箱已被占用</div><?php endif ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger">密码长度不得小于6位</div><?php endif ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger">两次输入密码不一致</div><?php endif ?>
<?php if (isset($_GET['error_del_a'])): ?>
    <div class="alert alert-danger">不能删除创始人</div><?php endif ?>
<?php if (isset($_GET['error_del_b'])): ?>
    <div class="alert alert-danger">不能修改创始人信息</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">用户</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> 添加用户</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <div id="f_t_order" class="mx-1">
                    <select name="order" id="order" onChange="selectOrder(this);" class="form-control">
                        <option value="date" <?= (empty($order)) ? 'selected' : '' ?>>最近注册</option>
                        <option value="update" <?= ($order === 'update') ? 'selected' : '' ?>>最近活跃</option>
                        <option value="admin" <?= ($order === 'admin') ? 'selected' : '' ?>>管理员优先</option>
                    </select>
                </div>
            </div>
            <form action="user.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control m-1 small" placeholder="输入邮箱或用户昵称搜索...">
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
                            <th>头像</th>
                            <th>昵称</th>
                            <th>邮箱</th>
                            <th>登录IP</th>
                            <th>活跃时间</th>
                            <th>创建时间</th>
                            <th>操作</th>
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
                                        <span class="badge badge-warning">已禁用</span>
                                    <?php endif ?>
                                    <br />
                                    <span class="small mr-2"> ID:<?= $val['uid'] ?></span>
                                    <span class="small mr-2">文章:<a href="article.php?uid=<?= $val['uid'] ?>"><?= $user_log_num ?></a></span>
                                    <span class="small"> 积分:<?= $val['credits'] ?></span>
                                </td>
                                <td><?= $val['email'] ?></td>
                                <td><?= $val['ip'] ?></td>
                                <td><?= $val['update_time'] ?></td>
                                <td><?= $val['create_time'] ?></td>
                                <td>
                                    <?php if (UID != $val['uid']): ?>
                                        <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'del_user', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
                                        <?php if ($forbid): ?>
                                            <a href="user.php?action=unforbid&uid=<?= $val['uid'] ?>&token=<?= LoginAuth::genToken() ?>" class="badge badge-success">解禁</a>
                                        <?php else: ?>
                                            <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'forbid_user', '<?= LoginAuth::genToken() ?>');" class="badge badge-warning">禁用</a>
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
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">操作</button>
                <div class="dropdown-menu">
                    <a href="javascript:useract('forbid');" class="dropdown-item text-warning">禁用</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page"><?= $pageurl ?></div>
<div class="d-flex justify-content-center mb-4 small">
    <form action="user.php" method="get" class="form-inline">
        <label for="perpage_num" class="mr-2">有 <?= $userCount ?> 个用户，每页显示</label>
        <select name="perpage_num" id="perpage_num" class="form-control form-control-sm" onChange="this.form.submit();">
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">添加用户</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="user.php?action=new" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role">用户组</label>
                        <select name="role" id="role" class="form-control">
                            <option value="writer">注册用户</option>
                            <option value="editor">内容编辑</option>
                            <option value="admin">管理员</option>
                        </select>
                    </div>
                    <div class="alert alert-warning">
                        注册用户：可以发文投稿、管理自己的文章、图文资源<br>
                        内容编辑：负责全站文章、资源、评论等内容的管理<br>
                        管理员：拥有站点全部管理权限，可以管理用户、进行系统设置等<br>
                    </div>
                    <div class="form-group">
                        <label for="email">登录邮箱</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $email ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">密码 (不少于6位)</label>
                        <input class="form-control" id="password" minlength="6" name="password" autocomplete="new-password" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password2">再次输入密码</label>
                        <input class="form-control" id="password2" minlength="6" name="password2" type="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_user").addClass('active');
    });

    function selectOrder(obj) {
        window.open("./user.php?order=" + obj.value, "_self");
    }

    function useract(act) {
        if (getChecked('ids') === false) {
            infoAlert('请选择用户');
            return;
        }

        if (act === 'forbid') {
            delAlert2('', '封禁所选用户？', function() {
                    $("#operate").val("forbid");
                    $("#form_user").submit();
                },
                '封禁')
            return;
        }

        $("#operate").val(act);
        $("#form_user").submit();
    }
</script>