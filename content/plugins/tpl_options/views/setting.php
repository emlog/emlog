<?php
defined('EMLOG_ROOT') || exit('access denied!');
?>

<div class="vtpl-theme-light">
    <div class="vtpl-container">
        <div class="vtpl-header vtpl-sticky-header">
            <div class="vtpl-header-inner">
                <div class="vtpl-header-left">
                    <h1><?= $allTemplate[$template]['name'] ?></h1>
                </div>
                <div class="vtpl-header-right">
                    <div class="vtpl-buttons">
                        <input type="submit" class="button vtpl-back-primary tpl-options-close" value="返回">
                        <input type="submit" class="button vtpl-menu none" value="菜单">
                        <input type="submit" class="button vtpl-collapse-section tpl-options-btns" value="全部收缩">
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php
        $tplget = $this->getTemplateDefinedOptions($template);
        $_isset_icons = isset($tplget['TplOptionsNavi']['icons']);
        if (array_key_exists('TplOptionsNavi', $tplget)):
            $tplnavi = $tplget['TplOptionsNavi']['values'];
            if($_isset_icons)
            {
                $tplnavi_icons = $tplget['TplOptionsNavi']['icons'];
            }
            ?>
        <?php else: ?>
            <style>.option {
                    display: block !important
                }</style>
        <?php endif; ?>
        <div class="vtpl-wrapper">
            <div class="vtpl-nav vtpl-nav-options tpl-nav-options">
                <ul>
                    <li onClick="TplShow('tpl-system')" class="active">设置说明</li>
                    <?php
                    foreach ($tplnavi as $key => $v):
                        $icom_html = '';
                        if($_isset_icons){
                            $icom_html = trim($tplnavi_icons[$key])?'<i class="'.$tplnavi_icons[$key].' ri-lg"></i>':'';
                        }
                        ?>
                        <li onClick="TplShow('<?php echo $key; ?>')"><?php echo $icom_html.$v; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="fixed-body"></div>
            <div class="vtpl-content">
                <form action="<?php echo $this->url(array('template' => $template)); ?>" method="post" class="tpl-options-form">
                    <?php if (array_key_exists('TplOptionsNavi', $tplget)): ?>
                        <div class="option tpl-system" style="display:block;">
                            <div class="option-body depend-none"><?php echo $tplget['TplOptionsNavi']['description']; ?></div>
                        </div>
                    <?php endif; ?>
                    <?php $this->renderOptions(); ?>
                </form>
            </div>
            <div class="vtpl-nav-background"></div>
        </div>
    </div>
</div>