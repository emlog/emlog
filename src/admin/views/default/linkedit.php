<?php if(!defined('ADM_ROOT')) {exit('error!');}?>
<div class=containertitle><b>友站修改</b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
  <table width="95%" align="center">
    <tbody>
      <tr>
        <td>名称:<br />
          <input size="40" value="<?php echo $sitename; ?>" name="sitename" /></td></tr>
      <tr>
        <td>地址 [加http://]
          <br />
          <input size="40" value="<?php echo $siteurl; ?>" name="siteurl" /></td>
      </tr>
      <tr>
        <td>描述:<br />
        <textarea name="description" rows="3" cols="50"><?php echo $description; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="2">
		<input type="hidden" value="<?php echo $linkid; ?>" name="linkid" />
		<input type="submit" value="确 定" class="submit2" />
		<input type="button" value="取 消" class="submit2" onclick="javascript: window.history.back();""/>
		</td>
      </tr>
    </tbody>
  </table>
</form>