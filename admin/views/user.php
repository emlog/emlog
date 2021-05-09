<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif; ?>
<?php if (isset($_GET['active_update'])): ?>
    <div class="alert alert-success">修改用户资料成功</div><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加用户成功</div><?php endif; ?>
<?php if (isset($_GET['error_login'])): ?>
    <div class="alert alert-danger">用户名不能为空</div><?php endif; ?>
<?php if (isset($_GET['error_exist'])): ?>
    <div class="alert alert-danger">该用户名已存在</div><?php endif; ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
    <div class="alert alert-danger">密码长度不得小于6位</div><?php endif; ?>
<?php if (isset($_GET['error_pwd2'])): ?>
    <div class="alert alert-danger">两次输入密码不一致</div><?php endif; ?>
<?php if (isset($_GET['error_del_a'])): ?>
    <div class="alert alert-danger">不能删除创始人</div><?php endif; ?>
<?php if (isset($_GET['error_del_b'])): ?>
    <div class="alert alert-danger">不能修改创始人信息</div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">用户管理</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> 添加用户</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">已创建的用户 (<?php echo $usernum; ?>)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover dataTable no-footer" id="adm_comment_list">
                <thead>
                <tr>
                    <th></th>
                    <th>用户</th>
                    <th>角色</th>
                    <th>文章数</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
				<?php
				foreach ($users as $key => $val):
					$avatar = empty($user_cache[$val['uid']]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[$val['uid']]['avatar'];
					?>
                    <tr>
                        <td><img src="<?php echo $avatar; ?>" height="40" width="40"/></td>
                        <td>
							<?php
							if (UID != $val['uid']): ?>
                                <a href="user.php?action=edit&uid=<?php echo $val['uid'] ?>"><?php echo empty($val['name']) ? $val['login'] : $val['name']; ?></a>
							<?php else: ?>
                                <a href="blogger.php"><?php echo empty($val['name']) ? $val['login'] : $val['name']; ?></a>
							<?php endif; ?>
							<?php echo "<br/>" . $val['description']; ?>
                        </td>
                        <td>
							<?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? '创始人' : '管理员') : '作者'; ?>
							<?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo '(文章需审核)'; ?>
                        </td>
                        <td><a href="article.php?uid=<?php echo $val['uid']; ?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
                        <td>
							<?php
							if (UID != $val['uid']): ?>
                                <a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger">删除</a>
							<?php endif; ?>
                        </td>
                    </tr>
				<?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="page"><?php echo $pageurl; ?></div>

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
                        <label for="sortname">角色</label>
                        <select name="role" id="role" class="form-control">
                            <option value="writer">作者（投稿人）</option>
                            <option value="admin">管理员</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sortname">用户名</label>
                        <input class="form-control" id="login" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="alias">密码 (大于6位)</label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="template">重复密码</label>
                        <input class="form-control" id="password2" name="password2" type="password" required>
                    </div>
                    <div class="form-group" id="ischeck">
                        <label for="template">发布权限</label>
                        <select name="ischeck" class="form-control">
                            <option value="n">文章不需要审核</option>
                            <option value="y">文章需要审核</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
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
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_user").addClass('active');
</script>
