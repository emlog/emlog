<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['comment_reply'];?></b></div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
<div>
	<li><? echo $lang['comment_author'];?>:<?php echo $poster; ?></li>
	<li><? echo $lang['time'];?>:<?php echo $date; ?></li>
	<li><? echo $lang['content'];?>:<?php echo $comment; ?></li>
	<li><textarea name="reply" rows="5" cols="60"><?php echo $reply; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $commentId; ?>" name="cid" />
	<input type="submit" value="<? echo $lang['reply'];?>" class="submit" />
	<?php if ($hide == 'y'): ?>
	    <input type="submit" value="<? echo $lang['reply_approve']; ?>" name="pub_it" class="submit" />
	<?php endif; ?>
	<input type="button" value="<? echo $lang['cancel'];?>" class="submit" onclick="javascript: window.history.back();"/></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>