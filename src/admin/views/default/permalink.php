<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>
setTimeout(hideActived,2600);
</script>
<div class=containertitle>
<?php if(isset($_GET['activated'])):?><span class="actived">设置保存成功</span><?php endif;?></div>
<?php if(isset($_GET['error'])):?><span class="error">保存失败：配置文件不可写</span><?php endif;?>
<div class=containertitle><a href="./configure.php">基本设置</a> <a href="./permalink.php">固定连接</a></div>
<div class=line></div>
<div class="des">你可以在这里修改日志链接的形式，以此提高链接的可读性和对搜索引擎的友好程度。<br />如果修改后日志无法访问，请修改回默认形式。</div>
<form action="permalink.php?action=update" method="post">
  <table cellspacing="8" cellpadding="4" width="95%" border="0">
    <tbody>
      <tr>
        <td><input type="radio" name="permalink" value="0" <?php echo $ex0; ?>>默认形式：<span class="permalink_url"><?php echo BLOG_URL; ?>?post=1</span></td>
      </tr>
	  <tr>
        <td><input type="radio" name="permalink" value="1" <?php echo $ex1; ?>>文件形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post-1.html</span></td>
      </tr>
	  <tr>
        <td><input type="radio" name="permalink" value="2" <?php echo $ex2; ?>>目录形式：<span class="permalink_url"><?php echo BLOG_URL; ?>post/1</span></td>
      </tr>
      <tr>
        <td rowspan="2"><input type="submit" value="保存设置" class="button" /></td>
      </tr>
    </tbody>
  </table>
</form>