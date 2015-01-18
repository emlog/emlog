<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<script charset="utf-8" src="./editor/kindeditor.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script charset="utf-8" src="./editor/lang/zh_CN.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>

<form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
<!--文章内容-->
<div class="col-lg-8">
    <div class="containertitle">
        <b><?php echo $containertitle; ?></b><span id="msg_2"></span>
    </div>
    <div id="msg"></div>
        <div id="post" class="form-group">
            <div>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="form-control" placeholder="文章标题" />
            </div>
            <div id="post_bar">
                <div>
                    <span onclick="displayToggle('FrameUpload', 0);autosave(1);" class="show_advset">上传插入</span>
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
            <div class="show_advset" onclick="displayToggle('advset', 1);">高级选项</div>
            <div id="advset">
                <div>文章摘要：</div>
                <div><textarea id="excerpt" name="excerpt" style="width:100%; height:260px;"><?php echo $excerpt; ?></textarea></div>
            </div>
        </div>
    <div class=line></div>
</div>

<!--文章侧边栏-->
<div class="col-lg-4 container-side">
    <div class="panel panel-default">
        <div class="panel-heading">设置项</div>
        <div class="panel-body">
            <div class="form-group">
            <select name="sort" id="sort" class="form-control">
                    <option value="-1">选择分类...</option>
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
            <label>标签：</label>
            <input name="tag" id="tag" class="form-control" value="<?php echo $tagStr; ?>" placeholder="文章标签，逗号或空格分隔，过多的标签会影响系统运行效率" />
            <span style="color:#2A9DDB;cursor:pointer;margin-right: 40px;"><a href="javascript:displayToggle('tagbox', 0);">已有标签+</a></span>
            <div id="tagbox" style="display: none;">
                <?php
                if ($tags) {
                    foreach ($tags as $val) {
                        echo " <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
                    }
                } else {
                    echo '还没有设置过标签！';
                }
                ?>
            </div>
            </div>

            <div class="form-group">
            <label>发布时间：</label>
            <input maxlength="200" name="postdate" id="postdate" value="<?php echo $postDate; ?>" class="form-control" />
            <input name="date" id="date" type="hidden" value="<?php echo $orig_date; ?>" >
            </div>
            
            <div class="form-group">
                <input name="alias" id="alias" class="form-control" value="<?php echo $alias;?>" placeholder="文章链接别名" />
            </div>
            
            <div class="form-group">
                <input type="text" value="" name="password" id="password" class="form-control" value="<?php echo $password; ?>" placeholder="文章访问密码" />
            </div>
            
            <div class="form-group">
            <input type="checkbox" value="y" name="top" id="top" <?php echo $is_top; ?> />
            <label for="top">首页置顶</label>
            <input type="checkbox" value="y" name="sortop" id="sortop" <?php echo $is_sortop; ?> />
            <label for="sortop">分类置顶</label>
            <input type="checkbox" value="y" name="allow_remark" id="allow_remark" checked="checked" <?php echo $is_allow_remark; ?> />
            <label for="allow_remark">允许评论</label>
            </div>
        </div>
    </div>

    <div id="post_button">
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>" />
        <input type="hidden" name="gid" value=<?php echo $logid; ?> />
        <input type="hidden" name="author" id="author" value=<?php echo $author; ?> />

        <?php if ($logid < 0):?>
        <input type="submit" value="发布文章" onclick="return checkform();" class="btn btn-primary" />
        <input type="button" name="savedf" id="savedf" value="保存草稿" onclick="autosave(2);" class="btn btn-success" />
        <?php else:?>
        <input type="submit" value="保存并返回" onclick="return checkform();" class="btn btn-primary" />
        <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="btn btn-success" />
        <?php if ($isdraft) :?>
        <input type="submit" name="pubdf" id="pubdf" value="发布" onclick="return checkform();" class="btn btn-success" />
        <?php endif;?>
        <?php endif;?>
        
    </div>
</div>
</form>
<script>
    loadEditor('content');
    loadEditor('excerpt');
    $("#menu_wt").addClass('active');
    $("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
    $("#alias").keyup(function () {
        checkalias();
    });
    setTimeout("autosave(0)", 60000);
    
    <?php if ($isdraft) :?>
    $("#menu_draft").addClass('active');
    <?php else:?>
    $("#menu_log").addClass('active');
    <?php endif;?>
</script>
