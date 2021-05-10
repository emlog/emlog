<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_reg'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('em_reg_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('reg_failed')?></div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('welcome')?>, <?php echo $user_cache[UID]['name'] ?></h1>
	<?php doAction('adm_main_top'); ?>
</div>
<?php if (ROLE == ROLE_ADMIN): ?>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
<!--vot-->  <h6 class="card-header"><?= lang('site_info') ?></h6>
            <div class="card-body">
                <ul class="list-group list-group-flush">
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('posts')?>
                        <a href="./article.php"><span class="badge badge-primary badge-pill"><?php echo $sta_cache['lognum']; ?></span></a>
                    </li>
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('drafts')?>
                        <a href="./article.php?draft=1"><span class="badge badge-primary badge-pill"><?php echo $sta_cache['draftnum']; ?></span></a>
                    </li>
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('comments')?>
                        <a href="./comment.php"><span class="badge badge-primary badge-pill"><?php echo $sta_cache['comnum_all']; ?></span></a>
                    </li>
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('pending_review')?>
                        <a href="./comment.php?hide=y"><span class="badge badge-warning badge-pill"><?php echo $sta_cache['hidecomnum']; ?></span></a>
                    </li>
<!--vot-->          <li class="list-group-item d-flex justify-content-between align-items-center"><?=lang('user_num')?>
                        <a href="./user.php"><span class="badge badge-warning badge-pill"><?php echo count($user_cache); ?></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
<!--vot-->  <h6 class="card-header"><?= lang('official_news') ?></h6>
            <div class="card-body" id="admindex_msg">
                <ul class="list-group list-group-flush"></ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
<!--vot-->  <h6 class="card-header"><?=lang('software_info')?></h6>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center small">
<!--vot-->              <?=lang('server_environment')?>:
<!--vot-->              <span>PHP<?php echo $php_ver; ?>, MySQL<?php echo $mysql_ver; ?>, <?php echo $serverapp; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center small">
<!--vot-->              <?=lang('emlog_version')?>:
						<?php if (ISREG === false) : ?>
<!--vot-->              <span class="badge badge-danger"><?php echo Option::EMLOG_VERSION; ?> <?=lang('unregistered')?></span>
						<?php else: ?>
<!--vot-->              <span class="badge badge-success"><?php echo Option::EMLOG_VERSION; ?> <?=lang('registered_already')?></span>
                        <?php endif; ?>
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
		<?php if (ISREG === false) : ?>
        <div class="card bg-danger text-white shadow">
            <div class="card-body">
<!--vot-->      <h4><?=lang('emlog_unregistered')?></h4>
<!--vot-->      <div><?=lang('advantage1')?></div>
<!--vot-->      <div><?=lang('advantage2')?></div>
<!--vot-->      <div><?=lang('advantage3')?></div>
<!--vot-->      <div><?=lang('advantage4')?></div>
<!--vot-->      <div><?=lang('advantage5')?></div>
            </div>
            <div class="card-footer text-center">
<!--vot-->      <a href="#" class="btn btn-sm btn-success shadow-lg" data-toggle="modal" data-target="#exampleModal"><?=lang('register_now')?></a>
            </div>
        </div>
		<?php endif; ?>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('register_emlog')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="register.php?action=register" method="post">
                <div class="modal-body">
                    <div class="form-group">
<!--vot-->              <input class="form-control" id="emkey" name="emkey" placeholder="<?=lang('enter_emkey')?>" required>
                    </div>
<!--vot-->          <div><a href="<?php echo OFFICIAL_SERVICE_HOST; ?>register"><?=lang('how_get_emkey')?> &rarr;</a></div>
                </div>
                <div class="modal-footer">
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('registered')?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_home").addClass('active');
    $(document).ready(function () {
        $("#admindex_msg ul").html("").addClass("spinner-border text-primary");
        $.get("./index.php?action=get_news",
            function (data) {
                $.each(data.items, function (i, item) {
                    var image = '';
                    if (item.image != '') {
                        image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br />";
                    }
                    $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                });
                $("#admindex_msg ul").removeClass();
            });
    });

    function checkupdate() {
        $("#upmsg").html("").addClass("spinner-border text-primary");
        $.get("./upgrade.php?action=check_update",
            function (result) {
                if (result.code == 1001) {
/*vot*/             $("#upmsg").html("<?=lang('emlog_unregistered')?>").removeClass();
                } else if (result.code == 1002) {
/*vot*/             $("#upmsg").html("<?=lang('updates_no')?> ").removeClass();
                } else if (result.code == 200) {
/*vot*/             $("#upmsg").html("<?=lang('update_exists')?> " + result.data.ver + ", <?=lang('backup_before_update')?>, <a id=\"doup\" href=\"javascript:doup('" + result.data.file + "','" + result.data.sql + "');\"><?=lang('update_now')?></a>").removeClass();
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
<?php endif; ?>