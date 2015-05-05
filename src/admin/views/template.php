<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="panel-heading">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="./template.php"><?=lang('template_current')?></a></li>
        <li role="presentation"><a href="template.php?action=install"><?=lang('template_mount')?></a></li>
        <?php if (isset($_GET['activated'])): ?><span class="alert alert-success"><?=lang('template_change_ok')?></span><?php endif; ?>
        <?php if (isset($_GET['activate_install'])): ?><span class="alert alert-success"><?=lang('template_upload_ok')?></span><?php endif; ?>
        <?php if (isset($_GET['activate_del'])): ?><span class="alert alert-success"><?=lang('template_delete_ok')?></span><?php endif; ?>
        <?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger"><?=lang('template_delete_failed')?></span><?php endif; ?>
        <?php if (!$nonceTplData): ?><span class="alert alert-danger"><?=lang('template_current_use')?> (<?php echo $nonce_templet; ?>) <?=lang('template_damaged')?></span><?php endif; ?>
    </ul>
</div>

<div class="tpl">
    <?php
    foreach ($tpls as $key => $value):
    ?>
        <ul class="item">
            <li>
                <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>">
                    <img alt="<?=lang('template_use_this')?>" src="<?php echo TPLS_URL . $value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
                </a>
            </li>
            <li class="title <?php if($nonce_templet == $value['tplfile']){echo "active";} ?>">
                <span class="name"><b><?php echo $value['tplname']; ?></b></span>
                <span class="act"> | <a href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a></span>
            </li>
        </ul>
    <?php endforeach;?>
        <ul class="add">
            <li><a href="template.php?action=install"><?=lang('template_add')?>+</a></li>
        </ul>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_tpl").addClass('active').parent().parent().addClass('active');
</script>
