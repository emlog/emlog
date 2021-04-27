<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<form action="page.php?action=save" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $containertitle; ?></h1>
    <div class="row">
        <div class="col-xl-12">
            <div id="post" class="form-group">
                <div>
<!--vot-->          <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?=lang('page_title')?>"/>
                </div>
                <div id="post_bar">
<!--vot-->          <a href="#" class="text-muted small my-3" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> <?=lang('upload_insert')?></a>
					<?php doAction('adm_writelog_head'); ?>
                </div>
                <div id="pagecontent"><textarea style="display:none;"><?php echo $content; ?></textarea></div>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('link_alias')?>:</label>
                <input name="alias" id="alias" class="form-control" value="<?php echo $alias; ?>"/>
            </div>
            <div class="form-group">
<!--vot-->      <label><?=lang('page_template')?>:</label>
                <input name="template" id="template" class="form-control" value="<?php echo $template; ?>"/>
            </div>
            <div class="form-group">
                <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
<!--vot-->      <label for="allow_remark"><?=lang('allow_comments')?></label>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
                <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
                <input type="hidden" name="pageid" value="<?php echo $pageId; ?>" />
				<?php if ($pageId < 0): ?>
<!--vot-->          <input type="submit" value="<?=lang('page_publish')?>" onclick="return checkform();" class="btn btn-success"/>
				<?php else: ?>
<!--vot-->          <input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="btn btn-success"/>
				<?php endif; ?>
            </div>
        </div>
    </div>
</form>

<!--Resource Library-->
<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('resource_library')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<script src="./editor.md/editormd.js"></script>
<script>
    $("#menu_page").addClass('active');
    checkalias();
    $("#alias").keyup(function () {
        checkalias();
    });
    $("#title").focus(function () {
        $("#title_label").hide();
    });
    $("#title").blur(function () {
        if ($("#title").val() == '') {
            $("#title_label").show();
        }
    });
    if ($("#title").val() != '') $("#title_label").hide();

    var Editor_page;
    $(function () {
        Editor_page = editormd("pagecontent", {
            width: "100%",
            height: 640,
            toolbarIcons: function () {
                return ["undo", "redo", "|",
                    "bold", "del", "italic", "quote", "|",
                    "h1", "h2", "h3", "h4", "h5", "h6", "|",
                    "list-ul", "list-ol", "hr", "|",
                    "link", "image", "preformatted-text", "table", "|", "search", "watch", "|", "info"]
            },
            path: "editor.md/lib/",
            tex: false,
            flowChart: false,
            watch: false,
            sequenceDiagram: false
        });
        Editor_page.setToolbarAutoFixed(false);
    });
</script>
