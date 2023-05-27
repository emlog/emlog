<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">模板更换成功</div><?php endif ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success">模板安装成功</div><?php endif ?>
<?php if (isset($_GET['activate_upgrade'])): ?>
    <div class="alert alert-success">模板更新成功</div><?php endif ?>
<?php if (isset($_GET['activate_del'])): ?>
    <div class="alert alert-success">删除模板成功</div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger">删除失败，请检查模板文件权限</div><?php endif ?>
<?php if (!$nonce_template_data): ?>
    <div class="alert alert-danger">当前使用的模板(<?= $nonce_template ?>)已被删除或损坏，请选择其他模板。</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">只支持zip压缩格式的模板包</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">上传失败，模板目录(content/templates)不可写</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">请选择一个zip格式的模板安装包</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">安装失败，模板安装包不符合标准</div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger">上传安装包大小超出PHP限制</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">服务器PHP不支持zip模块</div><?php endif ?>
<?php if (isset($_GET['error_h'])): ?>
    <div class="alert alert-danger">更新失败，无法下载更新包，可能是服务器网络问题。</div><?php endif ?>
<?php if (isset($_GET['error_i'])): ?>
    <div class="alert alert-danger">您的emlog pro尚未注册</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">模板外观</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 安装模板</a>
</div>
<div class="row app-list">
    <?php foreach ($templates as $key => $value): ?>
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm" data-app-alias="<?= $value['tplfile'] ?>" data-app-version="<?= $value['version'] ?>">
                <div class="card-header <?php if ($nonce_template == $value['tplfile']) {
                    echo "bg-success text-white font-weight-bold";
                } ?>">
                    <?= $value['tplname'] ?>
                </div>
                <div class="card-body">
                    <a href="template.php?action=use&tpl=<?= $value['tplfile'] ?>&token=<?= LoginAuth::genToken() ?>">
                        <img class="card-img-top" src="<?= TPLS_URL . $value['tplfile'] ?>/preview.jpg" alt="Card image cap">
                    </a>
                </div>
                <div class="card-footer">
                    <p><?= $value['tplname'] ?></p>
                    <?php if ($value['version']): ?>
                        <div class="small">版本号：<?= $value['version'] ?></div>
                    <?php endif ?>
                    <?php if ($value['author']): ?>
                        <div class="small">开发者：<?= $value['author'] ?></div>
                    <?php endif ?>
                    <div class="small">
                        <?= $value['tpldes'] ?>
                        <?php if ($value['tplurl']): ?>
                            <a href="<?= $value['tplurl'] ?>" target="_blank">更多介绍&rarr;</a>
                        <?php endif ?>
                    </div>
                    <div class="mt-3">
                        <a class="badge badge-danger" href="javascript: em_confirm('<?= $value['tplfile'] ?>', 'tpl', '<?= LoginAuth::genToken() ?>');">删除</a>
                        <span class="update-btn"></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
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
                            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
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
    // check for upgrade
    $(function () {
        setTimeout(hideActived, 3600);
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_tpl").addClass('active');
        
        var templateList = [];
        $('.app-list .card').each(function () {
            var $card = $(this);
            var alias = $card.data('app-alias');
            var version = $card.data('app-version');
            templateList.push({
                name: alias,
                version: version
            });
        });
        $.ajax({
            url: './template.php?action=check_update',
            type: 'POST',
            data: {
                templates: templateList
            },
            success: function (response) {
                if (response.code === 0) {
                    var pluginsToUpdate = response.data;
                    $.each(pluginsToUpdate, function (index, item) {
                        var $tr = $('.app-list .card[data-app-alias="' + item.name + '"]');
                        var $updateBtn = $tr.find('.update-btn');
                        $updateBtn.append($('<a>').addClass('badge badge-success').text('更新').attr("href", "./template.php?action=upgrade&alias=" + item.name));
                    });
                } else {
                    console.log('更新接口返回错误');
                }
            },
            error: function () {
                console.log('请求更新接口失败');
            }
        });
    });
</script>
