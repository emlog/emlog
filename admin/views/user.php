<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['active_update'])): ?>
    <div class="alert alert-success">修改用户资料成功</div><?php endif ?>
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
    <h1 class="h3 mb-0 text-gray-800">用户</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> 添加用户</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <h6 class="m-0 font-weight-bold">总用户数 (<?= $usernum ?>)</h6>
            </div>
            <form action="user.php" method="get">
                <div class="form-inline">
                    <input type="text" name="email" value="<?= $email ?>" class="form-control bg-light border-0 small" placeholder="按邮箱搜索用户...">
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
                    <th>用户</th>
                    <th>邮箱</th>
                    <th>文章</th>
                    <th>登录IP</th>
                    <th>活跃时间</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
				<?php
				foreach ($users as $key => $val):
					$avatar = empty($user_cache[$val['uid']]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[$val['uid']]['avatar'];
					?>
                    <tr>
                        <td><img src="<?= $avatar ?>" height="35" width="35" class="rounded-circle"/></td>
                        <td>
							<?php
							if (UID != $val['uid']): ?>
                                <a href="user.php?action=edit&uid=<?= $val['uid'] ?>"><?= empty($val['name']) ? $val['login'] : $val['name'] ?></a>
							<?php else: ?>
                                <a href="blogger.php"><?= empty($val['name']) ? $val['login'] : $val['name'] ?></a>
							<?php endif ?>
                            <span class="small"><?= "<br/>" . $val['role'] ?></span>
                        </td>
                        <td>
							<?= $val['email'] ?>
                        </td>
                        <td><a href="article.php?uid=<?= $val['uid'] ?>"><?= $sta_cache[$val['uid']]['lognum'] ?></a></td>
                        <td><?= $val['ip'] ?></td>
                        <td><?= $val['update_time'] ?></td>
                        <td><?= $val['create_time'] ?></td>
                        <td>
							<?php
							if (UID != $val['uid']): ?>
                                <a href="javascript: em_confirm(<?= $val['uid'] ?>, 'user', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
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
                <h5 class="modal-title" id="exampleModalLabel">添加用户</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="user.php?action=new" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sortname">用户组</label>
                        <select name="role" id="role" class="form-control">
                            <option value="writer">注册用户</option>
                            <option value="admin">管理员</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">登录邮箱</label>
                        <input class="hidden-auto-filling" name="email" style="width: 0;border: 0;opacity: 0">
                        <input type="email" name="email" class="form-control" value="<?= $email ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">密码 (大于6位)</label>
                        <input class="hidden-auto-filling" type="password" name="psw" style="width: 0;border: 0;opacity: 0">
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password2">再次输入密码</label>
                        <input class="form-control" id="password2" name="password2" type="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">保存</button>
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
