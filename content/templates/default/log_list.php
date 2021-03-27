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
                                    <a href="<?php echo $value['log_url']; ?>"><?php echo $value['log_title']; ?></a>
                                    <?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?>
                                </h3>
                                <p><?php echo $value['log_description']; ?></p>
                                <p class="tag"><?php blog_tag($value['logid']); ?></p>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-8 text-muted ">
<!--vot-->                          <?php echo gmdate('Y-m-d', $value['date']); ?><?php blog_author($value['author']); ?>
                                </div>
                                <div class="col-md-4 text-right text-muted">
<!--vot-->                          <a href="<?php echo $value['log_url']; ?>#comments"><?=lang('comments')?>: (<?= $value['comnum']; ?>)</a>
<!--vot-->                          <a href="<?php echo $value['log_url']; ?>"><?=lang('_views')?>: (<?= $value['views']; ?>)</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
<!--vot-->          <h2><?=lang('not_found')?></h2>
<!--vot-->          <p><?=lang('sorry_no_results')?></p>
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