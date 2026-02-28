<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['activate_install'])): ?>
    <div class="alert alert-success"><?= _lang('plugin_install_success') ?></div><?php endif ?>
<?php if (isset($_GET['activate_upgrade'])): ?>
    <div class="alert alert-success"><?= _lang('plugin_update_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_error'])): ?>
    <div class="alert alert-danger"><?= _lang('plugin_enable_failed') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= _lang('plugin_delete_failed_permission') ?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= _lang('plugin_upload_failed_permission') ?></div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger"><?= _lang('php_zip_not_support') ?></div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger"><?= _lang('select_zip_plugin') ?></div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger"><?= _lang('plugin_install_failed_invalid') ?></div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger"><?= _lang('plugin_only_zip') ?></div><?php endif ?>
<?php if (isset($_GET['error_g'])): ?>
    <div class="alert alert-danger"><?= _lang('upload_size_exceeded') ?></div><?php endif ?>
<?php if (isset($_GET['error_i'])): ?>
    <div class="alert alert-danger"><?= _lang('emlog_not_registered') ?></div><?php endif ?>
<?php if (isset($_GET['error_sys'])): ?>
    <div class="alert alert-danger"><?= _lang('system_plugin_warning') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('plugin') ?></h1>
    <div>
        <a href="javascript:em_confirm('', 'inactive_all_plugins', '<?= LoginAuth::genToken() ?>');" class="btn btn-sm btn-danger shadow-sm mt-4"><i class="icofont-close-circled"></i> <?= _lang('close_all_plugins') ?></a>
        <a href="#" class="btn btn-sm btn-success shadow-sm mt-4" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?= _lang('install_plugin') ?></a>
    </div>
</div>
<div class="panel-heading d-flex flex-column flex-md-row justify-content-between mb-3">
    <ul class="nav nav-pills justify-content-start mb-2 mb-md-0">
        <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);" onclick="pluginFilter('all', this);"><?= _lang('all') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" onclick="pluginFilter('active', this);"><?= _lang('active') ?></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="javascript:void(0);" onclick="pluginFilter('inactive', this);"><?= _lang('inactive') ?></a>
        </li>
    </ul>
    <div class="w-md-auto">
        <input type="text" id="pluginSearch" class="form-control" placeholder="<?= _lang('search_plugin_placeholder') ?>">
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="my-3" id="upMsg"></div>
        <div class="table-responsive">
            <table class="table table-striped table-hover dataTable no-footer">
                <thead>
                    <tr>
                        <th><?= _lang('plugin_name') ?></th>
                        <th><?= _lang('status') ?></th>
                        <th><?= _lang('author') ?></th>
                        <th><?= _lang('version') ?></th>
                        <th><?= _lang('operation') ?></th>
                    </tr>
                </thead>
                <tbody id="pluginTable">
                    <?php
                    if ($plugins):
                        $i = 0;
                        foreach ($plugins as $val):
                            $i++;
                            $plug_state = '';
                            $plug_action = 'active';
                            $plugin_name = $val['Name'];
                            $plugin_setting_url = "";
                            $alias = $val['alias'];
                            if ($val['active']) {
                                $plug_state = 'checked';
                                $plug_action = 'inactive';
                            }
                            if (TRUE === $val['Setting']) {
                                $plugin_setting_url = "./plugin.php?plugin={$val['Plugin']}";
                            }
                            if (!empty($plugin_setting_url) && $val['active']) {
                                $plugin_name = "<a href=\"{$plugin_setting_url}\">{$plugin_name}</a>";
                            }
                    ?>
                            <tr data-active="<?= $val['active'] ?>" data-plugin-alias="<?= $val['Plugin'] ?>" data-plugin-version="<?= $val['Version'] ?>" data-plugin-setting-url="<?= $plugin_setting_url ?>" data-plugin-show-url="<?= $val['ShowUrl'] ?>" data-plugin-name="<?= htmlspecialchars($val['Name']) ?>">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img src="<?= $val['preview'] ?>" height="45" width="45" class="rounded" />
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="align-items-center mb-3">
                                                <p class="mb-0 m-2">
                                                    <?= $plugin_name ?>
                                                    <?php if (!empty($val['ShowUrl']) && $val['active']): ?>
                                                        ｜ <a href="<?= $val['ShowUrl'] ?>" target="_blank"><i class="icofont-link icofont-1x"></i></a>
                                                    <?php endif ?>
                                                </p>
                                                <p class="mb-0 m-2 small"><?= $val['Description'] ?> <?php if (strpos($val['Url'], 'https://www.emlog.net') === 0): ?><a href="<?= $val['Url'] ?>" target="_blank"><?= _lang('more_info') ?>&raquo;</a><?php endif ?></p>
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
                                        <a href="javascript: em_confirm('<?= $alias ?>', 'plu', '<?= LoginAuth::genToken() ?>');" class="btn btn-outline-danger btn-sm"><?= _lang('delete') ?></a>
                                        <span class="update-btn"></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title"><?= _lang('install_plugin') ?></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data">
                <div class="modal-body px-4">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="pluzip" id="pluzip">
                        <label class="custom-file-label" for="pluzip"><?= _lang('select_plugin_package') ?></label>
                        <input name="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    </div>
                    <small class="form-text text-muted mt-2">
                        <?= _lang('upload_zip_plugin_tips') ?>
                    </small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('upload_install') ?></button>
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

        // 监听模板文件上传
        $('#pluzip').on('change', function() {
            var fileName = $(this).get(0).files[0] ? $(this).get(0).files[0].name : '';
            $(this).next('.custom-file-label').text(fileName || '<?= _lang('select_plugin_package') ?>');
        });

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
                        var $updateLink = $('<a>').addClass('btn btn-success btn-sm').text('<?= _lang('update') ?>').attr("href", "javascript:void(0);");
                        $updateLink.on('click', function() {
                            updatePlugin(item.name, $updateLink);
                        });
                        $updateBtn.append($updateLink);
                    });
                } else {
                    $('#upMsg').html('<?= _lang('plugin_update_check_failed') ?>' + response.code).addClass('alert alert-warning');
                }
            },
            error: function(xhr) {
                var responseText = xhr.responseText;
                var responseObject = JSON.parse(responseText);
                var msgValue = responseObject.msg;
                $('#upMsg').html('<?= _lang('plugin_update_check_error') ?>' + msgValue).addClass('alert alert-warning');
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
        var action = switchElement.checked ? 'active' : 'inactive';
        var filter = '';

        togglePluginAjax(plugin, action, token, id, filter);
    }

    function togglePluginAjax(plugin, action, token, switchId, filter) {
        const switchElement = document.getElementById(switchId);
        const originalState = switchElement.checked;

        // 禁用开关防止重复操作
        switchElement.disabled = true;

        $.ajax({
            type: "GET",
            url: "./plugin.php",
            data: {
                action: action,
                plugin: plugin,
                token: token,
                filter: filter
            },
            success: function(response) {
                if (response.code === 0) {
                    cocoMessage.success(response.data);
                    updatePluginSettingLink(switchId, action);
                } else {
                    switchElement.checked = !originalState;
                    cocoMessage.error(response.data, 4000);
                }
            },
            error: function(xhr) {
                switchElement.checked = !originalState;
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    cocoMessage.error(errorResponse.msg, 4000);
                } catch (e) {
                    cocoMessage.error(`HTTP ${xhr.status}`, 4000);
                }
            },
            complete: function() {
                switchElement.disabled = false;
            }
        });
    }

    function updatePluginSettingLink(switchId, action) {
        var $tr = $('#' + switchId).closest('tr');
        $tr.data('active', action === 'active' ? 1 : 0);
        var settingUrl = $tr.data('plugin-setting-url') || '';
        var showUrl = $tr.data('plugin-show-url') || '';
        var pluginName = $tr.data('plugin-name') || '';
        var $nameP = $tr.find('p.mb-0.m-2:not(.small)').first();

        $nameP.empty();
        if (action === 'active') {
            if (settingUrl) {
                $('<a>').attr('href', settingUrl).text(pluginName).appendTo($nameP);
            } else {
                $nameP.text(pluginName);
            }

            if (showUrl) {
                $nameP.append(' ｜ ');
                $('<a>').attr('href', showUrl).attr('target', '_blank').html('<i class="icofont-link icofont-1x"></i>').appendTo($nameP);
            }
        } else {
            $nameP.text(pluginName);
        }
    }

    function updatePlugin(pluginAlias, $updateLink) {
        $updateLink.text('<?= _lang('updating') ?>').prop('disabled', true);
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
                    $updateLink.text('<?= _lang('update') ?>').prop('disabled', false);
                    cocoMessage.error(response.msg, 4000);
                }
            },
            error: function(xhr) {
                $updateLink.text('<?= _lang('update') ?>').prop('disabled', false);
                cocoMessage.error('<?= _lang('update_request_failed') ?>', 4000)
            }
        });
    }
    function pluginFilter(filter, element) {
        $('.nav-pills .nav-link').removeClass('active');
        $(element).addClass('active');

        $('#pluginTable tr').each(function() {
            var isActive = $(this).data('active');
            if (filter === 'all') {
                $(this).show();
            } else if (filter === 'active') {
                if (isActive == 1) $(this).show();
                else $(this).hide();
            } else if (filter === 'inactive') {
                if (isActive == 0) $(this).show();
                else $(this).hide();
            }
        });
    }
</script>