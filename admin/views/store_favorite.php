<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger"><?= _lang('store_unavailable') ?></div><?php endif ?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('store') ?> - <?= $sub_title ?></h1>
</div>
<div class="row mb-4 ml-1">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./store.php"><?= _lang('store_all') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=tpl"><?= _lang('store_template') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=plu"><?= _lang('store_plugin') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=svip"><?= _lang('store_free_vip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= _lang('store_purchased') ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=favorite"><?= _lang('store_favorite') ?></a></li>
    </ul>
</div>
<div class="mb-3">
    <?php if (!empty($apps)): ?>
        <div class="d-flex flex-wrap app-list">
            <?php foreach ($apps as $k => $v):
                $icon = $v['icon'] ?: "./views/images/theme.png";
                $type = $v['app_type'] === 'template' ? 'tpl' : 'plugin';
                $order_url = 'https://www.emlog.net/order/submit/' . $type . '/' . $v['id']
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card mb-4 shadow-sm hover-shadow-lg">
                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                        </a>
                        <div class="card-body">
                            <p class="card-text font-weight-bold">
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>" class="h5"><?= $v['name'] ?></a>
                            </p>
                            <p class="card-text text-muted small">
                                <?= _lang('store_developer') ?><?= $v['author'] ?><br>
                                <?= _lang('store_version') ?><?= $v['ver'] ?><br>
                                <?= _lang('store_update_time') ?><?= $v['update_time'] ?><br>
                            </p>
                            <div class="card-text d-flex justify-content-between">
                                <div class="installMsg"></div>
                                <div>
                                    <!-- 取消收藏按钮 -->
                                    <button type="button" class="btn btn-warning favoriteBtn mr-1"
                                        data-app-id="<?= $v['id'] ?>"
                                        data-app-type="<?= $v['app_type'] ?>"
                                        data-favorited="1">
                                        <?= _lang('store_cancel_collect') ?>
                                    </button>

                                    <?php if (Plugin::isActive($v['alias'])): ?>
                                        <a href="plugin.php" class="btn btn-light"><?= _lang('store_using') ?></a>
                                    <?php elseif (Template::isActive($v['alias'])): ?>
                                        <a href="template.php" class="btn btn-light"><?= _lang('store_using') ?></a>
                                    <?php endif; ?>
                                    <?php if ($v['price'] > 0): ?>
                                        <?php if ($v['purchased'] === true): ?>
                                            <a href="store.php?action=mine" class="btn btn-light"><?= _lang('store_purchased_status') ?></a>
                                            <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= _lang('store_install') ?></a>
                                        <?php elseif ($v['svip'] && Register::getRegType() === 2): ?>
                                            <a href="#" class="btn btn-warning installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= _lang('store_install') ?></a>
                                        <?php else: ?>
                                            <a href="<?= $order_url ?>" class="btn btn-danger" target="_blank"><?= _lang('store_buy_now') ?></a>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= _lang('store_install') ?></a>
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
            <p class="alert alert-warning my-3"><?= _lang('store_favorite_need_auth') ?></p>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <p class="alert alert-warning my-3"><?= _lang('store_no_purchased') ?></p>
        </div>
    <?php endif; ?>
</div>
<div class="modal fade" id="appModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
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

        // 收藏按钮点击事件处理（取消收藏）
        $(document).on('click', '.favoriteBtn', function() {
            const $btn = $(this);
            const appId = $btn.data('app-id');
            const appType = $btn.data('app-type');

            // 更严格的数据类型检查，确保正确判断收藏状态
            const favoritedValue = $btn.data('favorited');
            const isFavorited = favoritedValue === '1' || favoritedValue === 1 || favoritedValue === true;

            // 防止重复点击
            if ($btn.prop('disabled')) {
                return;
            }

            // 验证必要参数
            if (!appId || !appType) {
                return;
            }

            $btn.prop('disabled', true);
            const originalText = $btn.html();
            $btn.html('<i class="icofont-spinner icofont-spin"></i> 处理中...');

            // 取消收藏
            $.ajax({
                url: './store.php?action=remove_favorite',
                type: 'POST',
                data: {
                    app_id: appId,
                    app_type: appType
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code === 0) {
                        if (isFavorited) {
                            $btn.closest('.col-md-6').fadeOut(300, function() {
                                $(this).remove();
                                if ($('.app-list .col-md-6').length === 0) {
                                    $('.app-list').html('<div class="col-md-12"><p class="alert alert-warning my-3">还没有收藏任何应用。</p></div>');
                                }
                            });
                        } else {
                            $btn.removeClass('btn-outline-warning').addClass('btn-warning');
                            $btn.html('已收藏');
                        }
                    } else {
                        $btn.html(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    $btn.html(originalText);
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });
    });
</script>