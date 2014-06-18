<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<!--vot--><script charset="utf-8" src="./editor/lang/<? echo str_replace('-','_', EMLOG_LANGUAGE); ?>.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<!--vot--><div class=containertitle><b><?=lang('page_edit')?></b><span id="msg_2"></span></div>
<div id="msg"></div>
<form action="page.php?action=edit" method="post" id="addlog" name="addlog">
<div id="post">
<div>
<!--vot--><label for="title" id="title_label"><?=lang('page_title_info')?></label>
    <input type="text" maxlength="200" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
    <div>
<!--vot-->  <span onclick="displayToggle('FrameUpload', 0);autosave(4);" class="show_advset"><?=lang('upload_insert')?></span>
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
<!--vot--> <?=lang('link_alias')?>: (<?=lang('link_alias_info')?> <a href="./seo.php" target="_blank"><?=lang('link_alias_enable')?></a>)<br />
    <input name="alias" id="alias" value="<?php echo $alias; ?>" class="input" />
</div>
<div style="margin-top:3px;">
<!--vot--><?=lang('page_template')?><input maxlength="200" class="input" name="template" id="template" value="<?php echo $template;?>" /> <?=lang('page_template_info')?>
    <div id="page_options">
<!--vot--><label for="allow_remark"><?=lang('page_enable_comments')?></label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
    </div>
</div>
<div id="post_button">
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
    <input type="hidden" name="gid" value=<?php echo $pageId; ?> />
<!--vot--><input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="button" />
<!--vot--><input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(3);" class="button" />
</div>
</div>
</form>
<div class=line></div>
<script>
KindEditor.ready(function(K) {
	var editor1 = KindEditor.create('#content', {
	});
});
checkalias();
$("#alias").keyup(function(){checkalias();});
$("#menu_page").addClass('sidebarsubmenu1');
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
if ($("#title").val() != '')$("#title_label").hide();
</script>