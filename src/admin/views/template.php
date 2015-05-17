<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="panel-heading">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="./template.php">模板管理</a></li>
        <li role="presentation"><a href="template.php?action=install">安装模板</a></li>
        <?php if (isset($_GET['activated'])): ?><span class="alert alert-success">模板更换成功</span><?php endif; ?>
        <?php if (isset($_GET['activate_install'])): ?><span class="alert alert-success">模板上传成功</span><?php endif; ?>
        <?php if (isset($_GET['activate_del'])): ?><span class="alert alert-success">删除模板成功</span><?php endif; ?>
        <?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">删除失败，请检查模板文件权限</span><?php endif; ?>
        <?php if (!$nonceTplData): ?><span class="alert alert-danger">当前使用的模板(<?php echo $nonce_templet; ?>)已被删除或损坏，请选择其他模板。</span><?php endif; ?>
    </ul>
</div>

<div class="tpl">
    <?php
    foreach ($tpls as $key => $value):
    ?>
        <ul class="item">
            <li>
                <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>">
                    <img alt="点击使用该模板" src="<?php echo TPLS_URL . $value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
                </a>
            </li>
            <li class="title <?php if($nonce_templet == $value['tplfile']){echo "active";} ?>">
                <span class="name"><b><?php echo $value['tplname']; ?></b></span>
                <span class="act"> | <a href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a></span>
            </li>
        </ul>
    <?php endforeach;?>
        <ul class="add">
            <li><a href="template.php?action=install">添加模板+</a></li>
        </ul>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
