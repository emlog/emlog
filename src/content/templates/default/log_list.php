<?php
/**
 * Home Post List section
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
            <h2><?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?><a href="<?= $value['log_url'] ?>"><?= $value['log_title'] ?></a></h2>
<!--vot-->  <p class="date"><?=emdate($value['date'])?> <?php blog_author($value['author']); ?> 
            <?php blog_sort($value['logid']); ?> 
            <?php editflg($value['logid'], $value['author']); ?>
            </p>
        <?= $value['log_description'] ?>
            <p class="tag"><?php blog_tag($value['logid']); ?></p>
            <p class="count">
<!--vot--><a href="<?= $value['log_url'] ?>#comments"><?=lang('comments')?> (<?= $value['comnum'] ?>)</a>,
<!--vot--><a href="<?= $value['log_url'] ?>"><?=lang('_views')?> (<?= $value['views'] ?>)</a>
            </p>
            <div style="clear:both;"></div>
            <?php
        endforeach;
    else:
        ?>
<!--vot--><h2><?=lang('not_found')?></h2>
<!--vot--><p><?=lang('sorry_no_results')?></p>
        <?php endif; ?>

    <div id="pagenavi">
<?= $page_url ?>
    </div>
</div>

<?php
include View::getView('side');
include View::getView('footer');
?>