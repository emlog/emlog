<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>
setTimeout(hideActived,2600);
</script>
<div class=containertitle><?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?></div>
<div class=containertitle><a href="./configure.php">基本设置</a> <a href="./permalink.php">固定连接</a></div>
<div class=line></div>
<form action="permalink.php?action=update" method="post">
  <table cellspacing="8" cellpadding="4" width="95%" align="center" border="0">
    <tbody>
      <tr>
        <td><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>> <?php echo BLOG_URL; ?>?post=1</td>
      </tr>
	  <tr>
        <td><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>> <?php echo BLOG_URL; ?>post-1.html</td>
      </tr>
	  <tr>
        <td><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>> <?php echo BLOG_URL; ?>post/1</td>
      </tr>
      <tr>
        <td rowspan="2"><input type="submit" value="保存设置" class="button" /></td>
      </tr>
    </tbody>
  </table>
</form>