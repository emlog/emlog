<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger">分类名称不能为空</div><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?><div class="alert alert-danger">别名格式错误</div><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?><div class="alert alert-danger">别名不能重复</div><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?><div class="alert alert-danger">别名不得包含系统保留关键字</div><?php endif; ?>
    <h1 class="h3 mb-2 text-gray-800">编辑分类</h1>
    <form action="sort.php?action=add" method="post" id="sort_new" style="margin-top: 30px;">
        <div class="form-group">
            <label for="sortname">分类名</label>
            <input class="form-control" value="<?php echo $sortname; ?>" name="sortname" id="sortname">
        </div>
        <div class="form-group">
            <label for="alias">别名</label>
            <input class="form-control" value="<?php echo $alias; ?>" name="alias" id="alias">
            <small class="form-text text-muted">用于URL的友好显示，可不填</small>
        </div>
        <div class="form-group">
            <label>父分类</label>
            <select name="pid" id="pid" class="form-control">
                <option value="0" <?php if ($pid == 0): ?> selected="selected"<?php endif; ?>>无</option>
                <?php
                foreach ($sorts as $key => $value):
                    if ($key == $sid || $value['pid'] != 0) continue;
                    ?>
                    <option value="<?php echo $key; ?>"<?php if ($pid == $key): ?> selected="selected"<?php endif; ?>><?php echo $value['sortname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="template">模板</label>
            <input class="form-control" name="template" id="template" value="<?php echo $template; ?>">
            <small class="form-text text-muted">(用于自定义分类页面模板，对应模板目录下.php文件，默认：log_list.php，可不填)</small>
        </div>
        <div class="form-group">
            <label for="description">分类描述</label>
            <textarea name="description" type="text" class="form-control"><?php echo $description; ?></textarea>
        </div>
        <input type="hidden" value="<?php echo $sid; ?>" name="sid"/>
        <input type="submit" value="保 存" class="btn btn-success" id="save"/>
        <input type="button" value="取 消" class="btn btn-default" onclick="javascript: window.history.back();"/>
        <span id="alias_msg_hook"></span>
    </form>
</div>
<script>
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
            $("#alias_msg_hook").html('<span id="input_error">别名错误，应由字母、数字、下划线、短横线组成</span>');
        } else if (2 == issortalias(a)) {
            $("#save").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为纯数字</span>');
        } else if (3 == issortalias(a)) {
            $("#save").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，与系统链接冲突</span>');
        } else {
            $("#alias_msg_hook").html('');
            $("#msg").html('');
            $("#save").attr("disabled", false);
        }
    }
</script>