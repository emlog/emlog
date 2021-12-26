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
            <a href="https://beian.miit.gov.cn/" target="_blank"><?= $icp ?></a><br>
			<?= $footer_info ?>
			<?php doAction('index_footer') ?>
        </p>
    </div>
</footer>
</body>
<script src="<?= TEMPLATE_URL ?>js/common_tpl.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script src="<?= TEMPLATE_URL ?>js/zoom.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
</html>
 