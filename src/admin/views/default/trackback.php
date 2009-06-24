<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_tb_list tbody tr:odd").addClass("tralt_b");
	$("#adm_tb_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>引用管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除引用成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要执行操作的引用</span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell" method="post" name="form_tb" id="form_tb">
  <table width="100%" id="adm_tb_list">
  <thead>
      <tr class="rowstop">
        <td width="10"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="270"><b>标题</b></td>
        <td width="300"><b>来源</b></td>
		<td width="80"><b>IP</b></td>
        <td width="120"><b>时间</b></td>
      </tr>
  </thead>
  <tbody>
	<?php foreach($trackback as $key=>$value):?>	
      <tr>
        <td><input type="checkbox" name="tb[<?php echo $value['tbid']; ?>]" value="1" class="ids" ></td>
        <td><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['title']; ?></a></td>
        <td><?php echo $value['blog_name']; ?></td>
        <td><?php echo $value['ip']; ?></td>
        <td><?php echo $value['date']; ?></td>
      </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
	<div class="list_footer">
	选中项：
    <a href="javascript:tbact('del');">删除</a>
	</div>
  <div class="page">(有<?php echo $tbnum; ?>条引用)<?php echo $pageurl; ?></div> 
</form>
<script>
function tbact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的日志');
		return;
	}
	if(act == 'del' && !confirm('你确定要删除所选引用吗？')){return;}
	$("#operate").val(act);
	$("#form_tb").submit();
}
$("#menu_tb").addClass('sidebarsubmenu1');
</script>