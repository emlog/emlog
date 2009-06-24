<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>修改链接</b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
<div>
	<li>名称</li>
	<li><input size="40" value="<?php echo $sitename; ?>" name="sitename" /></li>
	<li>地址</li>
	<li><input size="40" value="<?php echo $siteurl; ?>" name="siteurl" /></li>
	<li>描述</li>
	<li><textarea name="description" rows="3" cols="45"><?php echo $description; ?></textarea></li>
	<li>
	<input type="hidden" value="<?php echo $linkId; ?>" name="linkid" />
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();""/></li>
</div>
</form>
<script>
$("#menu_link").addClass('sidebarsubmenu1');
</script>