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
                    <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="文章标题" autofocus required/>
                </div>
                <div id="post_bar">
                    <a href="#" class="text-muted small my-3" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 插入图文资源</a>
					<?php doAction('adm_writelog_head'); ?>
                </div>
                <div id="logcontent"><textarea><?php echo $content; ?></textarea></div>
            </div>

            <div class="form-group">
                <label>文章摘要：</label>
                <div id="logexcerpt"><textarea><?php echo $excerpt; ?></textarea></div>
            </div>

            <div class="form-group">
                <label>文章封面：</label>
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
                    <label>标签：</label>
                    <input name="tag" id="tag" class="form-control" value="<?php echo $tagStr; ?>" placeholder="文章标签，使用逗号分隔"/>
                </div>
                <div class="form-group">
                    <label>发布时间：</label>
                    <input maxlength="200" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>链接别名：（用于seo设置 <a href="./seo.php">&rarr;</a>）</label>
                    <input name="alias" id="alias" class="form-control" value="<?php echo $alias; ?>"/>
                </div>
                <div class="form-group">
                    <label>访问密码：</label>
                    <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>"/>
                </div>
                <div class="form-group">
                    <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
                    <label for="allow_remark">允许评论</label>
                </div>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>"/>
                <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
                <input type="hidden" name="gid" value=<?php echo $logid; ?>/>
                <input type="hidden" name="author" id="author" value=<?php echo $author; ?>/>
				<?php if ($logid < 0): ?>
                    <input type="submit" value="发布文章" onclick="return checkform();" class="btn btn-success"/>
                    <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn btn-primary"/>
				<?php else: ?>
                    <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-success"/>
                    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="btn btn-primary"/>
					<?php if ($isdraft) : ?>
                        <input type="submit" name="pubdf" id="pubdf" value="发布" onclick="return checkform();" class="btn btn-success"/>
					<?php endif; ?>
				<?php endif; ?>
                <span id="save_info"></span>
            </div>
        </div>
    </div>
</form>

<!--资源库-->
<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">图文资源</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<?php if ($medias): ?>
                    <div class="card-columns">
						<?php
						foreach ($medias as $key => $value):
							$media_url = getFileUrl($value['filepath']);
							$media_name = $value['filename'];
							if (isImage($value['filepath'])) {
								$media_icon = getFileUrl($value['filepath_thum']);
							} else {
								$media_icon = "./views/images/fnone.png";
							}
							?>
                            <div class="card" style="min-height: 138px;">
								<?php if (isImage($value['filepath'])): ?>
                                    <a href="javascript:insert_media_img('<?php echo $media_url; ?>', '<?php echo $media_icon; ?>')" title="插入图片：<?php echo $media_name; ?>">
                                        <img class="card-img-top" src="<?php echo $media_icon; ?>"/>
                                    </a>
								<?php elseif (isVideo($value['filepath'])): ?>
                                    <a href="javascript:insert_media_video('<?php echo $media_url; ?>')" title="插入视频：<?php echo $media_name; ?>">
                                        <img class="card-img-top" src="<?php echo $media_icon; ?>"/>
                                    </a>
								<?php else: ?>
                                    <a href="javascript:insert_media('<?php echo $media_url; ?>', '<?php echo $media_name; ?>')" title="插入文件：<?php echo $media_name; ?>">
                                        <img class="card-img-top" src="<?php echo $media_icon; ?>"/>
                                    </a>
								<?php endif; ?>
                            </div>
						<?php endforeach; ?>
                    </div>
				<?php else: ?>
                    <div class="text-center">暂无可用资源，<a href="media.php">去上传</a></div>
				<?php endif; ?>
            </div>

        </div>
    </div>
</div>

<!-- 封面图裁剪 -->
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                <button type="button" class="bt btn-sm btn-secondary" data-dismiss="modal">取消</button>
                <button type="button" id="crop" class="btn btn-sm btn-success">保存</button>
            </div>
        </div>
    </div>
</div>
<script src="./editor.md/editormd.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<script>
    var icon_tog;//如果值为true，则“更多选项”箭头向右

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
    // 编辑器
    var Editor, Editor_summary;
    $(function () {
        Editor = editormd("logcontent", {
            width: "100%",
            height: 640,
            toolbarIcons: function () {
                return ["undo", "redo", "|", "bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "hr", "|",
                    "link", "image", "preformatted-text", "table", "|", "search", "watch"]
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
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    var base64data = reader.result;
                    $.ajax({
                        url: './article.php?action=upload_cover',
                        method: 'POST',
                        data: {image: base64data},
                        success: function (data) {
                            $modal.modal('hide');
                            if (data != "error") {
                                $('#cover_image').attr('src', data);
                                $('#cover').val(data);
                                $('#cover_rm').show();
                            }
                        }
                    });
                };
            });
        });
        $('#cover_rm').click(function () {
            $('#cover_image').attr('src', "./views/images/cover.svg");
            $('#cover').val("");
            $('#cover_rm').hide();
        });
    });
</script>
