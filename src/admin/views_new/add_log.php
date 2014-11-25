<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script charset="utf-8" src="./editor/lang/zh_CN.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<div class="containertitle">
    <b>写文章</b><span id="msg_2"></span>
</div>
<div id="msg"></div>
<form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog" class="form-inline">
<div id="post" class="form-group">
<div>
    <input type="text" name="title" id="title" class="form-control" placeholder="文章标题" />
</div>
<div id="post_bar">
	<div>
	    <span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset">上传插入</span>
	    <?php doAction('adm_writelog_head'); ?>
	    <span id="asmsg"></span>
	    <input type="hidden" name="as_logid" id="as_logid" value="-1">
    </div>
    <div id="FrameUpload" style="display: none;">
        <iframe width="860" height="330" frameborder="0" src="attachment.php?action=selectFile"></iframe>
    </div>
</div>
<div>
    <textarea id="content" name="content" style="width:860px; height:460px;"></textarea>
</div>
<div style="margin:10px 0px 5px 0px;">
    <input name="tag" id="tag" class="form-control" placeholder="文章标签，逗号或空格分隔，过多的标签会影响系统运行效率" />
    <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);">已有标签+</a></span>
    <select name="sort" id="sort" style="width:130px;" class="form-control">
        <option value="-1">选择分类...</option>
        <?php 
        foreach($sorts as $key=>$value):
        if ($value['pid'] != 0) {
            continue;
        }
        ?>
        <option value="<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></option>
        <?php
            $children = $value['children'];
            foreach ($children as $key):
            $value = $sorts[$key];
        ?>
        <option value="<?php echo $value['sid']; ?>">&nbsp; &nbsp; &nbsp; <?php echo $value['sortname']; ?></option>
        <?php
        endforeach;
        endforeach;
        ?>
    </select>
    发布于：<input maxlength="200" style="width:139px;" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control" />
    <input name="date" id="date" type="hidden" value="" >
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
<div><textarea id="excerpt" name="excerpt" style="width:860px; height:260px;"></textarea></div>
<div><span id="alias_msg_hook"></span>文章链接别名：(用于自定义文章链接。需要<a href="./seo.php" target="_blank">启用文章链接别名</a>)<span id="alias_msg_hook"></span></div>
<div><input name="alias" id="alias" class="form-control" /></div>
<div style="margin-top:3px;">
	<input type="text" value="" name="password" id="password" style="width:120px;" class="form-control" placeholder="文章访问密码" />
    <span id="post_options">
        <input type="checkbox" value="y" name="top" id="top" />
        <label for="top">首页置顶</label>
		<input type="checkbox" value="y" name="sortop" id="sortop" />
        <label for="sortop">分类置顶</label>
        <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" />
        <label for="allow_remark">允许评论</label>
    </span>
</div>
</div>
<div id="post_button">
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
    <input type="hidden" name="ishide" id="ishide" value="">
    <input type="submit" value="发布文章" onclick="return checkform();" class="btn btn-primary" />
    <input type="hidden" name="author" id="author" value=<?php echo UID; ?> />
    <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn btn-success" />
</div>
</div>
</form>
<div class=line></div>
<script>
loadEditor('content');
loadEditor('excerpt');
$("#menu_wt").addClass('active');
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
$("#alias").keyup(function(){checkalias();});
setTimeout("autosave(0)",60000);
</script>
