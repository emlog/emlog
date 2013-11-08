<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['comment_edit']; ?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doedit" method="post">
<div class="item_edit">
	<li><input type="text" value="<?php echo $poster; ?>" name="name" style="width:200px;" class="input" /> <? echo $lang['comment_author']; ?></li>
    <li><input type="text"  value="<?php echo $mail; ?>" name="mail" style="width:200px;" class="input" /> <? echo $lang['email']; ?></li>
	<li><input type="text"  value="<?php echo $url; ?>" name="url" style="width:200px;" class="input" /> <? echo $lang['homepage']; ?></li>
    <li><? echo $lang['comment_content']; ?>:<br /><textarea name="comment" rows="8" cols="60" class="textarea"><?php echo $comment; ?></textarea></li>
	<input type="hidden" value="<?php echo $cid; ?>" name="cid" />
	<input type="submit" value="<? echo $lang['save']; ?>" class="button" />
	<input type="button" value="<? echo $lang['_cancel_']; ?>" class="button" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>