<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./"><? echo $lang['home']; ?></a> 
<a href="./?action=tw"><? echo $lang['twitter']; ?></a> 
<a href="./?action=com"><? echo $lang['comments']; ?></a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write"><? echo $lang['post_add']; ?></a> 
<a href="./?action=logout"><? echo $lang['logout']; ?></a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login"><? echo $lang['login']; ?></a>
<?php endif;?>
</div>
<div id="m">
<? echo $lang['blog_password_required']; ?>:
<form action="" method="post">
<br /><input type="password" name="logpwd" /> <input type="submit" value="<? echo $lang['sure']; ?>" />
<br /><br /><a href="./">&laquo;<? echo $lang['back_home']; ?></a>
</form>
</div>