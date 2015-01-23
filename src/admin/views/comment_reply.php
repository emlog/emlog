<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('comment_reply')?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
<div class="item_edit">
<!--vot-->    <li><?=lang('commentator')?>: <?php echo $poster; ?></li>
<!--vot-->    <li><?=lang('time')?>: <?php echo $date; ?></li>
<!--vot-->    <li><?=lang('content')?>: <?php echo $comment; ?></li>
<!--vot-->    <li><textarea name="reply" rows="5" cols="60" class="textarea"></textarea></li>
    <li>
    <input type="hidden" value="<?php echo $commentId; ?>" name="cid" />
    <input type="hidden" value="<?php echo $gid; ?>" name="gid" />
    <input type="hidden" value="<?php echo $hide; ?>" name="hide" />
<!--vot--><input type="submit" value="<?=lang('reply')?>" class="button" />
    <?php if ($hide == 'y'): ?>
<!--vot--><input type="submit" value="<?=lang('reply_and_audit')?>" name="pub_it" class="button" />
    <?php endif; ?>
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="button" onclick="javascript: window.history.back();"/></li>
</div>
</form>
<script>
$("#menu_cm").addClass('sidebarsubmenu1');
</script>