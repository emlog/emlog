<?php
/**
 * Home Post List section
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php
            if (!empty($logs)):
                foreach ($logs as $value):
                    ?>
                    <div class="shadow-theme mb-4">
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="<?php echo $value['log_url']; ?>" id="loglist_title"><?php echo $value['log_title']; ?></a>
                                <?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?>
                            </h3>
                            <p id="loglist_content"><?php echo $value['log_description']; ?></p>
                            <p class="tag" id="loglist_tag"><?php blog_tag($value['logid']); ?></p>
                        </div>
                        <div class="row p-3">
                            <div class="col-md-8 text-muted " id="loglist_info">
<!--vot-->                      <?php echo gmdate('Y-m-d', $value['date']); ?>&nbsp;&nbsp;&nbsp;<?php blog_author($value['author']); ?>
                            </div>
                            <div class="col-md-4 text-right text-muted" id="loglist_count">
<!--vot-->                      <a href="<?php echo $value['log_url']; ?>#comments"><?=lang('comments')?>: (<?php echo $value['comnum']; ?>)</a>
<!--vot-->                      <a href="<?php echo $value['log_url']; ?>"><?=lang('_views')?>: (<?php echo $value['views']; ?>)</a>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else:
                ?>
<!--vot-->      <h2><?=lang('not_found')?></h2>
<!--vot-->      <p><?=lang('sorry_no_results')?></p>
            <?php endif; ?>

            <ul class="pagination justify-content-center mb-4">
                <?php echo $page_url; ?>
            </ul>
        </div>

        <?php
        include View::getView('side');
        ?>
    </div><!-- /.row -->
</div><!-- /.container -->
<?php
include View::getView('footer');
?>
