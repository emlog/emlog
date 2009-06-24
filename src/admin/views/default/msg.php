<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<html>
<head>
<?php if($type):?>
<meta http-equiv="refresh" content="2;url=<?php echo $url; ?>">
<?php endif;?>
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<title>提示信息</title><link rel="stylesheet" href="./views/<?php echo ADMIN_TPL; ?>/css-main.css"></head>
<body>
<center><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="130" align="center"><img src="./views/<?php echo ADMIN_TPL; ?>/images/<?php echo $typeimg; ?>" alt="" width="67" height="61"></td>
<td align="left" style="font-size:14px;"><?php echo $msg; ?><br />
<a href="<?php echo $url; ?>" style="font-size:12px;">如果页面没有跳转,请点击返回!</a></td>
</tr>
</table>
</center>
</body>
</html>