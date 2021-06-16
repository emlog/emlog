<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_update'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('user_modify_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('user_add_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_login'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('user_name_empty')?></div><?php endif; ?>
<?php if (isset($_GET['error_exist'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('user_name_exists')?></div><?php endif; ?>
<?php if (isset($_GET['error_pwd_len'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('password_length_short')?></div><?php endif; ?>
<?php if (isset($_GET['error_pwd2'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('passwords_not_equal')?></div><?php endif; ?>
<?php if (isset($_GET['error_del_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('founder_not_delete')?></div><?php endif; ?>
<?php if (isset($_GET['error_del_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('founder_not_edit')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('user_management')?></h1>
<!--vot--><a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#exampleModal"><i class="icofont-plus"></i> <?=lang('user_add')?></a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
<!--vot--><h6 class="m-0 font-weight-bold"><?=lang('users_total')?> (<?php echo $usernum; ?>)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
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
                        <td><img src="<?php echo $avatar; ?>" height="40" width="40" class="rounded-circle"/></td>
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
<!--vot-->                  <?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? lang('founder') : lang('admin')) : lang('user'); ?>
<!--vot-->                  <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo lang('posts_need_audit'); ?>
                        </td>
                        <td><a href="article.php?uid=<?php echo $val['uid']; ?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
                        <td>
							<?php
							if (UID != $val['uid']): ?>
<!--vot-->                      <a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger"><?=lang('delete')?></a>
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
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('user_add')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="user.php?action=new" method="post">
                <div class="modal-body">
                    <div class="form-group">
<!--vot-->              <label for="sortname"><?=lang('role')?></label>
                        <select name="role" id="role" class="form-control">
<!--vot-->                  <option value="writer"><?=lang('author_contributor')?></option>
<!--vot-->                  <option value="admin"><?=lang('admin')?></option>
                        </select>
                    </div>
                    <div class="form-group">
<!--vot-->              <label for="sortname"><?=lang('user_name')?></label>
                        <input class="form-control" id="login" name="login" required>
                    </div>
                    <div class="form-group">
<!--vot-->              <label for="alias"><?=lang('password_min_length')?></label>
                        <input class="form-control" id="password" name="password" type="password" required>
                    </div>
                    <div class="form-group">
<!--vot-->              <label for="template"><?=lang('password_repeat')?></label>
                        <input class="form-control" id="password2" name="password2" type="password" required>
                    </div>
                    <div class="form-group" id="ischeck">
<!--vot-->                  <label for="template"><?=lang('publish_permission')?></label>
                        <select name="ischeck" class="form-control">
<!--vot-->                  <option value="n"><?=lang('posts_not_need_audit')?></option>
<!--vot-->                  <option value="y"><?=lang('posts_need_audit')?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('save')?></button>
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
