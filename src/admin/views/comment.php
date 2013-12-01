<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['comments_management'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['comments_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_show'])):?><span class="actived"><? echo $lang['comments_approved_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_hide'])):?><span class="actived"><? echo $lang['comment_hide_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['comment_edit_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active_rep'])):?><span class="actived"><? echo $lang['comment_replied_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['comments_select'];?></span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error"><? echo $lang['comments_select_operation'];?></span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="error"><? echo $lang['reply_empty']; ?></span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="error"><? echo $lang['reply_is_long']; ?></span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="error"><? echo $lang['comment_empty']; ?></span><?php endif;?>
</div>
<div class=line></div>
<?php if ($hideCommNum > 0) : 
$hide_ = $hide_y = $hide_n = '';
$a = "hide_$hide";
$$a = "class=\"filter\"";
?>
<div class="filters">
<span <?php echo $hide_; ?>><a href="./comment.php?<?php echo $addUrl_1 ?>"><? echo $lang['all'];?></a></span>
<span <?php echo $hide_y; ?>><a href="./comment.php?hide=y&<?php echo $addUrl_1 ?>"><? echo $lang['pending'];?>
<?php
$hidecmnum = ROLE == ROLE_ADMIN ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
if ($hidecmnum > 0) echo '('.$hidecmnum.')';
?>
</a></span>
<span <?php echo $hide_n; ?>><a href="comment.php?hide=n&<?php echo $addUrl_1 ?>"><? echo $lang['approved']; ?></a></span>
</div>
<?php endif; ?>
<form action="comment.php?action=admin_all_coms" method="post" name="form_com" id="form_com">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
        <th width="369" colspan="2"><b><? echo $lang['content']; ?></b></th>
		<th width="300"><b><? echo $lang['time'];?></b></th>
        <th width="250"><b><? echo $lang['comment_author'];?></b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	if($comment):
	foreach($comment as $key=>$value):
	$ishide = $value['hide']=='y'?'<font color="red">['.$lang['comments_unapproved'].']</font>':'';
	$mail = !empty($value['mail']) ? "({$value['mail']})" : '';
	$ip = !empty($value['ip']) ? "<br />{$lang['ip']}: {$value['ip']}" : '';
	$poster = !empty($value['url']) ? '<a href="'.$value['url'].'" target="_blank">'. $value['poster'].'</a>' : $value['poster'];
	$value['content'] = str_replace('<br>',' ',$value['content']);
	$sub_content = subString($value['content'], 0, 50);
	$value['title'] = subString($value['title'], 0, 42);
	doAction('adm_comment_display');
	?>
     <tr>
        <td width="19"><input type="checkbox" value="<?php echo $value['cid']; ?>" name="com[]" class="ids" /></td>
        <td width="350"><a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>" title="<?php echo $value['content']; ?>"><?php echo $sub_content; ?></a> 	<?php echo $ishide; ?>
        <br /><?php echo $value['date']; ?>
		<span style="display:none; margin-left:8px;">    
		<a href="javascript: em_confirm(<?php echo $value['cid']; ?>, 'comment');" class="care"><? echo $lang['remove']; ?></a>
		<?php if($value['hide'] == 'y'):?>
		<a href="comment.php?action=show&amp;id=<?php echo $value['cid']; ?>"><? echo $lang['comments_approve']; ?></a>
		<?php else: ?>
		<a href="comment.php?action=hide&amp;id=<?php echo $value['cid']; ?>"><? echo $lang['hide']; ?></a>
		<?php endif;?>
		<a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>"><? echo $lang['reply']; ?></a>
        <a href="comment.php?action=edit_comment&amp;cid=<?php echo $value['cid']; ?>"><? echo $lang['edit']; ?></a>
		</span>
		</td>
		<td><?php echo $poster;?> <?php echo $mail;?> <?php echo $ip;?> 
            <?php if (ROLE == ROLE_ADMIN): ?><a href="javascript: em_confirm('<?php echo $value['ip']; ?>', 'commentbyip');" title="删除来自该IP的所有评论" class="care">(X)</a><?php endif;?></td>
        <td><a href="<?php echo Url::log($value['gid']); ?>" target="_blank" title="查看该文章"><?php echo $value['title']; ?></a></td>
     </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="4"><? echo $lang['comments_no_yet']; ?></td></tr>
	<?php endif;?>
	</tbody>
  </table>
	<div class="list_footer">
	<a href="javascript:void(0);" id="select_all"><? echo $lang['select all']; ?></a> <? echo $lang['with_selected_do']; ?>:
    <a href="javascript:commentact('del');" class="care"><? echo $lang['remove'];?></a>
	<a href="javascript:commentact('hide');"><? echo $lang['hide']; ?></a>
	<a href="javascript:commentact('pub');"><? echo $lang['comments_approve'];?></a>
	<input name="operate" id="operate" value="" type="hidden" />
	</div>
    <div class="page"><?php echo $pageurl; ?> (<? echo $lang['with'];?> <?php echo $cmnum; ?> <? echo $lang['comments'];?>)</div> 
</form>
<script>
$(document).ready(function(){
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover");$(this).find("span").show();})
		.mouseout(function(){$(this).removeClass("trover");$(this).find("span").hide();})
});
setTimeout(hideActived,2600);
function commentact(act){
	if (getChecked('ids') == false) {
		alert('<? echo $lang['comments_select'];?>');
		return;
	}
	if(act == 'del' && !confirm('<? echo $lang['comments_delete_sure'];?>')){return;}
	$("#operate").val(act);
	$("#form_com").submit();
}
$("#menu_cm").addClass('sidebarsubmenu1');
</script>