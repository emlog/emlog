<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<!doctype html>
<!--vot--><html lang="<?=LANG?>" dir="<?= LANG_DIR ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
<!--vot--><title><?=lang('admin_center')?> - <?= Option::get('blogname') ?></title>
    <link rel="shortcut icon" href="./views/images/favicon.ico"/>
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
<!--vot--><script>	var em_lang = '<?= LANG ?>';</script>
<!--vot--><script src="<?= BLOG_URL ?>/lang/<?= LANG ?>/lang_js.js"></script>
	<?php doAction('adm_head'); ?>
</head>
<body>
<div id="editor-md-dialog"></div>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sd-hidden" id="accordionSidebar">
        <li class="nav-item active emlog_title" id="menu_home">
			<?php if (User::isAdmin()): ?>
<!--vot-->      <a class="nav-link" href="./">EMLOG PRO <?php if (!Register::isRegLocal()) : ?><?=lang('unregistered')?><?php endif ?></a>
			<?php else: ?>
                <a class="nav-link" href="./"><?=lang('user_center')?></a>
			<?php endif ?>
        </li>
        <hr class="sidebar-divider my-0">
		<?php if (User::isAdmin()): ?>
            <li class="nav-item" id="menu_home">
<!--vot-->      <a class="nav-link" href="./"><i class="icofont-dashboard icofont-1x"></i><span><?= lang('admincp') ?></span></a>
            </li>
		<?php endif ?>
        <hr class="sidebar-divider my-0">
        <li class="nav-item" id="menu_category_content">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_content" aria-expanded="true" aria-controls="menu_content">
<!--vot-->      <i class="icofont-pencil-alt-5"></i><span><?=lang('content')?></span>
            </a>
            <div id="menu_content" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->          <a class="collapse-item" id="menu_write" href="article.php?action=write"><?=lang('post_write')?></a>
<!--vot-->          <a class="collapse-item" id="menu_log" href="article.php"><?=lang('articles')?></a>
<!--vot-->          <a class="collapse-item" id="menu_draft" href="article.php?draft=1"><?=lang('drafts')?></a>
					<?php if (User::isAdmin()): ?>
<!--vot-->          <a class="collapse-item" id="menu_sort" href="sort.php"><?=lang('categories')?></a>
<!--vot-->          <a class="collapse-item" id="menu_tag" href="tag.php"><?=lang('tags')?></a>
					<?php endif ?>
                </div>
            </div>
        </li>
        <li class="nav-item" id="menu_cm">
<!--vot-->  <a class="nav-link" href="comment.php"><i class="icofont-comment"></i><span><?= lang('comments') ?></span></a>
        </li>
        <li class="nav-item" id="menu_twitter">
<!--vot-->      <a class="nav-link" href="twitter.php"><i class="icofont-penalty-card"></i><span><?= lang('twitters') ?></span></a>
        </li>
        <li class="nav-item" id="menu_media">
<!--vot-->      <a class="nav-link" href="media.php"><i class="icofont-image"></i><span><?= lang('resources') ?></span></a>
        </li>
		<?php if (User::isAdmin()): ?>
            <li class="nav-item" id="menu_page">
<!--vot-->      <a class="nav-link" href="page.php"><i class="icofont-page"></i><span><?= lang('pages') ?></span></a>
            </li>
            <li class="nav-item" id="menu_user">
<!--vot-->      <a class="nav-link" href="user.php"><i class="icofont-user"></i><span><?=lang('users')?></span></a>
            </li>
            <li class="nav-item" id="menu_category_view">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_view" aria-expanded="true" aria-controls="menu_view">
<!--vot-->          <i class="icofont-paint"></i><span><?= lang('exterior') ?></span>
                </a>
                <div id="menu_view" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->              <a class="collapse-item" id="menu_tpl" href="template.php"><?= lang('templates') ?></a>
<!--vot-->              <a class="collapse-item" id="menu_navi" href="navbar.php"><?= lang('navigation') ?></a>
<!--vot-->              <a class="collapse-item" id="menu_widget" href="widgets.php"><?= lang('sidebar') ?></a>
<!--vot-->              <a class="collapse-item" id="menu_link" href="link.php"><?= lang('friend_links') ?></a>
                    </div>
                </div>
            </li>
            <li class="nav-item" id="menu_category_ext">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_ext" aria-expanded="true" aria-controls="menu_ext">
<!--vot-->          <i class="icofont-plugin"></i><span><?=lang('extensions')?></span>
                </a>
                <div id="menu_ext" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->              <a class="collapse-item" id="menu_plug" href="plugin.php"><?=lang('plugins')?></a>
						<?php doAction('adm_menu_ext') ?>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item" id="menu_store">
<!--vot-->      <a class="nav-link" href="store.php?tag=free"><i class="icofont-shopping-cart"></i><span><?= lang('store') ?></span></a>
            </li>
            <li class="nav-item" id="menu_category_sys">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_sys" aria-expanded="true" aria-controls="menu_sys">
<!--vot-->          <i class="icofont-options"></i><span><?=lang('system')?></span>
                </a>
                <div id="menu_sys" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->          <a class="collapse-item" id="menu_data" href="data.php"><?= lang('data') ?></a>
<!--vot-->          <a class="collapse-item" id="menu_setting" href="setting.php"><?= lang('settings') ?></a>
                    </div>
                </div>
            </li>
		<?php endif ?>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
                    <i class="icofont-navigation-menu"></i>
                </button>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link" href=".." target="_blank" role="button">
							<?php
							$blog_name = Option::get('blogname');
/*vot*/                  echo empty($blog_name) ? lang('to_site') : subString($blog_name, 0, 12);
							?>
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item mx-1">
                        <a class="nav-link" href="blogger.php" role="button">
                            <img class="img-profile rounded-circle"
                                 src="<?= empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
<!--vot-->          <li class="nav-item mx-1 drop">
                <span class="nav-link toggle"><?= lang('language') ?>:&nbsp;<img src="<?= BLOG_URL ?>/lang/<?= LANG ?>/flag.gif"></span>
                <div class="down"><!-- RIGHT -->
                <?php foreach(LANG_LIST as $l=>$lng) {
                $selected = ($_SESSION['LANG'] == $l) ? 'selected="selected"' : '';
?>
                <a href="?language=<?= $l ?>" title="<?= LANG_LIST[$l]['title'] ?>"><img src="<?= BLOG_URL ?>/lang/<?= $l ?>/flag.gif"> <?= LANG_LIST[$l]['name'] ?></a>
                <?php } ?>
                </div>
<!--vot-->          </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item mx-1">
<!--vot-->              <a class="nav-link" href="account.php?action=logout" title="<?= lang('logout') ?>" role="button">
                            <i class="icofont-logout icofont-1x"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
