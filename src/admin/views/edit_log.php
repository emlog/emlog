<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $hide == 'y' ? true : false;
?>
<!--vot--><script charset="utf-8" src="./editor/kindeditor-all-min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<!--vot--><script charset="utf-8" src="./editor/lang/<?= EMLOG_LANGUAGE ?>.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<!--vot--><div class=containertitle><b><?php if ($isdraft) :?><?=lang('draft_edit')?><?php else:?><?=lang('post_edit')?><?php endif;?></b><span id="msg_2"></span></div><div id="msg"></div>
<form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
<div id="post">
<div>
<!--vot--><label for="title" id="title_label"><?=lang('enter_post_title')?></label>
    <input type="text" maxlength="200" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
    <div>
<!--vot--><span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset"><?=lang('upload_insert')?></span>
        <?php doAction('adm_writelog_head'); ?>
        <span id="asmsg"></span>
        <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="860" height="330" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe>
    </div>
</div>
<div>
    <textarea id="content" name="content" style="width:845px; height:460px;"><?php echo $content; ?></textarea>
</div>
<div style="margin:10px 0px 5px 0px;">
<!--vot--><label for="tag" id="tag_label"><?=lang('post_tags_separated')?></label>
    <input name="tag" id="tag" maxlength="200" value="<?php echo $tagStr; ?>" />
<!--vot--><span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);"><?=lang('tags_have')?></a></span>
    <select name="sort" id="sort" style="width:130px;">
<!--vot--><option value="-1"><?=lang('category_select')?>...</option>
        <?php 
        foreach($sorts as $key=>$value):
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
<!--vot--><?=lang('post_time')?>: <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo gmdate('Y-m-d H:i:s', $date); ?>"/>
    <input name="date" id="date" type="hidden" value="<?php echo $orig_date; ?>" >
</div>
<div id="tagbox">
<?php
    if ($tags) {
        foreach ($tags as $val){
            echo " <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
        }
    } else {
        echo lang('tag_not_set');
    }
?>
</div>
<!--vot--><div class="show_advset" onclick="displayToggle('advset', 1);"><?=lang('advanced_options')?></div>
<div id="advset">
<!--vot--><div><?=lang('post_description')?>:</div>
<div><textarea id="excerpt" name="excerpt" style="width:845px; height:260px; border:#CCCCCC solid 1px;"><?php echo $excerpt; ?></textarea></div>
<!--vot--><div><span id="alias_msg_hook"></span><?=lang('post_alias')?>: (<?=lang('used_to_customize')?><a href="./seo.php" target="_blank"><?=lang('post_alias_enable')?></a>)</div>
<div><input name="alias" id="alias" value="<?php echo $alias;?>"/></div>
<div style="margin-top:3px;">
<!--vot--><?=lang('post_access_password')?>: <input type="text" value="<?php echo $password; ?>" name="password" id="password" style="width:80px;" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
<!--vot--><label for="top"><?=lang('home_top')?></label>
        <input type="checkbox" value="y" name="sortop" id="sortop" <?php echo $is_sortop; ?> />
<!--vot--><label for="sortop"><?=lang('category_top')?></label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
<!--vot--><label for="allow_remark"><?=lang('allow_comments')?></label>
    </span>
</div>
</div>
<div id="post_button">
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
    <input type="hidden" name="gid" value=<?php echo $logid; ?> />
    <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />
<!--vot--><input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="button" />
<!--vot--><input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(2);" class="button" />
    <?php if ($isdraft) :?>
<!--vot--><input type="submit" name="pubdf" id="pubdf" value="<?=lang('publish')?>" onclick="return checkform();" class="button" />
    <?php endif;?>
</div>
</div>
</form>
<div class=line></div>
<script>
/*vot*/$(function() {
/*vot*/  KindEditor.create('textarea[name="content"]');
/*vot*/  KindEditor.create('textarea[name="excerpt"]');
/*vot*/});
checkalias();
$("#alias").keyup(function(){checkalias();});
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
$("#title").focus(function(){$("#title_label").hide();});
$("#title").blur(function(){if($("#title").val() == '') {$("#title_label").show();}});
$("#tag").focus(function(){$("#tag_label").hide();});
$("#tag").blur(function(){if($("#tag").val() == '') {$("#tag_label").show();}});
if ($("#title").val() != '')$("#title_label").hide();
if ($("#tag").val() != '')$("#tag_label").hide();
setTimeout("autosave(0)",60000);
<?php if ($isdraft) :?>
$("#menu_draft").addClass('sidebarsubmenu1');
<?php else:?>
$("#menu_log").addClass('sidebarsubmenu1');
<?php endif;?>
</script>