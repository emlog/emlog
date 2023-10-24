<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success">插件安装成功，请开启使用</div><?php endif ?>
<?php if (isset($_GET['activate_upgrade'])): ?>
    <div class="alert alert-success">插件更新成功</div><?php endif ?>
<?php if (isset($_GET['activate_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['active_error'])): ?>
    <div class="alert alert-danger">插件开启失败</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">删除失败，请检查插件文件权限</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">上传失败，插件目录(content/plugins)不可写</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">服务器PHP不支持zip模块</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">请选择一个zip插件安装包</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">安装失败，插件安装包不符合标准</div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger">只支持zip压缩格式的插件包</div><?php endif ?>
<?php if (isset($_GET['error_g'])): ?>
    <div class="alert alert-danger">上传安装包大小超出PHP限制</div><?php endif ?>
<?php if (isset($_GET['error_h'])): ?>
    <div class="alert alert-danger">更新失败，无法下载更新包，可能是服务器网络问题。</div><?php endif ?>
<?php if (isset($_GET['error_i'])): ?>
    <div class="alert alert-danger">您的emlog pro尚未注册</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">插件扩展</h1>
    <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 安装插件</a>
</div>
<div class="panel-heading">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link <?= $filter == '' ? 'active' : '' ?>" href="./plugin.php">全部</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $filter == 'on' ? 'active' : '' ?>" href="./plugin.php?filter=on">已开启</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= $filter == 'off' ? 'active' : '' ?>" href="./plugin.php?filter=off">未开启</a>
        </li>
    </ul>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                <tr>
                    <th>插件名</th>
                    <th>开关</th>
                    <th>描述</th>
                    <th>版本</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($plugins):
                    $i = 0;
                    foreach ($plugins as $val):
                        if ($val['Plugin'] === 'tpl_options') {
                            continue;
                        }
                        $plug_state = '';
                        $plug_action = 'active';
                        if ($val['active']) {
                            $plug_state = 'checked';
                            $plug_action = 'inactive';
                        }
                        $i++;
                        if (TRUE === $val['Setting']) {
                            $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"点击设置插件\">{$val['Name']}</a>";
                        }
                        $alias = $val['alias'];
                        ?>
                        <tr data-plugin-alias="<?= $val['Plugin'] ?>" data-plugin-version="<?= $val['Version'] ?>">
                            <td><?= $val['Name'] ?></td>
                            <td>
                                <input class="mui-switch mui-switch-animbg" type="checkbox" id="sw<?= $i ?>" <?= $plug_state ?> onchange="toggleSwitch('<?= $alias ?>', '<?= 'sw' . $i ?>', '<?= LoginAuth::genToken() ?>')">
                            </td>
                            <td>
                                <?= $val['Description'] ?>
                                <?php if ($val['Url'] != ''): ?><a href="<?= $val['Url'] ?>" target="_blank">更多信息&raquo;</a><?php endif ?>
                                <div class="small mt-3">
                                    <?php if ($val['Author'] != ''): ?>
                                        作者：
                                        <?php if ($val['AuthorUrl'] != ''): ?>
                                            <a href="<?= $val['AuthorUrl'] ?>" target="_blank"><?= $val['Author'] ?></a>
                                        <?php else: ?>
                                            <?= $val['Author'] ?>
                                        <?php endif ?>
                                    <?php endif ?>
                                </div>
                            </td>
                            <td><?= $val['Version'] ?></td>
                            <td>
                                <a href="javascript: em_confirm('<?= $alias ?>', 'plu', '<?= LoginAuth::genToken() ?>');" class="btn btn-sm btn-danger">删除</a>
                                <span class="update-btn"></span>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5">未找到插件</td>
                    </tr>
                <?php endif ?>
                </tbody>
            </table>
            <div class="my-3" id="upMsg"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">安装插件</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div id="plugin_new" class="form-group">
                        <li>上传一个zip压缩格式的插件安装包</li>
                        <li><input name="pluzip" type="file"/></li>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">上传</button>
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // check for upgrade
    $(function () {
        setTimeout(hideActived, 3600);
        $("#menu_category_ext").addClass('active');
        $("#menu_ext").addClass('show');
        $("#menu_plug").addClass('active');

        var pluginList = [];
        $('table tbody tr').each(function () {
            var $tr = $(this);
            var pluginAlias = $tr.data('plugin-alias');
            var currentVersion = $tr.data('plugin-version');
            pluginList.push({
                name: pluginAlias,
                version: currentVersion
            });
        });
        $.ajax({
            url: './plugin.php?action=check_update',
            type: 'POST',
            data: {
                plugins: pluginList
            },
            success: function (response) {
                if (response.code === 0) {
                    var pluginsToUpdate = response.data;
                    $.each(pluginsToUpdate, function (index, item) {
                        var $tr = $('table tbody tr[data-plugin-alias="' + item.name + '"]');
                        var $updateBtn = $tr.find('.update-btn');
                        $updateBtn.append($('<a>').addClass('btn btn-success btn-sm').text('更新').attr("href", "./plugin.php?action=upgrade&alias=" + item.name));
                    });
                } else {
                    $('#upMsg').html('插件更新检查无法正常进行,错误码:' + response.code).addClass('alert alert-warning');
                }
            },
            error: function (xhr) {
                var responseText = xhr.responseText;
                var responseObject = JSON.parse(responseText);
                var msgValue = responseObject.msg;
                $('#upMsg').html('插件更新检查异常： ' + msgValue).addClass('alert alert-warning');
            }
        });
    });

    function toggleSwitch(plugin, id, token) {
        var switchElement = document.getElementById(id);
        if (switchElement.checked) {
            window.location.href = './plugin.php?action=active&plugin=' + plugin + '&token=' + token;
        } else {
            window.location.href = './plugin.php?action=inactive&plugin=' + plugin + '&token=' + token;
        }
    }
</script>
