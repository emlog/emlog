<?php

/**
 * 自建页面模板
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<article class="container log-con blog-container">
    <header class="log-header">
        <h1 class="log-title"><?php topflg($top) ?><?= $log_title ?></h1>
    </header>
    <hr class="bottom-5" />
    <div class="markdown" id="emlogEchoLog"><?= $log_content ?></div>

    <?php doAction('log_related', $logData) ?>

    <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) ?>
    <?php blog_comments($comments, $comnum) ?>

    <div style="clear:both;"></div>
</article>
<?php include View::getView('footer');
