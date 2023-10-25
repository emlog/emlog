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
                            Web服务
                            <span class="small"><?= $server_app ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            操作系统
                            <span class="small"><?= $os ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                            <span>
                            <?php if (!Register::isRegLocal()) : ?>
                                <a href="auth.php"><span class="badge badge-secondary">Emlog <?= Option::EMLOG_VERSION ?> 未注册，点击注册</span></a>
                            <?php elseif (Register::getRegType() == 2): ?>
                                <span class="badge badge-warning">Emlog <?= ucfirst(Option::EMLOG_VERSION) ?> 铁杆SVIP</span>
                            <?php elseif (Register::getRegType() == 1): ?>
                                <span class="badge badge-success">Emlog <?= ucfirst(Option::EMLOG_VERSION) ?> 友情VIP</span>
                            <?php else: ?>
                                <span class="badge badge-success">Emlog <?= ucfirst(Option::EMLOG_VERSION) ?> 已注册</span>
                            <?php endif ?>
                                </span>
                            <span>
                                <a id="ckup" href="javascript:checkUpdate();" class="badge badge-success d-flex align-items-center"><span>更新</span></a>
                            </span>
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
    <div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="update-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update-modal-label">检查更新</h5>
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

        // Check for updates
        $.get("./upgrade.php?action=check_update", function (result) {
            if (result.code === 200) {
                $("#ckup").append('<span class="badge bg-danger ml-1">!</span>');
            }
        });

        function checkUpdate() {
            const updateModal = $("#update-modal");
            const updateModalLoading = $("#update-modal-loading");
            const updateModalMsg = $("#update-modal-msg");
            const updateModalChanges = $("#update-modal-changes");
            const updateModalBtn = $("#update-modal-btn");

            updateModal.modal('show');
            updateModalLoading.addClass("spinner-border text-primary");

            let rep_msg = "";
            let rep_changes = "";
            let rep_btn = "";

            updateModalMsg.html(rep_msg);
            updateModalChanges.html(rep_changes);
            updateModalBtn.html(rep_btn);

            $.get("./upgrade.php?action=check_update", function (result) {
                if (result.code === 1001) {
                    rep_msg = "您的emlog pro尚未注册，<a href=\"auth.php\">去注册</a>";
                } else if (result.code === 1002) {
                    rep_msg = "已经是最新版本";
                } else if (result.code === 200) {
                    rep_msg = `有可用的新版本：<span class="text-danger">${result.data.version}</span> <br><br>`;
                    rep_changes = "<b>更新内容</b>:<br>" + result.data.changes;
                    rep_btn = `<hr><a href="javascript:doUp('${result.data.file}','${result.data.sql}');" class="btn btn-success btn-sm">现在更新</a>`;
                } else {
                    rep_msg = "检查失败，可能是网络问题";
                }

                updateModalLoading.removeClass();
                updateModalMsg.html(rep_msg);
                updateModalChanges.html(rep_changes);
                updateModalBtn.html(rep_btn);
            });
        }

        function doUp(source, upSQL) {
            const updateModalLoading = $("#update-modal-loading");
            const updateModalMsg = $("#update-modal-msg");
            const updateModalChanges = $("#update-modal-changes");
            const upmsg = $("#upmsg");

            updateModalLoading.addClass("spinner-border text-primary");
            updateModalMsg.html("更新中... 请耐心等待");
            updateModalChanges.html("");

            $.get(`./upgrade.php?action=update&source=${source}&upsql=${upSQL}`, function (data) {
                upmsg.removeClass();

                if (data.includes("succ")) {
                    updateModalMsg.html('🎉恭喜，更新成功了🎉，<a href="./">刷新页面</a> 开始体验新版本');
                } else if (data.includes("error_down")) {
                    updateModalMsg.html('下载更新失败，可能是服务器网络问题');
                } else if (data.includes("error_zip")) {
                    updateModalMsg.html('解压更新失败，可能是你的服务器空间不支持zip模块');
                } else if (data.includes("error_dir")) {
                    updateModalMsg.html('更新失败，目录不可写');
                } else {
                    updateModalMsg.html('更新失败');
                }

                updateModalLoading.removeClass();
            });
        }
    </script>
<?php endif ?>
<?php if (User::isAdmin()): ?>
    <div class="row">
        <?php doAction('adm_main_content') ?>
    </div>
<?php endif; ?>