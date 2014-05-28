<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['tags_management'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['tags_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['tags_edited_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['tag_select_for_delete'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="tag.php?action=dell_all_tag" method="post" name="form_tag" id="form_tag">
<div>
<li>
<?php 
if($tags):
foreach($tags as $key=>$value): ?>	
<input type="checkbox" name="tag[<?php echo $value['tid']; ?>]" class="ids" value="1" >
<a href="tag.php?action=mod_tag&tid=<?php echo $value['tid']; ?>"><?php echo $value['tagname']; ?></a> &nbsp;&nbsp;&nbsp;
<?php endforeach; ?>
</li>
<input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<li style="margin:20px 0px">
<a href="javascript:void(0);" id="select_all"><? echo $lang['select all']; ?></a> <? echo $lang['with_selected_do']; ?>:
<a href="javascript:deltags();" class="care"><? echo $lang['remove']; ?></a>
</li>
<?php else:?>
<li style="margin:20px 30px"><? echo $lang['no_tags_yet_add']; ?></li>
<?php endif;?>
</div>
</form>
<script>
$("#select_all").toggle(function () {$(".ids").attr("checked", "checked");},function () {$(".ids").removeAttr("checked");});
function deltags(){
	if (getChecked('ids') == false) {
		alert(l_tag_select_del);
		return;
	}
	if(!confirm(l_tag_del_sure)){return;}
	$("#form_tag").submit();
}
setTimeout(hideActived,2600);
$("#menu_tag").addClass('sidebarsubmenu1');
</script>