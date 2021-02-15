<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?><span class="alert alert-success">删除成功</span><?php endif; ?>
<?php if (isset($_GET['active_update'])): ?><span class="alert alert-success">修改用户资料成功</span><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?><span class="alert alert-success">添加用户成功</span><?php endif; ?>
<?php if (isset($_GET['error_login'])): ?><span class="alert alert-danger">用户名不能为空</span><?php endif; ?>
<?php if (isset($_GET['error_exist'])): ?><span class="alert alert-danger">该用户名已存在</span><?php endif; ?>
<?php if (isset($_GET['error_pwd_len'])): ?><span class="alert alert-danger">密码长度不得小于6位</span><?php endif; ?>
<?php if (isset($_GET['error_pwd2'])): ?><span class="alert alert-danger">两次输入密码不一致</span><?php endif; ?>
<?php if (isset($_GET['error_del_a'])): ?><span class="alert alert-danger">不能删除创始人</span><?php endif; ?>
<?php if (isset($_GET['error_del_b'])): ?><span class="alert alert-danger">不能修改创始人信息</span><?php endif; ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">用户管理</h1>
    </div>
    <form action="link.php?action=link_taxis" method="post">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">已创建的用户 (<?php echo $usernum; ?>)</h6>
            </div>
            <div class="card-body">
                <form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
                    <table class="table table-bordered table-striped table-hover dataTable no-footer"
                           id="adm_comment_list">
                        <thead>
                        <tr>
                            <th width="60"></th>
                            <th width="220"><b>用户</b></th>
                            <th width="250"><b>描述</b></th>
                            <th width="240"><b>电子邮件</b></th>
                            <th width="30" class="tdcenter"><b>文章</b></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($users):
                            foreach ($users as $key => $val):
                                $avatar = empty($user_cache[$val['uid']]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[$val['uid']]['avatar'];
                                ?>
                                <tr>
                                    <td style="padding:3px; text-align:center;"><img src="<?php echo $avatar; ?>"
                                                                                     height="40" width="40"/></td>
                                    <td>
                                        <?php echo empty($val['name']) ? $val['login'] : $val['name']; ?><br/>
                                        <?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? '创始人' : '管理员') : '作者'; ?>
                                        <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo '(文章需审核)'; ?>
                                        <?php
                                        if (UID != $val['uid']): ?>
                                            <a href="user.php?action=edit&uid=<?php echo $val['uid'] ?>">编辑</a>
                                            <a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');"
                                               class="care">删除</a>
                                        <?php else: ?>
                                            <a href="blogger.php">编辑</a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $val['description']; ?></td>
                                    <td><?php echo $val['email']; ?></td>
                                    <td class="tdcenter"><a
                                                href="admin_log.php?uid=<?php echo $val['uid']; ?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td class="tdcenter" colspan="6">还没有添加作者</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <div class="page"><?php echo $pageurl; ?></div>
        <div style="margin:10px 0px 30px 0px;"><a href="javascript:displayToggle('user_new', 2);"
                                                  class="btn btn-success">添加用户+</a></div>
        <form action="user.php?action=new" method="post">
            <div class="form-group">
                <label for="sortname">用户名</label>
                <input class="form-control" id="login" name="login">
            </div>
            <div class="form-group">
                <label for="alias">密码 (大于6位)</label>
                <input class="form-control" id="password" name="password" type="password">
            </div>
            <div class="form-group">
                <label for="template">重复密码</label>
                <input class="form-control" id="password2" name="password2" type="password">
            </div>
            <div class="form-group">
                <label for="template">发布权限</label>
                <select name="ischeck" class="form-control">
                    <option value="n">文章不需要审核</option>
                    <option value="y">文章需要审核</option>
                </select>
            </div>
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
            <button type="submit" id="addsort" class="btn btn-primary">提交</button>
            <span id="alias_msg_hook"></span>
        </form>
</div>

<script>
    // $("#user_new").css('display', $.cookie('em_user_new') ? $.cookie('em_user_new') : 'none');
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
