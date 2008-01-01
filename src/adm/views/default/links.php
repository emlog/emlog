<!--
<?php
if(!defined('ADM_ROOT')) {exit('error!');} 
print <<<EOT
-->
<div class=containertitle><b>友站管理</b></div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="95%" align="center">
    <tbody>
      <tr class="rowstop">
        <td width="137"><b>友情站点</b></td>
        <td width="589"><b>站点排序</b></td>
        <td width="184" colspan="2"></td>
      </tr>
<!--
EOT;
foreach($links as $key=>$value){
print <<<EOT
-->	  
      <tr class="$value[rowbg]">
        <td>$value[sitename]</td>
        <td><input size="18" name="link[$value[id]]" value="$value[taxis]" maxlength="4" /></td>
        <td><a href="link.php?action=mod_link&amp;linkid=$value[id]">编辑</a>
        <a href="javascript: isdel($value[id], 2);">删除</a></td>
      </tr>
<!--
EOT;
}print <<<EOT
-->	  
	  
    </tbody>
  </table>
  <table width="95%" align="center">
    <tbody>
      <tr>
        <td align="center">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />
		</td>
      </tr>
    </tbody>
  </table>
</form>
<div class=containertitle><b>添加友情站点</b></div>
<div class=line></div>
<form action="link.php?action=addlink" method="post" name="link" id="link">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td>站点名称
            <br />
            <input maxlength="200" size="35" name="sitename" />
            <br /></td></tr>
        <tr nowrap="nowrap">
          <td>地址<b>(</b>站点地址必须以http://开头)<br />
  <input maxlength="200" size="35" name="siteurl" />
              <br /></td>
        </tr>
        <tr nowrap="nowrap">
          <td>描述（可选）不得超过255字节<br />
  <textarea name="description" rows="5" cols="40" type="text"></textarea>
              <br /></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />         
		  </td>
        </tr>
      </tbody>
    </table>
</form>
  <!--
EOT;
?>-->