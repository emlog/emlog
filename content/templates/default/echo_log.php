<?php

/**
 * 阅读文章页面
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<article class="container log-con blog-container">
    <span class="back-top mh" onclick="history.go(-1);">&laquo;</span>
    <header class="log-header">
        <h1 class="log-title"><?php topflg($top) ?><?= $log_title ?></h1>
        <div class="log-meta">
            <div class="log-meta-left">
                <span class="log-meta-item"><?php blog_author($author) ?></span>
                <span class="log-meta-item">
                    <?= _langTpl('published_on') ?>
                    <time datetime="<?= date('c', $date) ?>"><?= date('Y-n-j H:i', $date) ?></time>
                </span>
                <span class="log-meta-item">
                    <span class="iconfont icon-view"></span>
                    <?= _langTpl('views') ?><?= $views ?>
                </span>
                <span class="log-meta-item"><?php blog_sort($sortid) ?></span>
            </div>
            <div class="log-meta-right"><?php editflg($logid, $author) ?></div>
        </div>
    </header>
    <hr class="bottom-5" />
    <div class="markdown" id="emlogEchoLog"><?= $log_content ?></div>
    <p class="top-5"><?php blog_tag($logid) ?></p>

    <?php doAction('log_related', $logData) ?>

    <nav class="neighbor-log"><?php neighbor_log($neighborLog) ?></nav>

    <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) ?>
    <?php blog_comments($comments, $comnum) ?>

    <div style="clear:both;"></div>
</article>
<?php include View::getView('footer');
