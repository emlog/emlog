<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./"><? echo $lang['home']; ?></a> 
<a href="./?action=tw"><? echo $lang['twitters']; ?></a> 
<a href="./?action=com"><? echo $lang['comments']; ?></a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write"><? echo $lang['post_add']; ?></a> 
<a href="./?action=logout"><? echo $lang['logout']; ?></a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login" id="active"><? echo $lang['login']; ?></a>
<?php endif;?>
</div>
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