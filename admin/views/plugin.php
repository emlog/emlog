<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div id="msg"></div>
<?php if (isset($_GET['activate_install'])): ?><span class="alert alert-success">插件上传成功，请激活使用</span><?php endif; ?>
<?php if (isset($_GET['active'])): ?><span class="alert alert-success">插件激活成功</span><?php endif; ?>
<?php if (isset($_GET['activate_del'])): ?><span class="alert alert-success">删除成功</span><?php endif; ?>
<?php if (isset($_GET['active_error'])): ?><span class="alert alert-danger">插件激活失败</span><?php endif; ?>
<?php if (isset($_GET['inactive'])): ?><span class="alert alert-success">插件禁用成功</span><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">删除失败，请检查插件文件权限</span><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?><span class="alert alert-danger">上传失败，插件目录(content/plugins)不可写</span><?php endif; ?>
<?php if (isset($_GET['error_c'])): ?><span class="alert alert-danger">空间不支持zip模块，请按照提示手动安装插件</span><?php endif; ?>
<?php if (isset($_GET['error_d'])): ?><span class="alert alert-danger">请选择一个zip插件安装包</span><?php endif; ?>
<?php if (isset($_GET['error_e'])): ?><span class="alert alert-danger">安装失败，插件安装包不符合标准</span><?php endif; ?>
<?php if (isset($_GET['error_f'])): ?><span class="alert alert-danger">只支持zip压缩格式的插件包</span><?php endif; ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">插件管理</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">插件管理</h6>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-hover dataTable no-footer">
                <thead>
                <tr>
                    <th width="200"></th>
                    <th width="80" class="tdcenter"><b>开启/禁用</b></th>
                    <th width="60" class="tdcenter"><b>版本</b></th>
                    <th width="450" class="tdcenter"><b>描述</b></th>
                    <th width="60" class="tdcenter"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($plugins):
                    $i = 0;
                    foreach ($plugins as $key => $val):
                        $plug_state = 'inactive';
                        $plug_action = 'active';
                        $plug_state_des = '点击激活插件';
                        if (in_array($key, $active_plugins)) {
                            $plug_state = 'active';
                            $plug_action = 'inactive';
                            $plug_state_des = '点击禁用插件';
                        }
                        $i++;
                        if (TRUE === $val['Setting']) {
                            $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"点击设置插件\">{$val['Name']} <img src=\"./views/images/set.png\" border=\"0\" /></a>";
                        }
                        ?>
                        <tr>
                            <td class="tdcenter"><?php echo $val['Name']; ?></td>
                            <td class="tdcenter" id="plugin_<?php echo $i; ?>">
                                <a href="./plugin.php?action=<?php echo $plug_action; ?>&plugin=<?php echo $key; ?>&token=<?php echo LoginAuth::genToken(); ?>"><img
                                            src="./views/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
                            </td>
                            <td class="tdcenter"><?php echo $val['Version']; ?></td>
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
                            <td class="tdcenter">
                                <a href="javascript: em_confirm('<?php echo $key; ?>', 'plu', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="tdcenter" colspan="5">还没有安装插件</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div><a href="javascript:displayToggle('plugin_new', 2);" class="btn btn-success">安装插件+</a></div>
    <form action="./plugin.php?action=upload_zip" method="post" enctype="multipart/form-data">
        <div id="plugin_new" class="form-group" style="margin:50px 0px;">
            <li>上传一个zip压缩格式的插件安装包</li>
            <li>
                <input name="pluzip" type="file"/>
            </li>
            <li>
                <input type="submit" value="上传安装" class="btn btn-primary"/>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
            </li>
        </div>
    </form>
</div>
<!-- /.container-fluid -->
<script>
    $("#plugin_new").css('display', $.cookie('em_plugin_new') ? $.cookie('em_plugin_new') : 'none');
    setTimeout(hideActived, 2600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('in');
    $("#menu_plug").addClass('active');
</script>
