<?php

/**
 * 页面底部信息
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<footer class="blog-footer">
    <div class="container footinfo">
        <?php
        if (!empty($icp)) {
            echo '<div><a href="https://beian.miit.gov.cn/" target="_blank">' . $icp . '</a></div>';
        }
        ?>
        <?= $footer_info ?>
        <?php doAction('index_footer') ?>
    </div>
</footer>
</body>

</html>