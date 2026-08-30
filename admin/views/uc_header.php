<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<!doctype html>
<html lang="<?= _currentHtmlLang() ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
    <title><?php echo _lang('uc_center') . ' - ' . Option::get('blogname') ?></title>
    <link rel="stylesheet" type="text/css" href="./views/css/style.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./editor.md/css/editormd.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/bootstrap-sbadmin-4.5.3.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/css-main.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/icofont/icofont.min.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/dropzone.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <link rel="stylesheet" type="text/css" href="./views/css/cropper.min.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <script src="./views/js/jquery.min.3.5.1.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/jquery-ui.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/jquery.ui.touch-punch.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/jquery.ui.timepicker-addon.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/js.cookie-2.2.1.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/cropper.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script>
        var _langJS = <?= json_encode(EmLang::getInstance()->getJsLang()); ?>;
    </script>
    <script src="./views/js/common.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/components/layer/layer.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/components/message.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <?php doAction('adm_head') ?>
    <style>
        body.uc-bg {
            background-color: #f4f6f9 !important;
        }

        .uc-container {
            max-width: 1240px;
            margin: 30px auto;
            padding: 0 15px;
        }

        /* 顶部顶部条导航优化 */
        #uc-top-bar {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 12px 24px;
            margin-bottom: 24px;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        #uc-top-bar a.brand-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 1.15rem;
            text-decoration: none;
        }

        #uc-top-bar .nav-link-item {
            color: #5a6a85;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        #uc-top-bar .nav-link-item:hover,
        #uc-top-bar .nav-link-item.active {
            color: #3b82f6;
            background-color: #eff6ff;
        }

        #uc-top-bar .nav-btn-logout {
            color: #ef4444;
            background-color: #fef2f2;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        #uc-top-bar .nav-btn-logout:hover {
            background-color: #fee2e2;
            color: #dc2626;
        }

        /* 侧边栏与名片样式 */
        .uc-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .uc-card:hover {
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
        }

        /* 个人基本信息重叠头像卡片 */
        .uc-profile-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            margin-bottom: 20px;
            text-align: center;
        }

        .uc-profile-banner {
            height: 95px;
            background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
            position: relative;
        }

        .uc-avatar-wrapper {
            position: relative;
            margin-top: -45px;
            display: inline-block;
        }

        .uc-avatar-img {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            object-fit: cover;
            background: #ffffff;
            transition: transform 0.3s ease;
        }

        .uc-avatar-wrapper:hover .uc-avatar-img {
            transform: scale(1.05);
        }

        .uc-profile-info {
            padding: 12px 20px 20px 20px;
        }

        .uc-profile-name {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .uc-profile-role {
            font-size: 0.85rem;
            color: #64748b;
            background: #f1f5f9;
            padding: 3px 12px;
            border-radius: 20px;
            display: inline-block;
        }

        /* 侧边导航组 */
        .uc-menu-group {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            padding: 16px;
            margin-bottom: 20px;
        }

        .uc-menu-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0 12px 10px 12px;
            margin-bottom: 6px;
            border-bottom: 1px solid #f1f5f9;
        }

        .uc-menu-item {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            color: #475569;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 4px;
        }

        .uc-menu-item:last-child {
            margin-bottom: 0;
        }

        .uc-menu-item i {
            font-size: 1.1rem;
            margin-right: 10px;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .uc-menu-item:hover,
        .uc-menu-item.active {
            background-color: #eff6ff;
            color: #2563eb;
            text-decoration: none;
        }

        .uc-menu-item:hover i,
        .uc-menu-item.active i {
            color: #2563eb;
        }

        /* 移动端侧边滑出菜单及响应式样式 */
        .uc-sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(2px);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .uc-sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .uc-mobile-toggle-btn {
            background: #f1f5f9;
            border: none;
            color: #334155;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .uc-mobile-toggle-btn:hover,
        .uc-mobile-toggle-btn:focus {
            background: #e2e8f0;
            color: #0f172a;
            outline: none;
        }

        @media (max-width: 767.98px) {
            .uc-container {
                margin: 15px auto;
                padding: 0 10px;
            }

            #uc-top-bar {
                padding: 10px 16px;
                margin-bottom: 16px;
                border-radius: 12px;
            }

            .uc-sidebar-wrapper {
                position: fixed;
                top: 0;
                left: 0;
                width: 280px;
                height: 100%;
                background: #ffffff;
                z-index: 1050;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                overflow-y: auto;
                padding: 20px 16px;
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15);
            }

            .uc-sidebar-wrapper.show {
                transform: translateX(0);
            }

            .uc-sidebar-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding-bottom: 12px;
                margin-bottom: 16px;
                border-bottom: 1px solid #f1f5f9;
            }

            .uc-sidebar-close-btn {
                background: transparent;
                border: none;
                font-size: 1.4rem;
                color: #64748b;
                cursor: pointer;
                padding: 4px 8px;
                border-radius: 8px;
            }

            .uc-sidebar-close-btn:hover {
                background: #f1f5f9;
                color: #0f172a;
            }
        }
    </style>
</head>

<body class="d-flex flex-column h-100 uc-bg">
    <div id="editor-md-dialog"></div>

    <!-- 移动端侧边遮罩层 -->
    <div class="uc-sidebar-overlay" id="ucSidebarOverlay"></div>

    <main class="flex-shrink-0">
        <div class="uc-container">
            <!-- 顶部导航栏 -->
            <div class="d-flex align-items-center justify-content-between" id="uc-top-bar">
                <div class="d-flex align-items-center">
                    <!-- 移动端侧边栏触发按钮 -->
                    <button type="button" class="uc-mobile-toggle-btn d-md-none mr-2" id="ucSidebarToggle" aria-label="Toggle Navigation">
                        <i class="icofont-navigation-menu"></i>
                    </button>
                    <a href="./" class="brand-title mr-md-4 mr-2"><?= subString(Option::get('blogname'), 0, 15) ?></a>
                    <nav class="d-none d-md-flex align-items-center">
                        <a class="nav-link-item active" href="./"><?= _lang('uc_center') ?></a>
                        <a class="nav-link-item ml-2" href="<?= BLOG_URL ?>"><?= _lang('back_to_home') ?></a>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <a class="nav-link-item mr-2 mr-md-3" href="blogger.php"><?= _lang('setting') ?></a>
                    <a class="nav-btn-logout" href="account.php?action=logout"><i class="icofont-logout mr-1"></i><?= _lang('logout') ?></a>
                </div>
            </div>

            <!-- 左右布局主内容区域 -->
            <div class="row">
                <!-- 左侧栏：个人名片与分类菜单栏（手机端滑出侧边栏） -->
                <div class="col-lg-3 col-md-4 mb-4 uc-sidebar-wrapper" id="ucSidebar">
                    <div class="uc-sidebar-header d-md-none">
                        <span class="font-weight-bold text-dark"><i class="icofont-user-alt-7 mr-2"></i><?= _lang('uc_center') ?></span>
                        <button type="button" class="uc-sidebar-close-btn" id="ucSidebarClose" aria-label="Close Navigation">
                            <i class="icofont-close"></i>
                        </button>
                    </div>

                    <!-- 移动端侧边栏专属导航菜单项 -->
                    <div class="uc-menu-group d-md-none mb-3">
                        <a href="./" class="uc-menu-item active">
                            <?= _lang('uc_center') ?>
                        </a>
                        <a href="<?= BLOG_URL ?>" class="uc-menu-item">
                            <?= _lang('back_to_home') ?>
                        </a>
                    </div>

                    <!-- 头像与个人信息名片 -->
                    <div class="uc-profile-card">
                        <div class="uc-profile-banner"></div>
                        <div class="uc-avatar-wrapper">
                            <a href="blogger.php" title="<?= _lang('click_to_change_avatar'); ?>">
                                <img src="<?= User::getAvatar(isset($currentUser['photo']) ? $currentUser['photo'] : (isset($photo) ? $photo : '')) ?>"
                                    alt="avatar" class="uc-avatar-img">
                            </a>
                        </div>
                        <div class="uc-profile-info">
                            <div class="uc-profile-name">
                                <a href="blogger.php" class="text-dark text-decoration-none">
                                    <?= isset($currentUser['nickname']) ? $currentUser['nickname'] : (isset($nickname) ? $nickname : '') ?>
                                </a>
                            </div>
                            <span class="uc-profile-role"><?= _lang('registered_user') ?></span>
                        </div>
                    </div>

                    <!-- 会员 / 内容菜单 -->
                    <div class="uc-menu-group">
                        <div class="uc-menu-title">内容与创作</div>
                        <?php if (!Article::hasForbidPost()): ?>
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <a href="article.php" class="uc-menu-item flex-grow-1 mb-0 mr-2" id="menu_log">
                                    <i class="icofont-pencil-alt-5"></i><?= Option::get("posts_name") ?>
                                </a>
                                <a href="./article.php?action=write" class="btn btn-sm btn-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; padding: 0;" title="<?= _lang('post_new') . Option::get("posts_name") ?>">
                                    <i class="icofont-plus" style="font-size: 0.85rem; margin-right: 0;"></i>
                                </a>
                            </div>
                            <?php if (Option::get('forbid_user_upload') !== 'y') : ?>
                                <a href="media.php" class="uc-menu-item" id="menu_media">
                                    <i class="icofont-image"></i><?= _lang('media') ?>
                                </a>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if (Option::get('allow_user_twitter') === 'y') : ?>
                            <a href="twitter.php" class="uc-menu-item" id="menu_twitter">
                                <i class="icofont-penalty-card"></i><?= Option::get('twitter_name') ?>
                            </a>
                        <?php endif ?>
                        <a href="comment.php" class="uc-menu-item" id="menu_cm">
                            <i class="icofont-comment"></i><?= _lang('comment') ?>
                        </a>
                        <?php doAction('user_menu') ?>
                    </div>
                </div>

                <!-- 右侧主内容区容器开口 -->
                <div class="col-lg-9 col-md-8">
                    <script>
                        // 注册用户个人中心移动端侧边栏交互 logic
                        $(document).ready(function() {
                            function openSidebar() {
                                $('#ucSidebar').addClass('show');
                                $('#ucSidebarOverlay').addClass('show');
                                $('body').css('overflow', 'hidden');
                            }

                            function closeSidebar() {
                                $('#ucSidebar').removeClass('show');
                                $('#ucSidebarOverlay').removeClass('show');
                                $('body').css('overflow', '');
                            }

                            $('#ucSidebarToggle').on('click', openSidebar);
                            $('#ucSidebarClose, #ucSidebarOverlay').on('click', closeSidebar);
                        });
                    </script>