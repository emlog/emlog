<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['tags_management'];?></b>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['tags_deleted_ok'];?></span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived"><? echo $lang['tags_edited_ok'];?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['tag_select_for_delete'];?></span><?php endif;?>
</div>
<div class=line></div>
<form action="tag.php?action=dell_all_tag" method="post">
<div>
<li>
<?php foreach($tags as $key=>$value): ?>	
<input type="checkbox" name="tag[<?php echo $value['tid']; ?>]" value="1" >
<a href="tag.php?action=mod_tag&tid=<?php echo $value['tid']; ?>"><?php echo $value['tagname']; ?></a> &nbsp;&nbsp;&nbsp;
<?php endforeach; ?>
</li>
<li style="margin:20px 0px"><input type="submit" value="<? echo $lang['tags_delete_selected'];?>" class="submit" /></li>
</div>
</form>
<script>
setTimeout(hideActived,2600);
$("#menu_tag").addClass('sidebarsubmenu1');
</script>