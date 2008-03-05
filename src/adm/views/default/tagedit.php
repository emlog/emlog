<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class=containertitle><b>标签修改</b></div>
<div class=line></div>
<form  method="post" action="tag.php?action=update_tag">
<table width="95%" align="center">
  <tbody>
    <tr>
      <td><input size="40" value="$tagname" name="tagname" /></td>
    </tr>
    <tr>
      <td colspan="2">
		<input type="hidden" value="$tagid" name="tid" />
		<input type="submit" value="确 定" class="submit2" />
		<input type="button" value="取 消" class="submit2" onclick="javascript: window.history.back();"/>
	</td>
    </tr>
  </tbody>
</table>
</form>
<!--
EOT;
?>-->