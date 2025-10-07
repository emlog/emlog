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
        <li class="nav-item"><a class="nav-link" href="./store.php?action=mine">我的已购</a></li>
        <li class="nav-item"><a class="nav-link active" href="./store.php?action=favorite">我的收藏</a></li>
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
                                    <!-- 取消收藏按钮 -->
                                    <button type="button" class="btn btn-sm btn-warning favoriteBtn mr-1"
                                        data-app-id="<?= $v['id'] ?>"
                                        data-app-type="<?= $v['app_type'] ?>"
                                        data-favorited="1">
                                        <i class="icofont-heart"></i>
                                        取消收藏
                                    </button>

                                    <?php if (Plugin::isActive($v['alias'])): ?>
                                        <a href="plugin.php" class="btn btn-light">使用中</a>
                                    <?php elseif (Template::isActive($v['alias'])): ?>
                                        <a href="template.php" class="btn btn-light">使用中</a>
                                    <?php endif; ?>
                                    <?php if ($v['price'] > 0): ?>
                                        <?php if ($v['purchased'] === true): ?>
                                            <a href="store.php?action=mine" class="btn btn-light">已购买</a>
                                            <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>">安装</a>
                                        <?php elseif ($v['svip'] && Register::getRegType() === 2): ?>
                                            <a href="#" class="btn btn-warning installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>">安装</a>
                                        <?php else: ?>
                                            <a href="<?= $order_url ?>" class="btn btn-danger" target="_blank">立即购买</a>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <a href="#" class="btn btn-success installBtn" data-url="<?= urlencode($v['download_url']) ?>" data-cdn-url="<?= urlencode($v['cdn_download_url']) ?>" data-type="<?= $type ?>">安装</a>
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
            <p class="alert alert-warning my-3">您还不是正版注册用户，无法使用应用商店收藏功能，<a href="https://www.emlog.net/register">付费支持 &rarr;</a></p>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <p class="alert alert-warning my-3">还没有收藏任何应用。</p>
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
                    if (response.code === 0 || response.code === 200) {
                        // 取消收藏成功后，从页面移除该应用卡片
                        if (isFavorited) {
                            // 显示成功提示
                            layer.msg('取消收藏成功', {icon: 1, time: 2000});
                            
                            $btn.closest('.col-md-6').fadeOut(300, function() {
                                $(this).remove();
                                // 检查是否还有应用，如果没有则显示提示信息
                                if ($('.app-list .col-md-6').length === 0) {
                                    $('.app-list').html('<div class="col-md-12"><p class="alert alert-warning my-3">还没有收藏任何应用。</p></div>');
                                }
                            });
                        } else {
                            // 如果是添加收藏（理论上在收藏页面不会发生）
                            $btn.removeClass('btn-outline-warning').addClass('btn-warning');
                            $btn.html('<i class="icofont-heart"></i> 已收藏');
                            layer.msg('收藏成功', {icon: 1, time: 2000});
                        }
                    } else {
                        // 显示错误信息
                        const errorMsg = response.msg || '操作失败，请重试';
                        layer.msg(errorMsg, {icon: 2, time: 3000});
                        $btn.html(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    // 显示网络错误提示
                    layer.msg('网络请求失败，请检查网络连接', {icon: 2, time: 3000});
                    $btn.html(originalText);
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });
    });
</script>