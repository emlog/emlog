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
        <th width="90"><b><? echo $lang['user_name'];?></b></th>
        <th width="100"><b><? echo $lang['nickname'];?></b></th>
        <th width="260"><b><? echo $lang['personal_description'];?></b></th>
        <th width="80"><b><? echo $lang['email'];?></b></th>
		<th width="30" class="tdcenter"><b><? echo $lang['posts'];?></b></th>
		<th width="130"></th>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($users as $key => $val):
	?>
     <tr>
        <td><a href="user.php?action=edit&uid=<?php echo $val['uid']?>"><?php echo $val['login']; ?></a></td>
		<td><?php echo $val['name']; ?></td>
		<td><?php echo $val['description']; ?></td>
		<td><?php echo $val['email']; ?></td>
		<td class="tdcenter"><a href="./admin_log.php?uid=<?php echo $val['uid'];?>"><?php echo $sta_cache[$val['uid']]['lognum']; ?></a></td>
		<td><a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user');"><? echo $lang['remove'];?></a></td>
     </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<form action="user.php?action=new" method="post">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('user_new', 2);"><? echo $lang['user_add_info'];?> &raquo;</a></div>
<div id="user_new">
	<li><? echo $lang['user_name'];?></li>
	<li><input name="login" type="text" id="login" value="" style="width:180px;" /></li>
	<li><? echo $lang['password'];?></li>
	<li><input name="password" type="password" id="password" value="" style="width:180px;" /></li>
	<li><? echo $lang['password_repeat'];?></li>
	<li><input name="password2" type="password" id="password2" value="" style="width:180px;" /></li>
	<li><br></li>
	<li><input type="submit" name="" value="<? echo $lang['user_add'];?>"  /></li>
</div>
</div>
</form>
<script type='text/javascript'>
$("#user_new").css('display', $.cookie('em_user_new') ? $.cookie('em_user_new') : 'none');
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_user").addClass('sidebarsubmenu1');
</script>