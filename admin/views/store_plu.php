<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= _lang('store_unavailable') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('store_title') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php"><?= _lang('store_all') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl"><?= _lang('store_template') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=plu"><?= _lang('store_plugin') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= _lang('store_free_vip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= _lang('store_purchased') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=favorite"><?= _lang('store_favorite') ?></a></li>
    </ul>
</div>
<div class="d-flex flex-column flex-sm-row justify-content-between mb-4 ml-1">
    <div class="mb-3 mb-sm-0">
        <a href="./store.php?action=plu" class="badge badge-primary m-1 p-2"><?= _lang('store_filter_latest') ?></a>
        <a href="./store.php?action=plu&tag=free" class="badge badge-success m-1 p-2"><?= _lang('store_filter_free') ?></a>
        <a href="./store.php?action=plu&tag=paid" class="badge badge-warning m-1 p-2"><?= _lang('store_filter_paid') ?></a>
        <a href="./store.php?action=plu&tag=promo" class="badge badge-danger m-1 p-2"><?= _lang('store_filter_promo') ?></a>
        <a href="./store.php?action=plu&tag=download_top" class="badge badge-light text-primary p-2 small"><?= _lang('store_filter_download_top') ?></a>
        <a href="./store.php?action=plu&tag=paid_top" class="badge badge-light text-primary p-2 small"><?= _lang('store_paid_top') ?></a>
    </div>
    <div class="d-flex mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" id="plugin-category" class="form-control category">
                <?php foreach ($plugin_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get" class="form-inline ml-2 mr-3">
            <div class="input-group">
                <input type="hidden" name="action" value="plu">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="<?= _langStr('store_search_plugin') ?>">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>