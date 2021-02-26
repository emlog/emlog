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
                <hr>
<!--vot-->      <?=lang('powered_by')?> <a href="http://www.emlog.net">emlog</a>
                <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <?php echo $footer_info; ?>
                <?php doAction('index_footer'); ?>
            </div>
        </div>
    </div>
</footer>
<script>
$(document).ready(function(){
	dropdownOpen();//Expand the submenu mouse across it, so need to click to expand
    prettyPrint();
});
function dropdownOpen() {
	var $dropdownLi = $('li.dropdown');
	$dropdownLi.mouseover(function() {
		$(this).addClass('open');
	}).mouseout(function() {
		$(this).removeClass('open');
	});
}
</script>
</body>
</html>