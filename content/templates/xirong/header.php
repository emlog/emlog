<?php
/**
 * 息壤信息咨询服务主题 - 页头模板
 */

defined('EMLOG_ROOT') || exit('access denied!');
require_once View::getView('module');

// 检查tpl_options插件
if (!function_exists('_g')) {
    emMsg('请开启【模板设置】插件以使用息壤主题的全部功能');
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">

    <title><?php echo $site_title; ?></title>
    <meta name="keywords" content="<?php echo $site_key; ?>">
    <meta name="description" content="<?php echo $site_description; ?>">

    <!-- DNS预解析 -->
    <link rel="dns-prefetch" href="<?php echo BLOG_URL; ?>">

    <!-- 主题色 -->
    <meta name="theme-color" content="#000000" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">

    <!-- 样式表 -->
    <link rel="stylesheet" href="<?php echo TEMPLATE_URL; ?>css/style.css?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>">

    <!-- 预加载关键资源 -->
    <link rel="preload" href="<?php echo TEMPLATE_URL; ?>js/main.js" as="script">

    <?php doAction('index_head'); ?>
</head>
<body class="xr-body">
    <!-- SVG图标库 -->
    <?php xr_svg_icons(); ?>

    <!-- 页面加载动画 -->
    <div class="xr-page-loader" id="page-loader">
        <div class="xr-loader-spinner"></div>
    </div>

    <!-- 顶部导航栏 -->
    <header class="xr-header" id="main-header">
        <div class="xr-container">
            <div class="xr-header-inner">
                <!-- LOGO -->
                <div class="xr-logo">
                    <a href="<?php echo BLOG_URL; ?>" class="xr-logo-link">
                        <?php
                        $logoType = _g('logo_type') ?: 'text';
                        if ($logoType === 'text') {
                            echo '<span class="xr-logo-text">7XR.CN</span>';
                        } else {
                            $logoImg = _g('logo_image') ?: TEMPLATE_URL . 'images/logo.png';
                            echo '<img src="' . htmlspecialchars($logoImg, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($blogname, ENT_QUOTES, 'UTF-8') . '" class="xr-logo-img">';
                        }
                        ?>
                    </a>
                </div>

                <!-- 导航菜单 -->
                <?php xr_navigation(); ?>

                <!-- 移动端菜单按钮 -->
                <button class="xr-mobile-menu-btn" id="mobile-menu-btn" aria-label="菜单">
                    <svg class="xr-icon"><use xlink:href="#icon-menu"></use></svg>
                </button>
            </div>
        </div>
    </header>

    <!-- 移动端菜单覆盖层 -->
    <div class="xr-mobile-menu-overlay" id="mobile-menu-overlay"></div>
