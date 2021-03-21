<?php 
/**
 * 页面底部信息
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>

</div>
</div>

<hr>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <p class="copyright text-muted">
                    Powered by <a href="http://www.emlog.net">emlog</a>
                    <br>
                    <a href="https://beian.miit.gov.cn" target="_blank"><?php echo $icp; ?>
                    </a> <?php echo $footer_info; ?>
                    <?php doAction('index_footer'); ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo TEMPLATE_URL; ?>js/jquery.min.3.5.1.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo TEMPLATE_URL; ?>js/common_tpl.js" type="text/javascript"></script>

</body>
</html>