<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>回复评论</b></div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
<div>
	<li>评论人：<?php echo $poster; ?></li>
	<li>时间：<?php echo $date; ?></li>
	<li>内容：<?php echo $comment; ?></li>
	<li><textarea name="reply" rows="5" cols="60"><?php echo $reply; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $commentId; ?>" name="cid" />
	<input type="submit" value="回复" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();"/></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>