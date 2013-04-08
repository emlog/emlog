<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $hide == 'y' ? true : false;
?>
<script charset="utf-8" src="./editor/kindeditor.js"></script>
<script charset="utf-8" src="./editor/lang/zh_CN.js"></script>
<div class=containertitle><b><?php if ($isdraft) :?>编辑草稿<?php else:?>编辑文章<?php endif;?></b><span id="msg_2"></span></div><div id="msg"></div>
<form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
<div id="post">
<div>
    <label for="title" id="title_label">输入文章标题</label>
    <input type="text" maxlength="200" style="width:710px;" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
    <a href="javascript: displayToggle('FrameUpload', 0);" class="thickbox"><b>上传和插入+</b></a>
    <span id="asmsg">
        <?php doAction('adm_writelog_head'); ?>
        <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
    </span><br />
    <div id="FrameUpload" style="display: none;">
        <iframe width="720" height="290" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe>
    </div>
</div>
<div>
    <textarea id="content" name="content" style="width:719px; height:460px; border:#CCCCCC solid 1px;"><?php echo $content; ?></textarea>
</div>
<div style="margin:10px 0px 5px 0px;">
    <label for="tag" id="tag_label">文章标签，逗号或空格分隔</label>
    <input name="tag" id="tag" maxlength="200" style="width:432px;" value="<?php echo $tagStr; ?>" />
    <select name="sort" id="sort" style="width:130px;">
     <?php
     $sorts[] = array('sid'=>-1, 'sortname'=>'选择分类...');
     foreach($sorts as $val):
         $flg = $val['sid'] == $sortid ? 'selected' : '';
     ?>
        <option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
     <?php endforeach; ?>
    </select>
    <input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo gmdate('Y-m-d H:i:s', $date); ?>"/>
    <input name="date" id="date" type="hidden" value="<?php echo $orig_date; ?>" >
</div>
<?php if (!empty($tags)):?>
<div style="color:#2A9DDB;cursor:pointer;"><a href="javascript:displayToggle('tagbox', 0);">选择已有标签+</a></div>
<?php endif; ?>
<div id="tagbox" style="width:688px;margin:0px 0px 0px 30px;display:none;">
<?php 
$tagStr = '';
foreach ($tags as $val){
    $tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
}
echo $tagStr;
?>
</div>
<div id="show_advset" onclick="displayToggle('advset', 1);"><b>高级选项</b></div>
<div id="advset">
<div><b>文章摘要：</b></div>
<div><textarea id="excerpt" name="excerpt" style="width:719px; height:260px; border:#CCCCCC solid 1px;"><?php echo $excerpt; ?></textarea></div>
<div><span id="alias_msg_hook"></span><b>链接别名：</b>(用于自定义该篇文章的链接地址。需要<a href="./permalink.php" target="_blank">启用链接别名</a>)</div>
<div><input name="alias" id="alias" value="<?php echo $alias;?>" style="width:711px;" /></div>
<?php if (Option::get('istrackback') == 'y'): ?>
<div><b>引用通告：</b>(每行一条引用地址)</div>
<div><textarea name="pingurl" id="pingurl" style="width:715px; height:50px;" class="input"></textarea></div>
<?php endif;?>
<div>          
    <b>文章访问密码：</b>
    <input type="text" value="<?php echo $password; ?>" name="password" id="password" style="width:80px;" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
        <label for="top">文章置顶</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
        <label for="allow_remark">允许评论</label>
        <input type="checkbox" value="y" id="allow_tb" name="allow_tb" <?php echo $is_allow_tb; ?> />
        <label for="allow_tb">允许引用</label>
    </span>
</div>
</div>
<div id="post_button">
    <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
    <input type="hidden" name="gid" value=<?php echo $logid; ?> />
    <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />
    <input type="submit" value="保存并返回" onclick="return checkform();" class="button" />
    <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="button" />
    <?php if ($isdraft) :?>
    <input type="submit" name="pubdf" id="pubdf" value="发布" onclick="return checkform();" class="button" />
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