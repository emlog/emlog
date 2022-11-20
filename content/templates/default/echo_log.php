<?php
/**
 * 阅读文章页面
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<article class="container log-con blog-container">
    <span class="back-top mh" onclick="history.go(-1);">&laquo;</span>
    <h1 class="log-title"><?php topflg($top) ?><?= $log_title ?></h1>
    <p class="date">
        <b>时间：</b><?= date('Y-n-j', $date) ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <b>作者：</b><?php blog_author($author) ?>&nbsp;&nbsp;&nbsp;&nbsp;
        <b>分类：</b><?php blog_sort($logid) ?>

		<?php editflg($logid, $author) ?>

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
