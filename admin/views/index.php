<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <div class="mb-0 text-gray-800">
        <span class="h3">欢迎，<a class="small" href="./blogger.php"><?= $user_cache[UID]['name'] ?></a></span>
        <span class="badge badge-primary ml-2"><?= $role_name ?></span>
    </div>
    <a href="./article.php?action=write" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-pencil-alt-5"></i> 写新文章</a>
</div>
<div class="row ml-1 mb-1"><?php doAction('adm_main_top') ?></div>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <h6 class="card-header">站点信息</h6>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="row">
                        <div class="col-xl-4 col-md-6 mb-1">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">待审文章</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="./article.php?checked=n"><?= $sta_cache['checknum'] ?></a></div>
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
                                                待审评论
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
                                                用户数量
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
                        <a href="./article.php">文章</a>
                        <a href="./article.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['lognum'] ?></span></a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="./twitter.php">笔记</a>
                        <a href="./twitter.php?all=y"><span class="badge badge-primary badge-pill"><?= $sta_cache['note_num'] ?></span></a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="./comment.php">评论</a>
                        <a href="./comment.php"><span class="badge badge-primary badge-pill"><?= $sta_cache['comnum_all'] ?></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php if (User::isAdmin()): ?>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <h6 class="card-header">软件信息</h6>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        PHP
                        <span class="small"><?= $php_ver ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        数据库
                        <span class="small">MySQL <?= $mysql_ver ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        web服务
                        <span class="small"><?= $server_app ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        EMLOG
                        <?php if (!Register::isRegLocal()) : ?>
                            <a href="auth.php"><span class="badge badge-secondary"><?= Option::EMLOG_VERSION ?> 未注册，点击注册</span></a>
                        <?php elseif (Register::getRegType() == 2): ?>
                            <span class="badge badge-warning"><?= ucfirst(Option::EMLOG_VERSION) ?> 铁杆SVIP</span>
                        <?php elseif (Register::getRegType() == 1): ?>
                            <span class="badge badge-success"><?= ucfirst(Option::EMLOG_VERSION) ?> 友情VIP</span>
                        <?php else: ?>
                            <span class="badge badge-success"><?= ucfirst(Option::EMLOG_VERSION) ?> 已注册</span>
                        <?php endif ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a id="ckup" href="javascript:checkupdate();" class="btn btn-success btn-sm">检查更新</a>
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
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <h6 class="my-0">您安装的emlog尚未注册，完成注册可使用全部功能，包括如下：</h6>
                    </div>
                    <div class="card-body">
                        <div>1. 解锁在线升级功能，一键升级到最新版本，获得来自官方的安全和功能更新。</div>
                        <div>2. 解锁应用商店，获得更多模板和插件，并支持应用在线一键更新。</div>
                        <div>3. 去除所有未注册提示及功能限制。</div>
                        <div>4. 加入专属Q群，获得官方技术指导问题解答。</div>
                        <div>5. 附赠多款收费应用（限铁杆SVIP）。</div>
                        <div>6. "投我以桃，报之以李"，您的支持也将帮助emlog变的更好并持续更新下去。</div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="auth.php" class="btn btn-sm btn-primary shadow-lg">去注册</a>
                        <a href="https://emlog.net/register" target="_blank" class="btn btn-sm btn-success shadow-lg">获取注册码-></a>
                    </div>
                </div>
            </div>
        <?php endif ?>
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <h6 class="card-header">获取帮助</h6>
                <div class="card-body admin_index_list">
                    <ul class="list-group list-group-flush">
                        <li class="msg_type_0"><a href="https://www.emlog.net/docs/#/faq" target="_blank">使用帮助 | 常见问题</a></li>
                        <li class="msg_type_0"><a href="https://www.emlog.net/docs/#/" target="_blank">应用开发 | 开发文档</a></li>
                        <li class="msg_type_0"><a href="https://www.emlog.net/docs/#/contact" target="_blank">联系交流 | 加入社群</a></li>
                        <li class="msg_type_0"><a href="https://emlog.cn/" target="_blank">问题反馈 | 官方社区</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <?php if (Register::isRegLocal() && option::get('accept_app_recs') === 'y'): ?>
            <div class="col-lg-6 mb-4">
                <div class="card mb-4">
                    <h6 class="card-header">今日应用 - <a href="./store.php">应用商店</a></h6>
                    <div class="card-body">
                        <div class="row" id="app-list"></div>
                    </div>
                </div>
            </div>
            <script>loadTopAddons();</script>
        <?php endif; ?>
    </div>
    <script>
        setTimeout(hideActived, 3600);
        // upgrade
        $("#menu_panel").addClass('active');
        $.get("./upgrade.php?action=check_update", function (result) {
            if (result.code == 200) {
                $("#upmsg").html("有可用的新版本 " + result.data.version + "，<a href=\"https://www.emlog.net/docs/#/changelog\" target=\"_blank\">查看更新内容</a>，<a id=\"doup\" href=\"javascript:doup('" + result.data.file + "','" + result.data.sql + "');\">现在更新</a>").removeClass();
            }
        });
    </script>
<?php endif ?>
<div class="row">
    <?php doAction('adm_main_content') ?>
</div>
