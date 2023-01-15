<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active'])): ?>
    <div class="alert alert-success">安装成功</div><?php endif ?>
<?php if (isset($_GET['error_param'])): ?>
    <div class="alert alert-danger">安装失败</div><?php endif ?>
<?php if (isset($_GET['error_down'])): ?>
    <div class="alert alert-danger">安装失败，无法下载安装包</div><?php endif ?>
<?php if (isset($_GET['error_dir'])): ?>
    <div class="alert alert-danger">安装失败，无法写文件，请检查content/下目录是否可写</div><?php endif ?>
<?php if (isset($_GET['error_zip'])): ?>
    <div class="alert alert-danger">安装失败，无法解压，请安装php的Zip扩展</div><?php endif ?>
<?php if (isset($_GET['error_source'])): ?>
    <div class="alert alert-danger">安装失败，不是有效的安装包</div><?php endif ?>

<?php if (isset($_GET['error'])): ?>
    <div class="container-fluid">
        <div class="text-center">
            <p class="lead text-gray-800 mb-5">商店暂不可用，可能是网络问题</p>
            <a href="./">&larr; 返回首页</a>
        </div>
    </div>
<?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php?tag=free">模板主题</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu&tag=free">扩展插件</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=mine">已购应用</a></li>
    </ul>
</div>
<div class="row">
	<?php if (!empty($addons)): ?>
		<?php foreach ($addons as $k => $v):
			$icon = $v['icon'] ?: "./views/images/theme.png";
			?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a class="p-1" href="<?= $v['buy_url'] ?>" target="_blank">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?= $icon ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text"><?= $v['name'] ?></p>
                        <p class="card-text text-muted small">
                            <span class="small"><?= $v['info'] ?></span><br><br>
                            开发者：<?= $v['author'] ?><br>
                            版本号：<?= $v['ver'] ?><br>
                            更新时间：<?= $v['update_time'] ?><br>
                        </p>
                        <p class="card-text text-right">
							<?php if (!empty($v['download_url'])): ?>
                                <a href="./store.php?action=install&source=<?= urlencode($v['download_url']) ?>&type=<?= $v['type'] ?>" class="btn btn-success btn-sm">安装</a>
							<?php else: ?>
                                <a href="#" class="btn btn-success btn-sm">联系作者安装</a>
							<?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
		<?php endforeach ?>
	<?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">你还没有购买任何应用。</div>
        </div>
	<?php endif ?>
</div>
<script>
    $("#menu_store").addClass('active');
    setTimeout(hideActived, 3600);
</script>
