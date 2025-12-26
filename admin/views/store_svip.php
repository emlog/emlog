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
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=svip"><?= _lang('store_free_vip') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine"><?= _lang('store_purchased') ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=favorite"><?= _lang('store_favorite') ?></a></li>
    </ul>
</div>
<div class="mb-3">
    <div class="col-md-12">
        <p class="alert alert-warning my-3"><?= _lang('store_svip_desc') ?></p>
        <div class="mb-3">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary active" id="filterAll"><?= _lang('store_filter_all') ?></button>
                <button type="button" class="btn btn-outline-success" id="filterTemplate"><?= _lang('store_filter_tpl') ?></button>
                <button type="button" class="btn btn-outline-primary" id="filterPlugin"><?= _lang('store_filter_plu') ?></button>
            </div>
        </div>
    </div>
    <div class="d-flex flex-wrap app-list">
        <?php foreach ($addons as $k => $v):
            $icon = $v['icon'] ?: "./views/images/theme.png";
            $type = $v['app_type'] === 'template' ? 'tpl' : 'plugin';
        ?>
            <div class="col-md-6 col-lg-3 app-item" data-type="<?= $type ?>">
                <div class="card mb-4 shadow-sm hover-shadow-lg">
                    <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>">
                        <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="<?= $icon ?>">
                    </a>
                    <div class="card-body">
                        <p class="card-text font-weight-bold">
                            <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= $v['name'] ?></a>
                            <?php if ($type === 'tpl'): ?>
                                <span class="badge badge-success p-1"><?= _lang('store_tpl_tag') ?></span>
                            <?php else: ?>
                                <span class="badge badge-primary p-1"><?= _lang('store_plu_tag') ?></span>
                            <?php endif; ?>
                        </p>
                        <p class="card-text text-muted small">
                            <?= _lang('store_developer') ?><a href="./store.php?author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a><br>
                            <?= _lang('store_version') ?><?= $v['ver'] ?><br>
                            <?= _lang('store_install_count') ?><?= $v['downloads'] ?><br>
                            <?= _lang('store_update_time') ?><?= $v['update_time'] ?><br>
                        </p>
                        <div class="card-text d-flex justify-content-between">
                            <div class="installMsg"></div>
                            <div>
                                <!-- 收藏按钮 -->
                                <button type="button" class="btn <?= $v['is_favorited'] ? 'btn-warning' : 'btn-outline-warning' ?> favoriteBtn mr-1"
                                    data-app-id="<?= $v['id'] ?>"
                                    data-app-type="<?= $v['app_type'] ?>"
                                    data-favorited="<?= $v['is_favorited'] ? '1' : '0' ?>">
                                    <?= $v['is_favorited'] ? _lang('store_collected') : _lang('store_collect') ?>
                                </button>

                                <?php if (Plugin::isActive($v['alias'])): ?>
                                    <a href="plugin.php" class="btn btn-light"><?= _lang('store_using') ?></a>
                                <?php elseif (Template::isActive($v['alias'])): ?>
                                    <a href="template.php" class="btn btn-light"><?= _lang('store_using') ?></a>
                                <?php endif; ?>
                                <a href="#" class="btn btn-warning installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>"><?= _lang('store_install') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
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

        // 筛选功能
        $('#filterAll').click(function() {
            $('.app-item').show();
            $('.btn-group button').removeClass('active');
            $(this).addClass('active');
        });

        $('#filterTemplate').click(function() {
            $('.app-item').hide();
            $('.app-item[data-type="tpl"]').show();
            $('.btn-group button').removeClass('active');
            $(this).addClass('active');
        });

        $('#filterPlugin').click(function() {
            $('.app-item').hide();
            $('.app-item[data-type="plugin"]').show();
            $('.btn-group button').removeClass('active');
            $(this).addClass('active');
        });

        // 收藏按钮点击事件处理
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
                showTip('<?= _lang("store_param_error") ?>', 'error');
                return;
            }

            $btn.prop('disabled', true);
            const originalText = $btn.html();
            $btn.html('<i class="icofont-spinner icofont-spin"></i> <?= _lang("store_loading") ?>');

            // 调用收藏/取消收藏API
            const action = isFavorited ? 'remove_favorite' : 'add_favorite';

            $.ajax({
                url: './store.php?action=' + action,
                type: 'POST',
                data: {
                    app_id: appId,
                    app_type: appType
                },
                dataType: 'json',
                success: function(response) {
                    if (response.code === 0) {
                        // 切换收藏状态
                        const newFavorited = !isFavorited;
                        $btn.data('favorited', newFavorited ? '1' : '0');

                        // 更新按钮样式和文本
                        if (newFavorited) {
                            $btn.removeClass('btn-outline-warning').addClass('btn-warning');
                            $btn.html('<?= _lang("store_collected") ?>');
                        } else {
                            $btn.removeClass('btn-warning').addClass('btn-outline-warning');
                            $btn.html('<?= _lang("store_collect") ?>');
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