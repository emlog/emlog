<?php if(!defined('ADM_ROOT')) {exit('error!');} ?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_log_list tbody tr:odd").addClass("tralt_b");
	$("#adm_log_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
</script>
<div class=containertitle><b><?php echo $pwd; ?></b></div>
<div class=line></div>
<form action="admin_log.php?action=admin_all_log" method="post" name="form" id="form">
  <table width="95%" id="adm_log_list">
  <thead>
      <tr class="rowstop">
        <td width="21"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="517"><b><a href="./admin_log.php?sortTitle=<?php echo $sortTitle.$sorturl; ?>">标题</a></b></td>
        <td width="146"><b><a href="./admin_log.php?sortDate=<?php echo $sortDate.$sorturl; ?>">时间</a></b></td>
		<td width="51"><b><a href="./admin_log.php?sortComm=<?php echo $sortComm.$sorturl; ?>">评论</a></b></td>
		<td width="51"><b><a href="./admin_log.php?sortView=<?php echo $sortView.$sorturl; ?>">阅读</a></b></td>
		<td width="105"></td>
      </tr>
	</thead>
 	<tbody>
	<?php foreach($logs as $key=>$value): ?>
      <tr>
      <td><input type="checkbox" name="blog[<?php echo $value['gid']; ?>]" value="1" /></td>
      <td width="517"><a href="admin_log.php?action=mod&amp;gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> <?php echo $value['attach']; ?> <?php echo $value['istop']; ?></td>
      <td><?php echo $value['date']; ?></td>
	  <td><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
	  <td><?php echo $value['views']; ?></a></td>
      <td><a href="javascript: isdel(<?php echo $value['gid']; ?>, 3);">删除</a></td>
      </tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
    <tr class="rowstop">
    <td colspan="6">执行操作：
          <input type="radio" value="del_log" name="modall" />删除
		  <?php echo $log_act; ?>
    </tr>
    <tr>
    <td align="right" colspan="6">(共<?php echo $num; ?>条日志/每页最多显示15条) <?php echo $pageurl; ?></td>
    </tr>	  
	<tr>
	<td align="center" colspan="6">
	  <input type="submit" value="确 定" class="submit2" />
      <input type="reset" value="重 置" class="submit2" />
	</td>
	</tr>
	</tfoot>
</table>
</form>