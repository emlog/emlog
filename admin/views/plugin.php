<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['activate_install'])): ?>
        <div class="alert alert-success">插件上传成功，请开启使用</div><?php endif; ?>
    <?php if (isset($_GET['active'])): ?>
        <div class="alert alert-success">插件开启成功</div><?php endif; ?>
    <?php if (isset($_GET['activate_del'])): ?>
        <div class="alert alert-success">删除成功</div><?php endif; ?>
    <?php if (isset($_GET['active_error'])): ?>
        <div class="alert alert-danger">插件开启失败</div><?php endif; ?>
    <?php if (isset($_GET['inactive'])): ?>
        <div class="alert alert-success">插件禁用成功</div><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?>
        <div class="alert alert-danger">删除失败，请检查插件文件权限</div><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?>
        <div class="alert alert-danger">上传失败，插件目录(content/plugins)不可写</div><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div class="alert alert-danger">空间不支持zip模块，请按照提示手动安装插件</div><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?>
        <div class="alert alert-danger">请选择一个zip插件安装包</div><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?>
        <div class="alert alert-danger">安装失败，插件安装包不符合标准</div><?php endif; ?>
    <?php if (isset($_GET['error_f'])): ?>
        <div class="alert alert-danger">只支持zip压缩格式的插件包</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">插件管理</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> 安装插件</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                <tr>
                    <th>插件名</th>
                    <th>版本</th>
                    <th>描述</th>
                    <th>开关</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($plugins):
                    $i = 0;
                    foreach ($plugins as $key => $val):
                        $plug_state = 'inactive';
                        $plug_action = 'active';
                        $plug_state_des = '点击开启插件';
                        if (in_array($key, $active_plugins)) {
                            $plug_state = 'active';
                            $plug_action = 'inactive';
                            $plug_state_des = '点击禁用插件';
                        }
                        $i++;
                        if (TRUE === $val['Setting']) {
                            $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"点击设置插件\">{$val['Name']}</a>";
                        }
                        ?>
                        <tr>
                            <td><?php echo $val['Name']; ?></td>
                            <td><?php echo $val['Version']; ?></td>
                            <td>
                                <?php echo $val['Description']; ?>
                                <?php if ($val['Url'] != ''): ?><a href="<?php echo $val['Url']; ?>" target="_blank">更多信息&raquo;</a><?php endif; ?>
                                <div style="margin-top:5px;">
                                    <?php if ($val['ForEmlog'] != ''): ?>适用于emlog：<?php echo $val['ForEmlog']; ?>&nbsp | &nbsp<?php endif; ?>
                                    <?php if ($val['Author'] != ''): ?>
                                        作者：<?php if ($val['AuthorUrl'] != ''): ?>
                                            <a href="<?php echo $val['AuthorUrl']; ?>" target="_blank"><?php echo $val['Author']; ?></a>
                                        <?php else: ?>
                                            <?php echo $val['Author']; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td id="plugin_<?php echo $i; ?>">
                                <a href="./plugin.php?action=<?php echo $plug_action; ?>&plugin=<?php echo $key; ?>&token=<?php echo LoginAuth::genToken(); ?>"><img
                                            src="./views/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
                            </td>
                            <td>
                                <a href="javascript: em_confirm('<?php echo $key; ?>', 'plu', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5">还没有安装插件</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
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
                            <li>
                                <input name="pluzip" type="file"/>
                            </li>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-success">上传</button>
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_plug").addClass('active');
</script>
