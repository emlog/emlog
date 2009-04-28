<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>页面管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除页面成功</span><?php endif;?>
<?php if(isset($_GET['active_hide_n'])):?><span class="actived">发布页面成功</span><?php endif;?>
<?php if(isset($_GET['active_hide_y'])):?><span class="actived">禁用页面成功</span><?php endif;?>
</div>
<div class=line></div>
<form action="comment.php?action=admin_all_coms" method="post" name="form" id="form">
  <table width="95%" id="adm_comment_list">
  	<thead>
      <tr class="rowstop">
        <td width="420"><b>标题</b></td>
        <td width="30" align="center"><b>查看</b></td>
        <td width="150"><b>时间</b></td>
        <td width="30" align="center"><b>评论</b></td>
        <td width="150"></td>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($pages as $key => $value):
	if (empty($navibar[$value['gid']]['url']))
	{
		$navibar[$value['gid']]['url'] = '../?action=showlog&gid='.$value['gid'];
	}
	if ($value['hide'] == 'y')
	{
		$isHide = "<font color=\"red\">[未发布]</font>";
		$dohide = "<a href=\"page.php?action=ishide&ishide=n&pid={$value['gid']}\">发布</a>";
	}else{
		$isHide = '';
		$dohide = "<a href=\"page.php?action=ishide&ishide=y&pid={$value['gid']}\">禁用</a>";		
	}
	?>
     <tr>
        <td><a href="page.php?action=mod&id=<?php echo $value['gid']?>"><?php echo $value['title']; ?></a> <?php echo $isHide; ?></td>
		<td align="center">
		<a href="<?php echo $navibar[$value['gid']]['url']; ?>" target="_blank" title="在新窗口查看">
		<img src="./views/<?php echo ADMIN_TPL; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
		</td>
        <td><?php echo $value['date']; ?></td>
        <td align="center"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
        <td><?php echo $dohide;?> <a href="javascript: em_confirm(<?php echo $value['gid']; ?>, 'page');">删除</a></td>
     </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
</form>
<div style="margin:30px 0px 0px 4px;"><span class="adm_link"><a href="page.php?action=new">新建一个页面&raquo;</a></span></div>