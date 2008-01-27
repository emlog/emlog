<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<html><head><meta http-equiv="refresh" content="2;url=$url">
<meta http-equiv="Content-Type" content="text/html ; charset=utf-8">
<title>msg</title><link rel="stylesheet" href="./views/$nonce_tpl/main.css"></head><body>
<center><br><br><br><br><br>
<table width="75%"  border="0" cellpadding="0" cellspacing="0"><tr>
<td width="130" align="center">
<img src="./views/$nonce_tpl/images/$typeimg" alt="" width="67" height="61">
</td><td align="left"><b>$msg</b><br /><a href="$url">如果页面没有跳转,请点击返回!</a></td>
</tr></table></center>
</body></html>
<!--
EOT;
?>-->