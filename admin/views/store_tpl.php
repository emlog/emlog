<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">商店暂不可用，可能是网络问题</div><?php endif ?>

<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php">全部应用</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=tpl">模板主题</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu">扩展插件</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip">铁杆免费</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
    </ul>
</div>

<div class="d-flex flex-column flex-sm-row justify-content-between mb-4 ml-1">
    <div class="mb-3 mb-sm-0">
        <a href="./store.php?action=tpl" class="badge badge-primary m-1 p-2">全部</a>
        <a href="./store.php?action=tpl&tag=free" class="badge badge-success m-1 p-2">免费</a>
        <a href="./store.php?action=tpl&tag=paid" class="badge badge-warning m-1 p-2">付费</a>
        <a href="./store.php?action=tpl&tag=promo" class="badge badge-danger m-1 p-2">优惠</a>
        <a href="./store.php?action=tpl&tag=download_top" class="badge badge-light text-primary p-2 small">🔥 下载排行</a>
        <a href="./store.php?action=tpl&tag=paid_top" class="badge badge-light text-primary p-2 small">🏆 销量排行</a>
    </div>
    <div class="d-flex mb-3 mb-sm-0">
        <form action="#" method="get" class="mr-sm-2">
            <select name="action" id="template-category" class="form-control">
                <?php foreach ($template_categories as $k => $v) { ?>
                    <option value="<?= $k; ?>" <?= $sid == $k ? 'selected' : '' ?>><?= $v; ?></option>
                <?php } ?>
            </select>
        </form>
        <form action="./store.php" method="get" class="form-inline ml-2 mr-3">
            <div class="input-group">
                <input type="hidden" name="action" value="tpl">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control small" placeholder="搜索模板...">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
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
                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold">
                                <?php if ($v['top'] === 1): ?>
                                    <span class="badge badge-success p-1">今日推荐</span>
                                <?php endif; ?>
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= subString($v['name'], 0, 15) ?></a>
                                <?php if ($v['svip']): ?>
                                    <a href="https://www.emlog.net/register" class="badge badge-warning p-1" target="_blank">铁杆免费</a>
                                <?php endif; ?>
                            </p>
                            <p class="card-text text-muted">
                                售价：
                                <?php if ($v['price'] > 0): ?>
                                    <?php if ($v['promo_price'] > 0): ?>
                                        <span style="text-decoration:line-through"><?= $v['price'] ?><small>元</small></span>
                                        <span class="text-danger"><?= $v['promo_price'] ?><small>元</small></span>
                                    <?php else: ?>
                                        <span class="text-danger"><?= $v['price'] ?><small>元</small></span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-success">免费</span>
                                <?php endif; ?>
                                <br>
                                <small>
                                    开发者：<a href="./store.php?action=tpl&author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a><br>
                                    版本号：<?= $v['ver'] ?><br>
                                    安装次数：<?= $v['downloads'] ?><br>
                                    更新时间：<?= $v['update_time'] ?><br>
                                </small>
                            </p>
                            <div class="card-text d-flex justify-content-between">
                                <div class="installMsg"></div>
                                <div>
                                    <?php if ($v['price'] > 0): ?>
                                        <?php if ($v['purchased'] === true): ?>
                                            <a href="store.php?action=mine" class="btn btn-light">已购买</a>
                                            <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="tpl">立即安装</a>
                                        <?php elseif ($v['svip'] && Register::getRegType() === 2): ?>
                                            <a href="#" class="btn btn-warning installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="tpl">立即安装</a>
                                        <?php else: ?>
                                            <a href="https://www.emlog.net/order/submit/tpl/<?= $v['id'] ?>" class="btn btn-danger" target="_blank">立即购买</a>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="tpl">免费安装</a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="col-md-12 page my-5"><?= $pageurl ?></div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">暂未找到结果，应用商店进货中，敬请期待：）</div>
        </div>
    <?php endif ?>
</div>
<div class="modal fade" id="appModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <div>
                    <a href="" class="modal-buy-url text-muted" target="_blank">去官网查看</a>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#menu_store").addClass('active');
        setTimeout(hideActived, 3600);

        $('#template-category').on('change', function() {
            var selectedCategory = $(this).val();
            if (selectedCategory) {
                window.location.href = './store.php?action=tpl&sid=' + selectedCategory;
            }
        });
    });
</script>