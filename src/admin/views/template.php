<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle2">
<!--vot--><a class="navi3" href="./template.php"><?=lang('template_current')?></a>
<!--vot--><a class="navi4" href="./template.php?action=install"><?=lang('template_mount')?></a>
<!--vot--><?php if(isset($_GET['activated'])):?><span class="actived"><?=lang('template_change_ok')?></span><?php endif;?>
</div>
<?php if(!$nonceTplData): ?>
<!--vot--><div class="error_msg"><?=lang('template_current_use')?> (<?php echo $nonce_templet; ?>) <?=lang('template_damaged')?></div>
<?php else:?>
<table cellspacing="20" cellpadding="0" width="80%" border="0">
    <tr>
      <td width="42%">
      <img src="<?php echo TPLS_URL.$nonce_templet; ?>/preview.jpg" width="240" height="180"  border="1" />	  </td>
      <td width="58%">
      <?php echo $tplName; ?> <em><?php echo $tplVer; ?></em><br>
      <?php echo $tplAuthor; ?><br>
      <?php echo $tplDes; ?>
      <?php if ('default' == $nonce_templet): ?>
<!--vot--><div class="custom_top_button"><a href="./template.php?action=custom-top"><i class="custom_top"></i><?=lang('template_top_image')?></a></div>
      <?php endif; ?>
      </td>
    </tr>
</table>
<?php endif;?>
<div class="containertitle2">
<!--vot--><span class="navi3"><?=lang('template_library')?> (<?php echo $tplnums; ?>)</span>
<a name="tpllib"></a>
<!--vot--><?php if(isset($_GET['activate_install'])):?><span class="actived"><?=lang('template_upload_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['activate_del'])):?><span class="actived"><?=lang('template_delete_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('template_delete_failed')?></span><?php endif;?>
</div>
<table cellspacing="0" cellpadding="0" width="99%" border="0" class="adm_tpl_list">
<?php 
$i = 0;
foreach($tpls as $key=>$value):
if($i % 3 == 0){echo "<tr>";}
$i++;
?>
      <td align="center" width="300">
      <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>&token=<?php echo LoginAuth::genToken(); ?>">
<!--vot--><img alt="<?=lang('template_use_this')?>" src="<?php echo TPLS_URL.$value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
      </a><br />
      <?php echo $value['tplname']; ?>
<!--vot--><span> | <a href="javascript: em_confirm('<?php echo $value['tplfile']; ?>', 'tpl', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a></span>
      </td>
<?php 
if($i > 0 && $i % 3 == 0){echo "</tr>";}
endforeach; 
?>
</table>
<script>
setTimeout(hideActived,2600);
$("#menu_tpl").addClass('sidebarsubmenu1');
</script>