<!--<?php 
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
<div class=containertitle><b>$pwd</b></div>
<div class=line></div>
<form action="admin_log.php?action=admin_all_log" method="post" name="form" id="form">
  <table width="95%" >
    <tbody>
      <tr class="rowstop">
        <td width="21"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="517"><b>标题</b></td>
        <td width="146"><b>时间</b></td>
		    <td width="113"><b>评论</b></td>
        <td width="105"></td>
      </tr>
<!--
EOT;
foreach($logs as $key=>$value){
print <<<EOT
-->
      <tr class="$value[rowbg]">
        <td><input type="checkbox" name="blog[$value[gid]]" value="1" /></td>
        <td width="517"><a href="admin_log.php?action=mod&amp;gid=$value[gid]">$value[title]</a> $value[attach] $value[istop]</td>
        <td>$value[date]</td>
		<td><a href="comment.php?gid=$value[gid]">$value[comnum]</a></td>
        <td><a href="../index.php?action=showlog&gid=$value[gid]" target="_blank">预览</a>  
        <a href="javascript: isdel($value[gid], 3);">删除</a></td>
      </tr>
<!--
EOT;
}print <<<EOT
-->
    <tbody>
      <tr class="rowstop">
        <td colspan="6">执行操作：
            <input type="radio" value="del_log" name="modall" />删除
		  	$log_act
      </tr>
    <tr>
      <td align="right" colspan="6">(共{$num}条日志/每页最多显示15条) $pageurl</td>
    </tr>	  
	<tr><td align="center" colspan="6">
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