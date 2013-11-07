<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['link_edit'];?></b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
<div class="item_edit">
	<li><input size="40" value="<?php echo $sitename; ?>" class="input" name="sitename" /> 名称</li>
	<li><input size="40" value="<?php echo $siteurl; ?>" class="input" name="siteurl" /> 地址</li>
	<li>链接描述<br /><textarea name="description" rows="3" class="textarea" cols="42"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
	<input type="submit" value="<? echo $lang['save'];?>" class="button" />
	<input type="button" value="<? echo $lang['cancel'];?>" class="button" onclick="javascript: window.history.back();" /></li>
</div>
</form>
<script>
$("#menu_link").addClass('sidebarsubmenu1');
</script>