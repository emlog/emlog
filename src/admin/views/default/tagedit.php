<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>标签修改</b></div>
<div class=line></div>
<form  method="post" action="tag.php?action=update_tag">
<div>
	<li><input size="40" value="<?php echo $tagname; ?>" name="tagname" /></li>
	<p><input type="hidden" value="<?php echo $tagid; ?>" name="tid" />
		<input type="submit" value="保 存" class="submit" />
		<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();"/></p>
</div>
</form>
<script>
$("#menu_tag").addClass('sidebarsubmenu1');
</script>