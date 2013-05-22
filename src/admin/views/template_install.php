<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<a class="navi1" href="./template.php">当前模板</a>
<a class="navi2" href="./template.php?action=install">安装模板</a>
<?php if(isset($_GET['error_a'])):?><span class="error">只支持zip压缩格式的模板包</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">上传失败，模板目录(content/templates)不可写</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">空间不支持zip模块，请按照提示手动安装模板</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">请选择一个zip模板安装包</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">安装失败，模板安装包不符合标准</span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 20px;">
<div class="des">
手动安装模板： <br />
1、把解压后的模板文件夹上传到 content/templates目录下。 <br />
2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。 <br />
</div>
</div>
<?php endif; ?>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div style="margin:50px 0px 50px 20px;">
	<li>
	<input name="tplzip" type="file" />
	<input type="submit" value="上传安装" class="submit" /> (上传一个zip压缩格式的模板安装包)
	</li>
</div>
</form>
<div style="margin:10px 20px;">获取更多模板：<a href="store.php">应用中心&raquo;</a></div>
<script>
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
</script>