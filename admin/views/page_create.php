<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<form action="page.php?action=save" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <h1 class="h3 mb-4 text-gray-800"><?= $containertitle ?></h1>
    <div class="row">
        <div class="col-xl-12">
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?= $title ?>" class="form-control" placeholder="页面标题"/>
                </div>
                <div id="post_bar" class="small my-3">
                    <a href="#mediaModal" data-toggle="modal" data-target="#mediaModal"><i class="icofont-plus"></i>上传插入图片</a>
                    <?php doAction('adm_writelog_head') ?>
                </div>
                <div id="pagecontent"><textarea><?= $content ?></textarea></div>
            </div>

            <div class="form-group">
                <label>链接别名：（用于seo设置 <a href="./setting.php?action=seo">&rarr;</a>）</label>
                <input name="alias" id="alias" class="form-control" value="<?= $alias ?>"/>
            </div>
            <div class="form-group">
                <label>跳转链接：<small class="text-muted">（填写后不展示页面内容，直接跳转该地址）</small></label>
                <input name="link" id="link" type="url" class="form-control" value="<?= $link ?>" placeholder="https://"/>
            </div>
            <div class="form-group">
                <label>页面模板：</label>
                <?php if ($customTemplates):
                    $sortListHtml = '<option value="">默认</option>';
                    foreach ($customTemplates as $v) {
                        $select = $v['filename'] == $template ? 'selected="selected"' : '';
                        $sortListHtml .= '<option value="' . str_replace('.php', '', $v['filename']) . '" ' . $select . '>' . ($v['comment']) . '</option>';
                    }
                    ?>
                    <select id="template" name="template" class="form-control"><?= $sortListHtml; ?></select>
                    <small class="form-text text-muted">(选择当前模板支持的页面模板，可不选)</small>
                <?php else: ?>
                    <input class="form-control" id="template" name="template" value="<?= $template ?>">
                    <small class="form-text text-muted">(用于自定义页面模板，对应模板目录下xxx.php文件，xxx即为模板名，可不填)</small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?= $is_allow_remark ?> />
                <label for="allow_remark">允许评论</label>
            </div>
            <div class="form-group">
                <input type="checkbox" value="y" name="home_page" id="home_page" <?= $is_home_page ?> />
                <label for="allow_remark">设为首页，同时原默认首页将变更为：<?= BLOG_URL ?>posts</label>
            </div>
            <div id="post_button">
                <input type="hidden" name="ishide" id="ishide" value="<?= $hide ?>"/>
                <input type="hidden" name="pageid" value="<?= $pageId ?>"/>
                <?php if ($pageId < 0): ?>
                    <input type="submit" value="发布页面" onclick="return checkform();" class="btn btn-sm btn-success"/>
                <?php else: ?>
                    <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-sm btn-success"/>
                <?php endif ?>
            </div>
        </div>
    </div>
</form>
<!--资源库-->
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
<div class="dropzone-previews" style="display: none;"></div>
<script src="./views/js/dropzone.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./views/js/media-lib.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="./editor.md/editormd.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
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
                    "link", "image", "preformatted-text", "table", "|", "watch", "help"]
            },
            path: "editor.md/lib/",
            tex: false,
            flowChart: false,
            watch: false,
            htmlDecode: true,
            sequenceDiagram: false,
            syncScrolling: "single",
            onload: function () {
                hooks.doAction("page_loaded", this);
                //在大屏模式下，编辑器默认显示预览
                if ($(window).width() > 767) {
                    this.watch();
                }
            }
        });
        Editor.setToolbarAutoFixed(false);


    });
    // 离开页面时，如果页面内容已做修改，则询问用户是否离开
    var pageText;
    hooks.addAction("page_loaded", function () {
        pageText = $("textarea").text();
    });
    window.onbeforeunload = function (e) {
        if ($("textarea").text() == pageText) return
        e = e || window.event;
        if (e) e.returnValue = '离开页面提示';
        return '离开页面提示';
    }

    // 页面编辑界面全局快捷键 Ctrl（Cmd）+ S 保存内容
    document.addEventListener('keydown', function (e) {
        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
            e.preventDefault();
            pagesave();
        }
    });
</script>
