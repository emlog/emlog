<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b><? echo $lang['template_current'];?></b><?php if(isset($_GET['activated'])):?><span class="actived"><? echo $lang['template_changed_successfully'];?></span><?php endif;?></div>
<div class=line></div>
<table cellspacing="10" cellpadding="0" width="80%" border="0">
    <tr>
      <td width="27%">
	  <img src="<?php echo $template_path.$nonce_templet; ?>/preview.jpg" width="300" height="225"  border="1" />	  </td>
	  <td width="73%">
	  <?php echo $tplName; ?><br>
	  <?php echo $tplAuthor; ?><br>
	  <?php echo $tplDes; ?><br>
	  </td>
    </tr>
</table>
<div class=containertitle><b><? echo $lang['templates_are_available'];?></b></div>
<div class=template_line><? echo $lang['templates_available'];?>: <?php echo $tplnums; ?>.  <a href="http://www.emlog.net/template/" target="_blank"><? echo $lang['templates_more'];?> &raquo;</a></div>
<table cellspacing="0" cellpadding="0" width="99%" border="0" class="adm_tpl_list">
<?php 
$i = 0;
foreach($tpls as $key=>$value):
if($i % 3 == 0){echo "<tr>";}
$i++;
?>
      <td align="center" width="300">
	  <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>">
	  <img alt="<? echo $lang['template_click'];?>" src="<?php echo $template_path.$value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
	  </a><br />
      <b><a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>" title="<? echo $lang['template_click'];?>"><?php echo $value['tplname']; ?></a></b><br />
      </td>
<?php 
if($i > 0 && $i % 3 == 0){echo "</tr>";}
endforeach; 
?>
</table>