<?php
/**
 * 自定义404页面
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<!doctype html>
<html lang="<?= _currentHtmlLang() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= _langTpl('page_not_found_title') ?></title>
    <?php
    $favicon = Option::get('favicon') ? Option::get('favicon') : (function_exists('_g') ? _g('favicon') : '');
    if (!empty($favicon)): ?>
        <link href="<?= $favicon ?>" rel="icon">
    <?php endif; ?>
    <link href="<?= TEMPLATE_URL ?>css/style.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>" rel="stylesheet" type="text/css" />
    <script>
        // 初始化主题模式
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.setAttribute('data-theme', savedTheme);
        }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: var(--bodyBground);
            color: var(--fontColor);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            transition: background-color 0.3s, color 0.3s;
        }
        .card {
            background-color: var(--conBgcolor);
            border-radius: var(--marRadius);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
            max-width: 480px;
            width: 90%;
            /* 黄金比例 1.618:1 */
            aspect-ratio: 1.618 / 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 20px;
            padding: 1.5rem;
            box-sizing: border-box;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        [data-theme="dark"] .card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        .error-code {
            font-size: clamp(3rem, 10vw, 5.5rem);
            font-weight: 800;
            margin: 0;
            line-height: 1;
            color: var(--lightColor);
            opacity: 0.15;
            letter-spacing: -1px;
        }
        .error-msg {
            font-size: 0.95rem;
            font-weight: 400;
            margin: 0.5rem 0 1.5rem;
            color: var(--lightColor);
        }
        .btn-home {
            display: inline-block;
            background-color: var(--buttonBgColor);
            color: var(--buttonTextColor) !important;
            border: 1px solid var(--buttonBorderColor);
            padding: 0.55rem 1.6rem;
            border-radius: var(--marRadius);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }
        .btn-home:hover {
            background-color: var(--aHoverColor);
            border-color: var(--aHoverColor);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 480px) {
            .card {
                aspect-ratio: 1.618 / 1;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="error-code">404</h1>
        <p class="error-msg">出错了，页面未找到 :(</p>
        <a href="<?= BLOG_URL ?>" class="btn-home"><?= _langTpl('back_to_home') ?></a>
    </div>
    <script src="<?= TEMPLATE_URL ?>js/jquery.min.3.5.1.js?v=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="<?= TEMPLATE_URL ?>js/common_tpl.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
</body>
</html>
