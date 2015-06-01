<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('user_management')?></b>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_update'])):?><span class="alert alert-success"><?=lang('user_modify_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_add'])):?><span class="alert alert-success"><?=lang('user_add_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_login'])):?><span class="alert alert-danger"><?=lang('user_name_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_exist'])):?><span class="alert alert-danger"><?=lang('user_name_exists')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_pwd_len'])):?><span class="alert alert-danger"><?=lang('password_length_short')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_pwd2'])):?><span class="alert alert-danger"><?=lang('passwords_not_equal')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_del_a'])):?><span class="alert alert-danger"><?=lang('founder_not_delete')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_del_b'])):?><span class="alert alert-danger"><?=lang('founder_not_edit')?></span><?php endif;?>
</div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="adm_comment_list">
  	<thead>
      <tr>
        <th width="60"></th>
<!--vot--><th width="220"><b><?=lang('user')?></b></th>
<!--vot--><th width="250"><b><?=lang('description')?></b></th>
<!--vot--><th width="240"><b><?=lang('email')?></b></th>
<!--vot--><th width="30" class="tdcenter"><b><?=lang('posts')?></b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	if($users):
	foreach($users as $key => $val):
		$avatar = empty($user_cache[$val['uid']]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[$val['uid']]['avatar'];
	?>
     <tr>
        <td style="padding:3px; text-align:center;"><img src="<?php echo $avatar; ?>" height="40" width="40" /></td>
		<td>
		<?php echo empty($val['name']) ? $val['login'] : $val['name']; ?><br />
<!--vot-->      <?php echo $val['role'] == ROLE_ADMIN ? $val['uid'] == 1 ? lang('founder'):lang('admin') : lang('user'); ?>
<!--vot-->      <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo lang('posts_need_audit');?>
		<span style="display:none; margin-left:8px;">
		<?php 
        if (UID != $val['uid']): ?>
<!--vot-->    <a href="user.php?action=edit&uid=<?php echo $val['uid']?>"><?=lang('edit')?></a> 
<!--vot-->    <a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
		<?php else:?>
<!--vot-->    <a href="blogger.php"><?=lang('edit')?></a>
		<?php endif;?>
		</span>
		</td>
		<td><?php echo $val['description']; ?></td>
		<td><?php echo $val['email']; ?></td>
		<td class="tdcenter"><a href="./admin_log.php?uid=<?php echo $val['uid'];?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
     </tr>
	<?php endforeach;else:?>
<!--vot--><tr><td class="tdcenter" colspan="6"><?=lang('no_authors_yet')?></td></tr>
	<?php endif;?>
	</tbody>
  </table>
</form>
<!--vot--><div class="page"><?php echo $pageurl; ?> (<?=lang('have')?><?php echo $usernum; ?><?=lang('_users')?>)</div> 
<form action="user.php?action=new" method="post" class="form-inline">
<!--vot--><div style="margin:10px 0px 30px 0px;"><a href="javascript:displayToggle('user_new', 2);" class="btn btn-success"><?=lang('user_add')?>+</a></div>
<div id="user_new" class="form-group">
    <li>
	<select name="role" id="role" class="form-control">
<!--vot-->      <option value="writer"><?=lang('author_contributor')?></option>
<!--vot-->      <option value="admin"><?=lang('admin')?></option>
	</select>
	</li>
<!--vot--><li><input name="login" type="text" id="login" value="" style="width:180px;" class="form-control" /> <?=lang('user_name')?></li>
<!--vot--><li><input name="password" type="password" id="password" value="" style="width:180px;" class="form-control" /> <?=lang('password_min_length')?></li>
<!--vot--><li><input name="password2" type="password" id="password2" value="" style="width:180px;" class="form-control" /> <?=lang('password_repeat')?></li>
	<li id="ischeck">
	<select name="ischeck" class="form-control">
<!--vot-->    <option value="n"><?=lang('posts_not_need_audit')?></option>
<!--vot-->    <option value="y"><?=lang('posts_need_audit')?></option>
	</select>
	</li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--><li><input type="submit" name="" value="<?=lang('user_add')?>" class="btn btn-primary" /></li>
</div>
</form>
<script>
$("#user_new").css('display', $.cookie('em_user_new') ? $.cookie('em_user_new') : 'none');
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})
    $("#role").change(function(){$("#ischeck").toggle()})
});
setTimeout(hideActived,2600);
$("#menu_sys").addClass('in');
$("#menu_user").addClass('active');
</script>
