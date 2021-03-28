<?php
/**
 * 自建页面模板
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2><?php echo $log_title; ?></h2>
                <?php echo $log_content; ?>
                <?php blog_comments($comments); ?>
                <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>
            </div>
            <?php
            include View::getView('side');
            ?>
        </div>
    </div>
<?php
include View::getView('footer');
?>