<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $hide == 'y' ? true : false;
?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/<? echo str_replace('-','_', EMLOG_LANGUAGE); ?>.js"></script>
<script>var EMLOG_LANG = '<? echo str_replace('-','_', EMLOG_LANGUAGE); ?>';</script>
<div class=containertitle><b><?php if ($isdraft) :?><? echo $lang['draft_edit']; ?><?php else:?><? echo $lang['post_edit']; ?><?php endif;?></b><span id="msg_2"></span></div><div id="msg"></div>
<form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label"><? echo $lang['title'];?></label>
    <input type="text" maxlength="200" style="width:852px;" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset"><? echo $lang['attachment_manager'];?></span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="860" height="330" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe>
    </div>
</div>
<div>
    <textarea id="content" name="content" style="width:860px; height:460px; border:#CCCCCC solid 1px;"><?php echo $content; ?></textarea>
</div>
<div style="margin:10px 0px 5px 0px;">
    <label for="tag" id="tag_label"><? echo $lang['tags_by_comma']; ?></label>
    <input name="tag" id="tag" maxlength="200" style="width:429px;" value="<?php echo $tagStr; ?>" />
    <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);"><? echo $lang['tags_current']; ?>+</a></span>
    <select name="sort" id="sort" style="width:200px;">
     <?php
     $sorts[] = array('sid'=>-1, 'sortname'=>$lang['choose_category'].'...');
     foreach($sorts as $val):
         $flg = $val['sid'] == $sortid ? 'selected' : '';
     ?>
        <option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
     <?php endforeach; ?>
    </select>
    <? echo $lang['posted_on']; ?>: <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo gmdate('Y-m-d H:i:s', $date); ?>"/>
    <input name="date" id="date" type="hidden" value="<?php echo $orig_date; ?>" >
</div>
<div id="tagbox" style="width:860px;margin:0px;display:none;">
<?php
    if ($tags) {
        foreach ($tags as $val){
            echo " <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
        }
    } else {
        echo $lang['no_tags_yet'];
    }
?>
</div>
<div class="show_advset" onclick="displayToggle('advset', 1);"><? echo $lang['advanced_options']; ?></div>
<div id="advset">
<div><? echo $lang['article_summary']; ?>:</div>
<div><textarea id="excerpt" name="excerpt" style="width:860px; height:260px; border:#CCCCCC solid 1px;"><?php echo $excerpt; ?></textarea></div>
<div><span id="alias_msg_hook"></span><? echo $lang['article_link_alias']; ?>: (<? echo $lang['link_alias_need_to']; ?> <a href="./seo.php" target="_blank"><? echo $lang['link_alias_enable']; ?></a>)</div>
<div><input name="alias" id="alias" value="<?php echo $alias;?>" style="width:856px;" /></div>
<div>
	<? echo $lang['post_password']; ?>:
    <input type="text" value="<?php echo $password; ?>" name="password" id="password" style="width:80px;" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
        <label for="top"><? echo $lang['post_pin']; ?></label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
        <label for="allow_remark"><? echo $lang['comments_allow']; ?></label>
    </span>
</div>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
    <input type="hidden" name="gid" value=<?php echo $logid; ?> />
    <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />
    <input type="submit" value="<? echo $lang['post_save_and_return'];?>" onclick="return checkform();" class="button" />
    <input type="button" name="savedf" id="savedf" value="<? echo $lang['post_save_draft'];?>" onclick="autosave(2);" class="button" />
    <?php if ($isdraft) :?>
    <input type="submit" name="pubdf" id="pubdf" value="<? echo $lang['publish']; ?>" onclick="return checkform();" class="button" />
    <?php endif;?>
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
loadEditor('excerpt');
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