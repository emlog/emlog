<?php 
/**
 * Page Bottom Information
 */
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
	</div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 footer-below">
                <p>Themes and templates licensed under the <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache License v2.0</a>.
                <br>Based on <a href="http://getbootstrap.com/">Bootstrap</a>.</p>
            </div>
        </div>
    </div>
</footer>
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.11.0.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script src="<?php echo BLOG_URL; ?>admin/editor/plugins/code/prettify.js" type="text/javascript"></script>
<script src="<?php echo BLOG_URL; ?>include/lib/js/common_tpl.js" type="text/javascript"></script>
<script src="<?php echo BLOG_URL; ?>admin/views/js/bootstrap.min.js" type="text/javascript"></script>
<script>prettyPrint();</script>
</body>
</html>