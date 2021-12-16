<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<div id="msg" class="fixed-top alert" style="display: none"></div>
<h1 class="h3 mb-4 text-gray-800"><?php echo $containertitle; ?></h1>
<form action="article_save.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <div class="row">
        <div class="col-xl-12">
            <div id="post" class="form-group">
                <div>
<!--vot-->          <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?=lang('post_title')?>" autofocus required/>
                </div>
                <div id="post_bar">
<!--vot-->          <a href="#mediaModal" class="text-muted small my-3" data-remote="./media.php?action=lib" data-toggle="modal" data-target="#mediaModal"><i
                                class="icofont-plus"></i> <?=lang('upload_insert')?></a>
					<?php doAction('adm_writelog_head'); ?>
                </div>
                <div id="logcontent"><textarea><?php echo $content; ?></textarea></div>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('post_description')?>:</label>
                <div id="logexcerpt"><textarea><?php echo $excerpt; ?></textarea></div>
            </div>

            <div class="form-group">
<!--vot-->      <label><?=lang('article_cover')?>:</label>
                <div class="row m-3">
                    <div class="col-md-4">
                        <label for="upload_img">
                            <img src="<?php echo $cover ?: './views/images/cover.svg'; ?>" id="cover_image" class="rounded"/>
                            <input type="file" name="upload_img" class="image" id="upload_img" style="display:none"/>
                            <input type="hidden" name="cover" id="cover" value="<?php echo $cover; ?>"/>
                            <button type="button" id="cover_rm" class="btn-sm btn btn-link" <?php if (!$cover): ?>style="display:none"<?php endif; ?>>x</button>
                        </label>
                    </div>
                </div>
            </div>

<!--vot-->  <div class="show_advset" id="displayToggle" onclick="displayToggle('advset', 1);"><?=lang('more_options')?><i class="icofont-simple-right"></i></div>

            <div id="advset" class="shadow-sm p-3 mb-2 bg-white rounded">
                <div class="form-group">
<!--vot-->          <label><?=lang('category')?>:</label>
                    <select name="sort" id="sort" class="form-control">
<!--vot-->              <option value="-1"><?=lang('category_select')?></option>
						<?php
						foreach ($sorts as $key => $value):
							if ($value['pid'] != 0) {
								continue;
							}
							$flg = $value['sid'] == $sortid ? 'selected' : '';
							?>
                            <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>><?php echo $value['sortname']; ?></option>
							<?php
							$children = $value['children'];
							foreach ($children as $key):
								$value = $sorts[$key];
								$flg = $value['sid'] == $sortid ? 'selected' : '';
								?>
                                <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>>&nbsp; &nbsp; &nbsp; <?php echo $value['sortname']; ?></option>
							<?php
							endforeach;
						endforeach;
						?>
                    </select>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('tags')?>:</label>
<!--vot-->          <input name="tag" id="tag" class="form-control" value="<?php echo $tagStr; ?>" placeholder="<?=lang('post_tags_separated')?>"/>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('publish_time')?>:</label>
                    <input maxlength="200" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control"/>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('link_alias')?></label>
                    <input name="alias" id="alias" class="form-control" value="<?php echo $alias; ?>"/>
                </div>
                <div class="form-group">
<!--vot-->          <label><?=lang('access_password')?>:</label>
                    <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>"/>
                </div>
                <div class="form-group">
                    <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
<!--vot-->          <label for="allow_remark"><?=lang('allow_comments')?></label>
                </div>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>"/>
                <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
                <input type="hidden" name="gid" value=<?php echo $logid; ?>/>
                <input type="hidden" name="author" id="author" value=<?php echo $author; ?>/>
				<?php if ($logid < 0): ?>
<!--vot-->          <input type="submit" value="<?=lang('post_publish')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
<!--vot-->          <input type="button" name="savedf" id="savedf" value="<?=lang('save_draft')?>" onclick="autosave(2);" class="btn btn-sm btn-primary"/>
				<?php else: ?>
<!--vot-->          <input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
<!--vot-->          <input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(2);" class="btn btn-sm btn-primary"/>
					<?php if ($isdraft) : ?>
<!--vot-->              <input type="submit" name="pubdf" id="pubdf" value="<?=lang('publish')?>" onclick="return checkform();" class="btn btn-sm btn-success"/>
					<?php endif; ?>
				<?php endif; ?>
                <span id="save_info"></span>
            </div>
        </div>
    </div>
</form>

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

<!-- Cover image cropping -->
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?=lang('crop_upload')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-11">
                            <img src="" id="sample_image"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
<!--vot-->      <button type="button" class="bt btn-sm btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->      <button type="button" id="crop" class="btn btn-sm btn-success"><?=lang('save')?></button>
            </div>
        </div>
    </div>
</div>
<script src="./editor.md/editormd.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<? if (EMLOG_LANGUAGE !== 'zh-cn') { ?>
<script src="./editor.md/languages/<?=EMLOG_LANGUAGE?>.js"></script>
<? } ?>
<script>
    var icon_tog;//If the value is true, the "advanced options" arrow points to the right

    $("#alias").keyup(function () {
        checkalias();
    });
    setTimeout("autosave(1)", 30000);
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');

    icon_tog = false;
    if (Cookies.get('em_advset') == "hidden") {
        displayToggle('advset', 1);
    } else {
        $(".icofont-simple-right").attr("class", "icofont-simple-down");
    }
    // Editor
    var Editor, Editor_summary;
    $(function () {
        Editor = editormd("logcontent", {
            width: "100%",
            height: 640,
            toolbarIcons: function () {
                return ["undo", "redo", "|", "bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "hr", "|",
                    "link", "image", "preformatted-text", "code-block", "table", "|", "search", "watch"]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            htmlDecode: true,
            flowChart: false,
            autoFocus: false,
            sequenceDiagram: false,
            imageUpload: false,
            imageFormats: ["jpg", "jpeg", "gif", "png"],
            imageUploadURL: "media.php?action=upload&editor=1",
            syncScrolling: "single",
            onload: function () {
                hooks.doAction("loaded", this);
                //In the large screen mode, the editor displays the preview by default
                if ($(window).width() > 767) {
                    this.watch();
                }
                //Add Ctrl(Cmd)+S shortcut key to save article content
                var articleSave = {
                    "Ctrl-S": function (cm) {
                        autosave(2);
                    },
                    "Cmd-S": function (cm) {
                        autosave(2);
                    }
                };
                this.addKeyMap(articleSave);
            }
        });
        Editor_summary = editormd("logexcerpt", {
            width: "100%",
            height: 300,
            toolbarIcons: function () {
                return ["undo", "redo", "|", "bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "hr", "|", "link", "image", "|", "watch"]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            htmlDecode: true,
            flowChart: false,
            autoFocus: false,
            sequenceDiagram: false,
/*vot*/     placeholder: "<?=lang('enter_summary')?>",
            onload: function () {
                hooks.doAction("sum_loaded", this);
            }
        });
        Editor.setToolbarAutoFixed(false);
        Editor_summary.setToolbarAutoFixed(false);
    });
    // Cover image
    $(document).ready(function () {
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_img').change(function (event) {
            var files = event.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                reader = new FileReader();
                reader.onload = function (event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 16 / 9,
                viewMode: 1
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $('#crop').click(function () {
            canvas = cropper.getCroppedCanvas({
                width: 650,
                height: 366
            });
            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('image', blob, 'cover.jpg');
                $.ajax('./article.php?action=upload_cover', {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $modal.modal('hide');
                        if (data != "error") {
                            $('#cover_image').attr('src', data);
                            $('#cover').val(data);
                            $('#cover_rm').show();
                        }
                    }
                });
            });
        });

        $('#cover_rm').click(function () {
            $('#cover_image').attr('src', "./views/images/cover.svg");
            $('#cover').val("");
            $('#cover_rm').hide();
        });
    });
</script>
