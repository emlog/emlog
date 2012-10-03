<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<form method="post" action="./index.php?action=auth">
		用户名<br />
	    <input type="text" name="user" /><br />
	    密码<br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value=" 登 录" />
	</form>
</div>