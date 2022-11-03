<?php
/**
 * Page Bottom Information
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
    <footer>
        <div class="container">
            <div class="text-center">
                <?php
                    if(!empty($icp)){
                        echo '<div><a href="https://beian.miit.gov.cn/" target="_blank">'.$icp.'</a></div>';
                    }
                ?>
                <?= $footer_info ?>
                <?php doAction('index_footer') ?>
            </div>
        </div>
    </footer>
    <script src="<?= TEMPLATE_URL ?>js/common_tpl.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
    <script src="<?= TEMPLATE_URL ?>js/zoom.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
</body>
</html>
 
