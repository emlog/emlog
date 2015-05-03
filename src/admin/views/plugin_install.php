<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>安装插件</h1>
    <div class="containertitle"><b>导航管理</b>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">只支持zip压缩格式的插件包</span><?php endif;?>
    <?php if(isset($_GET['error_b'])):?><span class="alert alert-danger">上传失败，插件目录(content/plugins)不可写</span><?php endif;?>
    <?php if(isset($_GET['error_c'])):?><span class="alert alert-danger">空间不支持zip模块，请按照提示手动安装插件</span><?php endif;?>
    <?php if(isset($_GET['error_d'])):?><span class="alert alert-danger">请选择一个zip插件安装包</span><?php endif;?>
    <?php if(isset($_GET['error_e'])):?><span class="alert alert-danger">安装失败，插件安装包不符合标准</span><?php endif;?>
    </div>
</section>
<section class="content">
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
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
    <input name="pluzip" type="file" />
    <input type="submit" value="上传安装" class="submit" /> （上传一个zip压缩格式的插件安装包）
    </li>
</div>
</form>
<div style="margin:10px 20px;">获取更多插件：<a href="store.php">应用中心&raquo;</a></div>
</section>
<script>
setTimeout(hideActived, 2600);
$("#menu_plug").addClass('active').parent().parent().addClass('active');
</script>
