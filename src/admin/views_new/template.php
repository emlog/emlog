<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>

<div class="containertitle"><b>模板管理</b>
    <?php if (isset($_GET['activated'])): ?><span class="alert alert-success">模板更换成功</span><?php endif; ?>
    <?php if (isset($_GET['activate_install'])): ?><span class="alert alert-success">模板上传成功</span><?php endif; ?>
    <?php if (isset($_GET['activate_del'])): ?><span class="alert alert-success">删除模板成功</span><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger">删除失败，请检查模板文件权限</span><?php endif; ?>
    <?php if (!$nonceTplData): ?><span class="alert alert-danger">当前使用的模板(<?php echo $nonce_templet; ?>)已被删除或损坏，请选择其他模板。</span><?php endif; ?>
</div>

<div class="tpl">
    <?php
    $i = 0;
    foreach ($tpls as $key => $value):
        if ($i % 3 == 0) {
            echo "<tr>";
        }
        $i++;
        ?>
        <div>
            <li>
                <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>">
                    <img alt="点击使用该模板" src="<?php echo TPLS_URL . $value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
                </a>
            </li>
            <li>
                <span class="name"><?php echo $value['tplname']; ?></span>
                <span class="act"> | <a href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a></span>
            </li>
        </div>
    <?php
    if ($i > 0 && $i % 3 == 0) {
        echo "</tr>";
    }
endforeach;
?>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
