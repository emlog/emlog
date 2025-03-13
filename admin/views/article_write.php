<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div id="msg" class="fixed-top alert" style="display: none"></div>
<h4 class="mb-4 text-gray-800"><?= $containerTitle ?> <span id="save_info"></span></h4>
<form action="article_save.php" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <div class="row">
        <div class="col-xl-9">
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?= $title ?>" class="form-control" placeholder="标题" autofocus required />
                </div>
                <div class="small my-3">
                    <a href="#mediaModal" data-toggle="modal" data-target="#mediaModal"><i class="icofont-plus"></i>资源媒体库</a>
                    <?php doAction('adm_writelog_bar') ?>
                </div>
                <div id="logcontent"><textarea><?= $content ?></textarea></div>
                <div class="mt-3">
                    摘要（选填）：
                    <input type="checkbox" value="y" name="auto_excerpt" id="auto_excerpt" onclick="toggleCheckbox('auto_excerpt')">
                    <label for="auto_excerpt" style="margin-right: 8px;">自动截取摘要</label>
                    <textarea id="logexcerpt" name="logexcerpt" class="form-control" rows="5"><?= $excerpt ?></textarea>
                </div>
                <div class="mt-3">
                    <a href="javascript:void (0);" class="field_add small"><i class="icofont-plus"></i>添加字段</a>
                    <div class="mt-2" id="field_box">
                        <?php
                        foreach ($fields as $key => $value): ?>
                            <div class="form-row field_list">
                                <div class="col-sm-4">
                                    <input type="text" name="field_keys[]" value="<?= $key ?>" id="field_keys" class="form-control" placeholder="字段名称" maxlength="120" required>
                                </div>
                                <div class="col-sm-6 mx-sm-3">
                                    <input type="text" name="field_values[]" value="<?= $value ?>" id="field_values" class="form-control" placeholder="字段值" required>
                                </div>
                                <div class="col-auto mt-1 text-align-right">
                                    <button type="button" class="btn btn-sm btn-outline-danger field_del">删除</button>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <div class="mt-3">
                    <label id="post_bar_label">插件扩展：</label>
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
                    <input type="submit" name="pubPost" id="pubPost" value="立即发布" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn btn-primary btn-sm" />
                <?php else: ?>
                    <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="btn btn-primary btn-sm" />
                    <?php if ($isdraft) : ?>
                        <input type="submit" name="pubPost" id="pubPost" value="发布" onclick="return checkform();" class="btn btn-success btn-sm" />
                    <?php endif ?>
                <?php endif ?>
            </div>
            <div class="shadow-sm p-3 bg-white rounded" id="post_side">
                <div class="form-group">
                    <label>封面图：</label>
                    <input name="cover" id="cover" class="form-control" placeholder="" value="<?= $cover ?>" />
                    <small class="text-muted">填写封面图URL或点击下方上传</small>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label for="upload_img">
                                <img src="<?= $cover ?: './views/images/cover.svg' ?>" width="200" id="cover_image" class="rounded" alt="封面图片" />
                                <input type="file" name="upload_img" class="image" id="upload_img" style="display:none" />
                                <button type="button" id="cover_rm" class="btn-sm btn btn-link" <?php if (!$cover): ?>style="display:none" <?php endif ?>>x</button>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
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
                    <?php if ($tags): ?>
                        <span class="small"> <a href="javascript:doToggle('tags', 1);">近期使用的+</a></span>
                        <div id="tags" class="mb-2" style="display: none">
                            <?php
                            foreach ($tags as $val) {
                                echo " <a class=\"em-badge small em-badge-tag\" href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <input name="tag" id="tag" class="form-control" value="<?= $tagStr ?>" />
                    <small class="text-muted">也用于页面关键词，英文逗号分隔</small>
                </div>
                <?php if (User::haveEditPermission()): ?>
                    <div class="form-group">
                        <label>发布时间：</label>
                        <input type="text" maxlength="200" name="postdate" id="postdate" value="<?= $postDate ?>" class="form-control datepicker" required />
                        <small class="text-muted">当设置未来时间，文章将在该时间点定时发布</small>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?= $is_allow_remark ?> />
                        <label for="allow_remark" style="margin-right: 8px;">允许评论</label>
                        <input type="checkbox" value="y" name="top" id="top" <?= $is_top; ?> />
                        <label for="top" style="margin-right: 8px;">首页置顶</label>
                        <input type="checkbox" value="y" name="sortop" id="sortop" <?= $is_sortop; ?> />
                        <label for="sortop" style="margin-right: 8px;">分类置顶</label>
                    </div>
                    <div><a href="javascript:void (0);" class="show_adv_set" onclick="displayToggle('adv_set');">高级选项<i class="icofont-simple-right"></i></a></div>
                <?php else: ?>
                    <input type="hidden" name="postdate" id="postdate" value="<?= $postDate ?>" />
                    <input type="hidden" value="y" name="allow_remark" id="allow_remark" />
                <?php endif; ?>
                <div id="adv_set">
                    <?php if (User::haveEditPermission()): ?>
                        <div class="form-group">
                            <label>链接别名：</label>
                            <input name="alias" id="alias" class="form-control" value="<?= $alias ?>" />
                            <small class="text-muted">英文字母、数字组成，用于<a href="./setting.php?action=seo">seo设置</a></small>
                        </div>
                        <div class="form-group">
                            <label>跳转链接：</label>
                            <input name="link" id="link" type="url" class="form-control" value="<?= $link ?>" placeholder="https://" />
                            <small class="text-muted">填写后不展示文章内容直接跳转该地址</small>
                        </div>
                        <div class="form-group">
                            <label>访问密码：</label>
                            <input type="text" name="password" id="password" class="form-control" value="<?= $password ?>" />
                        </div>
                        <?php if ($customTemplates): ?>
                            <div class="form-group">
                                <label>文章模板：</label>
                                <?php
                                $sortListHtml = '<option value="">默认</option>';
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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">资源媒体库</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div><a href="#" id="mediaAdd" class="btn btn-sm btn-success shadow-sm mb-3">上传图片/文件</a></div>
                    <div>
                        <?php if (User::haveEditPermission() && $mediaSorts): ?>
                            <select class="form-control" id="media-sort-select">
                                <option value="">选择资源分类…</option>
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
                        <button type="button" class="btn btn-success btn-sm mt-2" id="load-more">加载更多…</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 封面图裁剪 -->
<div class="modal fade" id="modal" tabindex="-2" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">上传封面</h5>
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
                <div>按住 Shift 等比例调整裁剪区域</div>
                <div>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="button" id="crop" class="btn btn-sm btn-success">保存</button>
                    <button type="button" id="use_original_image" class="btn btn-sm btn-primary">使用原图</button>
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
    setTimeout("autosave(1)", 60000);
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
                    "link", "image", "audio", "video", "code", "preformatted-text", "code-block", "table", "|", "search", "preview", "fullscreen", "help"
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
            videoUpload: false, //开启视频上传
            syncScrolling: "single",
            placeholder: "使用 Markdown 开始你的创作吧...",
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
                    alert('只能上传图片');
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
                        alert("上传封面出错了");
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
        if (e) e.returnValue = '离开页面提示';
        return '离开页面提示';
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
                    <div class="form-row field_list">
                        <div class="col-sm-4">
                            <input type="text" name="field_keys[]" value="" id="field_keys" class="form-control" placeholder="字段名称" maxlength="120" required>
                        </div>
                        <div class="col-sm-6 mx-sm-3">
                            <input type="text" name="field_values[]" value="" id="field_values" class="form-control" placeholder="字段值" required>
                        </div>
                        <div class="col-auto mt-1">
                            <button type="button" class="btn btn-sm btn-outline-danger field_del">删除</button>
                        </div>
                    </div>
                `;
        $('#field_box').append(newField);
    });

    // 高级选项展开状态
    initDisplayState('adv_set');
    // 自动截取摘要状态
    initCheckboxState('auto_excerpt');
</script>