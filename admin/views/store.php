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
    <div class="alert alert-danger">安装失败，无法写入文件</div><?php endif; ?>
<?php if (isset($_GET['error_zip'])): ?>
    <div class="alert alert-danger">安装失败，不支持zip解压</div><?php endif; ?>
<?php if (isset($_GET['error_source'])): ?>
    <div class="alert alert-danger">安装失败，不是有效的扩展安装包</div><?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="container-fluid">
        <div class="text-center">
            <p class="lead text-gray-800 mb-5">商店暂不可用，可能是网络问题</p>
            <a href="./">&larr; 返回首页</a>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($templates) || !empty($plugins)): ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">扩展商店</h1>
    </div>
    <div class="card-columns">
		<?php foreach ($templates as $k => $v):
			$icon = $v['icon'] ?: "./views/images/theme.png";
			?>
            <div class="card" style="min-height: 340px;">
                <img class="card-img-top" src="<?php echo $icon; ?>"/>
                <div class="card-body">
                    <p class="card-text"><span class="badge badge-warning">模板</span> <?php echo $v['name']; ?></p>
                    <p class="card-text text-muted small">
                        <span class="small"><?php echo $v['info']; ?></span><br><br>
                        价格：<?php echo $v['price'] > 0 ? $v['price'] : '免费'; ?><br>
                        开发者：<?php echo $v['author']; ?><br>
                        更新时间：<?php echo $v['update_time']; ?><br>
                    </p>
                    <p class="card-text text-right">
						<?php if ($v['price'] > 0): ?>
                            <a href="<?php echo $v['buy_url']; ?>" class="btn btn-sm btn-warning btn-sm" target="_blank">去购买</a>
						<?php else: ?>
                            <a href="./store.php?action=install&source=<?php echo urlencode($v['download_url']); ?>&type=tpl" class="btn btn-success btn-sm">下载安装</a>
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
                    <p class="card-text"><span class="badge badge-primary">插件</span> <?php echo $v['name']; ?></p>
                    <p class="card-text text-muted small">
						<?php echo $v['info']; ?><br><br>
                        价格：<?php echo $v['price'] > 0 ? $v['price'] : '免费'; ?><br>
                        开发者：<?php echo $v['author']; ?><br>
                        更新时间：<?php echo $v['update_time']; ?><br>
                    </p>
                    <p class="card-text text-right">
						<?php if ($v['price'] > 0): ?>
                            <a href="<?php echo $v['buy_url']; ?>" class="btn btn-warning btn-sm" target="_blank">去购买</a>
						<?php else: ?>
                            <a href="./store.php?action=install&source=<?php echo urlencode($v['download_url']); ?>&type=plugin" class="btn btn-success btn-sm">下载安装</a>
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
