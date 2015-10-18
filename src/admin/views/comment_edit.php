<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="container_title"><b><?=lang('comment_edit')?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doedit" method="post">
<div class="item_edit">
    <li><input type="text" value="<?php echo $poster; ?>" name="name" style="width:200px;" class="form-control" /> <?=lang('commentator')?></li>
    <li><input type="text"  value="<?php echo $mail; ?>" name="mail" style="width:200px;" class="form-control" /> <?=lang('email')?></li>
    <li><input type="text"  value="<?php echo $url; ?>" name="url" style="width:200px;" class="form-control" /> <?=lang('home_page')?></li>
    <li><?=lang('comment_content')?>:<br /><textarea name="comment" rows="8" cols="60" class="form-control"><?php echo $comment; ?></textarea></li>
    <input type="hidden" value="<?php echo $cid; ?>" name="cid" />
    <input type="submit" value="<?=lang('save')?>" class="btn btn-primary" />
    <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_cm").addClass('active');
</script>
