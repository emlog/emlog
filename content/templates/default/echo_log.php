<?php
/**
 * Read the Post page
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<main class="container log-con">
    <span class="back-top mh" onclick="history.go(-1);">&laquo;</span>
    <header class="log-title"><?php topflg($top) ?><?= $log_title ?></header>
    <p class="date">
<!--vot--><b><?=lang('time')?>:</b> <?= gmdate('Y-m-d', $date) ?>&nbsp;&nbsp;&nbsp;
<!--vot--><b><?=lang('author')?>:</b> <?php blog_author($author); ?>&nbsp;&nbsp;&nbsp;
<!--vot--><b><?=lang('category')?>:</b> <?php blog_sort($logid); ?>

		<?php editflg($logid, $author) ?>

    </p>
    <hr class="bottom-5"/>
    <article class="markdown" id="emlogEchoLog"><?= $log_content ?></article>
    <p class="top-5"><?php blog_tag($logid) ?></p>

	<?php doAction('log_related', $logData) ?>

    <nav class="neighbor-log"><?php neighbor_log($neighborLog) ?></nav>

	<?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) ?>
	<?php blog_comments($comments) ?>

    <div style="clear:both;"></div>
</main>

<?php include View::getView('footer') ?>
