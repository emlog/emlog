<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!--vot--><div class="container_title"><b><?=lang('comment_edit')?></b>
</div>
<div class=line></div>
<form action="comment.php?action=doedit" method="post">
    <div class="item_edit">
<!--vot--><li><input type="text" value="<?= $poster ?>" name="name" style="width:200px;" class="form-control"> <?=lang('commentator')?></li>
<!--vot--><li><input type="text" value="<?= $mail ?>" name="mail" style="width:200px;" class="form-control"> <?=lang('email')?></li>
<!--vot--><li><input type="text" value="<?= $url ?>" name="url" style="width:200px;" class="form-control"> <?=lang('home_page')?></li>
<!--vot--><li><?=lang('comment_content')?>:<br><textarea name="comment" rows="8" cols="60" class="form-control"><?= $comment ?></textarea></li>
<!--vot--><input type="hidden" value="<?= $cid ?>" name="cid">
<!--vot--><input type="submit" value="<?=lang('save')?>" class="btn btn-primary">
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();"></li>
    </div>
</form>
<script>
    $("#menu_cm").addClass('active');
</script>
