<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('category_name_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="alert alert-danger"><?=lang('alias_format_invalid')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="alert alert-danger"><?=lang('alias_unique')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="alert alert-danger"><?=lang('alias_no_keywords')?></span><?php endif;?>
<!--vot--><div class=containertitle><b><?=lang('category_edit')?></b></div>
<form action="sort.php?action=update" method="post" class="form-inline">
<div class="form-group">
    <li>
        <input style="width:200px;" value="<?php echo $sortname; ?>" name="sortname" id="sortname" class="form-control" />
<!--vot--><label><?=lang('name')?></label>
    </li>
    <li>
        <input style="width:200px;" value="<?php echo $alias; ?>" name="alias" id="alias" class="form-control" />
<!--vot--><label><?=lang('alias')?></label>
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
<!--vot--><label><?=lang('category_parent')?></label>
    </li>
    <?php endif; ?>
<!--vot--><li><input maxlength="200" style="width:200px;" class="form-control" name="template" id="template" value="<?php echo $template; ?>" /> <?=lang('template')?> <?=lang('template_info2')?></li>
    <li>
        <textarea name="description" type="text" style="width:360px;height:80px;overflow:auto;" class="form-control" placeholder="<?=lang('category_description')?>"><?php echo $description; ?></textarea>
    </li>
    <li>
    <input type="hidden" value="<?php echo $sid; ?>" name="sid" />
<!--vot--> <input type="submit" value="<?=lang('save')?>" class="btn btn-primary" id="save"  />
<!--vot--> <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();" />
    <span id="alias_msg_hook"></span>
    </li>
</div>
</form>
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