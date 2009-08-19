<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script type='text/javascript'>
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>评论管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除评论成功</span><?php endif;?>
<?php if(isset($_GET['active_show'])):?><span class="actived">审核评论成功</span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived">屏蔽评论成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">请选择要执行操作的评论</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">请选择要执行的操作</span><?php endif;?>
<?php if(isset($_GET['active_rep'])):?><span class="actived">回复评论成功</span><?php endif;?>
</div>
<div class=line></div>
<?php if ($hideCommNum > 0) : 
$hide_ = $hide_y = $hide_n = '';
$a = "hide_$hide";
$$a = "class=\"filter\"";
?>
<div class="filters">
<span <?php echo $hide_; ?>><a href="./comment.php?<?php echo $addUrl_1 ?>">全部</a></span>
<span <?php echo $hide_y; ?>><a href="./comment.php?hide=y&<?php echo $addUrl_1 ?>">未审核
<?php
$hidecmnum = ROLE == 'admin' ? $sta_cache['hidecomnum'] : $user_cache[UID]['hidecommentnum'];
if ($hidecmnum > 0) echo '('.$hidecmnum.')';
?>
</a></span>
<span <?php echo $hide_n; ?>><a href="comment.php?hide=n&<?php echo $addUrl_1 ?>">已审核</a></span>
</div>
<?php endif; ?>
<form action="comment.php?action=admin_all_coms" method="post" name="form_com" id="form_com">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
        <th width="19"><input onclick="CheckAll(this.form)" type="checkbox" value="on" name="chkall" /></th>
        <th width="380"><b>内容</b></th>
        <th width="120"><b>时间</b></th>
        <th width="260"><b>所属日志</b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	foreach($comment as $key=>$value):
	$ishide = $value['hide']=='y'?'<font color="red">[未审核]</font>':'';
	$isrp = $value['reply']?'<font color="green">[已回复]</font>':'';
	$ip = !empty($value['ip']) ? "({$value['ip']})" : '';
	$mail = !empty($value['mail']) ? "<br />邮箱：{$value['mail']}" : '';
	$poster = !empty($value['url']) ? '<a href="'.$value['url'].'" target="_blank">'. $value['poster'].'</a>' : $value['poster'];
	$value['content'] = subString(str_replace('<br>','',$value['content']),0,50);
	$value['title'] = subString($value['title'],0,42);
	?>
     <tr>
        <td><input type="checkbox" value="" name="com[<?php echo $value['cid']; ?>]" class="ids" /></td>
        <td><a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>&amp;hide=<?php echo $value['hide']; ?>"><?php echo $value['content']; ?></a> <?php echo $ishide; ?> <?php echo $isrp; ?>
        <br />来自：<?php echo $poster;?> <?php echo $ip;?> <?php echo $mail;?> 
        </td>
        <td><?php echo $value['date']; ?></td>
        <td><a href="../?post=<?php echo $value['gid']; ?>" target="_blank" title="查看该日志"><?php echo $value['title']; ?></a></td>
     </tr>
	<?php endforeach; ?>
	</tbody>
  </table>
	<div class="list_footer">
	选中项：
    <a href="javascript:commentact('del');">删除</a>
	<a href="javascript:commentact('hide');">屏蔽</a>
	<a href="javascript:commentact('pub');">审核</a>
	<input name="operate" id="operate" value="" type="hidden" />
	</div>
    <div class="page">(有<?php echo $cmnum; ?>条评论)<?php echo $pageurl; ?></div> 
</form>
<script>
function commentact(act){
	if (getChecked('ids') == false) {
		alert('请选择要操作的评论');
		return;
	}
	if(act == 'del' && !confirm('你确定要删除所选评论吗？')){return;}
	$("#operate").val(act);
	$("#form_com").submit();
}
$("#menu_cm").addClass('sidebarsubmenu1');
</script>