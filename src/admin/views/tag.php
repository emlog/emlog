<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle"><b><?=lang('tag_manage')?></b>
    <?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('tag_delete_ok')?></span><?php endif;?>
    <?php if(isset($_GET['active_edit'])):?><span class="alert alert-success"><?=lang('tag_modify_ok')?></span><?php endif;?>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('tag_select_to_delete')?></span><?php endif;?>
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
<!--vot--><a href="javascript:void(0);" id="select_all"><?=lang('select_all')?></a> <?=lang('selected_items')?>:
<!--vot--><a href="javascript:deltags();" class="care"><?=lang('delete')?></a>
</li>
<?php else:?>
<!--vot--><li style="margin:20px 30px"><?=lang('tags_no_info')?></li>
<?php endif;?>
</div>
</form>
<script>
selectAllToggle();
function deltags(){
    if (getChecked('ids') == false) {
/*vot*/        alert(lang('tag_select_to_delete'));
        return;
    }
/*vot*/    if(!confirm(lang('tag_delete_sure'))){return;}
    $("#form_tag").submit();
}
setTimeout(hideActived,2600);
$("#menu_tag").addClass('active');
</script>
