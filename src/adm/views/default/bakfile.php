<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<SCRIPT type="text/javascript" language=JavaScript>
function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
	var e = form.elements[i];
	if (e.name != 'chkall')
	e.checked = form.chkall.checked;}
	}
</SCRIPT>
<div class=containertitle><b>备份管理</b></div>
<div class=line></div>
<form  method="post" action="backupdata.php?action=dell_all_bak">
<table width="95%">
  <tbody>
    <tr class="rowstop">
      <td width="34"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
      <td width="480"><b>备份文件</b></td>
      <td width="170"><b>备份时间</b></td>
      <td width="112"><b>文件大小</b></td>
      <td width="63"></td>
    </tr>
<!--
EOT;
foreach($bakfiles  as $value){
	$modtime = date('Y-m-d H:i:s',filemtime($value));
	$size =  changeFileSize(filesize($value));
	$bakname = substr(strrchr($value,'/'),1);
	$rowbg = getRowbg();
print <<<EOT
-->
    <tr class="$rowbg">
      <td><input type="checkbox" value="$value" name="bak[$value]" /></td>
      <td>$bakname</a></td>
      <td>$modtime</td>
      <td>$size</td>
      <td><a href="javascript: isdel('$value', 5);">导入</a></td>
    </tr>
<!--
EOT;
}print <<<EOT
-->	
	
  </tbody>
  <tbody>
    <tr>
      <td colspan="5" class="notice"><b>警告:</b>
        如果你的mysql版本为4.1或者更高版本,恢复数据库之前请先确认安装emlog的数据库字符集为utf8,如不是请修改为utf8   ，设置方法可以参看&quot;安装说明&quot;，否则将导致数据丢失！</td>
    </tr>
    <tr>
      <td align="center" colspan="5">
	  	  <input type="submit" value="删除所选备份" class="submit2" />
</td>
    </tr>
  </tbody>
</table>
</form>
<!--
EOT;
?>-->