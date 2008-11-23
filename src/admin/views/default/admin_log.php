<?php if(!defined('ADMIN_ROOT')) {exit('error!');} ?>
<script type='text/javascript'>
$(document).ready(function(){
	
	$("#adm_log_list tbody tr:odd").addClass("tralt_b");
	$("#adm_log_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")});
});
</script>
<div class=containertitle><b><?php echo $pwd; ?></b></div>
<div class=line></div>
<form action="admin_log.php?action=admin_all_log" method="post" name="form" id="form">
  <input type="hidden" name="pid" value="<?php echo $pid; ?>">
  <table width="95%" id="adm_log_list">
  <thead>
      <tr class="rowstop">
        <td width="21"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="517"><b>标题</b></td>
        <td width="146"><b>分类</b></td>
        <td width="116"><b><a href="./admin_log.php?sortDate=<?php echo $sortDate.$sorturl; ?>">时间</a></b></td>
		<td width="51"><b><a href="./admin_log.php?sortComm=<?php echo $sortComm.$sorturl; ?>">评论</a></b></td>
		<td width="51"><b><a href="./admin_log.php?sortView=<?php echo $sortView.$sorturl; ?>">阅读</a></b></td>
		<td width="105"></td>
      </tr>
	</thead>
 	<tbody>
	<?php 
	foreach($logs as $key=>$value):
	$sortName = $emSort->getSortName($value['sortid']);
	$tags = $emTag->getTag($value['gid']);
	$tagStr = '';
	foreach ($tags as $val)
	{
		$tagStr .="<span class=logtag><a href=\"./admin_log.php?tag={$val['tagname']}\">{$val['tagname']}</a></span>";
	}
	if($tagStr)
	{
		$tagStr = '<span class=logtags>'.$tagStr.'</span>';
	}
	?>
      <tr>
      <td><input type="checkbox" name="blog[<?php echo $value['gid']; ?>]" value="1" /></td>
      <td width="517"><a href="edit_log.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> <?php echo $value['attach']; ?> <?php echo $value['istop']; ?> <?php echo $tagStr; ?></td>
      <td><a href="./admin_log.php?sid=<?php echo $value['sortid']; ?>"><?php echo $sortName; ?></a></td>
      <td><?php echo $value['date']; ?></td>
	  <td><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
	  <td><?php echo $value['views']; ?></a></td>
      <td>
      <?php if ($pid == 'draft'): ?>
      <a href="javascript: em_confirm(<?php echo $value['gid']; ?>, 'draft');">删除</a>
      <?php else: ?>
      <a href="javascript: em_confirm(<?php echo $value['gid']; ?>, 'log');">删除</a>
      <?php endif; ?>
      </td>
      </tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
    <tr class="rowstop">
    <td colspan="7">执行操作：
    <input type="radio" value="del_log" name="modall" />删除
	<?php if($pid == 'draft'): ?>
	<input type="radio" value="show" name="modall"/>发布
	<?php else: ?>
	<input type="radio" value="top" name="modall" />推荐
    <input type="radio" value="notop" name="modall"/> 取消推荐
	<input type="radio" value="hide" name="modall" />转入草稿箱
	<input type="radio" value="move" name="modall" />移动到
	<select name="sort">
	<option value="-1">选择分类...</option>
	<?php foreach($sorts as $val):?>
		<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
	<?php endforeach;?>
	</select>
	<?php endif;?>
    </tr>
    <tr>
    <td align="right" colspan="7">(共<?php echo $logNum; ?>条日志/每页最多显示15条) <?php echo $pageurl; ?></td>
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