<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>回复评论</h1>
</section>
<section class="content">
<form action="comment.php?action=doreply" method="post">
<div class="item_edit">
	<li>评论人：<?php echo $poster; ?></li>
	<li>时间：<?php echo $date; ?></li>
	<li>内容：<?php echo $comment; ?></li>
	<li><textarea name="reply" rows="5" cols="60" class="form-control"></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $commentId; ?>" name="cid" />
	<input type="hidden" value="<?php echo $gid; ?>" name="gid" />
	<input type="hidden" value="<?php echo $hide; ?>" name="hide" />
	<input type="submit" value="回复" class="btn btn-primary" />
	<?php if ($hide == 'y'): ?>
	    <input type="submit" value="回复并审核" name="pub_it" class="btn btn-primary" />
	<?php endif; ?>
	<input type="button" value="取 消" class="btn btn-default" onclick="javascript: window.history.back();"/></li>
</div>
</form>
</section>
<script>
$("#menu_cm").addClass('active');
</script>
