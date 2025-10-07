<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
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
                                <?php if ($v['top'] === 1): ?>
                                    <span class="badge badge-pink p-1">今日推荐</span>
                                <?php endif; ?>
                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="<?= $v['name'] ?>" data-url="<?= $v['app_url'] ?>" data-buy-url="<?= $v['buy_url'] ?>"><?= subString($v['name'], 0, 15) ?></a>
                                <?php if ($type === 'tpl'): ?>
                                    <span class="badge badge-success p-1">模板</span>
                                <?php else: ?>
                                    <span class="badge badge-primary p-1">插件</span>
                                <?php endif; ?>
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
                                    开发者：<a href="./store.php?author_id=<?= $v['author_id'] ?>"><?= $v['author'] ?></a><br>
                                    版本号：<?= $v['ver'] ?><br>
                                    安装次数：<?= $v['downloads'] ?><br>
                                    更新时间：<?= $v['update_time'] ?><br>
                                </small>
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
        <div class="col-md-12 page my-5"></div>
        <!-- 手动加载更多按钮 -->
        <div class="col-md-12 text-center mb-4" id="loadMoreContainer" style="display: none;">
            <button type="button" class="btn btn-primary" id="loadMoreBtn">
                点击加载更多
            </button>
        </div>
    <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">暂未找到结果，应用商店进货中，敬请期待：）</div>
        </div>
    <?php endif ?>
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

        $('.category').on('change', function() {
            var selectedCategory = $(this).val();
            if (selectedCategory) {
                window.location.href = './store.php?action=<?= $action ?>' + '&sid=' + selectedCategory;
            }
        });

        // 滚动加载功能
        let isLoading = false;
        let hasMore = <?= $has_more ? 'true' : 'false' ?>;
        let currentPage = <?= $page ?>;
        let tabType = "<?= $tab_type ?>";

        function loadMoreApps() {
            if (isLoading || !hasMore) return;

            isLoading = true;
            const nextPage = currentPage + 1;

            // 禁用手动加载按钮
            $('#loadMoreBtn').prop('disabled', true).html('加载中...');

            // 获取当前URL参数
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('action', 'ajax_load');
            urlParams.set('type', tabType);
            urlParams.set('page', nextPage);

            $.ajax({
                url: './store.php',
                type: 'GET',
                data: urlParams.toString(),
                dataType: 'json',
                success: function(response) {
                    if (response.code === 200 && response.data.apps.length > 0) {
                        // 渲染新的应用卡片
                        let html = '';
                        response.data.apps.forEach(function(app) {
                            const icon = app.icon || './views/images/theme.png';
                            const type = app.app_type === 'template' ? 'tpl' : 'plugin';
                            const orderUrl = 'https://www.emlog.net/order/submit/' + type + '/' + app.id;

                            // 构建按钮HTML
                            let buttonsHtml = '';

                            // 收藏按钮
                            const favoriteClass = app.is_favorited ? 'btn-warning' : 'btn-outline-warning';
                            const favoriteText = app.is_favorited ? '已收藏' : '收藏';
                            buttonsHtml += `<button type="button" class="btn ${favoriteClass} favoriteBtn mr-1" 
                                                    data-app-id="${app.id}" 
                                                    data-app-type="${app.app_type}" 
                                                    data-favorited="${app.is_favorited ? '1' : '0'}">
                                                ${favoriteText}
                                            </button> `;

                            // 检查使用中状态
                            if (app.is_active) {
                                buttonsHtml += '<a href="plugin.php" class="btn btn-light">使用中</a> ';
                            }

                            // 根据价格和权限构建安装/购买按钮
                            if (app.price > 0) {
                                if (app.purchased === true) {
                                    buttonsHtml += '<a href="store.php?action=mine" class="btn btn-light">已购买</a> ';
                                    buttonsHtml += `<a href="#" class="btn btn-success installBtn" data-url="${encodeURIComponent(app.download_url)}" data-cdn-url="${encodeURIComponent(app.cdn_download_url)}" data-type="${type}">安装</a>`;
                                } else if (app.svip && app.user_is_svip) {
                                    buttonsHtml += `<a href="#" class="btn btn-warning installBtn" data-url="${encodeURIComponent(app.download_url)}" data-cdn-url="${encodeURIComponent(app.cdn_download_url)}" data-type="${type}">安装</a>`;
                                } else {
                                    buttonsHtml += `<a href="${orderUrl}" class="btn btn-danger" target="_blank">立即购买</a>`;
                                }
                            } else {
                                buttonsHtml += `<a href="#" class="btn btn-success installBtn" data-url="${encodeURIComponent(app.download_url)}" data-cdn-url="${encodeURIComponent(app.cdn_download_url)}" data-type="${type}">安装</a>`;
                            }

                            html += `
                                <div class="col-md-6 col-lg-3">
                                    <div class="card mb-4 shadow-sm hover-shadow-lg">
                                        <a href="#appModal" class="p-1" data-toggle="modal" data-target="#appModal" data-name="${app.name}" data-url="${app.app_url}" data-buy-url="${app.buy_url}">
                                            <img class="bd-placeholder-img card-img-top" alt="cover" width="100%" height="225" src="${icon}">
                                        </a>
                                        <div class="card-body">
                                            <p class="card-text font-weight-bold">
                                                ${app.top === 1 ? '<span class="badge badge-pink p-1">今日推荐</span>' : ''}
                                                <a href="#appModal" data-toggle="modal" data-target="#appModal" data-name="${app.name}" data-url="${app.app_url}" data-buy-url="${app.buy_url}">${app.name.substring(0, 15)}</a>
                                                ${type === 'tpl' ? '<span class="badge badge-success p-1">模板</span>' : '<span class="badge badge-primary p-1">插件</span>'}
                                                ${app.svip ? '<a href="https://www.emlog.net/register" class="badge badge-warning p-1" target="_blank">铁杆免费</a>' : ''}
                                            </p>
                                            <p class="card-text text-muted">
                                                售价：
                                                ${app.price > 0 ? 
                                                    (app.promo_price > 0 ? 
                                                        `<span style="text-decoration:line-through">${app.price}<small>元</small></span> <span class="text-danger">${app.promo_price}<small>元</small></span>` : 
                                                        `<span class="text-danger">${app.price}<small>元</small></span>`
                                                    ) : 
                                                    '<span class="text-success">免费</span>'
                                                }
                                                <br>
                                                <small>
                                                    开发者：<a href="./store.php?author_id=${app.author_id}">${app.author}</a><br>
                                                    版本号：${app.ver}<br>
                                                    安装次数：${app.downloads}<br>
                                                    更新时间：${app.update_time}<br>
                                                </small>
                                            </p>
                                            <div class="card-text d-flex justify-content-between">
                                                <div class="installMsg"></div>
                                                <div>
                                                    ${buttonsHtml}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        // 添加到应用列表
                        $('.app-list').append(html);

                        // 更新状态
                        currentPage = response.current_page;
                        hasMore = response.has_more;

                        if (hasMore) {
                            // 显示手动加载按钮
                            $('#loadMoreContainer').show();
                            $('#loadMoreBtn').prop('disabled', false).html('点击加载更多');
                        } else {
                            $('.page').html('<div class="text-center text-muted">已加载全部内容</div>');
                            // 隐藏手动加载按钮
                            $('#loadMoreContainer').hide();
                        }
                    } else {
                        hasMore = false;
                        $('.page').html('<div class="text-center text-muted">已加载全部内容</div>');
                        $('#loadMoreContainer').hide();
                    }
                },
                error: function() {
                    // 重新启用手动加载按钮
                    $('#loadMoreBtn').prop('disabled', false).html('加载失败，点击重试加载');
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }

        // 手动加载更多按钮点击事件
        $('#loadMoreBtn').on('click', function() {
            loadMoreApps();
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

                        // 确保按钮重新启用
                        $btn.prop('disabled', false);
                    } else {
                        // 显示错误信息
                        $btn.html(originalText);
                        $btn.prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    $btn.html(originalText);
                    $btn.prop('disabled', false);
                }
            });
        });

        // 滚动监听
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                loadMoreApps();
            }
        });

        // 初始化时显示手动加载按钮（如果有更多内容）
        if (hasMore) {
            $('#loadMoreContainer').show();
        }
    });
</script>