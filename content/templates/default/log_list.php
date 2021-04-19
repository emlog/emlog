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
                            <div class="card-body loglist_body">
                                <h3 class="card-title">
                                    <a href="<?php echo $value['log_url']; ?>" class="loglist_title" >
                                    <?php echo $value['log_title']; ?></a><?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?>
                                </h3>
                                <p class="loglist_content"><?php echo $value['log_description']; ?></p>
                                <p class="tag loglist_tag"><?php blog_tag($value['logid']); ?></p>
                            </div>
                            <hr class="list_line" />
                            <div class="row p-3 info_row">
                                <div class="col-md-8 text-muted loglist_info">
<!--vot-->                          <?php echo gmdate('Y-m-d', $value['date']); ?>&nbsp;&nbsp;&nbsp;<?php blog_author($value['author']); ?>
                                </div>
                                <div class="col-md-4 text-right text-muted loglist_count">
<!--vot-->                      <a href="<?php echo $value['log_url']; ?>#comments"><?=lang('comments')?>: (<?php echo $value['comnum']; ?>)&nbsp;</a>
<!--vot-->                      <a href="<?php echo $value['log_url']; ?>"><?=lang('_views')?>: (<?php echo $value['views']; ?>)</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                else:
                    $keyword = isset($keyword) ? $keyword : '';
                    if ($keyword != '' ) {
                        ?>
                        <br><br>
                         <h2 style="text-align:center;">抱歉，没有找到与‘<?php echo htmlspecialchars($keyword,ENT_QUOTES); ?>’相关的内容</h2>
                        <div class="goback"><a href="javascript:history.go(-1);" class="goback_link">返回</a></div>    
                        <?php }elseif($sort != '' ){ ?>
                        <br><br>
                         <h2 style="text-align:center;">该分类下还没有内容</h2>
                        <div class="goback"><a href="javascript:history.go(-1);" class="goback_link">返回</a></div>
                        <?php } ?>
                <?php endif; ?>
                <ul class="pagination justify-content-center mb-4">
                    <?php echo $page_url; ?>
                </ul>
            </div>
            <?php include View::getView('side'); ?>
        </div>
    </div>
<?php
include View::getView('footer');
?>
