<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<html>
<head>
<?php if($type):?>
<meta http-equiv="refresh" content="2;url=<?php echo $url; ?>">
<?php endif;?>
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<title>提示信息</title><link rel="stylesheet" href="./views/<?php echo ADMIN_TPL; ?>/css-main.css"></head>
<body  style="text-align:center; font-size:12px;">
<div class="center"><br><br>
<table width="39%" border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="130" ><img src="./views/<?php echo ADMIN_TPL; ?>/images/<?php echo $typeimg; ?>" alt="" width="67" height="61"></td>
<td width="321" align="left" style="font-size:14px;""><?php echo $msg; ?><br />
  <a style="font-size:12px" href="<?php echo $url; ?>">如果页面没有跳转,请点击返回!</a></td>
</tr>
</table>
</div>
</body>
</html>