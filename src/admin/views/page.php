<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><script charset="utf-8" src="./editor/kindeditor-all-min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<!--vot--><script charset="utf-8" src="./editor/lang/<?= EMLOG_LANGUAGE ?>.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<form action="page.php?action=save" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
<!--Article Content-->
<div class="col-lg-8">
    <div class="containertitle">
        <b><?php echo $containertitle; ?></b><span id="msg_2"></span>
    </div>
    <div id="msg"></div>
        <div id="post" class="form-group">
            <div>
<!--vot-->       <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?=lang('page_title')?>" />
            </div>
            <div id="post_bar">
                <div>
                    <span onclick="displayToggle('FrameUpload', 0);autosave(4);" class="show_advset"><?=lang('upload_insert')?></span>
                    <?php doAction('adm_writelog_head'); ?>
                    <span id="asmsg"></span>
                    <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $pageId; ?>">
                </div>
                <div id="FrameUpload" style="display: none;">
                    <iframe width="100%" height="330" frameborder="0" src="<?php echo $att_frame_url;?>"></iframe>
                </div>
            </div>
            <div>
                <textarea id="content" name="content" style="width:100%; height:460px;"><?php echo $content; ?></textarea>
            </div>
        </div>
    <div class=line></div>
</div>

<!--Article sidebar-->
<div class="col-lg-4 container-side">
    <div class="panel panel-default">
<!--vot--><div class="panel-heading"><?=lang('setting_items')?></div>
        <div class="panel-body">

            <div class="form-group">
<!--vot-->      <label><?=lang('link_alias')?>:</label>
                <input name="alias" id="alias" class="form-control" value="<?php echo $alias;?>" />
            </div>
            
            <div class="form-group">
<!--vot-->      <label><?=lang('page_template')?></label>
                <input name="template" id="template" class="form-control" value="<?php echo $template;?>" />
            </div>
            
            <div class="form-group">
            <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
<!--vot-->  <label for="allow_remark"><?=lang('allow_comments')?></label>
            </div>
           
        </div>
    </div>

    <div id="post_button">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
        <input type="hidden" name="gid" value=<?php echo $pageId; ?> />
        <?php if ($pageId < 0):?>
<!--vot--><input type="submit" value="<?=lang('page_publish')?>" onclick="return checkform();" class="btn btn-primary" />
<!--vot--><input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(3);" class="btn btn-success" />
        <?php else:?>
<!--vot--><input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="btn btn-primary" />
<!--vot--><input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(3);" class="btn btn-success" />
        <?php endif;?>
        
    </div>
</div>
</form>
<script>
/*vot*/$(function() {
/*vot*/  KindEditor.create('textarea[name="content"]');
/*vot*/  KindEditor.create('textarea[name="excerpt"]');
/*vot*/});
checkalias();
$("#alias").keyup(function(){checkalias();});
$("#menu_page").addClass('active');
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
if ($("#title").val() != '')$("#title_label").hide();
</script>
