<?php
/**
 * 自建页面模板
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<style>
    .page {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 30px;
        margin-bottom: 29px;
    }
    .com_submit_p {
        font-size: 15px
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-8 page">
            <h2><?php echo $log_title; ?></h2>
            <div class="markdown"><?php echo $log_content; ?></div>
			<?php blog_comments($comments); ?>
			<?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>
        </div>
		<?php
		include View::getView('side');
		?>
    </div>
</div>
<script>
    function change_com_radius() {
        if (!document.getElementById("com_info")) {
            var comment = document.getElementById("comment");
            comment.style.height = "140px";
            comment.style.setProperty('border-radius', '10px');
        }
    }
    change_com_radius();
</script>
<?php
include View::getView('footer');
?>
