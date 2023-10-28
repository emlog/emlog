<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">商店暂不可用，可能是网络问题</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php">模板主题</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu">扩展插件</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=svip">铁杆SVIP专属</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
    </ul>
</div>
<div class="mb-3">
    <?php if (!empty($addons)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($addons as $k => $v):
                $icon = $v['icon'] ?: "./views/images/theme.png";
                ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-4 shadow-sm">
                        <a class="p-1" href="<?= $v['buy_url'] ?>" target="_blank">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold"><?= $v['name'] ?></p>
                            <p class="card-text text-muted small">
                                开发者：<?= $v['author'] ?><br>
                                版本号：<?= $v['ver'] ?><br>
                                更新时间：<?= $v['update_time'] ?><br>
                            </p>
                            <div class="card-text d-flex justify-content-between">
                                <div class="installMsg"></div>
                                <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-type="plu">免费安装</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <p class="alert alert-warning m-3">您还不是铁杆svip付费支持用户，无法安装专属免费应用，<a href="https://www.emlog.net/register">付费支持 &rarr;</a></p>
        </div>
    <?php endif ?>
</div>
<script>
    $(function () {
        $("#menu_store").addClass('active');
        setTimeout(hideActived, 3600);
    });
</script>
