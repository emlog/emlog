<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active'])): ?>
    <div class="alert alert-success">安装成功</div><?php endif; ?>
<?php if (isset($_GET['error_param'])): ?>
    <div class="alert alert-danger">安装失败</div><?php endif; ?>
<?php if (isset($_GET['error_down'])): ?>
    <div class="alert alert-danger">安装失败，无法下载安装包</div><?php endif; ?>
<?php if (isset($_GET['error_dir'])): ?>
    <div class="alert alert-danger">安装失败，无法写文件，请检查content/下目录是否可写</div><?php endif; ?>
<?php if (isset($_GET['error_zip'])): ?>
    <div class="alert alert-danger">安装失败，无法解压，请安装php的Zip扩展</div><?php endif; ?>
<?php if (isset($_GET['error_source'])): ?>
    <div class="alert alert-danger">安装失败，不是有效的安装包</div><?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="container-fluid">
        <div class="text-center">
            <p class="lead text-gray-800 mb-5">商店暂不可用，可能是网络问题</p>
            <a href="./">&larr; 返回首页</a>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($templates)): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">应用商店</h1>
    </div>
    <div class="panel-heading mb-4">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="./store.php">模板主题</a></li>
            <li class="nav-item"><a class="nav-link" href="./store.php?action=plu">扩展插件</a></li>
        </ul>
    </div>
    <div class="row">
		<?php foreach ($templates as $k => $v):
			$icon = $v['icon'] ?: "./views/images/theme.png";
			?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a class="p-1" href="<?php echo $v['buy_url']; ?>">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?php echo $icon; ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text"><?php echo $v['name']; ?> <span class="badge badge-info">模板</span></p>
                        <p class="card-text text-muted small">
                            <span class="small"><?php echo $v['info']; ?></span><br><br>
                            售价：<?php echo $v['price'] > 0 ? $v['price'] . '元' : '免费'; ?><br>
                            开发者：<?php echo $v['author']; ?><br>
                            更新时间：<?php echo $v['update_time']; ?><br>
                        </p>
                        <p class="card-text text-right">
							<?php if ($v['price'] > 0): ?>
                                <a href="<?php echo $v['buy_url']; ?>" class="btn btn-sm btn-warning btn-sm" target="_blank">去购买</a>
							<?php else: ?>
                                <a href="./store.php?action=install&source=<?php echo urlencode($v['download_url']); ?>&type=tpl" class="btn btn-success btn-sm">安装</a>
							<?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>
    </div>

<?php endif; ?>
<script>
    $("#menu_store").addClass('active');
    setTimeout(hideActived, 3600);
</script>
