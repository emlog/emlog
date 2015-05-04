<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>编辑分类</h1>
    <div class="containertitle">
    <?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">分类名称不能为空</span><?php endif;?>
    <?php if(isset($_GET['error_c'])):?><span class="alert alert-danger">别名格式错误</span><?php endif;?>
    <?php if(isset($_GET['error_d'])):?><span class="alert alert-danger">别名不能重复</span><?php endif;?>
    <?php if(isset($_GET['error_e'])):?><span class="alert alert-danger">别名不得包含系统保留关键字</span><?php endif;?>
    </div>
</section>
<section class="content">
<form action="sort.php?action=update" method="post" class="form-inline">
<div class="form-group">
    <li>
        <input style="width:200px;" value="<?php echo $sortname; ?>" name="sortname" id="sortname" class="form-control" />
        <label>名称</label>
    </li>
    <li>
        <input style="width:200px;" value="<?php echo $alias; ?>" name="alias" id="alias" class="form-control" />
        <label>别名</label>
    </li>
    <?php if (empty($sorts[$sid]['children'])): ?>
    <li>
        <select name="pid" id="pid" class="form-control" style="width:200px;">
<!--vot-->        <option value="0"<?php if($pid == 0):?> selected="selected"<?php endif; ?>><?=lang('no')?></option>
            <?php
                foreach($sorts as $key=>$value):
                    if ($key == $sid || $value['pid'] != 0) continue;
            ?>
            <option value="<?php echo $key; ?>"<?php if($pid == $key):?> selected="selected"<?php endif; ?>><?php echo $value['sortname']; ?></option>
            <?php endforeach; ?>
        </select>
        <label>父分类</label>
    </li>
    <?php endif; ?>
    <li><input maxlength="200" style="width:200px;" class="form-control" name="template" id="template" value="<?php echo $template; ?>" /> 模板 (用于自定义分类页面模板，对应模板目录下.php文件)</li>
    <li>
        <textarea name="description" type="text" style="width:360px;height:80px;overflow:auto;" class="form-control" placeholder="分类描述"><?php echo $description; ?></textarea>
    </li>
    <li>
    <input type="hidden" value="<?php echo $sid; ?>" name="sid" />
<!--vot--> <input type="submit" value="<?=lang('save')?>" class="btn btn-primary" id="save"  />
<!--vot--> <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();" />
    <span id="alias_msg_hook"></span>
    </li>
</div>
</form>
</section>
<script>
$("#menu_sort").addClass('active');
$("#alias").keyup(function(){checksortalias();});
function issortalias(a){
    var reg1=/^[\w-]*$/;
    var reg2=/^[\d]+$/;
    if(!reg1.test(a)) {
        return 1;
    }else if(reg2.test(a)){
        return 2;
    }else if(a=='post' || a=='record' || a=='sort' || a=='tag' || a=='author' || a=='page'){
        return 3;
    } else {
        return 0;
    }
}
function checksortalias(){
    var a = $.trim($("#alias").val());
    if (1 == issortalias(a)){
        $("#save").attr("disabled", "disabled");
/*vot*/        $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_invalid_characters')?></span>');
    }else if (2 == issortalias(a)){
        $("#save").attr("disabled", "disabled");
/*vot*/        $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_only_digits')?></span>');
    }else if (3 == issortalias(a)){
        $("#save").attr("disabled", "disabled");
/*vot*/        $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_system_link')?></span>');
    }else {
        $("#alias_msg_hook").html('');
        $("#msg").html('');
        $("#save").attr("disabled", false);
    }
}
</script>