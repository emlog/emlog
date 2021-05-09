<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">模板更换成功</div><?php endif; ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success">模板上传成功</div><?php endif; ?>
<?php if (isset($_GET['activate_del'])): ?>
    <div class="alert alert-success">删除模板成功</div><?php endif; ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger">删除失败，请检查模板文件权限</div><?php endif; ?>
<?php if (!$nonceTplData): ?>
    <div class="alert alert-danger">当前使用的模板(<?php echo $nonce_templet; ?>)已被删除或损坏，请选择其他模板。</div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">只支持zip压缩格式的模板包</div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">上传失败，模板目录(content/templates)不可写</div><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">请选择一个zip模板安装包</div><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">安装失败，模板安装包不符合标准</div><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">
        空间不支持zip模块，请手动安装： <br/>
        1、把解压后的模板文件夹上传到 content/templates目录下。 <br/>
        2、登录后台换模板，模板库中已经有了你刚才添加的模板，点击使用即可。 <br/>
    </div>
<?php endif; ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">模板管理</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 安装模板</a>
</div>
<div class="card-columns">
	<?php foreach ($tpls as $key => $value): ?>
        <div class="card">
            <div class="card-header <?php if ($nonce_templet == $value['tplfile']) {echo "bg-success text-white";} ?>">
                <?php echo $value['tplname']; ?>
            </div>
            <div class="card-body">
                <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>">
                    <img class="card-img-top" src="<?php echo TPLS_URL . $value['tplfile']; ?>/preview.jpg" alt="Card image cap">
                </a>
            </div>
            <div class="card-footer">
                <a class="btn btn-sm btn-danger" href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl', '<?php echo LoginAuth::genToken(); ?>');">删除</a>
            </div>
        </div>
	<?php endforeach; ?>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">安装模板</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div>
                        <p>上传一个zip压缩格式的模板安装包</p>
                        <p>
                            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                            <input name="tplzip" type="file"/>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">上传</button>
                    <span id="alias_msg_hook"></span>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
    $("#menu_tpl").addClass('active');
</script>
