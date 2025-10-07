<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">商店暂不可用，可能是网络问题</div><?php endif ?>

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./store.php">全部应用</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl">模板主题</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu">扩展插件</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip">铁杆免费</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=favorite">我的收藏</a></li>
    </ul>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between mb-4 ml-1">
    <div class="mb-3 mb-sm-0">
        <a href="./store.php" class="badge badge-primary m-1 p-2">全部</a>
        <a href="./store.php?tag=free" class="badge badge-success m-1 p-2">免费</a>
        <a href="./store.php?tag=paid" class="badge badge-warning m-1 p-2">付费</a>
        <a href="./store.php?tag=promo" class="badge badge-danger m-1 p-2">优惠</a>
        <a href="./store.php?tag=download_top" class="badge badge-light text-primary p-2 small">🔥下载排行</a>
        <a href="./store.php?keyword=ai" class="badge badge-light text-primary p-2 small">✨AI</a>
        <a href="./store.php?sid=2" class="badge badge-light text-primary p-2 small">SEO</a>
        <a href="./store.php?sid=8" class="badge badge-light text-primary p-2 small">个人博客</a>
        <a href="./store.php?sid=21" class="badge badge-light text-primary p-2 small">文档知识库</a>
        <a href="./store.php?sid=17" class="badge badge-light text-primary p-2 small">导航</a>
        <a href="./store.php?sid=1" class="badge badge-light text-primary p-2 small">资源下载</a>
        <a href="./store.php?sid=12" class="badge badge-light text-primary p-2 small">内容运营</a>
        <a href="./store.php?sid=11" class="badge badge-light text-primary p-2 small">用户互动</a>
    </div>
    <div class="d-flex mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" class="form-control category">
                <?php foreach ($template_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" class="form-control category">
                <?php foreach ($plugin_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get" class="form-inline ml-2 mr-3">
            <div class="input-group">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="搜索应用...">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>