<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1><?=lang('tag_edit')?></h1>
    <div class="containertitle">
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('tag_empty')?></span><?php endif;?>
    </div>
</section>
<section class="content">
<form  method="post" action="tag.php?action=update_tag" class="form-inline">
<div class="form-group">
    <li><input size="40" value="<?php echo $tagname; ?>" name="tagname" class="form-control" /></li>
    <li style="margin:10px 0px">
    <input type="hidden" value="<?php echo $tagid; ?>" name="tid" />
<!--vot--><input type="submit" value="<?=lang('_save_')?>" class="btn btn-primary" />
<!--vot--><input type="button" value="<?=lang('_cancel_')?>" class="btn btn-default" onclick="javascript: window.location='tag.php';"/>
    </li>
</div>
</form>
</section>
<script>
$("#menu_tag").addClass('active');
</script>
