<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['page_management'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['page_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_hide_n'])):?><span class="actived"><? echo $lang['page_published_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_hide_y'])):?><span class="actived"><? echo $lang['page_unpublished_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_pubpage'])):?><span class="actived"><? echo $lang['post_saved_ok']; ?></span><?php endif;?>
</div>
<div class=line></div>
<form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
  <table width="100%" id="adm_comment_list" class="item_list">
  	<thead>
      <tr>
        <th width="461" colspan="2"><b><? echo $lang['title']; ?></b></th>
        <th width="50" class="tdcenter"><b><? echo $lang['comments']; ?></b></th>
        <th width="280"><b><? echo $lang['time'];?></b></th>
      </tr>
    </thead>
    <tbody>
	<?php
	if($pages):
	foreach($pages as $key => $value):
	if (empty($navibar[$value['gid']]['url']))
	{
		$navibar[$value['gid']]['url'] = Url::log($value['gid']);
	}
	$isHide = $value['hide'] == 'y' ? 
	'<font color="red">['.$lang['draft'].']</font>' : 
	'<a href="'.$navibar[$value['gid']]['url'].'" target="_blank" title="'.$lang['page_new_window'].'"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>';
	?>
     <tr>
     	<td width="21"><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
        <td width="440">
        <a href="page.php?action=mod&id=<?php echo $value['gid']?>"><?php echo $value['title']; ?></a> 
   		<?php echo $isHide; ?>    
		<?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="<? echo $lang['attachments']; ?>: <?php echo $value['attnum']; ?>" /><?php endif; ?>
        </td>
        <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
        <td><?php echo $value['date']; ?></td>
     </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="4"><? echo $lang['no_pages_yet']; ?></td></tr>
	<?php endif;?>
	</tbody>
  </table>
  <input name="operate" id="operate" value="" type="hidden" />
</form>
<div class="list_footer">
<a href="javascript:void(0);" id="select_all"><? echo $lang['select all']; ?></a> <? echo $lang['with_selected_do'];?>:
<a href="javascript:pageact('del');" class="care"><? echo $lang['remove'];?></a> | 
<a href="javascript:pageact('hide');"><? echo $lang['hide'];?></a> | 
<a href="javascript:pageact('pub');"><? echo $lang['publish'];?></a>
</div>
<div style="margin:20px 0px 0px 0px;"><a href="page.php?action=new"><? echo $lang['page_add']; ?>+</a></div>
<div class="page"><?php echo $pageurl; ?> (<? echo $lang['with'];?> <?php echo $pageNum; ?><? echo $lang['_pages']; ?>)</div>
<script>
$(document).ready(function(){
	$("#adm_comment_list tbody tr:odd").addClass("tralt_b");
	$("#adm_comment_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")});
	$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
});
setTimeout(hideActived,2600);
function pageact(act){
	if (getChecked('ids') == false) {
		alert('<? echo $lang['page_select_to_deal'];?>');
		return;}
	if(act == 'del' && !confirm('<? echo $lang['page_delete_sure'];?>')){return;}
	$("#operate").val(act);
	$("#form_page").submit();
}
$("#menu_page").addClass('sidebarsubmenu1');
</script>