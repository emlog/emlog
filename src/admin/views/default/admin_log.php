<?php 
if(!defined('ADMIN_ROOT')) {exit('error!');}
$isdraft = $pid == 'draft' ? '&pid=draft' : '';
$isDisplaySort = !$sid ? "style=\"display:none;\"" : '';
$isDisplayTag = !$tag ? "style=\"display:none;\"" : '';
?>
<script type='text/javascript'>
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
</script>
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
<span <?php echo !$sid && !$tag ?  "class=\"filter\"" : ''; ?>><a href="./admin_log.php?<?php echo $isdraft; ?>">全部</a></span>
<span id="f_t_sort"><a href="javascript:void(0);">分类<a></span>
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
	$a = 'sort_'.md5($val['tagname']);
	$$a = '';
	$b = 'sort_'.md5($tag);
	$$b = "class=\"filter\"";
?>
	<span <?php echo $$a; ?>><a href="./admin_log.php?tag=<?php echo urlencode($val['tagname']).$isdraft; ?>"><?php echo $val['tagname']; ?></a></span>
<?php endforeach;?>
</div>
</div>
<form action="admin_log.php?action=admin_all_log" method="post" name="form" id="form">
  <input type="hidden" name="pid" value="<?php echo $pid; ?>">
  <table width="95%" id="adm_log_list">
  <thead>
      <tr class="rowstop">
        <td width="21"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></td>
        <td width="517"><b>标题</b></td>
        <td width="146"><b>分类</b></td>
        <td width="138"><b><a href="./admin_log.php?sortDate=<?php echo $sortDate.$sorturl; ?>">时间</a></b></td>
		<td width="40"><b><a href="./admin_log.php?sortComm=<?php echo $sortComm.$sorturl; ?>">评论</a></b></td>
		<td width="40"><b><a href="./admin_log.php?sortView=<?php echo $sortView.$sorturl; ?>">阅读</a></b></td>
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
		$tagUrl = urlencode($val['tagname']);
		$tagStr .="<span class=logtag><a href=\"./admin_log.php?tag={$tagUrl}$isdraft\">{$val['tagname']}</a></span>";
	}
	if($tagStr)
	{
		$tagStr = '<span class=logtags>'.$tagStr.'</span>';
	}
	?>
      <tr>
      <td><input type="checkbox" name="blog[<?php echo $value['gid']; ?>]" value="1" /></td>
      <td width="517">
      <a href="write_log.php?action=edit&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> 
      <?php echo $value['attnum']; ?>
      <?php echo $value['istop']; ?>
      <?php echo $tagStr; ?>
      </td>
      <td><a href="./admin_log.php?sid=<?php echo $value['sortid'].$isdraft;?>"><?php echo $sortName; ?></a></td>
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