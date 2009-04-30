<?php 
if(!defined('ADMIN_ROOT')) {exit('error!');}
$isdraft = $pid == 'draft' ? '&pid=draft' : '';
$isDisplaySort = !$sid ? "style=\"display:none;\"" : '';
$isDisplayTag = !$tagId ? "style=\"display:none;\"" : '';
?>
<div class=containertitle><b><?php echo $pwd; ?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除日志成功</span><?php endif;?>
<?php if(isset($_GET['active_up'])):?><span class="actived">推荐日志成功</span><?php endif;?>
<?php if(isset($_GET['active_down'])):?><span class="actived">取消推荐日志成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要处理的日志</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">请选择要执行的操作</span><?php endif;?>
<?php if(isset($_GET['active_post'])):?><span class="actived">发布日志成功</span><?php endif;?>
<?php if(isset($_GET['active_move'])):?><span class="actived">移动日志成功</span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived">转入草稿箱成功</span><?php endif;?>
</div>
<div class=line></div>
<div class="filters">
<div id="f_title">
<span <?php echo !$sid && !$tagId ?  "class=\"filter\"" : ''; ?>><a href="./admin_log.php?<?php echo $isdraft; ?>">全部</a></span>
<span id="f_t_sort"><a href="javascript:void(0);">分类</a></span>
<span id="f_t_tag"><a href="javascript:void(0);">标签</a></span>
</div>
<div id="f_sort" <?php echo $isDisplaySort ?>>
分类：
<span <?php echo $sid == -1 ?  "class=\"filter\"" : ''; ?>><a href="./admin_log.php?sid=-1&<?php echo $isdraft; ?>">未分类</a></span>
<?php foreach($sorts as $val):
	$a = "sort_{$val['sid']}";
	$$a = '';
	$b = "sort_$sid";
	$$b = "class=\"filter\"";
?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?sid=<?php echo $val['sid'].$isdraft; ?>"><?php echo $val['sortname']; ?></a></span>
<?php endforeach;?>
</div>
<div id="f_tag" <?php echo $isDisplayTag ?>>
标签：
<?php
foreach($tags as $val):
	$a = 'tag_'.$val['tid'];
	$$a = '';
	$b = 'tag_'.$tagId;
	$$b = "class=\"filter\"";
?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?tagid=<?php echo $val['tid'].$isdraft; ?>"><?php echo $val['tagname']; ?></a></span>
<?php endforeach;?>
</div>
</div>
<form action="admin_log.php?action=admin_all_log" method="post" name="form_log" id="form_log">
  <input type="hidden" name="pid" value="<?php echo $pid; ?>">
  <table width="95%" id="adm_log_list">
  <thead>
      <tr class="rowstop">
        <td width="21"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="490"><b>标题</b></td>
		<?php if ($pid != 'draft'): ?>
		<td width="40" align="center"><b>查看</b></td>
		<?php endif; ?>
        <td width="146"><b>分类</b></td>
        <td width="148"><b><a href="./admin_log.php?sortDate=<?php echo $sortDate.$sorturl; ?>">时间</a></b></td>
		<td width="40" align="center"><b><a href="./admin_log.php?sortComm=<?php echo $sortComm.$sorturl; ?>">评论</a></b></td>
		<td width="40" align="center"><b><a href="./admin_log.php?sortView=<?php echo $sortView.$sorturl; ?>">阅读</a></b></td>
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
		$tagStr .="<span class=logtag><a href=\"./admin_log.php?tagid={$val['tid']}$isdraft\">{$val['tagname']}</a></span>";
	}
	if($tagStr)
	{
		$tagStr = '<span class=logtags>'.$tagStr.'</span>';
	}
	?>
      <tr>
      <td><input type="checkbox" name="blog[<?php echo $value['gid']; ?>]" value="1" class="ids" /></td>
      <td width="517">
      <a href="write_log.php?action=edit&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> 
      <?php echo $value['attnum']; ?>
      <?php echo $value['istop']; ?>
      <?php echo $tagStr; ?>
      </td>
	  <?php if ($pid != 'draft'): ?>
	  <td align="center">
	  <a href="../?action=showlog&gid=<?php echo $value['gid']; ?>" target="_blank" title="在新窗口查看">
	  <img src="./views/<?php echo ADMIN_TPL; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
	  </td>
	  <?php endif; ?>
      <td><a href="./admin_log.php?sid=<?php echo $value['sortid'].$isdraft;?>"><?php echo $sortName; ?></a></td>
      <td><?php echo $value['date']; ?></td>
	  <td align="center"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
	  <td align="center"><?php echo $value['views']; ?></a></td>
      </tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	<div class="list_footer">
	选中项：
    <a href="javascript:logact('del');">删除</a>
	<?php if($pid == 'draft'): ?>
	<a href="javascript:logact('pub');">发布</a>
	<?php else: ?>
	<a href="javascript:logact('hide');">转入草稿箱</a>
	<a href="javascript:logact('top');">置顶</a>
    <a href="javascript:logact('notop');">取消置顶</a>
	<select name="sort" id="sort" onChange="move2sort(this);">
	<option value="" selected="selected">移动到分类...</option>
	<?php foreach($sorts as $val):?>
		<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
	<?php endforeach;?>
	<option value="-1">未分类</option>
	</select>
	<?php endif;?>
	<input name="operate" id="operate" value="" type="hidden" />
	</div>
    <div class="page"><?php echo $pageurl; ?></div>
</form>
<script>
$(document).ready(function(){
	$("#adm_log_list tbody tr:odd").addClass("tralt_b");
	$("#adm_log_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")});
	$("#f_t_sort").click(function(){
		$("#f_sort").toggle();
		$("#f_tag").hide();
	});
	$("#f_t_tag").click(function(){
		$("#f_tag").toggle();
		$("#f_sort").hide();
	})
});
setTimeout(hideActived,2600);
function logact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的日志');
		return;}
	if(act == 'del' && !confirm('你确定要删除所选日志吗？')){return;}
	$("#operate").val(act);
	$("#form_log").submit();
}
function move2sort(obj) {
	var sortId = obj.value;
	if (getChecked('ids') == false) {
		alert('请选择要操作的日志');
		return;}
	if($('#sort').val() == '')return;
	$("#operate").val('move');
	$("#form_log").submit();
}
</script>