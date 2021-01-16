<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot-->      <h1 class="h3 mb-0 text-gray-800"><?= lang('control_panel') ?></h1>
                <a href="./write_log.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="far fa-edit"></i> <?= lang('write_article') ?></a>
            </div>

            <!-- Content Row -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
<!--vot-->                              <?= lang('post_number') ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sta_cache['lognum']; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
<!--vot-->                              <?= lang('comment_number') ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $sta_cache['comnum_all']; ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
<!--vot-->                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1"><?= lang('tasks') ?>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
<!--vot-->                              <?= lang('pending_requests') ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Content Column -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
<!--vot-->                  <h6 class="m-0 font-weight-bold text-primary"><?= lang('site_info') ?></h6>
                        </div>
                        <div class="card-body">
<!--vot-->                  <h4 class="small font-weight-bold"><?= lang('db_prefix') ?>: <span class="float-right"><?php echo DB_PREFIX; ?></span></h4>
<!--vot-->                  <h4 class="small font-weight-bold"><?= lang('db_prefix') ?>: <span class="float-right"><?php echo DB_PREFIX; ?></span></h4>
<!--vot-->                  <h4 class="small font-weight-bold"><?= lang('db_prefix') ?>: <span class="float-right"><?php echo DB_PREFIX; ?></span></h4>
<!--vot-->                  <h4 class="small font-weight-bold"><?= lang('db_prefix') ?>: <span class="float-right"><?php echo DB_PREFIX; ?></span></h4>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
<!--vot-->                  <h6 class="m-0 font-weight-bold text-primary"><?= lang('official_news') ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="panel-body" id="admindex_msg">
                                <ul></ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

<script>
/*vot*/	var em_lang = '<?= EMLOG_LANGUAGE ?>';
    $(document).ready(function() {
/*vot*/ $("#admindex_msg ul").html("<span class=\"ajax_remind_1\"><?= lang('reading') ?></span>");
        $.getJSON("<?php echo OFFICIAL_SERVICE_HOST; ?>services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
            function(data) {
                $("#admindex_msg ul").html("");
                $.each(data.items, function(i, item) {
                    var image = '';
                    if (item.image != '') {
                        image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br />";
                    }
                    $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                });
            });
    });
</script>
