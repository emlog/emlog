<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('tag_edit')?></b>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('tag_empty')?></span><?php endif;?>
</div>
<div class=line></div>
<form  method="post" action="tag.php?action=update_tag">
<div>
<li><input size="40" value="<?php echo $tagname; ?>" name="tagname" class="input" /></li>
<li style="margin:10px 0px">
<input type="hidden" value="<?php echo $tagid; ?>" name="tid" />
<input type="submit" value="<? echo $lang['save'];?>" class="button" />
<input type="button" value="<? echo $lang['cancel'];?>" class="button" onclick="javascript: window.location='tag.php';"/>
</li>
</div>
</form>
<script>
$("#menu_tag").addClass('sidebarsubmenu1');
</script>