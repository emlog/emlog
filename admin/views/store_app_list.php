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
                                    <?php if (Plugin::isActive($v['alias']) || Template::isActive($v['alias'])): ?>
                                        <a href="plugin.php" class="btn btn-light">使用中</a>
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
                window.location.href = './store.php?sid=' + selectedCategory;
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