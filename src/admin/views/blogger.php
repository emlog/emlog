<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<?php if (ROLE == ROLE_ADMIN):?>
<!--vot--><a class="navi1" href="./configure.php"><?=lang('basic_settings')?></a>
<!--vot--><a class="navi4" href="./seo.php"><?=lang('seo_settings')?></a>
<!--vot--><a class="navi4" href="./style.php"><?=lang('background_style')?></a>
<!--vot--><a class="navi2" href="./blogger.php"><?=lang('personal_settings')?></a>
<?php else:?>
<!--vot--><a class="navi3" href="./blogger.php"><?=lang('personal_settings')?></a>
<?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="actived"><?=lang('personal_data_modified_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('avatar_deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('nickname_too_long')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('email_format_invalid')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="error"><?=lang('password_length_short')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="error"><?=lang('password_not_equal')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="error"><?=lang('username_exists')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_f'])):?><span class="error">'nickname_exists'</span><?php endif;?>
</div>
<form action="blogger.php?action=update" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
<div class="item_edit" style="margin-left:30px;">
    <li>
    <?php echo $icon; ?><input type="hidden" name="photo" value="<?php echo $photo; ?>"/><br />
<!--vot--><?=lang('avatar')?><br />
<!--vot--><input name="photo" type="file" /> <?=lang('avatar_format_supported')?>
    </li>
<!--vot--><li><?=lang('nickname')?><br /><input maxlength="50" style="width:200px;" class="input" value="<?php echo $nickname; ?>" name="name" /> </li>
<!--vot--><li><?=lang('email')?><br /><input name="email" class="input" value="<?php echo $email; ?>" style="width:200px;" maxlength="200" /></li>
<!--vot--><li><?=lang('personal_description')?><br /><textarea name="description" class="textarea" style="width:300px; height:65px;" type="text" maxlength="500"><?php echo $description; ?></textarea></li>
<!--vot--><li><input maxlength="200" style="width:200px;" class="input" value="<?php echo $username; ?>" name="username" /> <?=lang('login_name')?></li>
<!--vot--><li><input type="password" maxlength="200" class="input" style="width:200px;" value="" name="newpass" /> <?=lang('new_password_info')?></li>
<!--vot--><li><input type="password" maxlength="200" class="input" style="width:200px;" value="" name="repeatpass" /> <?=lang('new_password_repeat')?></li>
    <li>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--><input type="submit" value="<?=lang('save_data')?>" class="button" />
    </li>
</div>
</form>
<script>
$("#chpwd").css('display', $.cookie('em_chpwd') ? $.cookie('em_chpwd') : 'none');
setTimeout(hideActived,2600);
</script>