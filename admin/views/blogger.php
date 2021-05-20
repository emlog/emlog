<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_edit'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('personal_data_modified_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('avatar_deleted_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('nickname_too_long')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('email_format_invalid')?></div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('password_length_short')?></div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('password_not_equal')?></div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('username_exists')?></div><?php endif; ?>
<?php if (isset($_GET['error_f'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('nickname_exists')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?=lang('settings')?></h1>
</div>
<div class="panel-heading">
	<?php if (ROLE == ROLE_ADMIN): ?>
        <ul class="nav nav-pills">
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
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
					<?php echo $icon; ?>
                    <input type="hidden" name="photo" value="<?php echo $photo; ?>"/>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('avatar')?> <?=lang('avatar_format_supported')?></label>
<!--vot-->          <input type="file" name="photo">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('nickname')?></label>
                    <input class="form-control" value="<?php echo $nickname; ?>" name="name">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('email')?></label>
                    <input name="email" class="form-control" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('personal_description')?></label>
                    <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('login_name')?></label>
                    <input class="form-control" value="<?php echo $username; ?>" name="username">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('new_password_info')?></label>
                    <input type="password" class="form-control" value="" name="newpass">
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('new_password_repeat')?></label>
                    <input type="password" class="form-control" value="" name="repeatpass">
                </div>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->      <input type="submit" value="<?=lang('save_data')?>" class="btn btn-sm btn-success"/>
            </div>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
