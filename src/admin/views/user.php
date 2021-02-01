<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!--vot--><?php if (isset($_GET['active_del'])): ?><span class="alert alert-success"><?=lang('deleted_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_update'])): ?><span class="alert alert-success"><?=lang('user_modify_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_add'])): ?><span class="alert alert-success"><?=lang('user_add_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_login'])): ?><span class="alert alert-danger"><?=lang('user_name_empty')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_exist'])): ?><span class="alert alert-danger"><?=lang('user_name_exists')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_pwd_len'])): ?><span class="alert alert-danger"><?=lang('password_length_short')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_pwd2'])): ?><span class="alert alert-danger"><?=lang('passwords_not_equal')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_del_a'])): ?><span class="alert alert-danger"><?=lang('founder_not_delete')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_del_b'])): ?><span class="alert alert-danger"><?=lang('founder_not_edit')?></span><?php endif; ?>
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800"><?=lang('user_management')?></h1>
    <form action="link.php?action=link_taxis" method="post">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?=lang('user_management')?></h6>
            </div>
            <div class="card-body">
                <form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
                    <table class="table table-bordered table-striped table-hover dataTable no-footer"
                           id="adm_comment_list">
                        <thead>
                        <tr>
                            <th width="60"></th>
<!--vot-->                  <th width="220"><b><?=lang('user')?></b></th>
<!--vot-->                  <th width="250"><b><?=lang('description')?></b></th>
<!--vot-->                  <th width="240"><b><?=lang('email')?></b></th>
<!--vot-->                  <th width="30" class="tdcenter"><b><?=lang('posts')?></b></th>
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
<!--vot-->                              <?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? lang('founder') : lang('admin')) : lang('user'); ?>
<!--vot-->                              <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo lang('posts_need_audit'); ?>
                                        <?php
                                        if (UID != $val['uid']): ?>
<!--vot-->                                  <a href="user.php?action=edit&uid=<?php echo $val['uid'] ?>"><?=lang('edit')?></a>
<!--vot-->                                  <a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');"
                                               class="care"><?=lang('delete')?></a>
                                        <?php else: ?>
<!--vot-->                                  <a href="blogger.php"><?=lang('edit')?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $val['description']; ?></td>
                                    <td><?php echo $val['email']; ?></td>
                                    <td class="tdcenter"><a
                                                href="./admin_log.php?uid=<?php echo $val['uid']; ?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                            <tr>
<!--vot-->                      <td class="tdcenter" colspan="6"><?=lang('no_authors_yet')?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
<!--vot--><div class="page"><?php echo $pageurl; ?> (<?=lang('have')?><?php echo $usernum; ?><?=lang('_users')?>)</div>
<!--vot--><div style="margin:10px 0px 30px 0px;"><a href="javascript:displayToggle('user_new', 2);"
                                                  class="btn btn-success"><?=lang('user_add')?>+</a></div>
        <form action="user.php?action=new" method="post">
            <div class="form-group">
<!--vot-->      <label for="sortname"><?=lang('user_name')?></label>
                <input class="form-control" id="login" name="login">
            </div>
            <div class="form-group">
<!--vot-->      <label for="alias"><?=lang('password_min_length')?></label>
                <input class="form-control" id="password" name="password" type="password">
            </div>
            <div class="form-group">
<!--vot-->      <label for="template"><?=lang('password_repeat')?></label>
                <input class="form-control" id="password2" name="password2" type="password">
            </div>
            <div class="form-group">
<!--vot-->      <label for="template"><?=lang('publish_permission')?></label>
                <select name="ischeck" class="form-control">
<!--vot-->          <option value="n"><?=lang('posts_not_need_audit')?></option>
<!--vot-->          <option value="y"><?=lang('posts_need_audit')?></option>
                </select>
            </div>
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->  <button type="submit" id="addsort" class="btn btn-primary"><?=lang('submit')?></button>
            <span id="alias_msg_hook"></span>
        </form>
</div>
<!-- /.container-fluid -->
<script>
    $("#user_new").css('display', $.cookie('em_user_new') ? $.cookie('em_user_new') : 'none');
    $(document).ready(function () {
        $("#role").change(function () {
            $("#ischeck").toggle()
        })
    });
    setTimeout(hideActived, 2600);
    $("#menu_sys").addClass('in');
    $("#menu_user").addClass('active');
</script>
