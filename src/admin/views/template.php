<?php if (!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class="containertitle"><b><?=lang('template_manager')?></b>
<!--vot--><?php if (isset($_GET['activated'])): ?><span class="alert alert-success"><?=lang('template_change_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['activate_install'])): ?><span class="alert alert-success"><?=lang('template_upload_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['activate_del'])): ?><span class="alert alert-success"><?=lang('template_delete_ok')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger"><?=lang('template_delete_failed')?></span><?php endif; ?>
<!--vot--><?php if (!$nonceTplData): ?><span class="alert alert-danger"><?=lang('template_current_use')?>(<?= $nonce_templet ?>) <?=lang('template_damaged')?></span><?php endif; ?>
</div>
<div class="tpl">
    <?php
    foreach ($tpls as $key => $value):
    ?>
        <ul class="item">
            <li>
                <a href="template.php?action=usetpl&tpl=<?= $value['tplfile'] ?>&side=<?= $value['sidebar'] ?>&token=<?= LoginAuth::genToken() ?>">
<!--vot-->          <img alt="<?=lang('template_use_this')?>" src="<?= TPLS_URL . $value['tplfile'] ?>/preview.jpg" width="180" height="150" border="0" />
                </a>
            </li>
            <li class="title <?php if($nonce_templet == $value['tplfile']){echo "active";} ?>">
                <span class="name"><b><?= $value['tplname'] ?></b></span>
<!--vot-->      <span class="act"> | <a href="javascript: em_confirm('<?= $value['tplfile'] ?>', 'tpl', '<?= LoginAuth::genToken() ?>');" class="care"><?=lang('delete')?></a></span>
            </li>
        </ul>
    <?php endforeach;?>
        <ul class="add">
            <a href="template.php?action=install">
                <div class="theme-screenshot"><span></span></div>
<!--vot-->	<h3 class="theme-name"><?=lang('template_add')?></h3>
            </a>
        </ul>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
