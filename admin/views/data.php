<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
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
        <h5 class="card-header">备份数据库</h5>
        <div class="card-body">
            <form action="data.php?action=bakstart" method="post">
                <div id="backup">
                    <p>将站点内容数据库备份到自己电脑上。</p>
                    <p id="local_bakzip">压缩成zip包：<input type="checkbox" style="vertical-align:middle;" value="y" name="zipbak" id="zipbak"></p>
                    <p>
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                        <input type="submit" value="开始备份" class="btn btn-success"/>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">导入本地备份</h5>
        <div class="card-body">
            <form action="data.php?action=import" enctype="multipart/form-data" method="post">
                <div id="import">
                    <p class="des">仅可导入相同版本emlog的数据库备份文件，且数据库表前缀需保持一致。<br/>当前数据库表前缀：<?php echo DB_PREFIX; ?></p>
                    <p>
                        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                        <input type="file" name="sqlfile"/> <input type="submit" value="导入" class="submit"/>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">更新缓存</h5>
        <div class="card-body">
            <div id="cache">
                <p class="des">缓存可以加快站点的加载速度，通常系统会自动更新缓存。特殊情况需要手动更新，如：缓存文件被修改、手动修改过数据库、页面出现异常等。</p>
                <p><input type="button" onclick="window.location='data.php?action=Cache';" value="更新缓存" class="btn btn-success"/></p>
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
