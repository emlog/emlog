<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>picasa网络相册</b></div>
<div class=line></div>
<form action="link.php?action=update_link" method="post">
<div>
	<li>相册账户</li>
	<li><input size="40" value="" name="sitename" /></li>
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();""/></li>
</div>
</form>
<script>
$("#menu_link").addClass('sidebarsubmenu1');
</script>