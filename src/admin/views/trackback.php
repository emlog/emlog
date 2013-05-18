<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<script>
$(document).ready(function(){
	$("#adm_tb_list tbody tr:odd").addClass("tralt_b");
	$("#adm_tb_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
</script>
<div class=containertitle><b>引用通告（TrackBack）管理</b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['trackback_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['trackback_select'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="trackback.php?action=dell" method="post" name="form_tb" id="form_tb">
  <table width="100%" id="adm_tb_list" class="item_list">
  <thead>
      <tr>
        <th width="280" colspan="2"><b><? echo $lang['title']; ?></b></th>
        <th width="300"><b><? echo $lang['trackback_source'];?></b></th>
		<th width="80"><b>IP</b></th>
        <th width="120"><b><? echo $lang['time'];?></b></th>
      </tr>
  </thead>
  <tbody>
	<?php 
	if($trackback):
	foreach($trackback as $key=>$value):?>	
      <tr>
        <td width="10"><input type="checkbox" name="tb[]" value="<?php echo $value['tbid']; ?>" class="ids" ></td>
        <td width="270"><a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['title']; ?></a></td>
        <td><?php echo $value['blog_name']; ?></td>
        <td><?php echo $value['ip']; ?></td>
        <td><?php echo $value['date']; ?></td>
      </tr>
	<?php endforeach;else:?>
	  <tr><td class="tdcenter" colspan="5"><? echo $lang['no_trackback_yet']; ?></td></tr>
	<?php endif;?>
	</tbody>
  </table>
<div class="list_footer"><a href="javascript:void(0);" id="select_all"><? echo $lang['select all']; ?></a> <? echo $lang['with_selected_do']; ?>: <a href="javascript:tbact('del');" class="care"><? echo $lang['remove']; ?></a></div>
<div class="page"><?php echo $pageurl; ?> (<? echo $lang['with'];?> <?php echo $tbnum; ?> <? echo $lang['trackbacks_articles'];?>)</div> 
</form>
<script>
function tbact(act){
	if (getChecked('ids') == false) {
		alert('<? echo $lang['trackback_select'];?>');
		return;
	}
	if(act == 'del' && !confirm('<? echo $lang['trackback_delete_sure'];?>')){return;}
	$("#operate").val(act);
	$("#form_tb").submit();
}
$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
$("#menu_tb").addClass('sidebarsubmenu1');
</script>