<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<!doctype html>
<html lang="<?= _currentHtmlLang() ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
    <title><?= $page_title ?></title>
    <link rel="stylesheet" type="text/css" href="./views/css/bootstrap-sbadmin-4.5.3.css?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>">
    <script src="./views/js/jquery.min.3.5.1.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>

    <script>
        var _langJS = <?= json_encode(EmLang::getInstance()->getJsLang()); ?>;
    </script>
    <script src="./views/js/common.js?v=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <style>
        /* 认证页内联组合控件统一样式 */
        .em-login-captcha-group,
        .em-signup-inline-group,
        .em-reset-captcha-group {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 0.75rem;
        }

        .em-login-captcha-input,
        .em-signup-inline-input,
        .em-reset-captcha-input {
            flex: 1 1 auto;
            width: auto !important;
            min-width: 0;
        }

        .em-signup-inline-button,
        .em-login-captcha-image,
        .em-signup-inline-image,
        .em-reset-captcha-image {
            flex: 0 0 auto;
        }

        .em-signup-inline-button {
            white-space: nowrap;
            margin: 0;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .em-login-captcha-image,
        .em-signup-inline-image,
        .em-reset-captcha-image {
            display: block;
            max-width: 110px;
            height: auto;
            cursor: pointer;
        }

        @media (max-width: 576px) {
            .em-login-captcha-group,
            .em-signup-inline-group,
            .em-reset-captcha-group {
                gap: 0.5rem;
            }

            .em-signup-inline-button {
                padding-left: 0.875rem;
                padding-right: 0.875rem;
            }

            .em-login-captcha-image,
            .em-signup-inline-image,
            .em-reset-captcha-image {
                max-width: 96px;
            }
        }
    </style>
    <?php doAction('login_head') ?>
</head>

<body class="bg-gradient-gray">
