<?php
!defined('EMLOG_ROOT') && exit('access deined!');
?>
<div id="tpl-options">
    <div class="tpl-options-close">&laquo;返回</div>
    <div class="tpl-options-btns" data-type="1">全部收缩</div>
	<?php
	$tplget = $this->getTemplateDefinedOptions($template);
	if (array_key_exists('TplOptionsNavi', $tplget)):
		$tplnavi = $tplget['TplOptionsNavi']['values'];
		?>
        <div class="tpl-options-menubtn">快捷菜单</div>
        <div class="tpl-options-menu">
            <ul>
                <li onClick="TplShow('tpl-system')" class="active">设置说明</li>
				<?php
				foreach ($tplnavi as $key => $v):
					?>
                    <li onClick="TplShow('<?php echo $key; ?>')"><?php echo $v; ?></li>
				<?php endforeach; ?>
            </ul>
        </div>
	<?php else: ?>
        <style>.option {
                display: block !important
            }</style>
	<?php endif; ?>
    <form action="<?php echo $this->url(array('template' => $template)); ?>" method="post" class="tpl-options-form">
		<?php if (array_key_exists('TplOptionsNavi', $tplget)): ?>
            <div class="option tpl-system" style="display:block;">
                <div class="option-body depend-none"><?php echo $tplget['TplOptionsNavi']['description']; ?></div>
            </div>
		<?php endif; ?>
		<?php $this->renderOptions(); ?>
    </form>
</div>
