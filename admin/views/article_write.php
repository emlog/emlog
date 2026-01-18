<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div id="msg" class="fixed-top alert" style="display: none"></div>
<h4 class="mb-4 text-gray-800"><?= $containerTitle ?> <span id="save_info"></span></h4>
<form action="article_save.php" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <div class="row">
        <div class="col-xl-9">
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?= $title ?>" class="form-control" maxlength="512" placeholder="<?= _lang('title') ?>" autofocus required />
                </div>
                <div class="small my-3">
                    <a href="#mediaModal" data-toggle="modal" data-target="#mediaModal"><i class="icofont-plus"></i><?= _lang('media_lib') ?></a>
                    <?php doAction('adm_writelog_bar') ?>
                </div>
                <div id="logcontent"><textarea><?= $content ?></textarea></div>
                <?php if (User::haveEditPermission() && !Register::isRegLocal()): ?>
                    <div class="small"><?= _lang('switch_to_rich_editor') ?><a href="store.php?action=plu&sid=20"><?= _lang('install_tinymce_plugin') ?></a></div>
                <?php endif; ?>
                <div class="mt-3">
                    <?= _lang('excerpt_optional') ?>
                    <textarea id="logexcerpt" name="logexcerpt" class="form-control" rows="5"><?= $excerpt ?></textarea>
                    <div class="custom-control custom-switch mt-1">
                        <input type="checkbox" class="custom-control-input" id="auto_excerpt" name="auto_excerpt" value="y" onclick="toggleCheckbox('auto_excerpt')">
                        <label class="custom-control-label" for="auto_excerpt"><?= _lang('auto_excerpt') ?></label>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="javascript:void (0);" class="field_add small"><i class="icofont-plus"></i><?= _lang('add_field') ?></a>
                    <div class="mt-2" id="field_box">
                        <?php
                        foreach ($fields as $key => $value): ?>
                            <div class="form-row field_list mb-3">
                                <div class="col-sm-3 px-2 my-1">
                                    <input type="text" name="field_keys[]" value="<?= $key ?>" list="customFieldList" class="form-control field-keys-input" placeholder="<?= _lang('field_name') ?>" maxlength="120" required>
                                    <datalist id="customFieldList">
                                        <?php foreach ($customFields as $k => $v): ?>
                                            <option value="<?= $k ?>"><?= $k . '【' . $v['name'] . '】' . $v['description'] ?></option>
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                                <div class="col-sm-8 px-2 my-1">
                                    <textarea name="field_values[]" class="form-control auto-resize-textarea field-values-textarea" placeholder="<?= _lang('field_value') ?>" rows="1" style="resize: vertical; min-height: 33px; white-space: pre-wrap; overflow-x: auto;" required><?= $value ?></textarea>
                                </div>
                                <div class="col-sm-1 px-2 my-1 d-flex align-items-start justify-content-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger field_del"><?= _lang('delete') ?></button>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label id="post_bar_label"><?= _lang('plugin_extensions') ?></label>
                    <div id="post_bar">
                        <?php doAction('adm_writelog_head') ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div id="post_button">
                <input type="hidden" name="ishide" id="ishide" value="<?= $hide ?>" />
                <input type="hidden" name="as_logid" id="as_logid" value="<?= $logid ?>" />
                <input type="hidden" name="gid" id="gid" value="<?= $logid ?>" />
                <input type="hidden" name="author" id="author" value="<?= $author ?>" />
                <?php if ($logid < 0): ?>
                    <input type="submit" name="pubPost" id="pubPost" value="<?= _lang('publish_now') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <input type="button" name="savedf" id="savedf" value="<?= _lang('save_draft') ?>" onclick="autosave(2);" class="btn btn-primary btn-sm" />
                <?php else: ?>
                    <input type="submit" value="<?= _lang('save_and_return') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <input type="button" name="savedf" id="savedf" value="<?= _lang('save') ?>" onclick="autosave(2);" class="btn btn-primary btn-sm" />
                    <?php if ($isdraft) : ?>
                        <input type="submit" name="pubPost" id="pubPost" value="<?= _lang('publish') ?>" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <?php endif ?>
                <?php endif ?>
            </div>
            <div class="shadow-sm p-3 bg-white rounded" id="post_side">
                <div class="form-group">
                    <label><?= _lang('cover') ?>：</label>
                    <input name="cover" id="cover" class="form-control" maxlength="2048" placeholder="" value="<?= $cover ?>" />
                    <small class="text-muted"><?= _lang('cover_tip_1') ?><a href="#" data-toggle="modal" data-target="#mediaModal"><?= _lang('select_from_media_lib') ?></a></small>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="upload_img">
                                <img src="<?= $cover ?: './views/images/cover.svg' ?>" width="200" id="cover_image" class="rounded" alt="<?= _lang('cover_image') ?>" />
                                <input type="file" name="upload_img" class="image" id="upload_img" style="display:none" />
                                <button type="button" id="cover_rm" class="btn-sm btn btn-link" <?php if (!$cover): ?>style="display:none" <?php endif ?>>x</button>
                            </label>
                        </div>
                    </div>
                    <div class="custom-control custom-switch mt-1">
                        <input type="checkbox" class="custom-control-input" id="auto_cover" name="auto_cover" value="y" onclick="toggleCheckbox('auto_cover')">
                        <label class="custom-control-label" for="auto_cover"><?= _lang('auto_cover_from_content') ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <label><?= _lang('category') ?>：</label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="-1"><?= _lang('select_category') ?></option>
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
                    <label><?= _lang('tag') ?>：</label>
                    <?php if ($tags): ?>
                        <span class="small"> <a href="javascript:doToggle('tags', 1);"><?= _lang('recently_used_tags') ?></a></span>
                        <div id="tags" class="mb-2" style="display: none">
                            <?php
                            foreach ($tags as $val) {
                                echo " <a class=\"em-badge small em-badge-tag\" href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <input name="tag" id="tag" class="form-control" value="<?= $tagStr ?>" />
                    <small class="text-muted"><?= _lang('tag_tip_keywords') ?></small>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="allow_remark" name="allow_remark" value="y" <?= $is_allow_remark ?>>
                        <label class="custom-control-label" for="allow_remark"><?= _lang('allow_comment') ?></label>
                    </div>
                    <?php if (User::haveEditPermission()): ?>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="top" name="top" value="y" <?= $is_top; ?>>
                            <label class="custom-control-label" for="top"><?= _lang('home_top') ?></label>
                        </div>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="sortop" name="sortop" value="y" <?= $is_sortop; ?>>
                            <label class="custom-control-label" for="sortop"><?= _lang('sort_top') ?></label>
                        </div>
                    <?php endif; ?>
                </div>
                <?php if (User::haveEditPermission()): ?>
                    <div class="form-group">
                        <label><?= _lang('post_time') ?>：</label>
                        <input type="text" maxlength="200" name="postdate" id="postdate" value="<?= $postDate ?>" class="form-control datepicker" required />
                        <small class="text-muted"><?= _lang('future_post_tip') ?></small>
                    </div>
                    <div><a href="javascript:void (0);" class="show_adv_set" onclick="displayToggle('adv_set');"><?= _lang('advanced_options') ?><i class="icofont-simple-right"></i></a></div>
                <?php else: ?>
                    <input type="hidden" name="postdate" id="postdate" value="<?= $postDate ?>" />
                <?php endif; ?>
                <div id="adv_set">
                    <?php if (User::haveEditPermission()): ?>
                        <div class="form-group">
                            <label><?= _lang('link_alias') ?></label>
                            <input name="alias" id="alias" class="form-control" value="<?= $alias ?>" />
                            <small class="text-muted"><?= _lang('alias_tip_start') ?><a href="./setting.php?action=seo"><?= _lang('setting_seo') ?></a></small>
                        </div>
                        <div class="form-group">
                            <label><?= _lang('redirect_url') ?></label>
                            <input name="link" id="link" type="url" class="form-control" maxlength="2048" value="<?= $link ?>" placeholder="https://" />
                            <small class="text-muted"><?= _lang('redirect_url_tip') ?></small>
                        </div>
                        <div class="form-group">
                            <label><?= _lang('access_password') ?></label>
                            <input type="text" name="password" id="password" class="form-control" value="<?= $password ?>" />
                        </div>
                        <?php if ($customTemplates): ?>
                            <div class="form-group">
                                <label><?= _lang('article_template') ?></label>
                                <?php
                                $sortListHtml = '<option value="">' . _lang('default') . '</option>';
                                foreach ($customTemplates as $v) {
                                    $select = $v['filename'] == $template ? 'selected="selected"' : '';
                                    $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '" ' . $select . '>' . ($v['comment']) . '</option>';
                                }
                                ?>
                                <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                            </div>
                        <?php endif; ?>
                        <hr>
                    <?php endif; ?>
                    <div id="post_side_ext">
                        <?php doAction('adm_writelog_side') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="modal fade" id="mediaModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('media_lib') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div><a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm mb-3"><?= _lang('upload_file') ?></a></div>
                    <div>
                        <?php if (User::haveEditPermission() && $mediaSorts): ?>
                            <select class="form-control" id="media-sort-select">
                                <option value=""><?= _lang('select_media_category') ?></option>
                                <?php foreach ($mediaSorts as $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= $v['sortname'] ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php endif ?>
                    </div>
                </div>
                <form action="media.php?action=operate_media" method="post" name="form_media" id="form_media">
                    <div class="row" id="image-list"></div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm mt-2" id="load-more"><?= _lang('load_more') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 封面图裁剪 -->
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title"><?= _lang('upload_cover') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-11">
                            <img src="" id="sample_image" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <div><?= _lang('crop_tip') ?></div>
                <div>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="button" id="crop" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                    <button type="button" id="use_original_image" class="btn btn-sm btn-primary"><?= _lang('use_original_image') ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="dropzone-previews" style="display: none;"></div>
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./views/js/media-lib.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./editor.md/editormd.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $("#alias").keyup(function() {
        checkalias();
    });
    <?php if (!defined('ARTICLE_AUTOSAVE_OFF') || ARTICLE_AUTOSAVE_OFF !== true): ?>
        setTimeout(() => autosave(1), 60000);
    <?php endif; ?>
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_write").addClass('active');

    // 编辑器
    var Editor;
    $(function() {
        Editor = editormd("logcontent", {
            width: "100%",
            height: 745,
            toolbarIcons: function() {
                return ["bold", "del", "italic", "quote", "|", "h1", "h2", "h3", "|", "list-ul", "list-ol", "hr", "|",
                    "link", "image", "audio", "video", "code", "code-block", "table", "|", "search", "preview", "fullscreen", "help"
                ]
            },
            path: "editor.md/lib/",
            tex: false,
            watch: false,
            lineNumbers: false,
            htmlDecode: true,
            flowChart: false,
            autoFocus: false,
            sequenceDiagram: false,
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png"],
            imageUploadURL: "media.php?action=upload&editor=1",
            videoUpload: false,
            syncScrolling: "single",
            placeholder: "<?= _lang('markdown_placeholder') ?>",
            onfullscreen: function() {
                this.watch();
            },
            onfullscreenExit: function() {
                this.unwatch();
            },
            onload: function() {
                hooks.doAction("loaded", this);
            }
        });
        Editor.setToolbarAutoFixed(false);
    });

    // 封面图
    $(function() {
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_img').change(function(event) {
            var files = event.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            if (files && files.length > 0) {
                if (!files[0].type.startsWith('image')) {
                    alert('<?= _lang('only_image_allowed') ?>');
                    return;
                }
                reader = new FileReader();
                reader.onload = function(event) {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: NaN,
                viewMode: 1
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });

        // 上传图片
        function uploadImage(blob, filename) {
            var formData = new FormData();
            formData.append('image', blob, filename);
            $.ajax('./article.php?action=upload_cover', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    $modal.modal('hide');
                    if (data.code == 0) {
                        $('#cover_image').attr('src', data.data);
                        $('#cover').val(data.data);
                        $('#cover_rm').show();
                    } else {
                        alert(data.msg);
                    }
                },
                error: function(xhr) {
                    var data = xhr.responseJSON;
                    if (data && typeof data === "object") {
                        alert(data.msg);
                    } else {
                        alert("<?= _lang('upload_cover_error') ?>");
                    }
                }
            });
        }

        $('#crop').click(function() {
            canvas = cropper.getCroppedCanvas({
                width: 650,
                height: 366
            });
            canvas.toBlob(function(blob) {
                uploadImage(blob, 'cover.jpg')
            });
        });

        $('#use_original_image').click(function() {
            var blob = $('#upload_img')[0].files[0];
            uploadImage(blob, blob.name)
        });

        $('#cover_rm').click(function() {
            $('#cover_image').attr('src', "./views/images/cover.svg");
            $('#cover').val("");
            $('#cover_rm').hide();
        });
    });

    $('#cover').blur(function() {
        c = $('#cover').val();
        if (!c) {
            $('#cover_image').attr('src', "./views/images/cover.svg");
            $('#cover_rm').hide();
            return
        }
        $('#cover_image').attr('src', c);
        $('#cover_rm').show();
    });

    // 离开页面时，如果文章内容已做修改，则询问用户是否离开
    var articleTextRecord;
    var titleText = $('title').text();
    hooks.addAction("loaded", function() {
        articleTextRecord = $("textarea[name=logcontent]").text();
    });
    window.onbeforeunload = function(e) {
        if ($("textarea[name=logcontent]").text() == articleTextRecord) return
        e = e || window.event;
        if (e) e.returnValue = '<?= _lang('leave_page_prompt') ?>';
        return '<?= _lang('leave_page_prompt') ?>';
    }

    // 文章编辑界面全局快捷键 Ctrl（Cmd）+ S 保存内容
    document.addEventListener('keydown', function(e) {
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
            e.preventDefault();
            autosave(2);
        }
    });

    // 显示插件扩展label
    const postBar = $("#post_bar");
    if (postBar.children().length === 0) {
        $("#post_bar_label").hide();
    }

    // 自定义字段
    $(document).on('click', '.field_del', function() {
        $(this).closest('.field_list').remove();
    });
    $(document).on('click', '.field_add', function() {
        var newField = `
                    <div class="form-row field_list mb-3">
                        <div class="col-sm-3 px-2 my-1">
                            <input type="text" name="field_keys[]" list="customFieldList" value="" class="form-control field-keys-input" placeholder="<?= _lang('field_name') ?>" maxlength="120" required>
                            <datalist id="customFieldList">
                                <?php foreach ($customFields as $k => $v): ?>
                                    <option value="<?= $k ?>"><?= $k . '【' . $v['name'] . '】' . $v['description'] ?></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="col-sm-8 px-2 my-1">
                            <textarea name="field_values[]" value="" class="form-control auto-resize-textarea field-values-textarea" placeholder="<?= _lang('field_value') ?>" rows="1" style="resize: vertical; min-height: 33px; white-space: pre-wrap; overflow-x: auto;" required></textarea>
                        </div>
                        <div class="col-sm-1 px-2 my-1 d-flex align-items-start justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-danger field_del"><?= _lang('delete') ?></button>
                        </div>
                    </div>
                `;
        $('#field_box').append(newField);
        // 为新添加的textarea绑定自动调整高度功能
        autoResizeTextarea($('#field_box .auto-resize-textarea').last());
    });

    // 为现有的textarea绑定自动调整高度功能
    initAutoResizeTextareas();
    // 高级选项展开状态
    initDisplayState('adv_set');
    // 自动截取摘要状态
    initCheckboxState('auto_excerpt');
    // 自动提取封面状态
    initCheckboxState('auto_cover');
</script>