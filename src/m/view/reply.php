<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<!--vot-->	<div class="comcont"><?=lang('reply')?> <b><?php echo $poster; ?></b>: <?php echo $comment; ?></div>
	<form method="post" action="./index.php?action=addcom&gid=<?php echo $gid; ?>&pid=<?php echo $cid; ?>">
	<?php
		if(ISLOGIN == true):
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
	?>
<!--vot-->	<?=lang('logged_as')?> <b><?php echo $user_cache[UID]['name']; ?></b><br />
	<input type="hidden" name="comname" value="<?php echo $user_cache[UID]['name']; ?>" />
	<input type="hidden" name="commail" value="<?php echo $user_cache[UID]['mail']; ?>" />
	<input type="hidden" name="comurl" value="<?php echo BLOG_URL; ?>" />
	<?php else: ?>
<!--vot-->	<?=lang('nickname')?><br /><input type="text" name="comname" value="" /><br />
<!--vot-->	<?=lang('email_optional')?><br /><input type="text" name="commail" value="" /><br />
<!--vot-->	<?=lang('homepage_optional')?><br /><input type="text" name="comurl" value="" /><br />
	<?php endif; ?>
	<?=lang('content')?><br /><textarea name="comment" rows="10"></textarea><br />
<!--vot-->	<?php echo $verifyCode; ?><br /><input type="submit" value="<?=lang('comment_leave')?>" class="button" />
	</form>
</div>