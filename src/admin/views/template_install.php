<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./template.php"><? echo $lang['template_current']; ?></a>
<a class="navi2" href="./template.php?action=install"><? echo $lang['template_install']; ?></a>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['template_zip_only']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['template_not_writable']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['template_zip_nosupport']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"></ echo $lang['template_upload_zip']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['template_non_standard']; ?></span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
<? echo $lang['template_install_manually']; ?>
</div>
</div>
<?php endif; ?>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
	<input name="tplzip" type="file" />
	<input type="submit" value="<? echo $lang['upload']; ?>" class="submit" /> (上传一个zip压缩格式的模板安装包)
	</li>
</div>
</form>
<div class="containertitle2">
<span class="navi3">官方推荐</span>
</div>

<div id="recommend_template">
<p><a href="http://www.emlog.net/templates" target="_blank">更多模板&raquo;</a></p>
<div id="recommend_template_list" style="overflow: hidden;text-align: center;">
<span class="ajax_remind_1">正在读取...</span>
</div>
</div>
<script>
$(document).ready(function(){
	$.getJSON("http://emer.emlog.net/api/recommend?callback=?",function(data){
		var items = [];
		$.each(data, function(i,item){
			items.push('<ul> <li><a target="_blank" href="'+item.url+'"><img src="'+item.logo+'" width="180" height="140"></a><li> <li><a target="_blank" href="'+item.url+'"><b>'+item.name+'</b></a></li> <li>作者：'+item.author+'</li> </ul>');
		});
		$("#recommend_template_list").html(items.join(""));
	});
});
</script>