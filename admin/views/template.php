<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">模板更换成功</div><?php endif ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success">模板安装成功</div><?php endif ?>
<?php if (isset($_GET['activate_upgrade'])): ?>
    <div class="alert alert-success">模板更新成功</div><?php endif ?>
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
<?php if (isset($_GET['error_i'])): ?>
    <div class="alert alert-danger">您的emlog pro尚未注册</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">模板主题</h1>
    <div>
        <a href="store.php" class="btn btn-sm btn-warning shadow-sm mt-4"><i class="icofont-shopping-cart"></i> 应用商店</a>
        <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 安装模板</a>
    </div>
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
                        <img class="card-img-top" src="<?= $value['preview'] ?>" alt="preview image">
                    </a>
                </div>
                <div class="card-footer">
                    <?php if ($value['version']): ?>
                        <div class="small">版本号：<?= $value['version'] ?></div>
                    <?php endif ?>
                    <?php if ($value['author'] && strpos($value['author_url'], 'https://www.emlog.net') === 0): ?>
                        <div class="small">开发者：<a href="<?= $value['author_url'] ?>" target="_blank"><?= $value['author'] ?></a></div>
                    <?php elseif ($value['author']): ?>
                        <div class="small">开发者：<?= $value['author'] ?></div>
                    <?php endif ?>
                    <div class="small">
                        <?= $value['tpldes'] ?>
                        <?php if (strpos($value['tplurl'], 'https://www.emlog.net') === 0): ?>
                            <a href="<?= $value['tplurl'] ?>" target="_blank">更多信息&rarr;</a>
                        <?php endif ?>
                    </div>
                    <div class="card-text d-flex justify-content-between mt-3">
                        <span>
                            <?php if ($nonce_template !== $value['tplfile']): ?>
                                <a class="btn btn-success btn-sm" href="template.php?action=use&tpl=<?= $value['tplfile'] ?>&token=<?= LoginAuth::genToken() ?>">启用</a>
                            <?php endif; ?>
                            <span class="update-btn"></span>
                        </span>
                        <span>
                            <a class="btn btn-danger btn-sm" href="javascript: em_confirm('<?= $value['tplfile'] ?>', 'tpl', '<?= LoginAuth::genToken() ?>');">删除</a>
                        </span>
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
                            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                            <input name="tplzip" type="file" />
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
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_tpl").addClass('active');

        var templateList = [];
        $('.app-list .card').each(function() {
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
            success: function(response) {
                if (response.code === 0) {
                    var pluginsToUpdate = response.data;
                    $.each(pluginsToUpdate, function(index, item) {
                        var $tr = $('.app-list .card[data-app-alias="' + item.name + '"]');
                        var $updateBtn = $tr.find('.update-btn');
                        var $updateLink = $('<a>').addClass('btn btn-warning btn-sm').text('更新').attr("href", "javascript:void(0);");
                        $updateLink.on('click', function() {
                            updateTemplate(item.name, $updateLink);
                        });
                        $updateBtn.append($updateLink);
                    });
                } else {
                    console.log('更新接口返回错误');
                }
            },
            error: function() {
                console.log('请求更新接口失败');
            }
        });
    });

    function updateTemplate(alias, $updateLink) {
        $updateLink.text('正在更新...').prop('disabled', true);
        $.ajax({
            url: './template.php?action=upgrade',
            type: 'GET',
            data: {
                alias: alias,
                token: '<?= LoginAuth::genToken() ?>'
            },
            success: function(response) {
                if (response.code === 0) {
                    location.href = 'template.php?activate_upgrade=1';
                } else {
                    $updateLink.text('更新').prop('disabled', false);
                    cocoMessage.error(response.msg, 4000);
                }
            },
            error: function(xhr) {
                $updateLink.text('更新').prop('disabled', false);
                cocoMessage.error('更新请求失败，请稍后重试', 4000)
            }
        });
    }
</script>