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
        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
<!--vot-->          <h6 class="m-0 font-weight-bold text-primary"><?= lang('site_info') ?></h6>
                </div>
                <div class="card-body">
                    <ul>
<!--vot-->              <li><?=lang('have')?> <b><?php echo $sta_cache['lognum']; ?></b><?=lang('_posts')?>， <b><?php echo $sta_cache['comnum_all']; ?></b><?=lang('_comments')?></li>
<!--vot-->              <li><?=lang('db_prefix')?>： <?php echo DB_PREFIX; ?></li>
<!--vot-->              <li><?=lang('php_version')?>: <?php echo $php_ver; ?></li>
<!--vot-->              <li><?=lang('mysql_version')?>： <?php echo $mysql_ver; ?></li>
<!--vot-->              <li><?=lang('server_environment')?>： <?php echo $serverapp; ?></li>
<!--vot-->              <li><?=lang('server_max_upload_size')?>： <?php echo $uploadfile_maxsize; ?></li>
                    </ul>

                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
<!--vot-->          <h6 class="m-0 font-weight-bold text-primary"><?= lang('official_news') ?></h6>
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
    $(document).ready(function () {
/*vot*/ $("#admindex_msg ul").html("<span class=\"ajax_remind_1\"><?= lang('reading') ?></span>");
        $.getJSON("<?php echo OFFICIAL_SERVICE_HOST; ?>services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
            function (data) {
                $("#admindex_msg ul").html("");
                $.each(data.items, function (i, item) {
                    var image = '';
                    if (item.image != '') {
                        image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br />";
                    }
                    $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                });
            });
    });
</script>