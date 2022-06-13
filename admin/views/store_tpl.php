<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('install_ok')?></div><?php endif ?>
<?php if (isset($_GET['error_param'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed')?></div><?php endif ?>
<?php if (isset($_GET['error_down'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed_download')?></div><?php endif ?>
<?php if (isset($_GET['error_dir'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed_write')?></div><?php endif ?>
<?php if (isset($_GET['error_zip'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed_zip')?></div><?php endif ?>
<?php if (isset($_GET['error_source'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_invalid_ext')?></div><?php endif ?>

<?php if (isset($_GET['error'])): ?>
    <div class="container-fluid">
        <div class="text-center">
<!--vot-->  <p class="lead text-gray-800 mb-5"><?=lang('store_unavailable')?></p>
<!--vot-->  <a href="./">&larr; <?=lang('back_home')?></a>
        </div>
    </div>
<?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('app_store')?></h1>
</div>
<div class="row mb-4 ml-1 justify-content-between">
    <ul class="nav nav-pills">
<!--vot-->  <li class="nav-item"><a class="nav-link active" href="./store.php"><?=lang('ext_store_templates')?></a></li>
<!--vot-->  <li class="nav-item"><a class="nav-link" href="./store.php?action=plu"><?=lang('ext_store_plugins')?></a></li>
    </ul>
    <form action="./store.php" method="get">
        <div class="form-inline search-inputs-nowrap">
            <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control m-1 small" placeholder="搜索模板...">
            <div class="input-group-append">
                <button class="btn btn-sm btn-success" type="submit">
                    <i class="icofont-search-2"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<div class="row mb-3 ml-1">
    <a href="./store.php" class="badge badge-secondary m-1">全部</a>
    <a href="./store.php?tag=free" class="badge badge-success m-1">仅看免费</a>
</div>
<div class="row">
	<?php if (!empty($templates)): ?>
		<?php foreach ($templates as $k => $v):
			$icon = $v['icon'] ?: "./views/images/theme.png";
			?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a class="p-1" href="<?= $v['buy_url'] ?>" target="_blank">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?= $icon ?>">
                    </a>
                    <div class="card-body">
<!--vot-->              <p class="card-text"><?= $v['name'] ?>
							<?= $v['price'] > 0 ? '<span class="badge badge-warning">' . $v['price'] . '元</span>' : '<span class="badge badge-success">' . lang('free') . '</span>' ?>
                        </p>
                        <p class="card-text text-muted small">
                            <span class="small"><?= $v['info'] ?></span><br><br>
<!--vot-->              <?=lang('developer')?>: <?= $v['author'] ?><br>
<!--vot-->              <?=lang('version_number')?>: <?= $v['ver'] ?><br>
<!--vot-->              <?=lang('update_time')?>: <?= $v['update_time'] ?><br>
                        </p>
                        <p class="card-text text-right">
							<?php if ($v['price'] > 0): ?>
<!--vot-->                  <a href="<?= $v['buy_url'] ?>" class="btn btn-sm btn-warning btn-sm" target="_blank">￥<?= $v['price'] ?>, <?=lang('go_buy')?></a>
							<?php else: ?>
<!--vot-->                  <a href="./store.php?action=install&source=<?= urlencode($v['download_url']) ?>&type=tpl" class="btn btn-success btn-sm"><?=lang('install_free')?></a>
							<?php endif ?>
                        </p>
                    </div>
                </div>
            </div>
		<?php endforeach ?>
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
