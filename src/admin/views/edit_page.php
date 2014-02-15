<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/<? echo str_replace('-','_', EMLOG_LANGUAGE); ?>.js"></script>
<script>var EMLOG_LANG = '<? echo str_replace('-','_', EMLOG_LANGUAGE); ?>';</script>
<div class=containertitle><b><? echo $lang['page_edit'];?></b><span id="msg_2"></span></div>
<div id="msg"></div>
<form action="page.php?action=edit" method="post" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label"><? echo $lang['title'];?></label>
    <input type="text" maxlength="200" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
    <div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(4);" class="show_advset"><? echo $lang['upload_insert']; ?></span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $pageId; ?>">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="860" height="330" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $pageId; ?>"></iframe>
    </div>
</div>
<div><textarea id="content" name="content" style="width:845px; height:460px;"><?php echo $content; ?></textarea></div>
<div style="margin-top: 5px;">
    <span id="alias_msg_hook"></span>
    <? echo $lang['link_alias']; ?>: (<? echo $lang['alias_prompt']; ?> <? echo $lang['need_for']; ?><a href="./seo.php" target="_blank"><? echo $lang['link_alias_enable']; ?></a>)<br />
    <input name="alias" id="alias" value="<?php echo $alias; ?>" class="input" />
</div>
<div style="margin-top:3px;">
    <? echo $lang['page_template']; ?>: <input maxlength="200" class="input" name="template" id="template" value="<?php echo $template;?>" /> <? echo $lang['page_template_file']; ?>
    <span id="page_options">
    <label for="allow_remark"><? echo $lang['page_comments_allow']; ?></label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
    </span>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
    <input type="hidden" name="gid" value=<?php echo $pageId; ?> />
    <input type="submit" value="<? echo $lang['post_save_and_return']; ?>" onclick="return checkform();" class="button" />
    <input type="button" name="savedf" id="savedf" value="<? echo $lang['save']; ?>" onclick="autosave(3);" class="button" />
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
checkalias();
$("#alias").keyup(function(){checkalias();});
$("#menu_page").addClass('sidebarsubmenu1');
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
if ($("#title").val() != '')$("#title_label").hide();
</script>