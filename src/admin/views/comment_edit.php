<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('comment_edit')?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doedit" method="post">
<div class="item_edit">
<!--vot--><li><input type="text" value="<?php echo $poster; ?>" name="name" style="width:200px;" class="input" /> <?=lang('commentator')?></li>
<!--vot--><li><input type="text"  value="<?php echo $mail; ?>" name="mail" style="width:200px;" class="input" /> <?=lang('email')?></li>
<!--vot--><li><input type="text"  value="<?php echo $url; ?>" name="url" style="width:200px;" class="input" /> <?=lang('home_page')?></li>
<!--vot--><li><?=lang('comment_content')?>:<br /><textarea name="comment" rows="8" cols="60" class="textarea"><?php echo $comment; ?></textarea></li>
	<input type="hidden" value="<?php echo $cid; ?>" name="cid" />
<!--vot--><input type="submit" value="<?=lang('save')?>" class="button" />
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="button" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>