<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="panel-heading">
<?php if (ROLE == ROLE_ADMIN):?>
<ul class="nav nav-tabs" role="tablist">
<!--vot--><li role="presentation"><a href="./configure.php"><?=lang('basic_settings')?></a></li>
<!--vot--><li role="presentation"><a href="./seo.php"><?=lang('seo_settings')?></a></li>
<!--vot--><li role="presentation" class="active"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="alert alert-success"><?=lang('personal_data_modified_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('avatar_deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('nickname_too_long')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="alert alert-danger"><?=lang('email_format_invalid')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="alert alert-danger"><?=lang('password_length_short')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="alert alert-danger"><?=lang('password_not_equal')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="alert alert-danger"><?=lang('username_exists')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_f'])):?><span class="alert alert-danger"><?=lang('nickname_exists')?></span><?php endif;?>
</ul>
<?php else:?>
<ul class="nav nav-tabs" role="tablist">
<!--vot--><li role="presentation" class="active"><a href="./blogger.php"><?=lang('personal_settings')?></a></li>
</ul>
<?php endif;?>
</div>
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
<div class="form-group" style="margin-left:30px;">
    <li><?= $icon ?><input type="hidden" name="photo" value="<?= $photo ?>"/></li>
    <li>
<!--vot--><label><?=lang('avatar')?> <?=lang('avatar_format_supported')?></label>
    <input name="photo" type="file" />
    </li>
<!--vot--><li><label><?=lang('nickname')?></label><input maxlength="50" style="width:200px;" class="form-control" value="<?= $nickname ?>" name="name" /> </li>
<!--vot--><li><label><?=lang('email')?></label><input name="email" class="form-control" value="<?= $email ?>" style="width:200px;" maxlength="200" /></li>
<!--vot--><li><label><?=lang('personal_description')?></label><textarea name="description" class="form-control" style="width:300px; height:65px;" type="text" maxlength="500"><?= $description ?></textarea></li>
<!--vot--><li><label><?=lang('login_name')?></label><input maxlength="200" style="width:200px;" class="form-control" value="<?= $username ?>" name="username" /></li>
<!--vot--><li><label><?=lang('new_password_info')?></label><input type="password" maxlength="200" class="form-control" style="width:200px;" value="" name="newpass" /></li>
<!--vot--><li><label><?=lang('new_password_repeat')?></label><input type="password" maxlength="200" class="form-control" style="width:200px;" value="" name="repeatpass" /></li>
    <li>
        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
<!--vot--><input type="submit" value="<?=lang('save_data')?>" class="btn btn-primary" />
    </li>
</div>
</form>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived, 2600);
$("#menu_category_sys").addClass('active');
$("#menu_sys").addClass('in');
$("#menu_setting").addClass('active');
</script>
