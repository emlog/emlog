<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['comment_reply'];?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
<div class="item_edit">
	<li><? echo $lang['comment_author'];?>: <?php echo $poster; ?></li>
	<li><? echo $lang['time'];?>: <?php echo $date; ?></li>
	<li><? echo $lang['content'];?>: <?php echo $comment; ?></li>
	<li><textarea name="reply" rows="5" cols="60" class="textarea"></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $commentId; ?>" name="cid" />
	<input type="hidden" value="<?php echo $gid; ?>" name="gid" />
	<input type="hidden" value="<?php echo $hide; ?>" name="hide" />
	<input type="submit" value="<? echo $lang['reply'];?>" class="button" />
	<?php if ($hide == 'y'): ?>
	    <input type="submit" value="<? echo $lang['reply_approve']; ?>" name="pub_it" class="button" />
	<?php endif; ?>
	<input type="button" value="<? echo $lang['cancel'];?>" class="button" onclick="javascript: window.history.back();"/></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>