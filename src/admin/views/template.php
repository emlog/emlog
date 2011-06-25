<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class="containertitle2">
<a class="navi3" href="./template.php">当前模板</a>
<a class="navi4" href="./template.php">安装模板</a>
<?php if(isset($_GET['activated'])):?><span class="actived">模板更换成功</span><?php endif;?>
</div>
<?php if(!$nonceTplData): ?>
<div class="error_msg">当前使用的模板(<?php echo $nonce_templet; ?>)已被删除或损坏，请选择其他模板。</div>
<?php else:?>
<table cellspacing="20" cellpadding="0" width="80%" border="0">
    <tr>
      <td width="27%">
	  <img src="<?php echo TPLS_URL.$nonce_templet; ?>/preview.jpg" width="300" height="225"  border="1" />	  </td>
	  <td width="73%">
	  <?php echo $tplName; ?><br>
	  <?php echo $tplAuthor; ?><br>
	  <?php echo $tplDes; ?><br>
	  <?php if ('default' == $nonce_templet): ?>
	  <div class="custom_top_button"><a href="./template.php?action=custom-top">自定义顶部图片</a></div>
	  <?php endif; ?>
	  </td>
    </tr>
</table>
<?php endif;?>
<div class="containertitle2">
<span class="navi3">模板库 (<?php echo $tplnums; ?>)</span>
</div>
<table cellspacing="0" cellpadding="0" width="99%" border="0" class="adm_tpl_list">
<?php 
$i = 0;
foreach($tpls as $key=>$value):
if($i % 3 == 0){echo "<tr>";}
$i++;
?>
      <td align="center" width="300">
	  <a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>">
	  <img alt="点击使用该模板" src="<?php echo TPLS_URL.$value['tplfile']; ?>/preview.jpg" width="180" height="150" border="0" />
	  </a><br />
      <b><a href="template.php?action=usetpl&tpl=<?php echo $value['tplfile']; ?>&side=<?php echo $value['sidebar']; ?>" title="点击使用该模板"><?php echo $value['tplname']; ?></a></b><br />
      </td>
<?php 
if($i > 0 && $i % 3 == 0){echo "</tr>";}
endforeach; 
?>
</table>