<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('category_name_empty')?></div><?php endif;?>
<?php if (isset($_GET['error_c'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('alias_format_invalid')?></div><?php endif;?>
<?php if (isset($_GET['error_d'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('alias_unique')?></div><?php endif;?>
<?php if (isset($_GET['error_e'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('alias_no_keywords')?></div><?php endif;?>
<!--vot--><h1 class="h3 mb-2 text-gray-800"><?=lang('category_edit')?></h1>
<form action="sort.php?action=update" method="post">
    <div class="form-group">
<!--vot-->  <label for="sortname"><?=lang('category_name')?></label>
        <input class="form-control" value="<?php echo $sortname; ?>" name="sortname" id="sortname">
    </div>
    <div class="form-group">
<!--vot--><label for="alias"><?=lang('alias')?></label>
        <input class="form-control" value="<?php echo $alias; ?>" name="alias" id="alias">
<!--vot--><small class="form-text text-muted"><?=lang('alias_prompt')?></small>
    </div>
    <div class="form-group">
<!--vot--><label><?=lang('category_parent')?></label>
        <select name="pid" id="pid" class="form-control">
<!--vot-->  <option value="0" <?php if ($pid == 0): ?> selected="selected"<?php endif; ?>><?=lang('no')?></option>
            <?php
            foreach ($sorts as $key => $value):
                if ($key == $sid || $value['pid'] != 0) continue;
                ?>
                <option value="<?php echo $key; ?>"<?php if ($pid == $key): ?> selected="selected"<?php endif; ?>><?php echo $value['sortname']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
<!--vot--><label for="template"><?=lang('template')?></label>
        <input class="form-control" name="template" id="template" value="<?php echo $template; ?>">
<!--vot--><small class="form-text text-muted"><?=lang('template_info')?></small>
    </div>
    <div class="form-group">
<!--vot--><label for="description"><?=lang('category_description')?></label>
        <textarea name="description" type="text" class="form-control"><?php echo $description; ?></textarea>
    </div>
    <input type="hidden" value="<?php echo $sid; ?>" name="sid"/>
<!--vot--><input type="submit" value="<?=lang('save')?>" class="btn btn-success" id="save">
<!--vot--><input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();">
    <span id="alias_msg_hook"></span>
</form>

<script>
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_sort").addClass('active');

    $("#alias").keyup(function () {
        checksortalias();
    });

    function issortalias(a) {
        var reg1 = /^[\w-]*$/;
        var reg2 = /^[\d]+$/;
        if (!reg1.test(a)) {
            return 1;
        } else if (reg2.test(a)) {
            return 2;
        } else if (a == 'post' || a == 'record' || a == 'sort' || a == 'tag' || a == 'author' || a == 'page') {
            return 3;
        } else {
            return 0;
        }
    }

    function checksortalias() {
        var a = $.trim($("#alias").val());
        if (1 == issortalias(a)) {
            $("#save").attr("disabled", "disabled");
/*vot*/     $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_invalid_characters')?></span>');
        } else if (2 == issortalias(a)) {
            $("#save").attr("disabled", "disabled");
/*vot*/     $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_only_digits')?></span>');
        } else if (3 == issortalias(a)) {
            $("#save").attr("disabled", "disabled");
/*vot*/     $("#alias_msg_hook").html('<span id="input_error"><?=lang('alias_system_link')?></span>');
        } else {
            $("#alias_msg_hook").html('');
            $("#msg").html('');
            $("#save").attr("disabled", false);
        }
    }
</script>