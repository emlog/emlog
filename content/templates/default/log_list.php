<?php
/**
 * 站点首页模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>

<!-- Container -->
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
                                    <a href="<?php echo $value['log_url']; ?>" id="loglist_title" ><?php echo $value['log_title']; ?></a>
                                    <?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?>
                                </h3>
                                <p id="loglist_content"><?php echo $value['log_description']; ?></p>
                                <p class="tag" id="loglist_tag"><?php blog_tag($value['logid']); ?></p>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-8 text-muted " id="loglist_info" >
                                    <?php echo gmdate('Y-n-j', $value['date']); ?>&nbsp;&nbsp;&nbsp;<?php blog_author($value['author']); ?>
                                </div>
                                <div class="col-md-4 text-right text-muted" id="loglist_count">
                                    <a href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a>
                                    <a href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:
                    ?>
                    <h2>未找到</h2>
                    <p>抱歉，没有符合您查询条件的结果。</p>
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
