<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
    <title>个人中心 - <?= Option::get('blogname') ?></title>
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
    <script src="./views/js/js.cookie-2.2.1.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/cropper.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/js/common.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="./views/components/sweetalert.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <?php doAction('adm_head') ?>
</head>
<body class="d-flex flex-column h-100 bg-light">
<div id="editor-md-dialog"></div>
<main class="flex-shrink-0">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 border-bottom shadow-sm" id="top-bar">
        <h3 class="my-0 mr-md-5 font-weight-normal"><a href="./"><?= Option::get('blogname') ?></a></h3>
        <nav class="my-2 my-md-0 mr-md-auto">
            <a class="p-2 text-dark" href="/">首页</a>
            <a class="p-2 text-dark" href="./">个人中心</a>
            <a class="p-2 text-dark" href="article.php"><?= Option::get("posts_name") ?></a>
            <a class="p-2 text-dark" href="media.php">资源</a>
            <a class="p-2 text-dark" href="comment.php">评论</a>
            <?php doAction('user_menu') ?>
        </nav>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="mr-2" href="blogger.php">
                <img width="30" height="30" class="img-profile rounded-circle" src="<?= empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
            </a>
            <a class="text-dark" href="account.php?action=logout">
                <i class="icofont-logout icofont-1x"></i>退出
            </a>
        </nav>
    </div>
    <div class="container px-2 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-11 col-xl-9 col-xxl-8">
