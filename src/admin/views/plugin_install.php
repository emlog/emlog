<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>插件管理</b><div id="msg"></div>
<?php if(isset($_GET['error_a'])):?><span class="error">只支持zip压缩格式的插件包</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">上传失败，插件目录(content/plugins)不可写</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">空间不支持zip模块，请按照提示手动安装插件</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">请选择一个zip插件安装包</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">安装失败，插件安装包不符合标准</span><?php endif;?>
</div>
<div class=line></div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
手动安装插件： <br />
1、把解压后的插件文件夹上传到 content/plugins 目录下。<br />
2、登录后台进入插件管理,插件管理里已经有了该插件，点击激活即可。<br />
</div>
</div>
<?php endif; ?>
<form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
	<input name="pluzip" type="file" />
	<input type="submit" value="上传安装" class="submit" /> （上传一个zip压缩格式的插件安装包）
	</li>
</div>
</form>

<div class="containertitle2">
<span class="navi3">官方推荐</span>
</div>

<div id="recommend_plugin">
<p><a href="http://www.emlog.net/plugins" target="_blank">更多插件&raquo;</a></p>
<div id="recommend_plugin_list" style="overflow: hidden;text-align: center;">
<span class="ajax_remind_1">正在读取...</span>
</div>
</div>

<script>
$("#menu_plug").addClass('sidebarsubmenu1');

$(document).ready(function(){
	$.getJSON("http://emer.emlog.net/api/recommend?callback=?",function(data){
		var items = [];
		$.each(data, function(i,item){
			items.push('<ul> <li><a target="_blank" href="'+item.url+'"><img src="'+item.logo+'" width="100" height="100"></a><li> <li><a target="_blank" href="'+item.url+'"><b>'+item.name+'</b></a></li> <li>作者：'+item.author+'</li> </ul>');
		});
		$("#recommend_plugin_list").html(items.join(""));
	});
});
</script>