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
<div class="row mb-4 ml-1 justify-content-between">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php?tag=free">模板主题</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=plu&tag=free"><i class="icofont-plugin"></i> 扩展插件</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">已购应用</a></li>
    </ul>
    <form action="./store.php" method="get">
        <div class="form-inline search-inputs-nowrap">
            <input type="hidden" name="action" value="plu">
            <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control m-1 small" placeholder="搜索插件">
            <div class="input-group-append">
                <button class="btn btn-sm btn-success" type="submit">
                    <i class="icofont-search-2"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<div class="row mb-3 ml-1">
    <a href="./store.php?action=plu&tag=free" class="badge badge-success m-1 p-2">免费区</a>
    <a href="./store.php?action=plu&tag=paid" class="badge badge-warning m-1 ml-2 p-2">付费区</a>
</div>
<div class="row">
	<?php if (!empty($plugins)): ?>
		<?php foreach ($plugins as $k => $v):
			$icon = $v['icon'] ?: "./views/images/plugin.png";
			?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a class="p-1" href="<?= $v['buy_url'] ?>" target="_blank">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?= $icon ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text"><?= $v['name'] ?>
							<?= $v['price'] > 0 ? '<span class="badge badge-warning">' . $v['price'] . '元</span>' : '<span class="badge badge-success">免费</span>' ?>
                        </p>
                        <p class="card-text text-muted small">
							<?= $v['info'] ?><br><br>
                            售价：<?= $v['price'] > 0 ? $v['price'] . '元' : '免费' ?><br>
                            开发者：<?= $v['author'] ?><br>
                            版本号：<?= $v['ver'] ?><br>
                            更新时间：<?= $v['update_time'] ?><br>
                        </p>
                        <p class="card-text text-right">
							<?php if ($v['price'] > 0): ?>
                                <a href="<?= $v['buy_url'] ?>" class="btn btn-warning btn-sm" target="_blank">￥<?= $v['price'] ?>，去购买</a>
							<?php else: ?>
                                <a href="./store.php?action=install&source=<?= urlencode($v['download_url']) ?>&type=plugin" class="btn btn-success btn-sm">免费安装</a>
							<?php endif ?>
                        </p>
                    </div>
                </div>
            </div>
		<?php endforeach ?>
        <div class="col-md-12 page my-5"><?= $pageurl ?> (有<?= $count ?>个插件)</div>
	<?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">暂未找到结果，应用商店进货中，敬请期待：）</div>
        </div>
	<?php endif ?>
</div>
<script>
    $("#menu_store").addClass('active');
    setTimeout(hideActived, 3600);
</script>
