<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('install_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_param'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed')?></div><?php endif; ?>
<?php if (isset($_GET['error_down'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed')?></div><?php endif; ?>
<?php if (isset($_GET['error_dir'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed')?></div><?php endif; ?>
<?php if (isset($_GET['error_zip'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('install_failed')?></div><?php endif; ?>
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

<?php if (!empty($templates) || !empty($plugins)): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('ext_store')?></h1>
    </div>
    <div class="card-columns">
		<?php foreach ($templates as $k => $v):
			$icon = $v['icon'] ?: "./views/images/theme.png";
			?>
            <div class="card" style="min-height: 340px;">
                <img class="card-img-top" src="<?php echo $icon; ?>"/>
                <div class="card-body">
<!--vot-->          <p class="card-text"><span class="badge badge-warning"><?=lang('template')?></span> <?php echo $v['name']; ?></p>
                    <p class="card-text text-muted small">
                        <span class="small"><?php echo $v['info']; ?></span><br><br>
<!--vot-->              <?=lang('developer')?>: <?php echo $v['author']; ?><br>
<!--vot-->              <?=lang('update_time')?>: <?php echo $v['update_time']; ?><br>
<!--vot-->              <?=lang('price')?>: <?php echo $v['price'] > 0 ? $v['price'] : lang('free'); ?><br>
                    </p>
                    <p class="card-text text-right">
						<?php if ($v['price'] > 0): ?>
<!--vot-->                  <a href="<?php echo $v['buy_url']; ?>" class="btn btn-sm btn-warning btn-sm" target="_blank"><?=lang('go_buy')?></a>
						<?php else: ?>
<!--vot-->                  <a href="./store.php?action=install&source=<?php echo urlencode($v['download_url']); ?>&type=tpl" class="btn btn-success btn-sm"><?=lang('download&install')?></a>
						<?php endif; ?>
                    </p>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
    <div class="card-columns">
		<?php foreach ($plugins as $k => $v):
			$icon = $v['icon'] ?: "./views/images/plugin.png";
			?>
            <div class="card">
                <img class="card-img-top" src="<?php echo $icon; ?>" style="height: 150px;object-fit: cover;"/>
                <div class="card-body">
<!--vot-->          <p class="card-text"><span class="badge badge-primary"><?=lang('plugin')?></span> <?php echo $v['name']; ?></p>
                    <p class="card-text text-muted small">
						<?php echo $v['info']; ?><br><br>
<!--vot-->              <?=lang('developer')?>: <?php echo $v['author']; ?><br>
<!--vot-->              <?=lang('update_time')?>: <?php echo $v['update_time']; ?><br>
<!--vot-->              <?=lang('price')?>: <?php echo $v['price'] > 0 ? $v['price'] : lang('free'); ?><br>
                    </p>
                    <p class="card-text text-right">
						<?php if ($v['price'] > 0): ?>
<!--vot-->                  <a href="<?php echo $v['buy_url']; ?>" class="btn btn-warning btn-sm" target="_blank"><?=lang('go_buy')?></a>
						<?php else: ?>
<!--vot-->                  <a href="./store.php?action=install&source=<?php echo urlencode($v['download_url']); ?>&type=plugin" class="btn btn-success btn-sm"><?=lang('download&install')?></a>
						<?php endif; ?>
                    </p>
                </div>
            </div>
		<?php endforeach; ?>
    </div>
<?php endif; ?>
<script>
    $("#menu_store").addClass('active');
    setTimeout(hideActived, 3600);
</script>
