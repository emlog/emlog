<?php
!defined('EMLOG_ROOT') && exit('access denied!');
?>
<div class="containertitle2">
    <a class="navi3" href="<?php echo $this->url(); ?>">模板列表</a>
    <?php if ($toSetTemplate != ''): ?><a class="navi4" href="<?php echo $this->url(array('template' => $toSetTemplate)); ?>">模板设置</a><?php endif; ?>
    <?php include $this->view('message'); ?>
</div>
<table class="adm__list">
    <?php
    $i = 0;
    foreach ($templates as $name => $template):
        if ($i++ % 3 == 0) {
            if ($i > 1) {
                echo '</tr>';
            }
            echo "<tr>";
        }
        ?>
        <td>
            <?php if ($template['support'] !== false): ?>
                <a href="<?php echo $this->url(array('template' => $name)); ?>">
                    <img alt="点击设置该模板" title="点击设置该模板" src="<?php echo $template['preview']; ?>" width="180" height="150" border="0"/>
                    <br/>
                    <?php echo $template['name']; ?>
                </a>
            <?php else: ?>
                <img title="该模板不支持本插件设置" src="<?php echo $template['preview']; ?>" width="180" height="150" border="0"/>
                <br/>
                <?php echo $template['name']; ?>
            <?php endif; ?>
        </td>
    <?php
    endforeach;
    for ($j = $i + 3 - $i % 3; $i < $j; $i++) {
        echo '<td>&nbsp;</td>';
    }
    echo '</tr>';
    ?>
</table>