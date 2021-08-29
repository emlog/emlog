<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<!doctype html>
<!--vot--><html lang="<?=EMLOG_LANGUAGE?>" dir="<?= EMLOG_LANGUAGE_DIR ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=renderer content=webkit>
<!--vot--><title><?=lang('admin_center')?> - <?php echo Option::get('blogname'); ?></title>
    <link rel="stylesheet" href="./views/css/style.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"/>
    <link rel="stylesheet" href="./editor.md/css/editormd.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"/>
    <link href="./views/css/bootstrap-sbadmin-4.5.3.css?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>" rel="stylesheet">
    <link href="./views/css/css-main.css" type=text/css rel=stylesheet>
    <link href="./views/css/icofont/icofont.min.css" type=text/css rel=stylesheet>
    <link href="./views/css/dropzone.css" type=text/css rel=stylesheet>
    <link href="./views/css/cropper.min.css" type=text/css rel=stylesheet>

    <script src="./views/js/jquery.min.3.5.1.js"></script>
    <script src="./views/js/bootstrap.bundle.min.4.6.js"></script>
    <script src="./views/js/jquery-ui.min.js"></script>
    <script src="./views/js/js.cookie-2.2.1.min.js"></script>
    <script src="./views/js/cropper.min.js"></script>
    <script src="./views/js/common.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<!--vot--><script>/*vot*/	var em_lang = '<?= EMLOG_LANGUAGE ?>';</script>
<!--vot--><script src="<?= BLOG_URL ?>/lang/<?= EMLOG_LANGUAGE ?>/lang_js.js"></script>
	<?php doAction('adm_head'); ?>
</head>
<body>
<div id="wrapper">
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion sd-hidden" id="accordionSidebar">
        <li class="nav-item active emlog_title" id="menu_home">
<!--vot-->  <a class="nav-link" href="./">EMLOG PRO <?php if (ISREG === false) : ?><?=lang('unregistered')?><?php endif; ?></a>
        </li>
        <hr class="sidebar-divider my-0">
		<?php if (ROLE == ROLE_ADMIN): ?>
            <li class="nav-item" id="menu_home">
<!--vot-->      <a class="nav-link" href="./"><i class="icofont-dashboard icofont-1x"></i><span><?= lang('admincp') ?></span></a>
            </li>
		<?php endif; ?>
        <hr class="sidebar-divider my-0">
        <li class="nav-item" id="menu_category_content">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_content" aria-expanded="true" aria-controls="menu_content">
<!--vot-->      <i class="icofont-pencil-alt-5"></i><span><?=lang('content')?></span>
            </a>
            <div id="menu_content" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->          <a class="collapse-item" id="menu_write" href="article.php?action=write"><?=lang('post_write')?></a>
<!--vot-->          <a class="collapse-item" id="menu_log" href="article.php"><?=lang('post_manage')?></a>
					<?php if (ROLE == ROLE_ADMIN): ?>
<!--vot-->          <a class="collapse-item" id="menu_sort" href="sort.php"><?=lang('categories')?></a>
<!--vot-->          <a class="collapse-item" id="menu_tag" href="tag.php"><?=lang('tags')?></a>
					<?php endif; ?>
                </div>
            </div>
        </li>
        <li class="nav-item" id="menu_cm">
<!--vot-->  <a class="nav-link" href="comment.php"><i class="icofont-comment"></i><span><?= lang('comments') ?></span></a>
        </li>
        <li class="nav-item" id="menu_media">
<!--vot-->  <a class="nav-link" href="media.php"><i class="icofont-image"></i><span><?= lang('resources') ?></span></a>
        </li>
		<?php if (ROLE == ROLE_ADMIN): ?>
            <li class="nav-item" id="menu_page">
<!--vot-->      <a class="nav-link" href="page.php"><i class="icofont-page"></i><span><?= lang('pages') ?></span></a>
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
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item" id="menu_store">
<!--vot-->      <a class="nav-link" href="store.php"><i class="icofont-shopping-cart"></i><span><?= lang('store') ?></span></a>
            </li>
            <li class="nav-item" id="menu_category_sys">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu_sys" aria-expanded="true" aria-controls="menu_sys">
<!--vot-->          <i class="icofont-options"></i><span><?=lang('system')?></span>
                </a>
                <div id="menu_sys" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
<!--vot-->          <a class="collapse-item" id="menu_setting" href="configure.php"><?= lang('settings') ?></a>
<!--vot-->          <a class="collapse-item" id="menu_user" href="user.php"><?= lang('users') ?></a>
<!--vot-->          <a class="collapse-item" id="menu_data" href="data.php"><?= lang('data') ?></a>
<!--vot-->          <a class="collapse-item" id="menu_plug" href="plugin.php"><?= lang('plugins') ?></a>
                    </div>
                </div>
            </li>
		<?php endif; ?>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn d-md-none rounded-circle mr-3">
                    <i class="icofont-navigation-menu"></i>
                </button>
                <form action="article.php" method="get" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
<!--vot-->              <input type="text" name="keyword" class="form-control bg-light border-0 small" placeholder="<?=lang('search_for')?>" aria-label="<?=lang('search')?>" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-success" type="submit">
                                <i class="icofont-search-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow mx-1">
<!--vot-->          <a class="nav-link" href="../" target="_blank" role="button">
							<?php
							$blog_name = Option::get('blogname');
/*vot*/                  echo empty($blog_name) ? lang('to_site') : subString($blog_name, 0, 12);
							?>
                        </a>
                    </li>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle" src="<?php echo empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'] ?>">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="blogger.php">
<!--vot-->                      <i class="icofont-user icofont-1x"></i><?= lang('personal_settings') ?>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="?action=logout">
<!--vot-->                      <i class="icofont-logout icofont-1x"></i><?= lang('logout') ?>
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="container-fluid">
