<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['link_edit'];?></b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
<div>
	<li><? echo $lang['link_name'];?></li>
	<li><input size="40" value="<?php echo $sitename; ?>" name="sitename" /></li>
	<li><? echo $lang['link_url'];?></li>
	<li><input size="40" value="<?php echo $siteurl; ?>" name="siteurl" /></li>
	<li><? echo $lang['link_description'];?></li>
	<li><textarea name="description" rows="3" cols="45"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
	<input type="submit" value="<? echo $lang['save'];?>" class="submit" />
	<input type="button" value="<? echo $lang['cancel'];?>" class="submit" onclick="javascript: window.history.back();""/></li>
</div>
</form>
<script>
$("#menu_link").addClass('sidebarsubmenu1');
</script>