<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./template.php"><? echo $lang['template_current']; ?></a>
<a class="navi2" href="./template.php?action=install"><? echo $lang['template_install']; ?></a>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['template_zip_only']; ?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['template_not_writable']; ?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['template_zip_nosupport']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"></ echo $lang['template_upload_zip']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['template_non_standard']; ?></span><?php endif;?>
</div>
<?php if(isset($_GET['error_c'])): ?>
<div style="margin:20px 10px;">
<div class="des">
<? echo $lang['template_install_manually']; ?>
</div>
</div>
<?php endif; ?>
<div style="margin:20px 10px;">
<div class="des"><? echo $lang['template_upload_zip']; ?><a href="http://www.emlog.net/template/" target="_blank"> <? echo $lang['templates_more']; ?> &raquo;</a></div>
</div>
<form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data" >
<div id="topimg_custom">
	<li></li>
	<li>
	<input name="tplzip" type="file" />
	<input type="submit" value="<? echo $lang['upload']; ?>" class="submit" />
	</li>
</div>
</form>