<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
	<div class="posttitle"><?php echo $log_title; ?></div>
	<div class="postinfo"><?php echo gmdate('Y-m-d', $date); ?> <?php echo $user_cache[$author]['name'];?></div>
	<div class="postcont"><?php echo $log_content; ?></div>
    <?php if(!empty($commentStacks)): ?>
<!--vot-->	<div class="t"><?=lang('delete')?>:</div>
	<div class="c">
		<?php foreach($commentStacks as $cid):
			$comment = $comments[$cid];
			$comment['poster'] = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
		?>
		<div class="l">
		<b><?php echo $comment['poster']; ?></b>
<!--vot-->	<div class="info"><?php echo $comment['date']; ?> <a href="./?action=reply&cid=<?php echo $comment['cid'];?>"><?=lang('reply')?></a></div>
		<div class="comcont"><?php echo $comment['content']; ?></div>
        <?php if(ROLE === ROLE_ADMIN): ?>
        <div class="delcom"><a href="./?action=delcom&id=<?php echo $comment['cid'];?>&gid=<?php echo $logid; ?>&token=<?php echo LoginAuth::genToken();?>"><? echo $lang['remove']; ?></a></div>
        <?php endif; ?>
		</div>
		<?php endforeach; ?>
		<div id="page"><?php echo $commentPageUrl;?></div>
	</div>
    <?php endif;?>
    <?php if($allow_remark == 'y'): ?>
<!--vot-->	<div class="t"><?=lang('comment_leave')?>:</div>
	<div class="c">
		<form method="post" action="./index.php?action=addcom&gid=<?php echo $logid; ?>">
		<?php if(ISLOGIN == true):?>
<!--vot-->	<?=lang('logged_as')?>: <b><?php echo $user_cache[UID]['name']; ?></b><br />
		<?php else: ?>
<!--vot-->	<?=lang('nickname')?><br /><input type="text" name="comname" value="" /><br />
<!--vot-->	<?=lang('email_optional')?><br /><input type="text" name="commail" value="" /><br />
<!--vot-->	<?=lang('homepage_optional')?><br /><input type="text" name="comurl" value="" /><br />
		<?php endif; ?>
<!--vot-->	<?=lang('content')?><br /><textarea name="comment" rows="10"></textarea><br />
<!--vot-->	<?php echo $verifyCode; ?><br /><input type="submit" value="<?=lang('comment_leave')?>" />
		</form>
	</div>
    <?php endif;?>
</div>