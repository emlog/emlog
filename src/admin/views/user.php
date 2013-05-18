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
		<br /><?php echo $val['role'] == 'admin' ? $lang['administrator'] : $lang['author']; ?>
		<span style="display:none; margin-left:8px;">
		<?php if (UID != $val['uid']): ?>
		<a href="user.php?action=edit&uid=<?php echo $val['uid']?>"><? echo $lang['edit']; ?></a> 
		<a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user');" class="care"><? echo $lang['remove']; ?></a>
		<?php else:?>
		<a href="blogger.php"><? echo $lang['edit']; ?></a>
		<?php endif;?>
		</span>
		</td>
		<td><?php echo $val['description']; ?></td>
		<td><?php echo $val['email']; ?></td>
		<td class="tdcenter"><a href="./admin_log.php?uid=<?php echo $val['uid'];?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
     </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="6"><? echo $lang['no_author_yet']; ?></td></tr>
	<?php endif;?>
	</tbody>
  </table>
</form>
<div class="page"><?php echo $pageurl; ?> (有<?php echo $usernum; ?>位用户)</div> 
<form action="user.php?action=new" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('user_new', 2);"><? echo $lang['user_add_info'];?> &raquo;</a></div>
<div id="user_new" class="item_edit">
	<li><input name="login" type="text" id="login" value="" style="width:180px;" /><? echo $lang['user_name']; ?></li>
	<li><input name="password" type="password" id="password" value="" style="width:180px;" /><? echo $lang['password']; ?> <? echo $lang['password_length']; ?></li>
	<li><input name="password2" type="password" id="password2" value="" style="width:180px;" /><? echo $lang['password_repeat']; ?></li>
	<li>
	<select name="role">
		<option value="writer"><? echo $lang['author']; ?></option>
		<option value="admin"><? echo $lang['administrator']; ?></option>
	</select>
	</li>
	<li><input type="submit" name="" value="<? echo $lang['user_add']; ?>" class="button" /></li>
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