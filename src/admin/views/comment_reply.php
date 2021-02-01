<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <!-- Page Heading -->
<!--vot--><h1 class="h3 mb-2 text-gray-800"><?=lang('comment_reply')?></h1>
    <form action="comment.php?action=doreply" method="post">
        <div class="item_edit">
<!--vot-->  <li><?=lang('comment_author')： <?php echo $poster; ?></li>
<!--vot-->  <li><?=lang('time')?>：<?php echo $date; ?></li>
<!--vot-->  <li><?=lang('content')?>：<?php echo $comment; ?></li>
            <li><textarea name="reply" rows="5" cols="60" class="form-control"></textarea></li>
            <li>
                <input type="hidden" value="<?php echo $commentId; ?>" name="cid"/>
                <input type="hidden" value="<?php echo $gid; ?>" name="gid"/>
                <input type="hidden" value="<?php echo $hide; ?>" name="hide"/>
<!--vot-->      <input type="submit" value="<?=lang('reply')?>" class="btn btn-primary" />
                <?php if ($hide == 'y'): ?>
<!--vot-->          <input type="submit" value="<?=lang('reply_and_publish')?>" name="pub_it" class="btn btn-primary" />
                <?php endif; ?>
<!--vot-->      <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();"/></li>
        </div>
    </form>
</div>
<script>
    $("#menu_cm").addClass('active');
</script>
