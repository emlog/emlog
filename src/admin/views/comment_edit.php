<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>编辑评论</h1>
</section>
<section class="content">
<form action="comment.php?action=doedit" method="post">
<div class="item_edit">
<!--vot--><li><input type="text" value="<?php echo $poster; ?>" name="name" style="width:200px;" class="form-control" /> <?=lang('commentator')?></li>
<!--vot--><li><input type="text"  value="<?php echo $mail; ?>" name="mail" style="width:200px;" class="form-control" /> <?=lang('email')?></li>
<!--vot--><li><input type="text"  value="<?php echo $url; ?>" name="url" style="width:200px;" class="form-control" /> <?=lang('home_page')?></li>
<!--vot--><li><?=lang('comment_content')?>:<br /><textarea name="comment" rows="8" cols="60" class="form-control"><?php echo $comment; ?></textarea></li>
    <input type="hidden" value="<?php echo $cid; ?>" name="cid" />
<!--vot--><input type="submit" value="<?=lang('save')?>" class="btn btn-primary" />
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();" /></li>
</div>
</form>
</section>
<script>
$("#menu_cm").addClass('active');
</script>
