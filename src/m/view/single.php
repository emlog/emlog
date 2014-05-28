<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<div class="posttitle"><?php echo $log_title; ?></div>
	<div class="postinfo"><?php echo gmdate('Y-m-d', $date); ?> <?php echo $user_cache[$author]['name'];?></div>
	<div class="postcont"><?php echo $log_content; ?></div>
    <?php if(!empty($commentStacks)): ?>
	<div class="t"><? echo $lang['comments']; ?>:</div>
	<div class="c">
		<?php foreach($commentStacks as $cid):
			$comment = $comments[$cid];
			$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
		?>
		<div class="l">
		<b><?php echo $comment['poster']; ?></b>
		<div class="info"><?php echo $comment['date']; ?> <a href="./?action=reply&cid=<?php echo $comment['cid'];?>"><? echo $lang['reply']; ?></a></div>
		<div class="comcont"><?php echo $comment['content']; ?></div>
        <?php if(ROLE === ROLE_ADMIN): ?>
        <div class="delcom"><a href="./?action=delcom&id=<?php echo $comment['cid'];?>&gid=<?php echo $logid; ?>&token=<?php echo LoginAuth::genToken();?>">删除</a></div>
        <?php endif; ?>
		</div>
		<?php endforeach; ?>
		<div id="page"><?php echo $commentPageUrl;?></div>
	</div>
    <?php endif;?>
    <?php if($allow_remark == 'y'): ?>
	<div class="t"><? echo $lang['comment_add']; ?>:</div>
	<div class="c">
		<form method="post" action="./index.php?action=addcom&gid=<?php echo $logid; ?>">
		<?php if(ISLOGIN == true):?>
		<? echo $lang['logged_as']; ?>: <b><?php echo $user_cache[UID]['name']; ?></b><br />
		<?php else: ?>
		<? echo $lang['nickname']; ?><br /><input type="text" name="comname" value="" /><br />
		<? echo $lang['email_optional']; ?><br /><input type="text" name="commail" value="" /><br />
		<? echo $lang['homepage_optional']; ?><br /><input type="text" name="comurl" value="" /><br />
		<?php endif; ?>
		<? echo $lang['content']; ?><br /><textarea name="comment" rows="10"></textarea><br />
		<?php echo $verifyCode; ?><br /><input type="submit" value="<? echo $lang['comment_add']; ?>" />
		</form>
	</div>
    <?php endif;?>
</div>