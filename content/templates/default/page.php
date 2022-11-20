<?php
/**
 * 自建页面模板
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<article class="container blog-container">
    <div class="row">
        <div class="column-big log-con blog-container" id="page">
            <h1 class="page-title"><?= $log_title ?></h1>
            <div class="markdown">
                <?= $log_content ?>
            </div>
		    <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark) ?>
            <?php blog_comments($comments) ?>
        </div>
		<?php
		include View::getView('side');
		?>
    </div>
</article>
<?php
include View::getView('footer');
?>
 
