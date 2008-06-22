<?php if(!defined('ADM_ROOT')) {exit('error!');}?>
<div class=containertitle><b>模板设置</b></div>
<div class=line></div>
<table cellspacing="0" cellpadding="0" width="95%" border="0" align="center">
  <tbody>
    <tr>
      <td width="74%" class="care"><br />
	  <b>当前使用的模板：<?php echo $tplname; ?></b> </td>
      <td width="26%">
	  <img height="73" alt="" src="<?php echo $tpl_dir; ?><?php echo $tplname; ?>/preview.jpg" width="100" border="1" /></td>
    </tr>
  </tbody>
</table>
<br />
<table cellspacing="0" cellpadding="0" width="95%" border="0" align="center">
  <tbody>
    <tr class="rowstop">
      <td width="35%"><b>缩略图</b></td>
      <td width="65%"><b>模板说明</b></td>
    </tr>
<?php foreach($tpls as $key=>$value):?>
    <tr>
      <td align="left" class=tempImg>
	  <a href="template.php?action=usetpl&tplname=<?php echo $value; ?>">
	  <img height="136" alt="使用该模板" src="<?php echo $tpl_dir; ?><?php echo $value; ?>/preview.jpg" width="154" border="0" /></a></td>
      <td valign="top"><br />
          <b><?php echo $value; ?></b><br />
        <br /><a href="template.php?action=usetpl&tplname=<?php echo $value; ?>">使用该模板</a><br />
        <br /></td>
    </tr>
		<tr>
          <td colSpan=2>
            <div class=line style="width: 100%"></div></td></tr>
        <tr>
    <tr>
<?php endforeach; ?>
      <td align="center" colspan="2" class="care">目前共有 <?php echo $tplnums; ?> 个可选模板，更多模板请登录<a href="http://www.emlog.net" target="_blank">emlog官方站点</a>下载。</td>
    </tr>
		<tr>
          <td colSpan=2>
            <div class=line style="width: 100%"></div></td></tr>
        <tr>
    <tr>
  </tbody>
</table>