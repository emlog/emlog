<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./" id="active"><? echo ; ?>$lang['home']</a>
<a href="./?action=tw"><? echo $lang['twitters']; ?></a>
<a href="./?action=com"><? echo $lang['comments']; ?></a>
<?php if(ISLOGIN === true): ?>
<a href="./?action=write"><? echo $lang['post_add']; ?></a> 
<a href="./?action=logout"><? echo $lang['logout']; ?></a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login"><? echo $lang['login']; ?></a>
<?php endif;?>
</div>
<div id="m">
	<div class="posttitle"><?php echo $log_title; ?></div>
	<div class="postinfo"><? echo $lang['posted_by']; ?>: <?php echo $user_cache[$author]['name'];?> <?php echo gmdate('Y-m-d H:i', $date); ?>
	<?php if(ROLE == 'admin' || $author == UID): ?>
	<a href="./?action=dellog&gid=<?php echo $logid;?>"><? echo $lang['remove']; ?></a>
	<?php endif;?>
	</div>
	<div class="postcont"><?php echo $log_content; ?></div>
	<div class="t"><? echo $lang['comments']; ?>:</div>
	<div class="c">
		<?php foreach($comments as $key=>$value):
			$reply = $value['reply']?"<span>{$lang['blog_reply']}: {$value['reply']}</span>":'';
			$value['poster'] = $value['url'] ? '<a href="'.$value['url'].'" target="_blank">'.$value['poster'].'</a>' : $value['poster'];
		?>
		<div class="l">
		<b><?php echo $value['poster']; ?> </b>
		<div class="info"><?php echo $value['date']; ?></div>
		<div class="comcont"><?php echo $value['content']; ?></div>
		<div class="reply"><?php echo $reply; ?></div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="t"><? echo $lang['comment_add']; ?>:</div>
	<div class="c">
		<form method="post" action="./?action=addcom&gid=<?php echo $logid; ?>">
		<? echo $lang['nickname']; ?><br /><input type="text" name="comname" value="" /><br />
		<? echo $lang['email_optional']; ?><br /><input type="text" name="commail" value="" /><br />
		<? echo $lang['homepage_optional']; ?><br /><input type="text" name="comurl" value="" /><br />
		<? echo $lang['content']; ?><br /><textarea name="comment" rows="10"></textarea><br />
		<?php echo $cheackimg; ?><br /><input type="submit" value="<? echo $lang['comment_add']; ?>" />
		</form>
	</div>
</div>