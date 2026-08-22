<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?= FlashMsg::renderStoreAlerts(); ?>

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('store') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./store.php"><?= _lang('store_all') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl"><?= _lang('store_template') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu"><?= _lang('store_plugin') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= _lang('store_free_vip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= _lang('store_purchased') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=favorite"><?= _lang('store_favorite') ?></a></li>
    </ul>
</div>

<div class="d-flex flex-wrap align-items-center mb-4">
    <a href="./store.php" class="badge badge-primary m-1 px-3 py-2"><?= _lang('store_recent') ?></a>
    <a href="./store.php?tag=free" class="badge badge-success m-1 px-3 py-2"><?= _lang('store_filter_free') ?></a>
    <a href="./store.php?tag=download_top" class="badge badge-light text-primary border m-1 px-3 py-2"><?= _lang('store_download_top') ?></a>
    <a href="./store.php?tag=favorite_top" class="badge badge-light text-primary border m-1 px-3 py-2"><?= _lang('store_favorite_top') ?></a>
    <form action="#" method="get" class="m-1 d-inline-block">
        <select name="action" class="form-control form-control-sm category shadow-none border-secondary-subtle">
            <?php foreach ($template_categories as $k => $v) { ?>
                <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
            <?php } ?>
        </select>
    </form>
    <form action="#" method="get" class="m-1 d-inline-block">
        <select name="action" class="form-control form-control-sm category shadow-none border-secondary-subtle">
            <?php foreach ($plugin_categories as $k => $v) { ?>
                <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
            <?php } ?>
        </select>
    </form>
</div>

<div class="row justify-content-center mt-3 mb-5">
    <div class="col-12 col-md-6 col-lg-4 text-center">
        <form action="./store.php" method="get" class="mb-3">
            <div class="input-group shadow-sm" style="border-radius: 50rem; overflow: hidden; border: 1px solid #e3e6f0;">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control border-0 px-3 bg-white" placeholder="<?= _lang('store_search') ?>" style="height: 42px; box-shadow: none; font-size: 0.9rem;">
                <div class="input-group-append bg-white">
                    <button class="btn btn-success px-3 border-0 d-flex align-items-center justify-content-center" type="submit" style="border-radius: 0 50rem 50rem 0; height: 42px;">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: 4px;">
            <a href="./store.php?keyword=ai" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('setting_ai') ?></a>
            <a href="./store.php?sid=2" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('setting_seo') ?></a>
            <a href="./store.php?sid=8" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_blog') ?></a>
            <a href="./store.php?sid=21" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_docs') ?></a>
            <a href="./store.php?sid=9" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_bbs') ?></a>
            <a href="./store.php?sid=17" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_navi') ?></a>
            <a href="./store.php?sid=1" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_resource') ?></a>
            <a href="./store.php?sid=12" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_content') ?></a>
            <a href="./store.php?sid=11" class="badge badge-light text-secondary border px-2 py-1 small"><?= _lang('store_interaction') ?></a>
        </div>
    </div>
</div>
