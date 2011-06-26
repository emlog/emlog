<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./template.php">当前模板</a>
<a class="navi2" href="./template.php?action=install">安装模板</a>
<?php if(isset($_GET['activated'])):?><span class="actived">模板更换成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">只支持zip压缩格式的模板包</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">解压失败，请确保模板目录可写</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error">空间不支持zip模块，请按照如下提示手动安装模板</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error">请选择一个zip模板安装包</span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
手动安装模板： <br />
1、把解压后的模板文件夹复制或上传到 content/templates目录下。 <br />
2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。 <br />
</div>
</div>
<?php endif; ?>
<div style="margin:20px 10px;">
<div class="des">请上传一个zip压缩格式的模板安装包。<a href="http://www.emlog.net/template/" target="_blank">获取更多模板&raquo;</a></div>
</div>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
	<li></li>
	<li>
	<input name="tplzip" type="file" />
	<input type="submit" value="上传" class="submit" />
	</li>
</div>
</form>