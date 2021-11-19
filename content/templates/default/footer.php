<?php
/**
 * 页面底部信息
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<footer>
    <div class="container">
        <p class="text-center">
            <a href="https://beian.miit.gov.cn/" target="_blank"><?php echo $icp; ?></a><br>
			<?php echo $footer_info; ?>
			<?php doAction('index_footer'); ?>
        </p>
    </div>
</footer>
</body>
<script src="<?php echo TEMPLATE_URL; ?>js/common_tpl.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/zoom.js?t=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>
</html>
 