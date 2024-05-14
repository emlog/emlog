<?php
/**
 * 阅读文章页面
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<article class="container log-con blog-container">
    <span class="back-top mh" onclick="history.go(-1);">&laquo;</span>
    <h1 class="log-title"><?php topflg($top) ?><?= $log_title ?></h1>
    <p class="date">
        <?php blog_author($author) ?> 发布于 <?= date('Y-n-j H:i', $date) ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <?= $views ?>&nbsp;次阅读 &nbsp;&nbsp;&nbsp;&nbsp;
        <?php blog_sort($sortid) ?>
    </p>
    <hr class="bottom-5"/>
    <div class="markdown" id="emlogEchoLog"><?= $log_content ?></div>
    <p class="top-5"><?php blog_tag($logid) ?></p>

    <?php doAction('log_related', $logData) ?>

    <nav class="neighbor-log"><?php neighbor_log($neighborLog) ?></nav>

    <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) ?>
    <?php blog_comments($comments) ?>

    <div style="clear:both;"></div>
</article>
<?php include View::getView('footer') ?>
