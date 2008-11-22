<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
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
<form action="trackback.php?action=dell_all_tb" method="post">
  <table width="95%" id="adm_tb_list">
  <thead>
      <tr class="rowstop">
        <td width="10"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="400"><b>标题</b></td>
        <td width="180"><b>来源</b></td>
		<td width="120"><b>IP</b></td>
        <td width="150"><b>时间</b></td>
        <td width="80"></td>
      </tr>
  </thead>
  <tbody>
	<?php foreach($trackback as $key=>$value):?>	
      <tr>
        <td><input type="checkbox" name="tb[<?php echo $value['tbid']; ?>]" value="1" ></td>
        <td><a href="<?php echo $value['url']; ?>"><?php echo $value['title']; ?></a></td>
        <td><?php echo $value['blog_name']; ?></td>
        <td><?php echo $value['ip']; ?></td>
        <td><?php echo $value['date']; ?></td>
        <td> <a href="javascript: em_confirm(<?php echo $value['tbid']; ?>, 'trackback');">删除</a> </td>
      </tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
	  <tr>
      <td align="right" colspan="7">(共<?php echo $num; ?>条引用/每页最多显示15条) <?php echo $pageurl; ?></td>
      </tr>  
      <tr>
        <td align="center" colspan="5">
		<input type="submit" value="删除所选引用" class="submit2" />
		</td>
      </tr>
    </tfoot>
  </table>
</form>