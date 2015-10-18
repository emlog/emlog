<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<script charset="utf-8" src="./editor/kindeditor-all-min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script charset="utf-8" src="./editor/lang/en.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>

<form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
<!--Article Content-->
<div class="col-lg-8">
    <div class="containertitle">
        <b><?php echo $containertitle; ?></b><span id="msg_2"></span>
    </div>
    <div id="msg"></div>
        <div id="post" class="form-group">
            <div>
<!--vot-->      <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="<?=lang('post_title')?>" />
            </div>
            <div id="post_bar">
                <div class="show_advset">
<!--vot-->          <span onclick="displayToggle('FrameUpload', 0);autosave(1);"><?=lang('upload_insert')?><i class="fa fa-caret-right fa-fw"></i></span>
                    <?php doAction('adm_writelog_head'); ?>
                    <span id="asmsg"></span>
                    <input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>">
                </div>
                <div id="FrameUpload" style="display: none;">
                    <iframe width="100%" height="330" frameborder="0" src="<?php echo $att_frame_url;?>"></iframe>
                </div>
            </div>
            <div>
                <textarea id="content" name="content" style="width:100%; height:460px;"><?php echo $content; ?></textarea>
            </div>
<!--vot-->  <div class="show_advset" onclick="displayToggle('advset', 1);"><?=lang('advanced_options')?><i class="fa fa-caret-right fa-fw"></i></div>
            <div id="advset">
<!--vot-->      <div><?=lang('post_description')?>:</div>
                <div><textarea id="excerpt" name="excerpt" style="width:100%; height:260px;"><?php echo $excerpt; ?></textarea></div>
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
            <select name="sort" id="sort" class="form-control">
<!--vot-->          <option value="-1"><?=lang('category_select')?></option>
                    <?php
                    foreach ($sorts as $key => $value):
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
            </div>
            
            <div class="form-group">
<!--vot-->  <label><?=lang('tags')?>:</label>
<!--vot-->  <input name="tag" id="tag" class="form-control" value="<?php echo $tagStr; ?>" placeholder="<?=lang('post_tags_separated')?>" />
<!--vot-->  <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);"><?=lang('tags_have')?></a></span>
            <div id="tagbox" style="display: none;">
                <?php
                if ($tags) {
                    foreach ($tags as $val) {
                        echo " <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                    }
                } else {
/*vot*/             echo lang('tag_not_set');
                }
                ?>
            </div>
            </div>

            <div class="form-group">
<!--vot-->  <label><?=lang('publish_time')?></label>
            <input maxlength="200" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control" />
            </div>
            
            <div class="form-group">
<!--vot-->      <label><?=lang('link_alias')?>:</label>
                <input name="alias" id="alias" class="form-control" value="<?php echo $alias;?>" />
            </div>
            
            <div class="form-group">
<!--vot-->      <label><?=lang('access_password')?>:</label>
                <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>" />
            </div>
            
            <div class="form-group">
            <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
<!--vot-->  <label for="top"><?=lang('home_top')?></label>
            <input type="checkbox" value="y" name="sortop" id="sortop" <?php echo $is_sortop; ?> />
<!--vot-->  <label for="sortop"><?=lang('category_top')?></label>
            <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" <?php echo $is_allow_remark; ?> />
<!--vot-->  <label for="allow_remark"><?=lang('allow_comments')?></label>
            </div>
        </div>
    </div>

    <div id="post_button">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
        <input type="hidden" name="gid" value=<?php echo $logid; ?> />
        <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />

        <?php if ($logid < 0):?>
<!--vot--><input type="submit" value="<?=lang('post_publish')?>" onclick="return checkform();" class="btn btn-primary" />
<!--vot--><input type="button" name="savedf" id="savedf" value="<?=lang('save_draft')?>" onclick="autosave(2);" class="btn btn-success" />
        <?php else:?>
<!--vot--><input type="submit" value="<?=lang('save_and_return')?>" onclick="return checkform();" class="btn btn-primary" />
<!--vot--><input type="button" name="savedf" id="savedf" value="<?=lang('save')?>" onclick="autosave(2);" class="btn btn-success" />
        <?php if ($isdraft) :?>
<!--vot--><input type="submit" name="pubdf" id="pubdf" value="<?=lang('publish')?>" onclick="return checkform();" class="btn btn-success" />
        <?php endif;?>
        <?php endif;?>
        
    </div>
</div>
</form>
<script>
/*vot*/	$(function() {
/*vot*/		KindEditor.create('textarea[name="content"]');
/*vot*/	});
/*vot*/	$(function() {
/*vot*/		KindEditor.create('textarea[name="excerpt"]');
/*vot*/	});

    $("#menu_wt").addClass('active');
    $("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
    $("#alias").keyup(function () {
        checkalias();
    });
    setTimeout("autosave(0)", 60000);
    $("#menu_wt").addClass('active');
</script>
