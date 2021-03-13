<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['active_del'])): ?>
        <div class="alert alert-success">备份文件删除成功</div><?php endif; ?>
    <?php if (isset($_GET['active_backup'])): ?>
        <div class="alert alert-success">数据备份成功</div><?php endif; ?>
    <?php if (isset($_GET['active_import'])): ?>
        <div class="alert alert-success">备份导入成功</div><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?>
        <div class="alert alert-danger">请选择要删除的备份文件</div><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?>
        <div class="alert alert-danger">备份文件名错误(应由英文字母、数字、下划线组成)</div><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div class="alert alert-danger">服务器空间不支持zip，无法导入zip备份</div><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?>
        <div class="alert alert-danger">上传备份失败</div><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?>
        <div class="alert alert-danger">错误的备份文件</div><?php endif; ?>
    <?php if (isset($_GET['error_f'])): ?>
        <div class="alert alert-danger">服务器空间不支持zip，无法导出zip备份</div><?php endif; ?>
    <?php if (isset($_GET['active_mc'])): ?>
        <div class="alert alert-success">缓存更新成功</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">数据管理</h1>
    </div>
    <div class="card-deck">
        <div class="card">
            <!--            <img class="card-img-top" src="..." alt="Card image cap">-->
            <div class="card-body">
                <h5 class="card-title">备份数据库</h5>
                <form action="data.php?action=bakstart" method="post">
                    <div id="backup">
                        <p>将站点内容数据库备份到自己电脑上</p>
<!--vot-->      <p id="local_bakzip"><?=lang('backup_export_to')?>: <input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
                        <p>
                            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                    <input type="submit" value="<?=lang('backup_start')?>" class="btn btn-primary"/>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <!--            <img class="card-img-top" src="..." alt="Card image cap">-->
            <div class="card-body">
                <h5 class="card-title">导入本地备份</h5>
                <form action="data.php?action=import" enctype="multipart/form-data" method="post">
                    <div id="import">
<!--vot-->      <p class="des"><?=lang('backup_version_tip')?> <?php echo DB_PREFIX; ?></p>
                        <p>
                            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
<!--vot-->          <input type="file" name="sqlfile"> <input type="submit" value="<?=lang('import')?>" class="submit">
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <!--            <img class="card-img-top" src="..." alt="Card image cap">-->
            <div class="card-body">
                <h5 class="card-title">更新缓存</h5>
                <div id="cache">
<!--vot-->  <p class="des"><?=lang('cache_update_info')?></p>
<!--vot-->  <p><input type="button" onclick="window.location='data.php?action=Cache';" value="<?=lang('cache_update')?>" class="btn btn-primary"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_data").addClass('active');
    setTimeout(hideActived, 2600);
</script>
