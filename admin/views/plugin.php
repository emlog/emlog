<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success">插件安装成功，请开启使用</div><?php endif ?>
<?php if (isset($_GET['activate_upgrade'])): ?>
    <div class="alert alert-success">插件更新成功</div><?php endif ?>
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
<?php if (isset($_GET['error_i'])): ?>
    <div class="alert alert-danger">您的emlog pro尚未注册</div><?php endif ?>
<?php if (isset($_GET['error_sys'])): ?>
    <div class="alert alert-danger">系统依赖插件，请勿删除和关闭</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">插件扩展</h1>
    <div>
        <a href="store.php?action=plu" class="btn btn-sm btn-warning shadow-sm mt-4"><i class="icofont-shopping-cart"></i> 应用商店</a>
        <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 安装插件</a>
    </div>
</div>
<div class="panel-heading d-flex flex-column flex-md-row justify-content-between mb-3">
    <ul class="nav nav-pills justify-content-start mb-2 mb-md-0">
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
    <div class="w-md-auto">
        <input type="text" id="pluginSearch" class="form-control" placeholder="搜索插件...">
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <div class="my-3" id="upMsg"></div>
            <table class="table table-striped table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th>插件名</th>
                        <th>开关</th>
                        <th>作者</th>
                        <th>版本</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody id="pluginTable">
                    <?php
                    if ($plugins):
                        $i = 0;
                        foreach ($plugins as $val):
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
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="<?= $val['preview'] ?>" height="45" width="45" class="rounded" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="align-items-center mb-3">
                                                <p class="mb-0 m-2"><?= $val['Name'] ?></p>
                                                <p class="mb-0 m-2 small"><?= $val['Description'] ?> <?php if (strpos($val['Url'], 'https://www.emlog.net') === 0): ?><a href="<?= $val['Url'] ?>" target="_blank">更多信息&raquo;</a><?php endif ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3">
                                        <input class="mui-switch mui-switch-animbg" type="checkbox" id="sw<?= $i ?>" <?= $plug_state ?> onchange="toggleSwitch('<?= $alias ?>', '<?= 'sw' . $i ?>', '<?= LoginAuth::genToken() ?>')">
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3">
                                        <?php if ($val['Author'] != ''): ?>
                                            <?php if (strpos($val['AuthorUrl'], 'https://www.emlog.net') === 0): ?>
                                                <a href="<?= $val['AuthorUrl'] ?>" target="_blank"><?= $val['Author'] ?></a>
                                            <?php else: ?>
                                                <?= $val['Author'] ?>
                                            <?php endif ?>
                                        <?php endif ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3 small">
                                        <?= $val['Version'] ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3">
                                        <a href="javascript: em_confirm('<?= $alias ?>', 'plu', '<?= LoginAuth::genToken() ?>');" class="btn btn-sm btn-danger">删除</a>
                                        <span class="update-btn"></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="6">未找到插件</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
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
                        <li><input name="pluzip" type="file" /></li>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-success">上传</button>
                    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // check for upgrade
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_ext").addClass('active');

        var pluginList = [];
        $('table tbody tr').each(function() {
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
            success: function(response) {
                if (response.code === 0) {
                    var pluginsToUpdate = response.data;
                    $.each(pluginsToUpdate, function(index, item) {
                        var $tr = $('table tbody tr[data-plugin-alias="' + item.name + '"]');
                        var $updateBtn = $tr.find('.update-btn');
                        var $updateLink = $('<a>').addClass('btn btn-success btn-sm').text('更新').attr("href", "javascript:void(0);");
                        $updateLink.on('click', function() {
                            updatePlugin(item.name, $updateLink);
                        });
                        $updateBtn.append($updateLink);
                    });
                } else {
                    $('#upMsg').html('插件更新检查无法正常进行,错误码:' + response.code).addClass('alert alert-warning');
                }
            },
            error: function(xhr) {
                var responseText = xhr.responseText;
                var responseObject = JSON.parse(responseText);
                var msgValue = responseObject.msg;
                $('#upMsg').html('插件更新检查异常： ' + msgValue).addClass('alert alert-warning');
            }
        });

        // Plugin search functionality
        $('#pluginSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#pluginTable tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });

    function toggleSwitch(plugin, id, token) {
        var switchElement = document.getElementById(id);
        if (switchElement.checked) {
            window.location.href = './plugin.php?action=active&plugin=' + plugin + '&token=' + token + '<?= '&filter=' . $filter ?>';
        } else {
            window.location.href = './plugin.php?action=inactive&plugin=' + plugin + '&token=' + token + '<?= '&filter=' . $filter ?>';
        }
    }

    function updatePlugin(pluginAlias, $updateLink) {
        $updateLink.text('正在更新...').prop('disabled', true);
        $.ajax({
            url: './plugin.php?action=upgrade',
            type: 'GET',
            data: {
                alias: pluginAlias,
                token: '<?= LoginAuth::genToken() ?>'
            },
            success: function(response) {
                if (response.code === 0) {
                    location.href = 'plugin.php?activate_upgrade=1';
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