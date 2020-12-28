<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot-->      <h1 class="h3 mb-0 text-gray-800"><?= lang('control_panel') ?></h1>
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
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

                <!-- Earnings (Monthly) Card Example -->
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

                <!-- Earnings (Monthly) Card Example -->
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

                <!-- Pending Requests Card Example -->
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

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
<!--vot-->      <span>Powered by <a href="http://www.emlog.net" title="<?= lang('emlog_official') ?>">emlog</a> </span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?= lang('logout_sure') ?></h5>
<!--vot-->      <button class="close" type="button" data-dismiss="modal" aria-label="<?= lang('close') ?>">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
<!--vot-->  <div class="modal-body"><?= lang('logout_prompt') ?></div>
            <div class="modal-footer">
<!--vot-->      <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= lang('cancel') ?></button>
<!--vot-->      <a class="btn btn-primary" href="login.html"><?= lang('logout') ?></a>
            </div>
        </div>
    </div>
</div>

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
