<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?><span class="alert alert-success">删除标签成功</span><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?><span class="alert alert-success">修改标签成功</span><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">请选择要删除的标签</span><?php endif; ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">标签管理</h1>
    </div>
    <form action="tag.php?action=dell_all_tag" method="post" name="form_tag" id="form_tag">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <span class="badge badge-secondary">已创建的标签</span>
            </div>
            <div clas
            <div class="card-body">
                <div>
                    <?php if ($tags): ?>
                        <li>
                            <?php
                            foreach ($tags as $key => $value): ?>
                                <a class="badge badge-pill badge-primary" href="tag.php?action=mod_tag&tid=<?php echo $value['tid']; ?>">
                                    <input type="checkbox" name="tag[<?php echo $value['tid']; ?>]" class="ids" value="1">
                                    <?php echo $value['tagname']; ?>
                                </a>
                            <?php endforeach; ?>
                        </li>
                        <li style="margin:20px 0px">
                            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                            <a href="javascript:void(0);" id="select_all">全选</a> 选中项：
                            <a href="javascript:deltags();" class="care">删除</a>
                        </li>
                    <?php else: ?>
                        <li style="margin:20px 30px">还没有标签，写文章的时候可以给文章打标签</li>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    selectAllToggle();

    function deltags() {
        if (getChecked('ids') == false) {
            alert('请选择要删除的标签');
            return;
        }
        if (!confirm('你确定要删除所选标签吗？')) {
            return;
        }
        $("#form_tag").submit();
    }

    setTimeout(hideActived, 2600);
    $("#menu_tag").addClass('active');
</script>
