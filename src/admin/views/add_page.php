<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/zh_CN.js"></script>
<div class=containertitle><b>新建页面</b><span id="msg_2"></span></div>
<div id="msg"></div>
<form action="page.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label">输入页面标题</label>
    <input type="text" maxlength="200" style="width:792px;" name="title" id="title"/>
    <input name="date" id="date" type="hidden" value="" >
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(4);" class="show_advset">上传插入</span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="-1">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="720" height="290" frameborder="0" src="attachment.php?action=selectFile"></iframe>
    </div>
</div>
<div><textarea id="content" name="content" style="width:800px; height:460px; border:#CCCCCC solid 1px;"></textarea></div>
<div>
    <span id="alias_msg_hook"></span>
    链接别名：(用于自定义该页面的链接地址。需要<a href="./permalink.php" target="_blank">启用链接别名</a>)<br />
    <input name="alias" id="alias" style="width:798px;" />
</div>
<div>
    <span id="page_options">
        <label for="allow_remark">页面接受评论</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" />
    </span>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="">
    <input type="submit" value="发布页面" onclick="return checkform();" class="button" />
    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(3);" class="button" />
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
$("#menu_page").addClass('sidebarsubmenu1');
$("#alias").keyup(function(){checkalias();});
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
</script>