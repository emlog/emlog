<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('comment_reply')?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
<div class="item_edit">
<!--vot--> <li><?=lang('commentator')?>: <?= $poster ?></li>
<!--vot--> <li><?=lang('time')?>: <?= $date ?></li>
<!--vot--> <li><?=lang('content')?>: <?= $comment ?></li>
	<li><textarea name="reply" rows="5" cols="60" class="form-control"></textarea></li>
	<li>
	<input type="hidden" value="<?= $commentId ?>" name="cid">
	<input type="hidden" value="<?= $gid ?>" name="gid">
	<input type="hidden" value="<?= $hide ?>" name="hide">
<!--vot--><input type="submit" value="<?=lang('reply')?>" class="btn btn-primary">
	<?php if ($hide == 'y'): ?>
<!--vot--><input type="submit" value="<?=lang('reply_and_audit')?>" name="pub_it" class="btn btn-primary">
	<?php endif; ?>
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();"></li>
</div>
</form>
<script>
$("#menu_cm").addClass('active');
</script>
