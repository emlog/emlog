<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<form method="post" action="./index.php?action=auth">
<!--vot-->  <?=lang('user_name')?><br />
	    <input type="text" name="user" /><br />
<!--vot-->  <?=lang('password')?><br />
	    <input type="password" name="pw" /><br />
	    <?php echo $ckcode; ?>
<!--vot-->  <br /><input type="submit" value="<?=lang('log_in')?>" class="button" />
	</form>
</div>