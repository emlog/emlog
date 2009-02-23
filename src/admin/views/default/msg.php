<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<html><head><meta http-equiv="refresh" content="2;url=<?php echo $url; ?>">
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<title>msg</title><link rel="stylesheet" href="./views/<?php echo ADMIN_TPL; ?>/css-main.css"></head><body>
<center><br><br>
<table width="80%" border="0" cellpadding="0" cellspacing="0"><tr>
<td width="130" align="center">
<img src="./views/<?php echo ADMIN_TPL; ?>/images/<?php echo $typeimg; ?>" alt="" width="67" height="61">
</td><td align="left"><?php echo $msg; ?><br /><a href="<?php echo $url; ?>">如果页面没有跳转,请点击返回!</a></td>
</tr></table></center>
</body>
</html>