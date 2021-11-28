<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('install_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_param'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed')?></div><?php endif; ?>
<?php if (isset($_GET['error_down'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed_download')?></div><?php endif; ?>
<?php if (isset($_GET['error_dir'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed_write')?></div><?php endif; ?>
<?php if (isset($_GET['error_zip'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed_zip')?></div><?php endif; ?>
<?php if (isset($_GET['error_source'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_invalid_ext')?></div><?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="container-fluid">
        <div class="text-center">
<!--vot-->  <p class="lead text-gray-800 mb-5"><?=lang('store_unavailable')?></p>
<!--vot-->  <a href="./">&larr; <?=lang('back_home')?></a>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($plugins)): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('app_store')?></h1>
    </div>
    <div class="panel-heading mb-4">
        <ul class="nav nav-pills">
<!--vot-->  <li class="nav-item"><a class="nav-link" href="./store.php"><?=lang('ext_store_templates')?></a></li>
<!--vot-->  <li class="nav-item"><a class="nav-link active" href="./store.php?action=plu"><?=lang('ext_store_plugins')?></a></li>
        </ul>
    </div>
    <div class="row">
		<?php foreach ($plugins as $k => $v):
			$icon = $v['icon'] ?: "./views/images/plugin.png";
			?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <a class="p-1" href="<?php echo $v['buy_url']; ?>" target="_blank">
                        <img class="bd-placeholder-img card-img-top" width="100%" height="225" src="<?php echo $icon; ?>">
                    </a>
                    <div class="card-body">
<!--vot-->              <p class="card-text"><?php echo $v['name']; ?> <span class="badge badge-primary"><?=lang('plugin')?></span></p>
                        <p class="card-text text-muted small">
							<?php echo $v['info']; ?><br><br>
<!--vot-->              <?=lang('price')?>: <?php echo $v['price'] > 0 ? $v['price'] . ' ' . lang('price_unit') : lang('free'); ?><br>
<!--vot-->              <?=lang('developer')?>: <?php echo $v['author']; ?><br>
<!--vot-->                  <?=lang('version_number')?>: <?php echo $v['ver']; ?><br>
<!--vot-->              <?=lang('update_time')?>: <?php echo $v['update_time']; ?><br>
                        </p>
                        <p class="card-text text-right">
							<?php if ($v['price'] > 0): ?>
<!--vot-->                  <a href="<?php echo $v['buy_url']; ?>" class="btn btn-warning btn-sm" target="_blank"><?=lang('go_buy')?></a>
							<?php else: ?>
<!--vot-->                  <a href="./store.php?action=install&source=<?php echo urlencode($v['download_url']); ?>&type=plugin" class="btn btn-success btn-sm"><?=lang('install')?></a>
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
