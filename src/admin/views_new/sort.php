<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<script>setTimeout(hideActived, 2600);</script>
<div class="containertitle"><b>分类管理</b>
    <?php if (isset($_GET['active_taxis'])): ?><span class="alert alert-success">排序更新成功</span><?php endif; ?>
    <?php if (isset($_GET['active_del'])): ?><span class="alert alert-success">删除分类成功</span><?php endif; ?>
    <?php if (isset($_GET['active_edit'])): ?><span class="alert alert-success">修改分类成功</span><?php endif; ?>
    <?php if (isset($_GET['active_add'])): ?><span class="alert alert-success">添加分类成功</span><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">分类名称不能为空</span><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?><span class="alert alert-danger">没有可排序的分类</span><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?><span class="alert alert-danger">别名格式错误</span><?php endif; ?>
    <?php if (isset($_GET['error_d'])): ?><span class="alert alert-danger">别名不能重复</span><?php endif; ?>
    <?php if (isset($_GET['error_e'])): ?><span class="alert alert-danger">别名不得包含系统保留关键字</span><?php endif; ?>
</div>
<div class=line></div>
<form  method="post" action="sort.php?action=taxis">
    <table class="table table-striped table-bordered table-hover dataTable no-footer">
        <thead>
            <tr>
                <th width="55"><b>序号</b></th>
                <th width="160"><b>名称</b></th>
                <th width="180"><b>描述</b></th>
                <th width="130"><b>别名</b></th>
                <th width="100"><b>模板</b></th>
                <th width="40" class="tdcenter"><b>查看</b></th>
                <th width="40" class="tdcenter"><b>文章</b></th>
                <th width="60"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($sorts):
                foreach ($sorts as $key => $value):
                    if ($value['pid'] != 0) {
                        continue;
                    }
                    ?>
                    <tr>
                        <td>
                            <input type="hidden" value="<?php echo $value['sid']; ?>" class="sort_id" />
                            <input class="form-control em-small" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
                        </td>
                        <td class="sortname">
                            <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a>
                        </td>
                        <td><?php echo $value['description']; ?></td>
                        <td class="alias"><?php echo $value['alias']; ?></td>
                        <td class="alias"><?php echo $value['template']; ?></td>
                        <td class="tdcenter">
                            <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
                        </td>
                        <td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                        <td>
                            <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">编辑</a>
                            <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
                        </td>
                    </tr>
                    <?php
                    $children = $value['children'];
                    foreach ($children as $key):
                        $value = $sorts[$key];
                        ?>
                        <tr>
                            <td>
                                <input type="hidden" value="<?php echo $value['sid']; ?>" class="sort_id" />
                                <input class="form-control em-small" name="sort[<?php echo $value['sid']; ?>]" value="<?php echo $value['taxis']; ?>" />
                            </td>
                            <td class="sortname">---- <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a></td>
                            <td><?php echo $value['description']; ?></td>
                            <td class="alias"><?php echo $value['alias']; ?></td>
                            <td class="alias"><?php echo $value['template']; ?></td>
                            <td class="tdcenter">
                                <a href="<?php echo Url::sort($value['sid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
                            </td>
                            <td class="tdcenter"><a href="./admin_log.php?sid=<?php echo $value['sid']; ?>"><?php echo $value['lognum']; ?></a></td>
                            <td>
                                <a href="sort.php?action=mod_sort&sid=<?php echo $value['sid']; ?>">编辑</a>
                                <a href="javascript: em_confirm(<?php echo $value['sid']; ?>, 'sort', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach;
            else: ?>
                <tr><td class="tdcenter" colspan="8">还没有添加分类</td></tr>
<?php endif; ?>  
        </tbody>
    </table>
    <div class="list_footer">
		<input type="submit" value="改变排序" class="btn btn-primary" /> 
		<a href="javascript:displayToggle('sort_new', 2);" class="btn btn-success">添加分类+</a>
	</div>
</form>
<form action="sort.php?action=add" method="post" class="form-inline">
    <div id="sort_new" class="form-group">
        <li>
            <input maxlength="4" style="width:50px;" name="taxis" class="form-control"  />
            <label>序号</label>
        </li>
        <li>
            <input style="width:243px;" class="form-control" name="sortname" id="sortname" required="required" />
            <label>名称</label>
        </li>
        <li>
            <input style="width:243px;" class="form-control" name="alias" id="alias" />
            <label>别名 (用于URL的友好显示)</label>
        </li>
        <li>
            <select name="pid" id="pid" class="form-control" style="width:243px;">
                <option value="0">无</option>
                <?php
                foreach ($sorts as $key => $value):
                    if ($value['pid'] != 0) {
                        continue;
                    }
                    ?>
                    <option value="<?php echo $key; ?>"><?php echo $value['sortname']; ?></option>
<?php endforeach; ?>
            </select>
            <label>父分类</label>
        </li>
        <li>
            <input style="width:243px;" class="form-control" name="template" id="template" value="log_list" />
            <label>模板 (用于自定义分类页面模板，对应模板目录下.php文件，默认为log_list.php)</label>
        </li>
        <li>
            <textarea name="description" type="text" style="width:360px;height:80px;overflow:auto;" class="form-control" placeholder="分类描述"></textarea></li>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <li><input type="submit" id="addsort" value="添加新分类" class="btn btn-primary"/><span id="alias_msg_hook"></span></li>
    </div>
</form>
<script>
    $("#sort_new").css('display', $.cookie('em_sort_new') ? $.cookie('em_sort_new') : 'none');
    $("#alias").keyup(function() {
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
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，应由字母、数字、下划线、短横线组成</span>');
        } else if (2 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，不能为纯数字</span>');
        } else if (3 == issortalias(a)) {
            $("#addsort").attr("disabled", "disabled");
            $("#alias_msg_hook").html('<span id="input_error">别名错误，与系统链接冲突</span>');
        } else {
            $("#alias_msg_hook").html('');
            $("#msg").html('');
            $("#addsort").attr("disabled", false);
        }
    }
    $(document).ready(function() {
        $("#adm_sort_list tbody tr:odd").addClass("tralt_b");
        $("#adm_sort_list tbody tr")
                .mouseover(function() {
                    $(this).addClass("trover")
                })
                .mouseout(function() {
                    $(this).removeClass("trover")
                });
        $("#menu_sort").addClass('active');
    });
</script>
