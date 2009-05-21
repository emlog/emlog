<?php 
/**
 * google picasa相册插件
 * @copyright (c) Emlog All Rights Reserved
 */
if(!defined('ADMIN_ROOT')) {exit('error!');}
?>
<?php 
function plugin_setting_veiw()
{
?>
<div class=containertitle><b>Picasa网络相册</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
</div>
<div class=line></div>
<form action="plugin.php?plugin=picasa_album&action=setting" method="post">
<div>
	<li>Google Picasa网络相册账户：</li>
	<li><input size="40" value="" name="account" /><br></li>
	<p><input type="submit" value="保 存" class="submit" /></p>
</div>
</form>
<script>
$("#menu_picasa_album").addClass('sidebarsubmenu1');
</script>
<?php 
}
function plugin_setting()
{
	$account = isset($_POST['account']) ? trim($_POST['account']) : '';
	if($account)
	{
		$cachefile = EMLOG_ROOT.'/content/plugins/picasa_album/cache/account';
		@ $fp = fopen($cachefile, 'wb') OR emMsg('读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/plugins/picasa_album/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为everyone可写');
		@ $fw =	fwrite($fp,$account) OR emMsg('写入缓存失败，相册插件缓存目录 (content/plugins/picasa_album/cache) 不可写');
		fclose($fp);
	}
}

?>