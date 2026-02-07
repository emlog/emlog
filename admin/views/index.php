<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['add_shortcut_suc'])): ?>
    <div class="alert alert-success"><?= _lang('save_success') ?></div>
<?php endif ?>
<div class="d-flex align-items-center mb-3">
    <div class="flex-shrink-0">
        <a class="mr-2" href="blogger.php">
            <img src="<?= User::getAvatar($user_cache[UID]['avatar']) ?>"
                alt="avatar" class="img-fluid rounded-circle border border-mute border-3"
                style="width: 56px; height: 56px;">
        </a>
    </div>
    <div class="flex-grow-1 ms-3">
        <div class="align-items-center mb-3">
            <p class="mb-0 m-2"><a class="mr-2" href="blogger.php"><?= $user_cache[UID]['name'] ?></a></p>
            <p class="mb-0 m-2 small"><?= $role_name ?></p>
        </div>
    </div>
</div>
<div class="row ml-1 mb-1"><?php doAction('adm_main_top') ?></div>
<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card shadow mb-3">
            <h6 class="card-header"><?= _lang('site_info') ?></h6>
            <div class="card-body">
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
                        <a href="./user.php"><span class="badge badge-cyan badge-pill"><?= count($user_cache) ?></span></a>
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
    </div>
    <?php if (User::isAdmin()): ?>
        <div class="col-lg-6 mb-3">
            <div class="card shadow mb-3">
                <h6 class="card-header"><?= _lang('software_info') ?></h6>
                <div class="card-body">
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
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <?php if (!Register::isRegLocal()) : ?>
                                    <a href="https://www.emlog.net/register" target="_blank"><span class="badge badge-secondary">Emlog <?= Option::EMLOG_VERSION ?></span></a>
                                    <a href="https://www.emlog.net/register" target="_blank" class="badge badge-secondary"><?= _lang('unregistered') ?></a>
                                <?php else: ?>
                                    <a href="https://www.emlog.net" target="_blank"><span class="badge badge-success">Emlog <?= ucfirst(Option::EMLOG_VERSION) ?></span></a>
                                    <?php if (Register::getRegType() === 2): ?>
                                        <a href="https://www.emlog.net/register" target="_blank" class="badge badge-warning"><?= _lang('hardcore_svip') ?></a>
                                    <?php elseif (Register::getRegType() === 1): ?>
                                        <a href="https://www.emlog.net/register" target="_blank" class="badge badge-success"><?= _lang('friend_vip') ?></a>
                                    <?php else: ?>
                                        <a href="https://www.emlog.net/register" target="_blank" class="badge badge-success"><?= _lang('registered') ?></a>
                                    <?php endif ?>
                                <?php endif; ?>
                            </div>
                            <div>
                                <a id="ckup" href="javascript:checkUpdate();" class="badge badge-success d-flex align-items-center"><span><?= _lang('update') ?></span></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if (User::isAdmin()): ?>
    <?php if (!Register::isRegLocal()) : ?>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card shadow">
                    <div class="card-header bg-gradient-warning text-danger">
                        <h6 class="my-0 font-weight-bold"><?= _lang('register_full_feature') ?></h6>
                    </div>
                    <div class="card-body">
                        <p><span class="badge badge-warning badge-pill">1</span> <?= _lang('register_feature_1') ?></p>
                        <p><span class="badge badge-warning badge-pill">2</span> <?= _lang('register_feature_2') ?></p>
                        <p><span class="badge badge-warning badge-pill">3</span> <?= _lang('register_feature_3') ?></p>
                        <p><span class="badge badge-warning badge-pill">4</span> <?= _lang('register_feature_4') ?></p>
                        <p>
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
            .bg-gradient-warning {
                background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            }

            .registration-prompt {
                animation: slideInUp 0.6s ease-out;
            }

            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .registration-prompt .card-body {
                background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            }
        </style>
    <?php endif ?>
    <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="update-modal-label" aria-hidden="true">
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

        // auto check update
        $.get("./upgrade.php?action=check_update", function(result) {
            if (result.code === 200) {
                $("#ckup").append('<span class="badge bg-danger ml-1">!</span>');
            }
        });
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

            $(".ext-column").sortable({
                connectWith: ".ext-column",
                items: '> div',
                handle: '.card-header',
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

            $("<style>")
                .prop("type", "text/css")
                .html(".ui-state-highlight { height: 100px; background-color: #f8f9fa; border: 1px dashed #ccc; }")
                .appendTo("head");
        });
    </script>
<?php endif; ?>