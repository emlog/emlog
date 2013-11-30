<?php
/*
Plugin Name: sitemap
Version: 1.0
Plugin URL: http://www.qiyuuu.com/for-emlog/emlog-plugin-sitemap
Description: 生成sitemap，供搜索引擎抓取
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function plugin_setting_view()
{
	extract(sitemap_config());
	$ex1 = $ex2 = '';
	if($sitemap_show_footer) $ex1 = 'checked="checked" ';
	if($sitemap_comment_time) $ex2 = 'checked="checked" ';
?>
<div class=containertitle><b>SiteMap</b>
<?php if(isset($_GET['setting'])):?><span class="actived">插件设置完成</span><?php endif;?>
<?php if(isset($_GET['error'])):?><span class="error">插件设置失败</span><?php endif;?>
</div>
<div class=line></div>
<form action="plugin.php?plugin=sitemap&action=setting" method="post">
<div>
	<p>sitemap文件名：
	<input size="12" name="sitemap_name" type="text" value="<?php echo $sitemap_name; ?>" /></p>
	<p>在网站底部显示：
	<input size="12" name="sitemap_show_footer" type="checkbox" value="1" <?php echo $ex1;?>/></p>
	<p>最新评论时间作为最后更新时间：
	<input size="12" name="sitemap_comment_time" type="checkbox" value="1" <?php echo $ex2;?>/></p>
	<p>注：对以下选项不了解者请保持默认，参考资料<a href="http://www.sitemaps.org/zh_CN/protocol.php">sitemaps.org</a></p>
	<table width="500">
		<tbody>
			<tr align="center">
				<td widtd="14%"></td>
				<td widtd="14%">日志</td>
				<td widtd="14%">页面</td>
				<td widtd="14%">分类</td>
				<td widtd="14%">标签</td>
				<td widtd="14%">碎语</td>
				<td widtd="14%">归档</td>
			</tr>
			<tr align="center">
				<td align="right">更新周期</td>
			<?php foreach($sitemap_changefreq as $value): ?>
				<td><input size="5" name="sitemap_changefreq[]" type="text" value="<?php echo $value; ?>" /></td>
			<?php endforeach; ?>
			</tr>
			<tr align="center">
				<td align="right">权重</td>
			<?php foreach($sitemap_priority as $value): ?>
				<td><input size="5" name="sitemap_priority[]" type="text" value="<?php echo $value; ?>" /></td>
			<?php endforeach; ?>
			</tr>
		</tbody>
	</table>
	<p><input type="submit" value="保 存" class="submit" /></p>
</div>
</form>
<div class=line></div>
<form action="plugin.php?plugin=sitemap&action=setting" method="post">
	<input type="hidden" name="update" value="1" />
	<p><input type="submit" value="更新sitemap" class="submit" /></p>
</div>
</form>
<script>
$("#sitemap").addClass('sidebarsubmenu1');
</script>
<?php 
}
function plugin_setting()
{
	extract(sitemap_config());
	if(!isset($_POST['update'])) {
		$changefreq2 = isset($_POST['sitemap_changefreq']) ? $_POST['sitemap_changefreq'] : array();
		$priority2 = isset($_POST['sitemap_priority']) ? $_POST['sitemap_priority'] : array();
		$sitemap_name2 = isset($_POST['sitemap_name']) ? strval($_POST['sitemap_name']) : '';
		foreach($changefreq2 as $key=>$value) {
			if(!in_array($value,array('always','hourly','daily','weekly','monthly','yearly','never'))){
				$sitemap_changefreq[$key] = 'daily';
			} else {
				$sitemap_changefreq[$key] = $value;
			}
		}
		foreach($priority2 as $key=>$value) {
			if(floatval($value) > 1.0 || floatval($value) <= 0){
				$sitemap_priority[$key] = '0.8';
			} else {
				$sitemap_priority[$key] = $value;
			}
		}
		if($sitemap_name2 != '' && $sitemap_name != $sitemap_name2) {
			if(!@rename(EMLOG_ROOT . '/' . $sitemap_name, EMLOG_ROOT . '/' . $sitemap_name2)) {
				formMsg("重命名文件{$sitemap_name}失败,请设置根目录下{$sitemap_name}权限为777（LINUX)/everyone可写（windows）",'./plugin.php?plugin=sitemap',0);
			}
			$sitemap_name = $sitemap_name2;
		}
		$sitemap_show_footer = isset($_POST['sitemap_show_footer']) ? addslashes($_POST['sitemap_show_footer']) : 0;
		$sitemap_comment_time = isset($_POST['sitemap_comment_time']) ? addslashes($_POST['sitemap_comment_time']) : 0;
		if(!@file_put_contents(EMLOG_ROOT . '/content/plugins/sitemap/config',serialize(compact('sitemap_name','sitemap_changefreq','sitemap_priority','sitemap_show_footer','sitemap_comment_time')))) {
			formMsg("更新配置失败,请设置文件content/plugins/sitemap/config权限为777（LINUX）/everyone可写（windows）",'./plugin.php?plugin=sitemap',0);
		}
	}
	if(!sitemap_update()) {
		formMsg("更新sitemap失败,请设置根目录下{$sitemap_name}权限为777（LINUX）/everyone可写（windows）",'./plugin.php?plugin=sitemap',0);
	}
	return true;
}