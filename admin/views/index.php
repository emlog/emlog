<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?= lang('admincp') ?></h1>
    <?php doAction('adm_main_top'); ?>
</div>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
<!--vot-->  <h6 class="card-header"><?= lang('site_info') ?></h6>
            <div class="card-body">
                <ul class="list-group list-group-flush">
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('posts')?>
                        <span class="badge badge-primary badge-pill"><?php echo $sta_cache['lognum']; ?></span>
                    </li>
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('comments')?>
                        <span class="badge badge-primary badge-pill"><?php echo $sta_cache['comnum_all']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center small">
<!--vot-->              <?=lang('php_version')?>: <?php echo $php_ver; ?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center small">
<!--vot-->              <?=lang('emlog_version')?>: <?php echo Option::EMLOG_VERSION; ?> <?=lang('unregistered')?>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center small">
<!--vot-->              <a id="ckup" href="javascript:checkupdate();"><?=lang('update_check')?></a>
                        <span id="upmsg"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
<!--vot-->  <h6 class="card-header"><?= lang('official_news') ?></h6>
            <div class="card-body">
                <div class="panel-body" id="admindex_msg">
                    <ul class="list-group list-group-flush"></ul>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $("#menu_home").addClass('active');
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


    function checkupdate() {
/*vot*/ $("#upmsg").html("?=lang('checking_wait')?>").addClass("ajaxload");
        $.getJSON("<?php echo OFFICIAL_SERVICE_HOST;?>services/check_update.php?ver=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
            function (data) {
                if (data.result.match("no")) {
/*vot*/             $("#upmsg").html("<?=lang('updates_no')?>").removeClass();
                } else if (data.result.match("yes")) {
/*vot*/             $("#upmsg").html("<?=lang('update_exists')?> " + data.ver + "， <?=lang('backup_before_update')?>， <a id=\"doup\" href=\"javascript:doup('" + data.file + "','" + data.sql + "');\"><?=lang('update_now')?></a>").removeClass();
                } else {
/*vot*/             $("#upmsg").html("<?=lang('update_check_failed')?>").removeClass();
                }
            });
    }

    function doup(source, upsql) {
/*vot*/ $("#upmsg").html("<?=lang('updating')?>").addClass("ajaxload");
        $.get('./upgrade.php?action=update&source=' + source + "&upsql=" + upsql,
            function (data) {
                $("#upmsg").removeClass();
                if (data.match("succ")) {
/*vot*/             $("#upmsg").html('<?=lang('update_completed')?>');
                } else if (data.match("error_down")) {
/*vot*/             $("#upmsg").html('<?=lang('update_download_failed')?>');
                } else if (data.match("error_zip")) {
/*vot*/             $("#upmsg").html('<?=lang('update_extract_failed')?>');
                } else if (data.match("error_dir")) {
/*vot*/             $("#upmsg").html('<?=lang('update_failed_nonwritable')?>');
                } else {
/*vot*/             $("#upmsg").html('<?=lang('update_failed')?>');
                }
            });
    }

</script>