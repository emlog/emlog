<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!'); ?>
<div class="containertitle"><b>静态化管理</b></div>
<div class="line"></div>
<div class="em_static">
	<div class="containertitle2">
		<a class="navi1" href="?plugin=em_static&do=home">最新日志生成</a>
		<a class="navi3" href="?plugin=em_static&do=create_all">全站日志生成</a>
		<a class="navi4" href="?plugin=em_static&do=tag_alias">标签别名管理</a>
		<a class="navi4" href="?plugin=em_static&do=config">自动生成设置</a>			
		<a class="navi4" href="?plugin=em_static&do=url">URL格式管理</a>
		
	</div>
<?php include em_static_template('warning');?>
<div style="padding: 10px; height: 300px; position: absolute; width: 400px; margin-left: 400px;">
	日志：
	<div class="line"></div>
	<div id="em_static_msg" style="height: 300px; overflow-y: auto; color: #ccc;"></div>
</div>	
<form action="<?php echo BLOG_URL.'content/plugins/em_static/em_static_hook.php?do=create_start'?>" target="working_frame" method="post">
<p>请选择需要生成静态页的页面：<a href="?plugin=em_static&do=url">静态页url格式设置 &GT;&GT;</a></p>
<p><input type="checkbox" name="create_pages[]" value="index" /> 首页</p>
<p>
	<input type="checkbox" name="create_pages[]" value="post" />
	日志页面 - 每次生成<input type="text" name="post_limit" value="20" size="2" maxlength="3"/>篇
	<a href="?plugin=em_static&do=url#post">url格式设置 &GT;&GT;</a>
</p>
<p>
	<input type="checkbox" name="create_pages[]" value="page" />
	日志列表 - 每次生成<input type="text" name="list_limit" value="20" size="2" maxlength="3"/>页
	<a href="?plugin=em_static&do=url#post">url格式设置 &GT;&GT;</a>
</p>
<p>
	<input type="checkbox" name="create_pages[]" value="sort" />
	分类列表 - 每次生成<input type="text" name="sort_limit" value="20" size="2" maxlength="3"/>页
	<a href="?plugin=em_static&do=url#sort">url格式设置 &GT;&GT;</a>
</p>
<p>
	<input type="checkbox" name="create_pages[]" value="tag" />
	标签列表 - 每次生成<input type="text" name="tag_limit" value="20" size="2" maxlength="3"/>页
	<a href="?plugin=em_static&do=url#tag">url格式设置 &GT;&GT;</a>
</p>
<p>
	<input type="checkbox" name="create_pages[]" value="author" />
	作者列表 - 每次生成<input type="text" name="author_limit" value="20" size="2" maxlength="3"/>页
	<a href="?plugin=em_static&do=url#author">url格式设置 &GT;&GT;</a>
</p>
<p>
	<input type="checkbox" name="create_pages[]" value="record" />
	归档列表 - 每次生成<input type="text" name="record_limit" value="20" size="2" maxlength="3"/>页
	<a href="?plugin=em_static&do=url#record">url格式设置 &GT;&GT;</a>
</p>
<p><input type="checkbox" id="select_all"/>全选 <input type="submit" id="start" value="开始生成" /></p>
</form>
</div>	
<iframe src="" style="width: 0px; height: 0px; border: 0;" id="working_frame" name="working_frame"></iframe>
<script>
$().ready(function() {
	$('#start').click(function() {
		if ($('input[name=create_pages\\[\\]]:checked').length == 0) {
			alert('请选择要生成的页面');
			return false;
		}
	});
	$('#select_all').click(function() {
		if ($(this).attr('checked')) {
			$('input[name=create_pages\\[\\]]').attr('checked', true);
		} else {
			$('input[name=create_pages\\[\\]]').attr('checked', false);
		}
	});
	$("#em_static").addClass('sidebarsubmenu1');
});	
</script>