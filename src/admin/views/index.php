<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived, 2600);</script>
<!--vot--><div class="containertitle"><b><?=lang('admincp')?></b></div>
<?php doAction('adm_main_top'); ?>
<div class="row">
<?php if (ROLE == ROLE_ADMIN): ?>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-laptop fa-fw"></i> <?=lang('site_info')?>
                </div>
                <div class="panel-body" id="admindex_servinfo">
                    <ul>
<!--vot-->              <li><?=lang('have')?><b><?= $sta_cache['lognum'] ?></b><?=lang('_posts')?>, <b><?= $sta_cache['comnum_all'] ?></b><?=lang('_comments')?></li>
<!--vot-->              <li><?=lang('db_prefix')?>: <?= DB_PREFIX ?></li>
<!--vot-->              <li><?=lang('php_version')?>: <?= $php_ver ?></li>
<!--vot-->              <li><?=lang('mysql_version')?>: <?= $mysql_ver ?></li>
<!--vot-->              <li><?=lang('server_environment')?>: <?= $serverapp ?></li>
<!--vot-->              <li><?=lang('server_max_upload_size')?>: <?= $uploadfile_maxsize ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
<!--vot-->          <i class="fa fa-volume-down fa-fw"></i> <?=lang('official_source')?>
                </div>
                <div class="panel-body" id="admindex_msg">
                    <ul></ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div id="admindex">
                <div id="about" class="alert alert-warning">
<!--vot-->        <?=lang('welcome_using')?> &copy; <a href="http://www.emlog.net" target="_blank">emlog</a> v<?= Option::EMLOG_VERSION ?> <span><a id="ckup" href="javascript:void(0);"><?=lang('update_check')?></a></span><br>
                </div>
            </div>
        </div>
    </div>
    <script>
	var em_lang = '<?=EMLOG_LANGUAGE?>';
	function mkdate(str, y, m, d, offset, s) {
	  y = '20' + y;
	  m = m.replace( /^([0-9])$/, '0$1' );
	  d = d.replace( /^([0-9])$/, '0$1' );
	  return (y + '-' + m + '-' + d);
	}
        $(document).ready(function() {
/*vot*/             $("#admindex_msg ul").html("<span class=\"ajax_remind_1\"><?=lang('reading')?></span>");
                    $.getJSON("<?= OFFICIAL_SERVICE_HOST ?>services/messenger.php?v=<?= Option::EMLOG_VERSION ?>&callback=?",
                    function(data) {
                        $("#admindex_msg ul").html("");
                        $.each(data.items, function(i, item) {
                            var image = '';
                            if (item.image != '') {
                                image = "<a href=\"" + item.url + "\" target=\"_blank\" title=\"" + item.title + "\"><img src=\"" + item.image + "\"></a><br>";
                            }

/*vot*/				    if(em_lang != 'cn') {
/*vot*/	/* DO NOT TRANSLATE!! */	item.date = item.date.replace(/(\d+)年(\d+)月(\d+)日/, mkdate);
/*vot*/					//alert(item.date);
/*vot*/	/* DO NOT TRANSLATE!! */	item.title = item.title.replace("发布", "<?=lang('release')?>");
/*vot*/				    }

                            $("#admindex_msg ul").append("<li class=\"msg_type_" + item.type + "\">" + image + "<span>" + item.date + "</span><a href=\"" + item.url + "\" target=\"_blank\">" + item.title + "</a></li>");
                        });
                    });
        });
    </script>
<?php else: ?>
<div class="row">
        <div class="col-lg-12">
            <div id="admindex_main">
<!--vot--><div id="about"><a href="blogger.php"><?= $name ?></a> (<b><?= $sta_cache[UID]['lognum'] ?></b><?=lang('_posts')?>, <b><?= $sta_cache[UID]['commentnum'] ?></b><?=lang('_comments')?>)</div>
            </div>
            <div class="clear"></div>
        </div>
</div>
<?php endif; ?>
