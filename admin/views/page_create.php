<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<form action="page.php?action=save" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $containertitle; ?></h1><span id="msg_2"></span>
    <div class="row">
        <div class="col-xl-12">
            <div id="msg"></div>
            <div id="post" class="form-group">
                <div>
                    <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="页面标题"/>
                </div>
                <div id="post_bar">
                    <a href="#" class="text-muted small my-3" data-toggle="modal" data-target="#addModal"><i class="icofont-plus"></i> 上传文件\图片</a>
					<?php doAction('adm_writelog_head'); ?>
                    <span id="asmsg"></span>
                    <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $pageId; ?>">
                </div>
                <div id="pagecontent">
                    <textarea name="content"><?php echo $content; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label>链接别名：</label>
                <input name="alias" id="alias" class="form-control" value="<?php echo $alias; ?>"/>
            </div>
            <div class="form-group">
                <label>页面模板：</label>
                <input name="template" id="template" class="form-control" value="<?php echo $template; ?>"/>
            </div>
            <div class="form-group">
                <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
                <label for="allow_remark">允许评论</label>
            </div>

            <div id="post_button">
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>"/>
                <input type="hidden" name="gid" value=<?php echo $pageId; ?>/>
				<?php if ($pageId < 0): ?>
                    <input type="submit" value="发布页面" onclick="return checkform();" class="btn btn-success"/>
                    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(3);" class="btn btn-success"/>
				<?php else: ?>
                    <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-success"/>
                    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(3);" class="btn btn-success"/>
				<?php endif; ?>

            </div>
        </div>
    </div>
</form>

<!--资源库-->
<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">资源库</h5>
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
    setTimeout(hideActived, 2600);

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
                    "bold", "del", "italic", "quote", "uppercase", "lowercase", "|",
                    "h1", "h2", "h3", "h4", "h5", "h6", "|",
                    "list-ul", "list-ol", "hr", "|",
                    "link", "image", "preformatted-text", "table", "pagebreak", "|",
                    "goto-line", "watch", "preview", "search", "|", "info"]
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
