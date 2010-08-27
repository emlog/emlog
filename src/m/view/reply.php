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
	<form method="post" action="./?action=dorep&id=<?php echo $id; ?>">
	<textarea name="reply"><?php echo $reply; ?></textarea><br />
	<input type="submit" value="<? echo $lang['comment_reply']; ?>" />
	</form>
</div>