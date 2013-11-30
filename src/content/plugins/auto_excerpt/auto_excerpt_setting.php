<?php 
/**
 * 自动摘要插件
 * @copyright (c) Emlog All Rights Reserved
 */
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view()
{
	$auto_excerpt_file = EMLOG_ROOT.'/content/plugins/auto_excerpt/data';
	if(@$auto_excerpt_fp = fopen($auto_excerpt_file, 'r'))
	{
		$auto_excerpt_data = unserialize(fread($auto_excerpt_fp,filesize($auto_excerpt_file)));
		fclose($auto_excerpt_fp);
	}
	$auto_excerpt_length = $auto_excerpt_data['length'];
	$auto_excerpt_paragraph = $auto_excerpt_data['paragraph'];
?>
<div class=containertitle><b>摘要设置</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
</div>
<div class=line></div>
<form action="plugin.php?plugin=auto_excerpt&action=setting" method="post">
摘要长度：<input size="10" name="auto_excerpt_length" type="text" value="<?php echo $auto_excerpt_length; ?>" />字节<br>
摘要段落数：<input size="10" name="auto_excerpt_paragraph" type="text" value="<?php echo $auto_excerpt_paragraph; ?>" /><br>
<input type="submit" value="保存设置" class="button" />
</form>
<script>
$("#auto_excerpt").addClass('sidebarsubmenu1');
</script>
<?php 
}
function plugin_setting()
{
	$auto_excerpt_length = isset($_POST['auto_excerpt_length']) ? intval(trim($_POST['auto_excerpt_length'])) : 1000;
	$auto_excerpt_paragraph = isset($_POST['auto_excerpt_paragraph']) ? intval(trim($_POST['auto_excerpt_paragraph'])) : 3;
	$auto_excerpt_data = serialize(array('length' => $auto_excerpt_length,'paragraph' => $auto_excerpt_paragraph));
	$auto_excerpt_file = EMLOG_ROOT.'/content/plugins/auto_excerpt/data';
	@ $auto_excerpt_fp = fopen($auto_excerpt_file, 'wb') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/auto_excerpt/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	@ $auto_excerpt_fw =	fwrite($auto_excerpt_fp,$auto_excerpt_data) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/auto_excerpt/data的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
	fclose($auto_excerpt_fp);
}
?>