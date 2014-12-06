<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle"><b>修改作者资料</b>
<?php if(isset($_GET['error_login'])):?><span class="error">用户名不能为空</span><?php endif;?>
<?php if(isset($_GET['error_exist'])):?><span class="error">该用户名已存在</span><?php endif;?>
<?php if(isset($_GET['error_pwd_len'])):?><span class="error">密码长度不得小于6位</span><?php endif;?>
<?php if(isset($_GET['error_pwd2'])):?><span class="error">两次输入密码不一致</span><?php endif;?>
</div>
<div class=line></div>
<form action="user.php?action=update" method="post">
<div class="item_edit">
    <li><input type="text" value="<?php echo $username; ?>" name="username" style="width:200px;" class="form-control" /> 用户名</li>
    <li><input type="text" value="<?php echo $nickname; ?>" name="nickname" style="width:200px;" class="form-control" /> 昵称</li>
    <li><input type="password" value="" name="password" style="width:200px;" class="form-control" /> 新密码(不修改请留空)</li>
    <li><input type="password" value="" name="password2" style="width:200px;" class="form-control" /> 重复新密码</li>
    <li><input type="text"  value="<?php echo $email; ?>" name="email" style="width:200px;" class="form-control" /> 电子邮件</li>
    <li>
    <select name="role" id="role" class="form-control">
        <option value="writer" <?php echo $ex1; ?>>作者</option>
        <option value="admin" <?php echo $ex2; ?>>管理员</option>
    </select>
    </li>
    <li id="ischeck">
    <select name="ischeck" class="form-control">
        <option value="n" <?php echo $ex3; ?>>文章不需要审核</option>
        <option value="y" <?php echo $ex4; ?>>文章需要审核</option>
    </select>
    </li>
    <li>个人描述<br />
    <textarea name="description" rows="5" style="width:260px;" class="form-control"><?php echo $description; ?></textarea></li>
    <li>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
    <input type="hidden" value="<?php echo $uid; ?>" name="uid" />
    <input type="submit" value="保 存" class="btn btn-primary" />
    <input type="button" value="取 消" class="btn btn-default" onclick="window.location='user.php';" /></li>
</div>
</form>
<script>
setTimeout(hideActived,2600);
$("#menu_user").addClass('active');
if($("#role").val() == 'admin') $("#ischeck").hide();
$("#role").change(function(){$("#ischeck").toggle()})
</script>
