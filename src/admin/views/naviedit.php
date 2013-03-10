<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>修改导航</b></div>
<div class=line></div>
<form action="navbar.php?action=update" method="post">
<div id="navi_edit">
	<li><input size="20" value="<?php echo $naviname; ?>" name="naviname" /> 导航名称</li>
	<li>
	<input size="50" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?> /> 导航地址，
	在新窗口打开<input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" <?php echo $conf_newtab; ?> /></li>
	<li>
	<input type="hidden" value="<?php echo $naviId; ?>" name="navid" />
	<input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault" />
	<input type="submit" value="保 存" class="submit" />
	<input type="button" value="取 消" class="submit" onclick="javascript: window.history.back();" />
	</li>
</div>
</form>
<script>
$("#menu_navbar").addClass('sidesubmenu_curr');
</script>