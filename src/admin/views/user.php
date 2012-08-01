<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['user_management'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['user_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_update'])):?><span class="actived"><? echo $lang['user_edited_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived"><? echo $lang['user_added_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_login'])):?><span class="error"><? echo $lang['user_name_empty'];?></span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="error"><? echo $lang['user_allready_exists'];?></span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error"><? echo $lang['password_short'];?></span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error"><? echo $lang['password_not_equal'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
        <th width="60"></th>
        <th width="100"><b><? echo $lang['author'];?></b></th>
        <th width="340"><b><? echo $lang['personal_description'];?></b></th>
        <th width="270"><b><? echo $lang['email'];?></b></th>
		<th width="30" class="tdcenter"><b><? echo $lang['posts'];?></b></th>
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
		<?php echo empty($val['name']) ? $val['login'] : $val['name']; ?>
		<br /><?php echo $val['role'] == 'admin' ? '管理员' : '作者'; ?>
		<span style="display:none; margin-left:8px;">
		<?php if (UID != $val['uid']): ?>
		<a href="user.php?action=edit&uid=<?php echo $val['uid']?>">编辑</a> 
		<a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user');">删除</a>
		<?php else:?>
		<a href="blogger.php">编辑</a>
		<?php endif;?>
		</span>
		</td>
		<td><?php echo $val['description']; ?></td>
		<td><?php echo $val['email']; ?></td>
		<td class="tdcenter"><a href="./admin_log.php?uid=<?php echo $val['uid'];?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
     </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="6">还没有添加作者</td></tr>
	<?php endif;?>
	</tbody>
  </table>
</form>
<form action="user.php?action=new" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('user_new', 2);"><? echo $lang['user_add_info'];?> &raquo;</a></div>
<div id="user_new">
	<li><input name="login" type="text" id="login" value="" style="width:180px;" /> 用户名</li>
	<li><input name="password" type="password" id="password" value="" style="width:180px;" /> 密码 (大于6位)</li>
	<li><input name="password2" type="password" id="password2" value="" style="width:180px;" /> 重复密码</li>
	<li>
	<select name="role">
		<option value="writer">作者</option>
		<option value="admin">管理员</option>
	</select>
	</li>
	<li><input type="submit" name="" value="添加用户"  /></li>
</div>
</div>
</form>
<script>
$("#user_new").css('display', $.cookie('em_user_new') ? $.cookie('em_user_new') : 'none');
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})
});
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
</script>