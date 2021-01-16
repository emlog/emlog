<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle">
<?php if(isset($_GET['active_del'])):?><span class="alert alert-success">删除成功</span><?php endif;?>
<?php if(isset($_GET['active_update'])):?><span class="alert alert-success">修改用户资料成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="alert alert-success">添加用户成功</span><?php endif;?>
<?php if(isset($_GET['error_login'])):?><span class="alert alert-danger">用户名不能为空</span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="alert alert-danger">该用户名已存在</span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="alert alert-danger">密码长度不得小于6位</span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="alert alert-danger">两次输入密码不一致</span><?php endif;?>
<?php if(isset($_GET['error_del_a'])):?><span class="alert alert-danger">不能删除创始人</span><?php endif;?>
<?php if(isset($_GET['error_del_b'])):?><span class="alert alert-danger">不能修改创始人信息</span><?php endif;?>
</div>
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">用户管理</h1>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="adm_comment_list">
  	<thead>
      <tr>
        <th width="60"></th>
        <th width="220"><b>用户</b></th>
        <th width="250"><b>描述</b></th>
        <th width="240"><b>电子邮件</b></th>
		<th width="30" class="tdcenter"><b>文章</b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	if($users):
	foreach($users as $key => $val):
		$avatar = empty($user_cache[$val['uid']]['avatar']) ? './templates/default/images/avatar.svg' : '../' . $user_cache[$val['uid']]['avatar'];
	?>
     <tr>
        <td style="padding:3px; text-align:center;"><img src="<?php echo $avatar; ?>" height="40" width="40" /></td>
		<td>
		<?php echo empty($val['name']) ? $val['login'] : $val['name']; ?><br />
		<?php echo $val['role'] == ROLE_ADMIN ? ($val['uid'] == 1 ? '创始人':'管理员') : '作者'; ?>
        <?php if ($val['role'] == ROLE_WRITER && $val['ischeck'] == 'y') echo '(文章需审核)';?>
		<span style="display:none; margin-left:8px;">
		<?php 
        if (UID != $val['uid']): ?>
		<a href="user.php?action=edit&uid=<?php echo $val['uid']?>">编辑</a> 
		<a href="javascript: em_confirm(<?php echo $val['uid']; ?>, 'user', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
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
<div class="page"><?php echo $pageurl; ?> (有<?php echo $usernum; ?>位用户)</div> 
<form action="user.php?action=new" method="post" class="form-inline">
<div style="margin:10px 0px 30px 0px;"><a href="javascript:displayToggle('user_new', 2);" class="btn btn-success">添加用户+</a></div>
<div id="user_new" class="form-group">
    <li>
	<select name="role" id="role" class="form-control">
		<option value="writer">作者（投稿人）</option>
		<option value="admin">管理员</option>
	</select>
	</li>
	<li><input name="login" type="text" id="login" value="" style="width:180px;" class="form-control" /> 用户名</li>
	<li><input name="password" type="password" id="password" value="" style="width:180px;" class="form-control" /> 密码 (大于6位)</li>
	<li><input name="password2" type="password" id="password2" value="" style="width:180px;" class="form-control" /> 重复密码</li>
	<li id="ischeck">
	<select name="ischeck" class="form-control">
        <option value="n">文章不需要审核</option>
		<option value="y">文章需要审核</option>
	</select>
	</li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
	<li><input type="submit" name="" value="添加用户" class="btn btn-primary" /></li>
</div>
</form>
</div>
<!-- /.container-fluid -->
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
