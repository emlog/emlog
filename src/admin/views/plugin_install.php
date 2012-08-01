<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b><? echo $lang['plugin_management']; ?></b><div id="msg"></div>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['plugin_zip_only']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['plugin_not_writable']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['plugin_zip_nosupport']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['plugin_use_zip']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['plugin_non_standard']; ?></span><?php endif;?>
</div>
<div class=line></div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
<? echo $lang['plugin_install_manually']; ?>
</div>
</div>
<?php endif; ?>
<form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
	<input name="pluzip" type="file" />
	<input type="submit" value="<? echo $lang['upload']; ?>" class="submit" /> （上传一个zip压缩格式的插件安装包）
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