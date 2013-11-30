<?php 
/**
 * 相关日志插件
 * @copyright (c) Emlog All Rights Reserved
 */

if(!defined('EMLOG_ROOT')) {exit('error!');}

function plugin_setting_view()
{
	require_once('related_log_config.php');
	$ex1 = $ex2 = $ex3 = $ex4 = $ex5 = $ex6 = $ex7 = $ex8 = $ex9 = '';
	switch ($related_log_type)
	{
		case 'sort':$ex1 = 'selected="selected"';break;
		case 'tag':$ex2 = 'selected="selected"';break;
	}
	switch ($related_log_sort)
	{
		case 'views_desc':$ex3 = 'selected="selected"';break;
		case 'comnum_desc':$ex4 = 'selected="selected"';break;
		case 'rand':$ex5 = 'selected="selected"';break;
		case 'views_asc':$ex6 = 'selected="selected"';break;
		case 'comnum_asc':$ex7 = 'selected="selected"';break;

	}
	switch ($related_inrss)
	{
		case 'y':$ex8 = 'selected="selected"';break;
		case 'n':$ex9 = 'selected="selected"';break;
	}
?>
<div class=containertitle><b>相关日志</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
</div>
<div class=line></div>
<form action="plugin.php?plugin=related_log&action=setting" method="post">
<div>
	<p>相关类型：
	<select name="related_log_type">
       <option value="sort" <?php echo $ex1; ?>>分类</option>
       <option value="tag" <?php echo $ex2; ?>>标签</option>
    </select>
    </p>
    <p>相关日至排序：
	<select name="related_log_sort">
       <option value="views_desc" <?php echo $ex3; ?>>点击数（降序）</option>
       <option value="comnum_desc" <?php echo $ex4; ?>>评论数（降序）</option>
       <option value="rand" <?php echo $ex5; ?>>随机</option>
       <option value="views_asc" <?php echo $ex6; ?>>点击数（升序）</option>
       <option value="comnum_asc" <?php echo $ex7; ?>>评论数（升序）</option>
    </select>
    </p>
    <p>相关日志数量：
	<input size="5" name="related_log_num" type="text" value="<?php echo $related_log_num; ?>" /></p>
	<p>显示在RSS输出里：
	<select name="related_inrss">
       <option value="y" <?php echo $ex8; ?>>是</option>
       <option value="n" <?php echo $ex9; ?>>否</option>
    </select>
	</p>
	<p><input type="submit" value="保 存" class="submit" /></p>
</div>
</form>
<script>
$("#related_log").addClass('sidebarsubmenu1');
</script>
<?php 
}
function plugin_setting()
{
	$related_log_type = isset($_POST['related_log_type']) ? trim($_POST['related_log_type']) : '';
	$related_log_sort = isset($_POST['related_log_sort']) ? trim($_POST['related_log_sort']) : '';
	$related_log_num = isset($_POST['related_log_num']) ? trim($_POST['related_log_num']) : '';
	$related_inrss = isset($_POST['related_inrss']) ? trim($_POST['related_inrss']) : '';
	$data = "<?php
	\$related_log_type = '".$related_log_type."';
	\$related_log_sort = '".$related_log_sort."';
	\$related_log_num = '".$related_log_num."';
	\$related_inrss = '".$related_inrss."';
?>";
	if($related_log_num != '' && $related_log_sort != '' && $related_log_type != '')
	{
		$file = EMLOG_ROOT.'/content/plugins/related_log/related_log_config.php';
		@ $fp = fopen($file, 'wb') OR emMsg('读取文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/related_log/related_log_config.php的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
		@ $fw =	fwrite($fp,$data) OR emMsg('写入文件失败，如果您使用的是Unix/Linux主机，请修改文件/content/plugins/related_log/related_log_config.php的权限为777。如果您使用的是Windows主机，请联系管理员，将该文件设为everyone可写');
		fclose($fp);
	}
}

?>