<?php
defined('EMLOG_ROOT') || exit('access denied!');
$tplget = $this->getTemplateDefinedOptions($template);
$tplnavi_icons = isset($tplget['TplOptionsNavi']['icons']) ? $tplget['TplOptionsNavi']['icons'] : [];
$tplnavi = isset($tplget['TplOptionsNavi']['values']) ? $tplget['TplOptionsNavi']['values'] : [];
$is_has_menu = array_key_exists('TplOptionsNavi', $tplget);
$show_desc = $is_has_menu && isset($tplget['TplOptionsNavi']['description']) && trim($tplget['TplOptionsNavi']['description']) !== '';
$first_key = '';
if ($is_has_menu && !$show_desc && !empty($tplnavi)) {
    $first_keys = array_keys($tplnavi);
    $first_key = $first_keys[0];
}
?>
<div class="vtpl-modern-theme">
    <div class="vtpl-container">
        <div class="vtpl-header vtpl-sticky-header">
            <div class="vtpl-header-inner">
                <div class="vtpl-header-left">
                    <h1><?= $allTemplate[$template]['name'] ?></h1>
                </div>
                <div class="vtpl-header-right">
                    <div class="vtpl-buttons">
                        <input type="submit" class="button vtpl-back-primary tpl-options-close" value="<?= _langPlu('back', 'tpl_options'); ?>">
                        <?php if ($is_has_menu): ?>
                            <input type="submit" class="button vtpl-menu none" value="<?= _langPlu('menu', 'tpl_options'); ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php if (!$is_has_menu): ?>
            <style>
                .option {
                    display: block !important
                }
            </style>
        <?php elseif ($first_key): ?>
            <style>
                .vtpl-modern-theme .option.<?= $first_key; ?> {
                    display: block;
                }
            </style>
        <?php endif; ?>
        <div class="vtpl-wrapper vtpl-option-main">
            <div class="vtpl-nav vtpl-nav-options tpl-nav-options">
                <ul>
                    <?php if ($show_desc): ?>
                        <li onClick="TplShow('tpl-system')" class="active"><?= _langPlu('setting_desc', 'tpl_options'); ?></li>
                    <?php endif; ?>
                    <?php
                    $is_first = !$show_desc;
                    foreach ($tplnavi as $key => $v):
                        $icom_html = '';
                        if ($tplnavi_icons) {
                            $icom_html = trim($tplnavi_icons[$key]) ? '<i class="' . $tplnavi_icons[$key] . ' ri-lg"></i>' : '';
                        }
                        $active_class = $is_first ? ' class="active"' : '';
                        $is_first = false;
                    ?>
                        <li onClick="TplShow('<?= $key; ?>')"<?= $active_class; ?>><?= $icom_html . $v; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="fixed-body"></div>
            <div class="vtpl-content">
                <form action="<?= $this->url(array('template' => $template)); ?>" method="post" class="tpl-options-form">
                    <?php if ($show_desc): ?>
                        <div class="option tpl-system" style="display:block;">
                            <div class="option-body depend-none"><?= $tplget['TplOptionsNavi']['description']; ?></div>
                        </div>
                    <?php endif; ?>
                    <?php $this->renderOptions(); ?>
                </form>
            </div>
            <div class="vtpl-nav-background"></div>
        </div>
    </div>
</div>