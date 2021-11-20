<?php
/**
 * 自建页面模板
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<main class="container">
    <div class="row">
        <div class="column-big log-con " id="page">
            <header class="page-title"><?php echo $log_title; ?></header>
            <article class="markdown">
                <?php echo $log_content; ?>
            </article>
		    <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>
            <?php blog_comments($comments); ?>
        </div>
		<?php
		include View::getView('side');
		?>
    </div>
</main>
<?php
include View::getView('footer');
?>
 
