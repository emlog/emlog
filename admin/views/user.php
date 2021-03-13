<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
<!--vot--><?php if (isset($_GET['active_del'])): ?><div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_update'])): ?><div class="alert alert-success"><?=lang('user_modify_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_add'])): ?><div class="alert alert-success"><?=lang('user_add_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_login'])): ?><div class="alert alert-danger"><?=lang('user_name_empty')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_exist'])): ?><div class="alert alert-danger"><?=lang('user_name_exists')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_pwd_len'])): ?><div class="alert alert-danger"><?=lang('password_length_short')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_pwd2'])): ?><div class="alert alert-danger"><?=lang('passwords_not_equal')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_del_a'])): ?><div class="alert alert-danger"><?=lang('founder_not_delete')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_del_b'])): ?><div class="alert alert-danger"><?=lang('founder_not_edit')?></div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('user_management')?></h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> 添加用户</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
<!--vot-->  <h6 class="m-0 font-weight-bold"><?=lang('users_total')?> (<?php echo $usernum; ?>)</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover dataTable no-footer" id="adm_comment_list">
                <thead>
                <tr>
                    <th></th>
<!--vot-->          <th><?=lang('user')?></th>
<!--vot-->          <th><?=lang('description')?></th>
<!--vot-->          <th><?=lang('email')?></th>
<!--vot-->          <th><?=lang('posts')?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $key => $val):
                    $avatar = empty($user_cache[$val['uid']]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[$val['uid']]['avatar'];
                    ?>
                    <tr>
                        <td style="padding:3px; text-align:center;"><img src="<?php echo $avatar; ?>" height="40" width="40"/></td>
                        <td>
                            <?php echo empty($val['name']) ? $val['login'] : $val['name']; ?><br/>
<!--vot-->                  <?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? lang('founder') : lang('admin')) : lang('user'); ?>
<!--vot-->                  <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo lang('posts_need_audit'); ?>
                        </td>
                        <td>
<!--vot-->                  <?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? lang('founder') : lang('admin')) : lang('user'); ?>
<!--vot-->                  <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo lang('posts_need_audit'); ?>
                        </td>
                        <td><a href="admin_log.php?uid=<?php echo $val['uid']; ?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
                        <td>
                            <?php
                            if (UID != $val['uid']): ?>
<!--vot-->                      <a href="user.php?action=edit&uid=<?php echo $val['uid'] ?>"><?=lang('edit')?></a>
<!--vot-->                      <a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');"
                                   class="care"><?=lang('delete')?></a>
                            <?php else: ?>
<!--vot-->                      <a href="blogger.php"><?=lang('edit')?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="page"><?php echo $pageurl; ?></div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
<!--vot-->          <h5 class="modal-title" id="exampleModalLabel"><?=lang('')?>添加用户</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="user.php?action=new" method="post">
                    <div class="modal-body">
                        <div class="form-group">
<!--vot-->                  <label for="sortname"><?=lang('role')?></label>
                            <select name="role" id="role" class="form-control">
<!--vot-->                      <option value="writer"><?=lang('author_contributor')?></option>
<!--vot-->                      <option value="admin"><?=lang('admin')?></option>
                            </select>
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="sortname"><?=lang('user_name')?></label>
                            <input class="form-control" id="login" name="login">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('password_min_length')?></label>
                            <input class="form-control" id="password" name="password" type="password">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="template"><?=lang('password_repeat')?></label>
                            <input class="form-control" id="password2" name="password2" type="password">
                        </div>
                        <div class="form-group" id="ischeck">
<!--vot-->                  <label for="template"><?=lang('publish_permission')?></label>
                            <select name="ischeck" class="form-control">
<!--vot-->                      <option value="n"><?=lang('posts_not_need_audit')?></option>
<!--vot-->                      <option value="y"><?=lang('posts_need_audit')?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
                        <button type="submit" class="btn btn-success">保存</button>
                        <span id="alias_msg_hook"></span>
                    </div>
                </form>
            </div>
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
