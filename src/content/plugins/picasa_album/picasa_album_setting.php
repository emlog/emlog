<?php 
/**
 * google picasa相册插件
 * @copyright (c) Emlog All Rights Reserved
 */
if(!defined('ADMIN_ROOT')) {exit('error!');}

function plugin_setting_veiw()
{
$user_info = '';
$cachefile = EMLOG_ROOT.'/content/plugins/picasa_album/cache/account';
if(@$fp = fopen($cachefile, 'r'))
{
	$user_info = unserialize(fread($fp,filesize($cachefile)));
	fclose($fp);
}
$account = $user_info['account'];
$thum_width = $user_info['thum_width'];
$ex1 = $ex2 = $ex3 = $ex4 = $ex5 = '';
switch ($thum_width)
{
	case 512:$ex1 = 'selected="selected"';break;
	case 576:$ex2 = 'selected="selected"';break;
	case 640:$ex3 = 'selected="selected"';break;
	case 720:$ex4 = 'selected="selected"';break;
	case 800:$ex5 = 'selected="selected"';break;	
}
?>
<div class=containertitle><b>Picasa网络相册</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
</div>
<div class=line></div>
<div>
<img src="../content/plugins/picasa_album/images/logo.gif">
<p>还没有Google Picasa网络相册账户？<a href="http://picasaweb.google.com/" target="_blank"> 注册一个</a></p>
</div>
<form action="plugin.php?plugin=picasa_album&action=setting" method="post">
<div>
	<li>Google Picasa网络相册账户：</li>
	<li><input size="40" name="account" type="text" value="<?php echo $account; ?>" /><br></li>
	<p>照片缩放尺寸：
	<select name="thum_width">
       <option value="512" <?php echo $ex1; ?>>512像素</option>
       <option value="576" <?php echo $ex2; ?>>576像素</option>
       <option value="640" <?php echo $ex3; ?>>640像素</option>
       <option value="720" <?php echo $ex4; ?>>720像素</option>
       <option value="800" <?php echo $ex5; ?>>800像素</option>
    </select>
    </p>
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
	$thum_width = isset($_POST['thum_width']) ? trim($_POST['thum_width']) : '';
	
	$data = serialize(array('account'=>$account, 'thum_width'=>$thum_width));
	
	if($account)
	{
		$cachefile = EMLOG_ROOT.'/content/plugins/picasa_album/cache/account';
		@ $fp = fopen($cachefile, 'wb') OR emMsg('读取缓存失败。如果您使用的是Unix/Linux主机，请修改缓存目录 (content/plugins/picasa_album/cache) 下所有文件的权限为777。如果您使用的是Windows主机，请联系管理员，将该目录下所有文件设为everyone可写');
		@ $fw =	fwrite($fp,$data) OR emMsg('写入缓存失败，相册插件缓存目录 (content/plugins/picasa_album/cache) 不可写');
		fclose($fp);
	}
}

?>