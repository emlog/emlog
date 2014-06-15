<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('comment_management')?></b>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('comment_delete_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_show'])):?><span class="actived"><?=lang('comment_audit_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_hide'])):?><span class="actived"><?=lang('comment_hide_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="actived"><?=lang('comment_edit_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_rep'])):?><span class="actived"><?=lang('comment_reply_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('comment_choose_operation')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('select_action_to_perform')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="error"><?=lang('reply_is_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="error"><?=lang('comment_too_long')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="error"><?=lang('comment_is_empty')?></span><?php endif;?>
</div>
<div class=line></div>
<?php if ($hideCommNum > 0) : 
$hide_ = $hide_y = $hide_n = '';
$a = "hide_$hide";
$$a = "class=\"filter\"";
?>
<div class="filters">
<!--vot--><span <?php echo $hide_; ?>><a href="./comment.php?<?php echo $addUrl_1 ?>"><?=lang('all')?></a></span>
<!--vot--><span <?php echo $hide_y; ?>><a href="./comment.php?hide=y&<?php echo $addUrl_1 ?>"><?=lang('pending')?>
<?php
$hidecmnum = ROLE == ROLE_ADMIN ? $sta_cache['hidecomnum'] : $sta_cache[UID]['hidecommentnum'];
if ($hidecmnum > 0) echo '('.$hidecmnum.')';
?>
</a></span>
<!--vot--><span <?php echo $hide_n; ?>><a href="comment.php?hide=n&<?php echo $addUrl_1 ?>"><?=lang('audited')?></a></span>
</div>
<?php endif; ?>
<form action="comment.php?action=admin_all_coms" method="post" name="form_com" id="form_com">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
<!--vot--><th width="369" colspan="2"><b><?=lang('content')?></b></th>
<!--vot--><th width="300"><b><?=lang('commentator')?></b></th>
<!--vot--><th width="250"><b><?=lang('belongs_to_post')?></b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	if($comment):
	foreach($comment as $key=>$value):
	$ishide = $value['hide']=='y'?'<font color="red">['. lang('pending') .']</font>':'';
	$mail = !empty($value['mail']) ? "({$value['mail']})" : '';
/*vot*/ 	$ip = !empty($value['ip']) ? "<br /><?=lang('from')?>: {$value['ip']}" : '';
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
<!--vot-->	<a href="javascript: em_confirm(<?php echo $value['cid']; ?>, 'comment', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
		<?php if($value['hide'] == 'y'):?>
<!--vot-->	<a href="comment.php?action=show&amp;id=<?php echo $value['cid']; ?>"><?=lang('approve')?></a>
		<?php else: ?>
<!--vot-->	<a href="comment.php?action=hide&amp;id=<?php echo $value['cid']; ?>"><?=lang('hide')?></a>
		<?php endif;?>
<!--vot-->	<a href="comment.php?action=reply_comment&amp;cid=<?php echo $value['cid']; ?>"><?=lang('reply')?></a>
<!--vot-->	<a href="comment.php?action=edit_comment&amp;cid=<?php echo $value['cid']; ?>"><?=lang('edit')?></a>
		</span>
		</td>
		<td><?php echo $poster;?> <?php echo $mail;?> <?php echo $ip;?> 
<!--vot-->	<?php if (ROLE == ROLE_ADMIN): ?><a href="javascript: em_confirm('<?php echo $value['ip']; ?>', 'commentbyip', '<?php echo LoginAuth::genToken(); ?>');" title="<?=lang('delete_comments_from_ip')?>" class="care">(X)</a><?php endif;?></td>
<!--vot-->	<td><a href="<?php echo Url::log($value['gid']); ?>" target="_blank" title="<?=lang('show_post')?>"><?php echo $value['title']; ?></a></td>
     </tr>
	<?php endforeach;else:?>
<!--vot-->  <tr><td class="tdcenter" colspan="4"><?=lang('no_comments_yet')?></td></tr>
	<?php endif;?>
	</tbody>
  </table>
	<div class="list_footer">
<!--vot-->	<a href="javascript:void(0);" id="select_all"><?=lang('select_all')?></a> <?=lang('selected_items')?>:
<!--vot-->	<a href="javascript:commentact('del');" class="care"><?=lang('delete')?></a>
<!--vot-->	<a href="javascript:commentact('hide');"><?=lang('hide')?></a>
<!--vot-->	<a href="javascript:commentact('pub');"><?=lang('approve')?></a>
	<input name="operate" id="operate" value="" type="hidden" />
	</div>
<!--vot--><div class="page"><?php echo $pageurl; ?> (<?=lang('have')?><?php echo $cmnum; ?><?=lang('_comments')?>)</div> 
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
/*vot*/		alert('<?=lang('comment_operation_select')?>');
		return;
	}
/*vot*/	if(act == 'del' && !confirm('<?=lang('comment_selected_delete_sure')?>')){return;}
	$("#operate").val(act);
	$("#form_com").submit();
}
$("#menu_cm").addClass('sidebarsubmenu1');
</script>