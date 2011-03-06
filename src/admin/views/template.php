<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>当前模板</b><?php if(isset($_GET['activated'])):?><span class="actived">模板更换成功</span><?php endif;?></div>
<div class=line></div>
<?php if(!$nonceTplData): ?>
<div class="error_msg">当前使用的模板(<?php echo $nonce_templet; ?>)已被删除或损坏，请选择其他模板。</div>
<?php else:?>
<table cellspacing="10" cellpadding="0" width="80%" border="0">
    <tr>
      <td width="27%">
	  <img src="<?php echo TPLS_URL.$nonce_templet; ?>/preview.jpg" width="300" height="225"  border="1" />	  </td>
	  <td width="73%">
	  <?php echo $tplName; ?><br>
	  <?php echo $tplAuthor; ?><br>
	  <?php echo $tplDes; ?><br>
	  <?php if ('default' == $nonce_templet): ?>
	  <div><a href="./template.php?action=custom-top">自定义顶部图片</a></div>
	  <?php endif; ?>
	  </td>
    </tr>
</table>
<?php endif;?>
<div class=containertitle><b>可用模板</b></div>
<div class=template_line>当前共有<?php echo $tplnums; ?>个可用模板 <a href="http://www.emlog.net/template/" target="_blank">获取更多模板&raquo;</a></div>
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