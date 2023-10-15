<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">商店暂不可用，可能是网络问题</div><?php endif ?>

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./store.php"><i class="icofont-paint"></i> 模板主题</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu">扩展插件</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip">铁杆SVIP专属</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
    </ul>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between mb-4 ml-1">
    <div class="mb-3 mb-sm-0">
        <a href="./store.php" class="badge badge-success m-1 p-2">全部</a>
        <a href="./store.php?tag=free" class="badge badge-success m-1 p-2">仅看免费</a>
        <a href="./store.php?tag=paid" class="badge badge-warning m-1 p-2">仅看付费</a>
    </div>
    <div class="d-flex mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" id="template-category" class="form-control">
                <?php foreach ($categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get" class="form-inline ml-2">
            <div class="input-group">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="搜索模板...">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit">搜索</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="mb-3">
    <?php if (!empty($templates)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($templates as $k => $v):
                $icon = $v['icon'] ?: "./views/images/theme.png";
                ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-4 shadow-sm">
                        <a class="p-1" href="<?= $v['buy_url'] ?>" target="_blank">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold">
                                <?php if ($v['top'] === 1): ?>
                                    <span class="badge badge-success p-1">今日推荐</span>
                                <?php endif; ?>
                                <a class="text-secondary" href="<?= $v['buy_url'] ?>" target="_blank"><?= subString($v['name'], 0, 22) ?></a>
                            </p>
                            <p class="card-text text-muted">
                                <small><?= subString($v['info'], 0, 56) ?></small><br><br>
                                售价：<?= $v['price'] > 0 ? '<span class="text-danger">' . $v['price'] . '元</span>' : '<span class="text-success">免费</span>' ?><br>
                                <small>
                                    开发者：<?= $v['author'] ?> <a href="./store.php?author_id=<?= $v['author_id'] ?>">仅看Ta的作品</a><br>
                                    版本号：<?= $v['ver'] ?><br>
                                    更新时间：<?= $v['update_time'] ?><br>
                                </small>
                            </p>
                            <div class="card-text d-flex justify-content-between">
                                <div class="installMsg"></div>
                                <?php if ($v['price'] > 0): ?>
                                    <a href="https://www.emlog.net/order/submit/tpl/<?= $v['id'] ?>" class="btn btn-danger" target="_blank">立即购买</a>
                                <?php else: ?>
                                    <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-type="tpl">免费安装</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-12 page my-5"><?= $pageurl ?> (有<?= $count ?>个模板)</div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">未找到任何应用</div>
        </div>
    <?php endif ?>
</div>
<script>
    $(function () {
        $("#menu_store").addClass('active');
        setTimeout(hideActived, 3600);

        $('#template-category').on('change', function () {
            var selectedCategory = $(this).val();
            if (selectedCategory) {
                window.location.href = './store.php?sid=' + selectedCategory;
            }
        });
    });
</script>
