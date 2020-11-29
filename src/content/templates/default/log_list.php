<?php
/**
 * 站点首页模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>

<div class="col-md-7 content">
    <?php
    if (!empty($logs)):
        foreach ($logs as $value):
            ?>
            <h3><a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a><?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?></h3>
            <p class="date"><?php echo gmdate('Y-n-j', $value['date']); ?> <?php blog_author($value['author']); ?> 
            <?php blog_sort($value['logid']); ?> 
            <?php editflg($value['logid'], $value['author']); ?>
            </p>
        <?php echo $value['log_description']; ?>
            <p class="tag"><?php blog_tag($value['logid']); ?></p>
            <p class="count">
                <a href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a>
                <a href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
            </p>
            <div style="clear:both;"></div>
            <?php
        endforeach;
    else:
        ?>
        <h2>未找到</h2>
        <p>抱歉，没有符合您查询条件的结果。</p>
        <?php endif; ?>

    <div id="pagenavi">
<?php echo $page_url; ?>
    </div>
</div>

<?php
include View::getView('side');
include View::getView('footer');
?>