<?php
/**
 * 页面底部信息
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>

<footer class="py-3">
    <div class="container">
        <p class="text-center small">powered by <a href="https://www.emlog.net">emlog pro</a>
            <a href="https://beian.miit.gov.cn/" target="_blank"><?php echo $icp; ?></a> <br>
			<?php echo $footer_info; ?>
			<?php doAction('index_footer'); ?>
        </p>
    </div>
</footer>

<script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script>
    $('#captcha').click(function () {
        var timestamp = new Date().getTime();
        $(this).attr("src", "./include/lib/checkcode.php?" + timestamp);
    });
</script>
</body>
</html>
