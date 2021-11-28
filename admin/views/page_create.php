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
<!--vot-->          <a href="#mediaModal" class="text-muted small my-3" data-remote="./media.php?action=lib" data-toggle="modal" data-target="#mediaModal"><i
                                class="icofont-plus"></i> <?=lang('upload_insert')?></a>
					<?php doAction('adm_writelog_head'); ?>
                </div>
                <div id="pagecontent"><textarea style="display:none;"><?php echo $content; ?></textarea></div>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('link_alias')?></label>
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
<!--vot-->          <input type="submit" value="<?=lang('page_publish')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
				<?php else: ?>
<!--vot-->          <input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
				<?php endif; ?>
            </div>
        </div>
    </div>
</form>
<!--Resource Library-->
<div class="modal" id="mediaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('resource_library')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<!--vot-->      <a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm mb-3"><?=lang('upload_files')?></a>
                <form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
                    <div class="row">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="dropzone-previews" style="display: none;"></div>
<script src="./views/js/dropzone.min.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<script>
    // Upload resources
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#mediaAdd", {
        url: "./media.php?action=upload",
        addRemoveLinks: false,
        method: 'post',
        maxFilesize: 2048,//M
        filesizeBase: 1024,
        previewsContainer: ".dropzone-previews",
        sending: function (file, xhr, formData) {
            formData.append("filesize", file.size);
<!--vot-->  $('#mediaAdd').html("<?=lang('uploading')?>");
        },
        init: function () {
            this.on("error", function (file, response) {
                alert(response);
            });
            this.on("queuecomplete", function (file) {
                $('#mediaModal').find('.modal-body .row').load("./media.php?action=lib");
<!--vot-->      $('#mediaAdd').html("<?=lang('upload_files')?>");
            });
        }
    });
    // Load file list
    $('#mediaModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var modal = $(this);
        modal.find('.modal-body .row').load(button.data("remote"));
    });
</script>

<script src="./editor.md/editormd.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<? /*vot*/ if (EMLOG_LANGUAGE !== 'zh-cn') { ?>
<script src="./editor.md/languages/<?=EMLOG_LANGUAGE?>.js"></script>
<? } ?>
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

    var Editor;
    $(function () {
        Editor = editormd("pagecontent", {
            width: "100%",
            height: 640,
            toolbarIcons: function () {
                return ["undo", "redo", "|",
                    "bold", "del", "italic", "quote", "|",
                    "h1", "h2", "h3", "|",
                    "list-ul", "list-ol", "hr", "|",
                    "link", "image", "preformatted-text", "table", "|", "watch"]
            },
            path: "editor.md/lib/",
            tex: false,
            flowChart: false,
            watch: false,
            htmlDecode : true,
            sequenceDiagram: false,
            syncScrolling : "single",
            onload: function () {
                    hooks.doAction("page_loaded",this);
                    //In the large screen mode, the editor displays the preview by default
                    if($(window).width() > 767){
                        this.watch();
                    }
                    //Add Ctrl(Cmd)+S shortcut key to save article content
                    var articleSave = {
                    "Ctrl-S": function(cm) {
                    	autosave(2);
                    },
                    "Cmd-S": function(cm) {
                    	autosave(2);
                    }};
                    this.addKeyMap(articleSave);  
            }
        });
        Editor.setToolbarAutoFixed(false);
    });
</script>
