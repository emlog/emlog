<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<div id="msg" class="fixed-top alert" style="display: none"></div>
<h1 class="h3 mb-4 text-gray-800"><?= $containertitle ?></h1>
<form action="article_save.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <div class="row">
        <div class="col-xl-12">
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?= $title ?>" class="form-control" placeholder="文章标题" autofocus required/>
                </div>
                <div id="post_bar">
                    <a href="#mediaModal" class="text-muted small my-3" data-remote="./media.php?action=lib" data-toggle="modal" data-target="#mediaModal"><i
                                class="icofont-plus"></i> 插入图文资源</a>
					<?php doAction('adm_writelog_head') ?>
                </div>
                <div id="logcontent"><textarea><?= $content ?></textarea></div>
            </div>

            <div class="form-group">
                <label>文章摘要：</label>
                <div id="logexcerpt"><textarea><?= $excerpt ?></textarea></div>
            </div>

            <div class="form-group">
                <label>文章封面：</label>
                <input name="cover" id="cover" class="form-control" placeholder="封面图地址URL，可手动填写或点击下方图片区域上传" value="<?= $cover ?>"/>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="upload_img">
                            <img src="<?= $cover ?: './views/images/cover.svg' ?>" id="cover_image" class="rounded"/>
                            <input type="file" name="upload_img" class="image" id="upload_img" style="display:none"/>
                            <button type="button" id="cover_rm" class="btn-sm btn btn-link" <?php if (!$cover): ?>style="display:none"<?php endif ?>>x</button>
                        </label>
                    </div>
                </div>
            </div>

            <div class="show_advset" id="displayToggle" onclick="displayToggle('advset', 1);">更多选项<i class="icofont-simple-right"></i></div>

            <div id="advset" class="shadow-sm p-3 mb-2 bg-white rounded">
                <div class="form-group">
                    <label>分类：</label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="-1">选择分类...</option>
						<?php
						foreach ($sorts as $key => $value):
							if ($value['pid'] != 0) {
								continue;
							}
							$flg = $value['sid'] == $sortid ? 'selected' : '';
							?>
                            <option value="<?= $value['sid'] ?>" <?= $flg ?>><?= $value['sortname'] ?></option>
							<?php
							$children = $value['children'];
							foreach ($children as $key):
								$value = $sorts[$key];
								$flg = $value['sid'] == $sortid ? 'selected' : '';
								?>
                                <option value="<?= $value['sid'] ?>" <?= $flg ?>>&nbsp; &nbsp; &nbsp; <?= $value['sortname'] ?></option>
							<?php
							endforeach;
						endforeach;
						?>
                    </select>
                </div>
                <div class="form-group">
                    <label>标签：</label>
                    <input name="tag" id="tag" class="form-control" value="<?= $tagStr ?>" placeholder="文章标签，使用逗号分隔"/>
                </div>
                <div class="form-group">
                    <label>发布时间：</label>
                    <input maxlength="200" name="postdate" id="postdate" value="<?= $postDate ?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>链接别名：（用于seo设置 <a href="./setting.php?action=seo">&rarr;</a>）</label>
                    <input name="alias" id="alias" class="form-control" value="<?= $alias ?>"/>
                </div>
                <div class="form-group">
                    <label>访问密码：</label>
                    <input type="text" name="password" id="password" class="form-control" value="<?= $password ?>"/>
                </div>
                <div class="form-group">
                    <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?= $is_allow_remark ?> />
                    <label for="allow_remark">允许评论</label>
                </div>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
                <input type="hidden" name="ishide" id="ishide" value="<?= $hide ?>"/>
                <input type="hidden" name="as_logid" id="as_logid" value="<?= $logid ?>">
                <input type="hidden" name="gid" value=<?= $logid ?>/>
                <input type="hidden" name="author" id="author" value=<?= $author ?>/>
				<?php if ($logid < 0): ?>
                    <input type="submit" value="发布文章" onclick="return checkform();" class="btn btn-sm btn-success"/>
                    <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn btn-sm btn-primary"/>
				<?php else: ?>
                    <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-sm btn-success"/>
                    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="btn btn-sm btn-primary"/>
					<?php if ($isdraft) : ?>
                        <input type="submit" name="pubdf" id="pubdf" value="发布" onclick="return checkform();" class="btn btn-sm btn-success"/>
					<?php endif ?>
				<?php endif ?>
                <span id="save_info"></span>
            </div>
        </div>
    </div>
</form>

<div class="modal" id="mediaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">图文资源</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm mb-3">上传图片/文件</a>
                <form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
                    <div class="row">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="dropzone-previews" style="display: none;"></div>
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    // 上传资源
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#mediaAdd", {
        url: "./media.php?action=upload",
        addRemoveLinks: false,
        method: 'post',
        maxFilesize: 2048,//MB
        filesizeBase: 1024,
        timeout: 3600000,// milliseconds
        previewsContainer: ".dropzone-previews",
        sending: function (file, xhr, formData) {
            formData.append("filesize", file.size);
            $('#mediaAdd').html("上传中……");
        },
        init: function () {
            this.on("error", function (file, response) {
                alert(response);
            });
            this.on("queuecomplete", function (file) {
                $('#mediaModal').find('.modal-body .row').load("./media.php?action=lib");
                $('#mediaAdd').html("上传图片/文件");
            });
        }
    });
    // 载入资源列表
    $('#mediaModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var modal = $(this);
        modal.find('.modal-body .row').load(button.data("remote"));
    });
</script>

<!-- 封面图裁剪 -->
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">裁剪并上传</h5>
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
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" id="crop" class="btn btn-sm btn-success">保存</button>
            </div>
        </div>
    </div>
</div>
<script src="./editor.md/editormd.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    var icon_tog = false;

    $("#alias").keyup(function () {
        checkalias();
    });
    setTimeout("autosave(1)", 30000);
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');

    if (Cookies.get('em_advset') == "hidden") {
        displayToggle('advset', 1);
    } else {
        $(".icofont-simple-right").attr("class", "icofont-simple-down");
    }
    // 编辑器
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
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png"],
            imageUploadURL: "media.php?action=upload&editor=1",
            syncScrolling: "single",
            onload: function () {
                hooks.doAction("loaded", this);
                //在大屏模式下，编辑器默认显示预览
                if ($(window).width() > 767) {
                    this.watch();
                }
                //添加Ctrl(Cmd)+S快捷键保存文章内容
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
            placeholder: "如果留空，则使用文章内容作为摘要...",
            onload: function () {
                hooks.doAction("sum_loaded", this);
            }
        });
        Editor.setToolbarAutoFixed(false);
        Editor_summary.setToolbarAutoFixed(false);
    });
    // 封面图
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

    // 离开页面时，如果文章内容已做修改，则询问用户是否离开
    var articleTextRecord;
    hooks.addAction("loaded", function () {
        articleTextRecord = $("textarea[name=logcontent]").text();
    });
    window.onbeforeunload = function (e) {
        if ($("textarea[name=logcontent]").text() == articleTextRecord) return
        e = e || window.event;
        if (e) e.returnValue = '离开页面提示';
        return '离开页面提示';
    }

    // 如果文章内容已做修改，则使网页标题修改为‘已修改’
    var titleText = $('title').text()
    hooks.addAction("loaded", function (obj) {
        obj.config({
            onchange: function () {
                if ($("textarea[name=logcontent]").text() == articleTextRecord) return
                $('title').text('[已修改] ' + titleText);
            }
        });
    });
</script>
