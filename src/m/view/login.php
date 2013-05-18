<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<form method="post" action="./index.php?action=auth">
	    <? echo $lang['user_name']; ?><br />
	    <input type="text" name="user" /><br />
	    <? echo $lang['password']; ?><br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
	    <br /><input type="submit" value="<? echo $lang['log_in']; ?>" />
	</form>
</div>