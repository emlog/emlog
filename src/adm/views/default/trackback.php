<?php if(!defined('ADM_ROOT')) {exit('error!');}?>
<SCRIPT type="text/javascript" language=JavaScript>
function CheckAll(form) {
	for (var i=0;i<form.elements.length;i++) {
	var e = form.elements[i];
	if (e.name != 'chkall')
	e.checked = form.chkall.checked;}
	}
</SCRIPT>
<div class=containertitle><b>引用管理</b></div>
<div class=line></div>
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="95%">
    <tbody>
      <tr class="rowstop">
        <td width="10"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="400"><b>标题</b></td>
        <td width="180"><b>来源</b></td>
		<td width="120"><b>IP</b></td>
        <td width="150"><b>时间</b></td>
        <td width="80"></td>
      </tr>
    </tbody>
	<tbody>
<?php
foreach($trackback as $key=>$value):
?>	
      <tr class="<?php echo $value['rowbg']; ?>">
        <td><input type="checkbox" name="tb[<?php echo $value['tbid']; ?>]" value="1" ></td>
        <td><a href="<?php echo $value['url']; ?>"><?php echo $value['title']; ?></a></td>
        <td><?php echo $value['blog_name']; ?></td>
        <td><?php echo $value['ip']; ?></td>
        <td><?php echo $value['date']; ?></td>
        <td> <a href="javascript: isdel(<?php echo $value['tbid']; ?>, 4);">删除</a> </td>
      </tr>
<?php endforeach; ?>	
	  <tr>
      <td align="right" colspan="7">(共<?php echo $num; ?>条引用/每页最多显示15条) <?php echo $pageurl; ?></td>
    </tr>  
    </tbody>
  </table>
  <table width="95%">
    <tbody>
      <tr>
        <td align="center" colspan="5">
			  <input type="submit" value="删除所选引用" class="submit2" />
		</td>
      </tr>
    </tbody>
  </table>
</form>