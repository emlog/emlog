<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class=containertitle><b>数据库备份</b></div>
<div class=line></div>
  <form action="backupdata.php?action=bakstart" method="post">
<table width="95%" align="center" border="0">
    <tbody>
      <tr>
        <td valign="top" width="65">选择要备份的数据库表:<br /></td>
        <td width="608"><select multiple="multiple" size="12" name="table_box[]">
<!--
EOT;
foreach($tables  as $value){
print <<<EOT
-->		
	<option value="$db_prefix$value" selected="selected">$db_prefix$value</option>
<!--
EOT;
}print <<<EOT
-->		  
      </select></td>
      </tr>
      <tr>
        <td align="left" width="65">备份文件名:</td>
        <td valign="top" class="care">	  
		<input maxlength="200" size="35" value="$defname" name="bakfname" />
		文件名只能由英文字母、数字、下划线组成</td>
      </tr>      <tr>
        <td align="left" width="65"></td>
        <td valign="top">	  
		<input type="submit" value="确定备份" class="submit2" />
        </td>
      </tr>
    </tbody>
</table>
  </form>
<!--
EOT;
?>-->