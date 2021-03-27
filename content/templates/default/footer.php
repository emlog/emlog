<?php 
/**
 * Page Bottom Information
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

<footer class="py-5">
    <div class="container">
<!--vot--><p class="m-0 text-center"><?=lang('powered_by')?><a href="http://www.emlog.net">emlog</a><br>
            <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <?php echo $footer_info; ?>
            <?php doAction('index_footer'); ?>
        </p>
    </div>
</footer>

<script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/common_tpl.js" type="text/javascript"></script>

</body>
</html>