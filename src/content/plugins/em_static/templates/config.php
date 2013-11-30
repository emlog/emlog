<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<div class="containertitle"><b>静态化管理</b></div>
<div class="line"></div>
<div class="em_static">
	<div class="containertitle2">
		<a class="navi1" href="?plugin=em_static&do=home">最新日志生成</a>
		<a class="navi4" href="?plugin=em_static&do=create_all">全站日志生成</a>
		<a class="navi4" href="?plugin=em_static&do=tag_alias">标签别名管理</a>
		<a class="navi3" href="?plugin=em_static&do=config">自动生成设置</a>
		<a class="navi4" href="?plugin=em_static&do=url">URL格式管理</a>
	</div>
	<?php include em_static_template('warning');?>
	<form method="post">
		<p><b>插件授权码:</b></p>
		<p><?php echo EM_STATIC_KEY?></p>
		<p style="color:#FF6600">授权码为识别您升级服务的重要凭证，请勿向他人透露</p>		
		<p>
			<input type="radio" name="enable_auto_create" value="0" <?php $GLOBALS['em_static_config_data']['enable_auto_create'] == 0 AND print 'checked'?>/>关闭
			<input type="radio" name="enable_auto_create" value="1" <?php $GLOBALS['em_static_config_data']['enable_auto_create'] == 1 AND print 'checked'?>/>开启
		</p>
		<p style="color:#FF6600">开启自动生成功能会增加服务器性能压力，如果站点数据量较大建议关闭本功能改为手动生成</p>
		<p><b>页面自动生成性能阈值</b></p>
		<p>
			<select name="auto_create_performance_value">
			<?php for ($i = 1; $i <= 10; $i++):?>
			<option value="<?php echo $i?>" <?php $GLOBALS['em_static_config_data']['auto_create_performance_value'] == $i AND print 'selected="selected"'?>><?php echo $i?></option>
			<?php endfor;?>
			</select>
		</p>
		<p style="color:#FF6600">数字越大生成速度越快，但是给服务器带来的压力也更大, 请根据站点的实际情况设定</p>
		<p><input type="submit" value="保存设置" /></p>
	</form>
</div>
<script>
$().ready(function() {
	$('#time').change(function() {
		window.location.href = window.location.href.replace(/&interval=(\d+)/, '')+'&interval='+$('#time').val();
	});
});
</script>