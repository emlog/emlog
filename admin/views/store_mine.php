<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">商店暂不可用，可能是网络问题</div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">应用商店 - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php">全部应用</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl">模板主题</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu">扩展插件</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip">铁杆免费</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=mine">我的已购</a></li>
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
                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold">
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= $v['name'] ?></a>
                            </p>
                            <p class="card-text text-muted small">
                                开发者：<?= $v['author'] ?><br>
                                版本号：<?= $v['ver'] ?><br>
                                更新时间：<?= $v['update_time'] ?><br>
                            </p>
                            <div class="card-text d-flex justify-content-between">
                                <div class="installMsg"></div>
                                <div>
                                    <?php if (empty($v['download_url'])): ?>
                                        <a href="<?= $v['buy_url'] ?>" class="btn btn-success btn-sm">请联系作者安装</a>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $v['type'] ?>">立即安装</a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php elseif (!Register::isRegLocal()): ?>
        <div class="col-md-12">
            <p class="alert alert-warning my-3">您还不是付费注册用户，无法使用应用商店已购功能，<a href="https://www.emlog.net/register">付费支持 &rarr;</a></p>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <p class="alert alert-warning my-3">还没有购买任何应用。</p>
        </div>
    <?php endif; ?>
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
    });
</script>