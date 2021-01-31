<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">安装模板</h1>
    <?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">只支持zip压缩格式的模板包</span><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?><span class="alert alert-danger">上传失败，模板目录(content/templates)不可写</span><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?><span class="alert alert-danger">空间不支持zip模块，请按照提示手动安装模板</span><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?><span class="alert alert-danger">请选择一个zip模板安装包</span><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?><span class="alert alert-danger">安装失败，模板安装包不符合标准</span><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div style="margin:20px 20px;">
            <div class="alert alert-danger">
                手动安装模板： <br/>
                1、把解压后的模板文件夹上传到 content/templates目录下。 <br/>
                2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。 <br/>
            </div>
        </div>
    <?php endif; ?>
    <form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data">
        <div style="margin:50px 0px 50px 20px;">
            <p>上传一个zip压缩格式的模板安装包</p>
            <p>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input name="tplzip" type="file"/>
            </p>
            <p>
                <input type="submit" value="上传安装" class="btn btn-primary"/>
            </p>
        </div>
    </form>
    <div style="margin:10px 20px;">获取更多模板：<a href="https://emlog.net/">访问emlog官方网站&raquo;</a></div>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
