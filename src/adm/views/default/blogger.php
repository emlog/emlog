<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
$Icon = $photo?" <img src=\"$photo\" border=\"1\" align=\"absbottom\" /><a href=\"javascript: isdel(0, 7);\">[删除头像]</a>":'';
?>
	<div class=containertitle><b>个人资料</b></div>
	<div class=line></div>
  <form action="blogger.php?action=modintro" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td>昵称<b><br />
          </b>
          <input maxlength="50" style="width:245px;" value="<?php echo $name; ?>" name="name" /></td>
        </tr>
		 <tr nowrap="nowrap">
          <td>电子邮件地址<br />
           <input name="mail" value="<?php echo $email; ?>" style="width:245px;" maxlength="200" /></td>
        </tr>
		<tr nowrap="nowrap">
          <td>头像 (推荐上传大小为185 X 230，格式为jpg或png的图片)<br />
            <input type="hidden" name="photo" value="<?php echo $photo; ?>"/>
            <?php echo $Icon; ?>
           	<br><input name="photo" type="file" style="width:245px;" />
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td>我的状态<b><br />
          </b>
            <textarea name="description" rows="3" cols="" style="width:300px;" type="text" maxlength="500"><?php echo $bloggerdes; ?></textarea></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />          </td>
        </tr>
      </tbody>
    </table>
  </form>
  	<div class=containertitle><b>修改密码</b></div>
	<div class=line></div>
  <form action="blogger.php?action=update_admin" method="post" name="blooger" id="blooger">
  <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
    <tbody>
      <tr nowrap="nowrap">
        <td width="62%">当前密码 <br />
          <input type="password" maxlength="200" style="width:200px;" value="" name="oldpass" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td>新密码(不得小于6位)<b><br />
        </b>
          <input type="password" maxlength="200" style="width:200px;" value="" name="newpass" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td>确认新密码(确保与上面新密码一致)<b><br />
        </b>
          <input type="password" maxlength="200" style="width:200px;" value="" name="repeatpass" /></td>
      </tr>
      <tr nowrap="nowrap">
        <td>后台登录名<br />
          <input maxlength="200" style="width:200px;" name="username" /></td>
      </tr>
      <tr>
        <td align="center" colspan="2">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />        
			</td>
      </tr>
    </tbody>
  </table>
</form>