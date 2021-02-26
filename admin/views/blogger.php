<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!--vot--><?php if (isset($_GET['active_edit'])): ?><div class="alert alert-success"><?=lang('personal_data_modified_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_del'])): ?><div class="alert alert-success"><?=lang('avatar_deleted_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger"><?=lang('nickname_too_long')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_b'])): ?><div class="alert alert-danger"><?=lang('email_format_invalid')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_c'])): ?><div class="alert alert-danger"><?=lang('password_length_short')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_d'])): ?><div class="alert alert-danger"><?=lang('password_not_equal')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_e'])): ?><div class="alert alert-danger"><?=lang('username_exists')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_f'])): ?><div class="alert alert-danger"><?=lang('nickname_exists')?></div><?php endif; ?>
<div class="panel-heading">
    <?php if (ROLE == ROLE_ADMIN): ?>
        <ul class="nav nav-tabs">
<!--vot--><li class="nav-item"><a class="nav-link" href="./configure.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link" href="./seo.php"><?=lang('seo_settings')?></a></li>
<!--vot--><li class="nav-item"><a class="nav-link active" href="./blogger.php"><?=lang('personal_settings')?></a></li>
        </ul>

    <?php else: ?>
        <ul class="nav nav-tabs" role="tablist">
<!--vot-->  <li role="presentation" class="active"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
        </ul>
    <?php endif; ?>
</div>
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
    <div class="form-group" style="margin-left:30px;">
        <li><?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/></li>
        <li>
<!--vot-->  <label><?=lang('avatar')?> <?=lang('avatar_format_supported')?></label>
            <input name="photo" type="file"/>
        </li>
<!--vot--><li><label><?=lang('nickname')?></label><input maxlength="50" style="width:200px;" class="form-control" value="<?= $nickname ?>" name="name"> </li>
<!--vot--><li><label><?=lang('email')?></label><input name="email" class="form-control" value="<?= $email ?>" style="width:200px;" maxlength="200"></li>
<!--vot--><li><label><?=lang('personal_description')?></label><textarea name="description" class="form-control" style="width:300px; height:65px;" type="text" maxlength="500"><?= $description ?></textarea></li>
<!--vot--><li><label><?=lang('login_name')?></label><input maxlength="200" style="width:200px;" class="form-control" value="<?= $username ?>" name="username"></li>
<!--vot--><li><label><?=lang('new_password_info')?></label><input type="password" maxlength="200" class="form-control" style="width:200px;" value="" name="newpass"></li>
<!--vot--><li><label><?=lang('new_password_repeat')?></label><input type="password" maxlength="200" class="form-control" style="width:200px;" value="" name="repeatpass"></li>
        <li>
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->  <input type="submit" value="<?=lang('save_data')?>" class="btn btn-primary">
        </li>
    </div>
</form>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    // $("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
    setTimeout(hideActived, 2600);
</script>
