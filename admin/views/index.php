<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="mb-0 text-gray-800">
        <span class="h3"><?= lang('welcome') ?>, <a class="small" href="./blogger.php"><?= $user_cache[UID]['name'] ?></a></span>
        <span class="badge badge-primary ml-2"><?= $role_name ?></span>
    </div>
	<?php doAction('adm_main_top') ?>
</div>
<?php if (User::haveEditPermission()): ?>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header"><?= lang('site_info') ?></h6>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="row">
                            <div class="col-xl-4 col-md-6 mb-1">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><?= lang('articles_pending') ?></div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="./article.php"><?= $sta_cache['checknum'] ?></a></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="icofont-pencil-alt-5 fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 mb-1">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
													<?= lang('pending_review') ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="./comment.php?hide=y"><?= $sta_cache['hidecomnum'] ?></a></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="icofont-comment fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-1">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
													<?= lang('user_num') ?>
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="./user.php"><?= count($user_cache) ?></a></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="icofont-user fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="./article.php"><?= lang('articles') ?></a>
                            <a href="./article.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['lognum'] ?></span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="./twitter.php"><?= lang('twitters') ?></a>
                            <a href="./twitter.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['note_num'] ?></span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="./comment.php"><?= lang('comments') ?></a>
                            <a href="./comment.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['comnum_all'] ?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
		<?php if (User::isAdmin()): ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header"><?= lang('software_info') ?></h6>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            PHP
                            <span class="small"><?= $php_ver ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
							<?= lang('database') ?>
                            <span class="small">MySQL <?= $mysql_ver ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
							<?= lang('web_server') ?>
                            <span class="small"><?= $serverapp ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            EMLOG
							<?php if (!Register::isRegLocal()) : ?>
                                <a href="auth.php"><span class="badge badge-danger"><?= Option::EMLOG_VERSION ?> <?= lang('unregistered') ?></span></a>
							<?php else: ?>
                                <span class="badge <?php if (Register::getRegType() === 2): ?>badge-warning<?php else: ?>badge-success<?php endif; ?>"><?= Option::EMLOG_VERSION ?> <?= lang('registered') ?></span>
							<?php endif ?>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a id="ckup" href="javascript:checkupdate();" class="btn btn-success btn-sm"><?= lang('update_check') ?></a>
                            <span id="upmsg"></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
		<?php if (!Register::isRegLocal()) : ?>
            <div class="col-lg-6 mb-4">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <h4><?= lang('emlog_reg_advantages') ?></h4>
                        <div><?= lang('advantage1') ?></div>
                        <div><?= lang('advantage2') ?></div>
                        <div><?= lang('advantage3') ?></div>
                        <div><?= lang('advantage4') ?></div>
                        <div><?= lang('advantage5') ?></div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="https://emlog.net/register" target="_blank" class="btn btn-sm btn-primary shadow-lg"><?= lang('get_emkey') ?></a>
                        <a href="auth.php" class="btn btn-sm btn-success shadow-lg"><?= lang('register_now') ?></a>
                    </div>
                </div>
            </div>
		<?php endif ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header"><?= lang('official_news') ?></h6>
                <div class="card-body" id="admindex_msg">
                    <ul class="list-group list-group-flush">
                        <li class="msg_type_0"><a href="https://www.emlog.net/docs/#/faq" target="_blank">帮助文档 | 常见问题</a></li>
                        <li class="msg_type_0"><a href="https://www.emlog.net/docs/#/contact" target="_blank">联系交流 | 加入Q群</a></li>
                        <li class="msg_type_0"><a href="https://emlog.cn/" target="_blank">问题反馈 | 官方社区</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(hideActived, 2600);
        $("#menu_panel").addClass('active');
    </script>
<?php endif ?>
<?php endif ?>

<div class="row">
	<?php doAction('adm_main_content') ?>
</div>
