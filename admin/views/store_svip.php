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
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=svip">铁杆免费</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
        <li class="nav-item"><a class="nav-link" href="./store.php?action=favorite">我的收藏</a></li>
    </ul>
</div>
<div class="mb-3">
    <div class="col-md-12">
        <p class="alert alert-warning my-3"><a href="https://www.emlog.net/register">铁杆SVIP</a> 用户可以免费安装下面的应用👇</p>
        <div class="mb-3">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary active" id="filterAll">全部</button>
                <button type="button" class="btn btn-outline-success" id="filterTemplate">模板</button>
                <button type="button" class="btn btn-outline-primary" id="filterPlugin">插件</button>
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
                                <span class="badge badge-success p-1">模板</span>
                            <?php else: ?>
                                <span class="badge badge-primary p-1">插件</span>
                            <?php endif; ?>
                        </p>
                        <p class="card-text text-muted small">
                            开发者：<a href="./store.php?author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a><br>
                            版本号：<?= $v['ver'] ?><br>
                            安装次数：<?= $v['downloads'] ?><br>
                            更新时间：<?= $v['update_time'] ?><br>
                        </p>
                        <div class="card-text d-flex justify-content-between">
                            <div class="installMsg"></div>
                            <div>
                                <!-- 收藏按钮 -->
                                <button type="button" class="btn <?= $v['is_favorited'] ? 'btn-warning' : 'btn-outline-warning' ?> favoriteBtn mr-1"
                                    data-app-id="<?= $v['id'] ?>"
                                    data-app-type="<?= $v['app_type'] ?>"
                                    data-favorited="<?= $v['is_favorited'] ? '1' : '0' ?>">
                                    <?= $v['is_favorited'] ? '已收藏' : '收藏' ?>
                                </button>

                                <?php if (Plugin::isActive($v['alias'])): ?>
                                    <a href="plugin.php" class="btn btn-light">使用中</a>
                                <?php elseif (Template::isActive($v['alias'])): ?>
                                    <a href="template.php" class="btn btn-light">使用中</a>
                                <?php endif; ?>
                                <a href="#" class="btn btn-warning installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>">安装</a>
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
                showTip('参数错误，请刷新页面重试', 'error');
                return;
            }

            $btn.prop('disabled', true);
            const originalText = $btn.html();
            $btn.html('<i class="icofont-spinner icofont-spin"></i> 处理中...');

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
                            $btn.html('已收藏');
                        } else {
                            $btn.removeClass('btn-warning').addClass('btn-outline-warning');
                            $btn.html('收藏');
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