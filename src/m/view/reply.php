<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./"><? echo $lang['home']; ?></a> 
<a href="./?action=tw"><? echo $lang['twitters']; ?></a> 
<a href="./?action=com" id="active"><? echo $lang['comments']; ?></a> 
<?php if(ISLOGIN === true): ?>
<a href="./?action=write"><? echo $lang['post_add']; ?></a> 
<a href="./?action=logout"><? echo $lang['logout']; ?></a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login"><? echo $lang['login']; ?></a>
<?php endif;?>
</div>
<div id="m">
	<div class="comcont"><? echo $lang['reply']; ?> <b><?php echo $poster; ?></b>: <?php echo $comment; ?></div>
	<form method="post" action="./index.php?action=addcom&gid=<?php echo $gid; ?>&pid=<?php echo $cid; ?>">
	<?php
		if(ISLOGIN == true):
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
	?>
	<? echo $lang['logged_as']; ?><b> <?php echo $user_cache[UID]['name']; ?></b><br />
	<input type="hidden" name="comname" value="<?php echo $user_cache[UID]['name']; ?>" />
	<input type="hidden" name="commail" value="<?php echo $user_cache[UID]['mail']; ?>" />
	<input type="hidden" name="comurl" value="<?php echo BLOG_URL; ?>" />
	<?php else: ?>
	<? echo $lang['nickname']; ?><br /><input type="text" name="comname" value="" /><br />
	<? echo $lang['email_optional']; ?><br /><input type="text" name="commail" value="" /><br />
	<? echo $lang['homepage_optional']; ?><br /><input type="text" name="comurl" value="" /><br />
	<?php endif; ?>
	<? echo $lang['content']; ?><br /><textarea name="comment" rows="10"></textarea><br />
	<?php echo $verifyCode; ?><br /><input type="submit" value="<? echo $lang['comment_add']; ?>" />
	</form>
</div>