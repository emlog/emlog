<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi1" href="./configure.php"><? echo $lang['base_settings']; ?></a>
<a class="navi4" href="./seo.php">SEO设置</a>
<a class="navi2" href="./style.php"><? echo $lang['backstage_style']; ?></a>
<a class="navi4" href="./blogger.php"><? echo $lang['personal_data']; ?></a>
<?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?>
</div>
<form action="configure.php?action=mod_config" method="post" name="input" id="input">
<div id="admin_style">
	<?php 
	foreach ($styles as $key=>$value): 
	$style = $value['style_file'];
	?>
	<div>
	<a href="./style.php?action=usestyle&style=<?php echo $style; ?>" title="<? echo $lang['use_this_style']; ?>" >
	<img src="<?php echo $style_path.$style; ?>/preview.jpg" width="230px" height="48px" class="styleTH" />
	</a>
	<li class="admin_style_info" >
	<?php if($style == Option::get('admin_style')): ?>
	<img src="./views/images/onsel.gif" align="absmiddle" />
	<?php endif;?>
	<a href="./style.php?action=usestyle&style=<?php echo $style; ?>" title="<? echo $lang['use_this_style']; ?>" ><?php echo $value['style_name']; ?></a> <br /><span><?php echo $value['style_author'];?></span></li>
	</div>
	<?php endforeach;?>
</div>
</form>