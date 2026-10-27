<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['add_shortcut_suc'])): ?>
    <div class="alert alert-success"><?= _lang('save_success') ?></div>
<?php endif ?>
<div class="row ml-1 mb-1"><?php doAction('adm_main_top') ?></div>
<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card h-100 shadow mb-3">
            <h6 class="card-header"><?= _lang('site_info') ?></h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="./article.php?checked=n"><?= _lang('pending_articles') ?></a>
                    <a href="./article.php?checked=n"><span class="badge badge-pink badge-pill"><?= $sta_cache['checknum'] ?></span></a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="./comment.php?hide=y"><?= _lang('pending_comments') ?></a>
                    <a href="./comment.php?hide=y"><span class="badge badge-warning badge-pill"><?= $sta_cache['hidecomnum'] ?></span></a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="./user.php"><?= _lang('user') ?></a>
                    <a href="./user.php"><span class="badge badge-cyan badge-pill"><?= isset($sta_cache['user_num']) ? (int)$sta_cache['user_num'] : 0 ?></span></a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="./article.php"><?= _lang('article') ?></a>
                    <a href="./article.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['lognum'] ?></span></a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="./twitter.php?all=y"><?= _lang('twitter') ?></a>
                    <a href="./twitter.php?all=y"><span class="badge badge-primary badge-pill"><?= $sta_cache['note_num'] ?></span></a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="./comment.php"><?= _lang('comment') ?></a>
                    <a href="./comment.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['comnum_all'] ?></span></a>
                </li>
            </ul>
        </div>
    </div>
    <?php if (User::isAdmin()): ?>
        <div class="col-lg-6 mb-3">
            <div class="card h-100 shadow mb-3">
                <h6 class="card-header"><?= _lang('software_info') ?></h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP
                        <span class="small"><?= $php_ver ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= _lang('database') ?>
                        <span class="small">MySQL <?= $mysql_ver ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= _lang('web_service') ?>
                        <span class="small"><?= $server_app ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= _lang('os') ?>
                        <span class="small"><?= $os ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= _lang('system_timezone') ?>
                        <span class="small"><?= Option::get('timezone') ?></span>
                    </li>
                    <?php if (defined('OFFLINE_MODE') && OFFLINE_MODE === true): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge badge-secondary"><?= preg_replace('/^(?:emlog\s*)?(?:pro\s*)?/i', '', Option::EMLOG_VERSION) ?></span>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <?php if (!Register::isRegLocal()) : ?>
                                    <a href="https://www.emlog.net/register" target="_blank"><span class="badge badge-secondary">Emlog <?= Option::EMLOG_VERSION ?></span></a>
                                    <a href="https://www.emlog.net/register" target="_blank" class="badge badge-secondary ml-1"><?= _lang('unregistered') ?></a>
                                <?php else: ?>
                                    <a href="https://www.emlog.net" target="_blank"><span class="badge badge-success">Emlog <?= ucfirst(Option::EMLOG_VERSION) ?></span></a>
                                    <?php if (Register::getRegType() === 2): ?>
                                        <a href="https://www.emlog.net/register" target="_blank" class="badge badge-warning ml-1"><?= _lang('hardcore_svip') ?></a>
                                    <?php elseif (Register::getRegType() === 1): ?>
                                        <a href="https://www.emlog.net/register" target="_blank" class="badge badge-success ml-1"><?= _lang('friend_vip') ?></a>
                                    <?php else: ?>
                                        <a href="https://www.emlog.net/register" target="_blank" class="badge badge-success ml-1"><?= _lang('registered') ?></a>
                                    <?php endif ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a id="ckup" href="javascript:checkUpdate();" class="btn-check-update position-relative">
                                    <i class="icofont-refresh mr-1"></i>
                                    <span><?= _lang('update') ?></span>
                                </a>
                            </div>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if (User::isAdmin()): ?>
    <?php if (!Register::isRegLocal()) : ?>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card shadow">
                    <div class="card-header text-danger">
                        <h6 class="my-0 font-weight-bold"><?= _lang('register_full_feature') ?></h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled reg-features mb-3">
                            <li class="reg-feature-item">
                                <span class="reg-icon-box">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                                <span class="reg-feature-text"><?= _lang('register_feature_1') ?></span>
                            </li>
                            <li class="reg-feature-item">
                                <span class="reg-icon-box">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                                <span class="reg-feature-text"><?= _lang('register_feature_2') ?></span>
                            </li>
                            <li class="reg-feature-item">
                                <span class="reg-icon-box">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </span>
                                <span class="reg-feature-text"><?= _lang('register_feature_3') ?></span>
                            </li>
                            <li class="reg-feature-item">
                                <span class="reg-icon-box reg-icon-highlight">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                </span>
                                <span class="reg-feature-text"><?= _lang('register_feature_4') ?></span>
                            </li>
                        </ul>
                        <p class="mb-0">
                            <a href="https://www.emlog.net/register" target="_blank" class="btn btn-danger px-4">
                                <?= _lang('register_now') ?>
                                <i class="icofont-external-link me-2"></i>
                            </a>
                            <a href="auth.php" class="btn btn-outline-success px-4">
                                <?= _lang('input_license') ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .reg-features {
                display: flex;
                flex-direction: column;
                margin-bottom: 0;
            }

            .reg-feature-item {
                display: flex;
                align-items: center;
                padding: 6px 0;
                font-size: 13.5px;
                color: #4b5563;
                line-height: 1.4;
            }

            .reg-icon-box {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background-color: #ecfdf5;
                color: #10b981;
                margin-right: 10px;
                flex-shrink: 0;
            }

            .reg-icon-highlight {
                background-color: #fde68a;
                color: #d97706;
            }
        </style>
    <?php endif ?>
    <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="update-modal-label" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="update-modal-label"><?= _lang('check_update') ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="update-modal-loading"></div>
                    <div id="update-modal-msg" class="text-center"></div>
                    <div id="update-modal-changes"></div>
                    <div id="update-modal-btn" class="mt-2 text-right"></div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(hideActived, 3600);
        const menuPanel = $("#menu_panel").addClass('active');

        <?php if (!defined('OFFLINE_MODE') || OFFLINE_MODE !== true): ?>
            // auto check update
            $.get("./upgrade.php?action=check_update", function(result) {
                if (result.code === 200) {
                    $("#ckup").append('<span class="update-dot"></span>');
                }
            });

            // auto check templates & plugins update
            $.get("./index.php?action=check_app_update", function(response) {
                if (response.code === 0 && response.data) {
                    var tplCount = response.data.template_count || 0;
                    var pluCount = response.data.plugin_count || 0;

                    localStorage.setItem('emlog_has_plugin_update', pluCount > 0 ? '1' : '0');
                    localStorage.setItem('emlog_has_template_update', tplCount > 0 ? '1' : '0');
                    if (typeof renderAppUpdateDots === 'function') {
                        renderAppUpdateDots();
                    }
                }
            });
        <?php endif ?>
    </script>
<?php endif ?>
<?php if (User::isAdmin()): ?>
    <div class="row" id="ext-content-box">
        <?php doAction('adm_main_content') ?>
    </div>
    <script>
        $(document).ready(function() {
            var $box = $("#ext-content-box");

            $box.children().each(function(index) {
                if (!$(this).attr('id')) {
                    $(this).attr('id', 'ext-item-' + index);
                }
            });

            if ($box.find('.ext-column').length === 0) {
                $box.append('<div class="col-lg-6 ext-column" id="ext-col-left"></div>');
                $box.append('<div class="col-lg-6 ext-column" id="ext-col-right"></div>');
            }
            var $leftCol = $("#ext-col-left");
            var $rightCol = $("#ext-col-right");

            function cleanItem($item) {
                $item.removeClass(function(index, className) {
                    return (className.match(/(^|\s)col-\S+/g) || []).join(' ');
                });
                $item.addClass('mb-4');
                return $item;
            }

            var savedData = localStorage.getItem('ext_content_box_layout');
            var itemsMap = {};

            $box.children().not('.ext-column').each(function() {
                itemsMap[this.id] = $(this);
            });

            if (savedData) {
                try {
                    var layout = JSON.parse(savedData);
                    if (layout.left && layout.right) {
                        $.each(layout.left, function(i, id) {
                            if (itemsMap[id]) {
                                $leftCol.append(cleanItem(itemsMap[id]));
                                delete itemsMap[id];
                            }
                        });
                        $.each(layout.right, function(i, id) {
                            if (itemsMap[id]) {
                                $rightCol.append(cleanItem(itemsMap[id]));
                                delete itemsMap[id];
                            }
                        });
                    } else if (Array.isArray(layout)) {
                        $.each(layout, function(i, id) {
                            if (itemsMap[id]) {
                                var target = (i % 2 === 0) ? $leftCol : $rightCol;
                                target.append(cleanItem(itemsMap[id]));
                                delete itemsMap[id];
                            }
                        });
                    }
                } catch (e) {
                    console.error(e);
                }
            }

            var leftCount = $leftCol.children().length;
            var rightCount = $rightCol.children().length;

            $.each(itemsMap, function(id, $elem) {
                var target;
                if (leftCount <= rightCount) {
                    target = $leftCol;
                    leftCount++;
                } else {
                    target = $rightCol;
                    rightCount++;
                }
                target.append(cleanItem($elem));
            });

            // 仅在非移动端（宽度大于768px）启用拖拽
            if ($(window).width() > 768) {
                $(".ext-column").sortable({
                    connectWith: ".ext-column",
                    items: '> div',
                    cursor: 'move',
                    placeholder: "ui-state-highlight mb-4",
                    forcePlaceholderSize: true,
                    opacity: 0.6,
                    update: function(event, ui) {
                        var layout = {
                            left: $leftCol.sortable("toArray"),
                            right: $rightCol.sortable("toArray")
                        };
                        localStorage.setItem('ext_content_box_layout', JSON.stringify(layout));
                    }
                }).disableSelection();
            }

            $("<style>")
                .prop("type", "text/css")
                .html(".ui-state-highlight { height: 100px; background-color: #f8f9fa; border: 1px dashed #ccc; }")
                .appendTo("head");
        });
    </script>
<?php endif;
