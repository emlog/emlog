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
                <div id="post_bar">
                    <a href="#mediaModal" class="text-muted small my-3" data-remote="./media.php?action=lib" data-toggle="modal" data-target="#mediaModal"><i
                                class="icofont-plus"></i> 插入图文资源</a>
					<?php doAction('adm_writelog_head') ?>
                </div>
                <div id="pagecontent"><textarea><?= $content ?></textarea></div>
            </div>

            <div class="form-group">
                <label>链接别名：（用于seo设置 <a href="./setting.php?action=seo">&rarr;</a>）</label>
                <input name="alias" id="alias" class="form-control" value="<?= $alias ?>"/>
            </div>
            <div class="form-group">
                <label>页面模板：</label>
                <input name="template" id="template" class="form-control" value="<?= $template ?>"/>
            </div>
            <div class="form-group">
                <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?= $is_allow_remark ?> />
                <label for="allow_remark">允许评论</label>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input type="hidden" name="ishide" id="ishide" value="<?= $hide ?>" />
                <input type="hidden" name="pageid" value="<?= $pageId ?>" />
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
        maxFilesize: 2048,//M
        filesizeBase: 1024,
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

<script src="./editor.md/editormd.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
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
                    "link", "image", "preformatted-text", "table", "|", "watch","help"]
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
                    //在大屏模式下，编辑器默认显示预览
                    if($(window).width() > 767){
                        this.watch();
                    }
                    //添加Ctrl(Cmd)+S快捷键保存页面内容
                    var pageSave = {
                    "Ctrl-S": function(cm) {
                    	pagesave();
                    },
                    "Cmd-S": function(cm) {
                    	pagesave();
                    }};
                    this.addKeyMap(pageSave);  
            }
        });
        Editor.setToolbarAutoFixed(false);


    });
    // 离开页面时，如果页面内容已做修改，则询问用户是否离开
    var pageText;
    hooks.addAction("page_loaded", function(){
        pageText = $("textarea").text();
    });
    window.onbeforeunload = function (e) {
        if($("textarea").text() == pageText) return
        e = e || window.event;
        if (e) e.returnValue = '离开页面提示';
        return '离开页面提示';
    }
</script>
