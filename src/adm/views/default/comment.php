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
<div class=containertitle><b>评论管理</b></div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
  <table width="95%" >
    <tbody>
      <tr class="rowstop">
        <td width="28"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="402"><b>评论内容</b></td>
        <td width="122"><b>评论者</b></td>
        <td width="116"><b>时间</b></td>
        <td width="234" colspan="3"></td>
      </tr>
<!--
EOT;
foreach($comment as $key=>$value){
$ishide = $value['hide']=='y'?'<font color="red">[未审核]</font>':'';
$isrp = $value['reply']?'<font color="green">[已回复]</font>':'';
$rowbg = getRowbg();
print <<<EOT
-->      <tr class="$rowbg">
        <td><input type="checkbox" value="$value[hide]" name="com[$value[cid]]" /></td>
        <td>$value[comment] $ishide $isrp</td>
        <td>$value[poster]</td>
        <td>$value[date]</td>
        <td>
        <a href="comment.php?action=reply_comment&amp;cid=$value[cid]&amp;hide=$value[hide]">回复</a>
        <a href="comment.php?action=show_comment&amp;cid=$value[cid]&amp;hide=$value[hide]">审核</a>
        <a href="comment.php?action=kill_comment&amp;cid=$value[cid]&amp;hide=$value[hide]">屏蔽</a>
        <a href="javascript: isdel($value[cid], 1);">删除</a>
		</td>
      	</tr>
<!--
EOT;
}print <<<EOT
-->
    </tbody>
    <tbody>
      <tr class="rowstop">
        <td colspan="7">对选中的评论执行操作：
          <input type="radio" value="delcom" name="modall" />
          删除
          <input type="radio" value="killcom" name="modall" />
          屏蔽
          <input type="radio" value="showcom" name="modall" />
          审核
      </tr>
	  <tr>
      <td align="right" colspan="7">(共{$num}条评论/每页最多显示15条) $pageurl</td>
    </tr>
	  <tr><td align="center" colspan="7">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />
	  </td></tr>
	 </tbody>
  </table>
</form>
<!--
EOT;
?>-->