<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>插件管理</b><div id="msg"></div>
<?php if(isset($_GET['error_a'])):?><span class="error">只支持zip压缩格式的插件包</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">上传失败，请确保插件目录可写</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">空间不支持zip模块，请按照如下提示手动安装插件</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">请选择一个zip插件安装包</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error">安装失败，插件安装包不符合标准</span><?php endif;?>
</div>
<div class=line></div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
手动安装插件： <br />
1、把解压后的插件文件夹复制或上传到 content/plugins 目录下。<br />
2、登录后台进入插件管理,插件管理里已经有了该插件，点击激活即可。<br />
</div>
</div>
<?php endif; ?>
<div style="margin:20px 10px;">
<div class="des">请上传一个zip压缩格式的插件安装包。<a href="http://www.emlog.net/plugins/" target="_blank">获得更多插件&raquo;</a></div>
</div>
<form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
	<li></li>
	<li>
	<input name="pluzip" type="file" />
	<input type="submit" value="上传" class="submit" />
	</li>
</div>
</form>
<script>
$("#menu_plug").addClass('sidebarsubmenu1');
</script>