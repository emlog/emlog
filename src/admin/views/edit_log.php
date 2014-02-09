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
    <input type="text" maxlength="200" name="title" id="title" value="<?php echo $title; ?>" />
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset">上传插入</span>
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
    <label for="tag" id="tag_label">文章标签，逗号或空格分隔，过多的标签会影响系统运行效率</label>
    <input name="tag" id="tag" maxlength="200" value="<?php echo $tagStr; ?>" />
    <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);">已有标签+</a></span>
    <select name="sort" id="sort" style="width:130px;">
        <option value="-1">选择分类...</option>
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
    发布于：<input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo gmdate('Y-m-d H:i:s', $date); ?>"/>
    <input name="date" id="date" type="hidden" value="<?php echo $orig_date; ?>" >
</div>
<div id="tagbox">
<?php
    if ($tags) {
        foreach ($tags as $val){
            echo " <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
        }
    } else {
        echo '还没有设置过标签！';
    }
?>
</div>
<div class="show_advset" onclick="displayToggle('advset', 1);">高级选项</div>
<div id="advset">
<div>文章摘要：</div>
<div><textarea id="excerpt" name="excerpt" style="width:845px; height:260px; border:#CCCCCC solid 1px;"><?php echo $excerpt; ?></textarea></div>
<div><span id="alias_msg_hook"></span>文章链接别名：(用于自定义该篇文章的链接地址。需要<a href="./seo.php" target="_blank">启用文章链接别名</a>)</div>
<div><input name="alias" id="alias" value="<?php echo $alias;?>"/></div>
<div style="margin-top:3px;">
	文章访问密码：<input type="text" value="<?php echo $password; ?>" name="password" id="password" style="width:80px;" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
        <label for="top">首页置顶</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" <?php echo $is_allow_remark; ?> />
        <label for="allow_remark">允许评论</label>
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