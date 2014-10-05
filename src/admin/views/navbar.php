<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!--vot--><div class=containertitle><b><?=lang('nav_manage')?></b>
<!--vot--><?php if(isset($_GET['active_taxis'])):?><span class="actived"><?=lang('category_update_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('nav_delete_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="actived"><?=lang('nav_edit_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_add'])):?><span class="actived"><?=lang('nav_add_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('nav_name_url_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="error"><?=lang('nav_no_order')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_c'])):?><span class="error"><?=lang('nav_default_nodelete')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_d'])):?><span class="error"><?=lang('select_category')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_e'])):?><span class="error"><?=lang('select_page')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_f'])):?><span class="error"><?=lang('nav_url_invalid')?></span><?php endif;?>
</div>
<div class=line></div>
<form action="navbar.php?action=taxis" method="post">
  <table width="100%" id="adm_navi_list" class="item_list">
    <thead>
      <tr>
<!--vot--><th width="50"><b><?=lang('id')?></b></th>
<!--vot--><th width="230"><b><?=lang('navigation')?></b></th>
<!--vot--><th width="60" class="tdcenter"><b><?=lang('type')?></b></th>
<!--vot--><th width="60" class="tdcenter"><b><?=lang('status')?></b></th>
<!--vot--><th width="50" class="tdcenter"><b><?=lang('view')?></b></th>
<!--vot--><th width="360"><b><?=lang('address')?></b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
	<?php 
	if($navis):
	foreach($navis as $key=>$value):
        if ($value['pid'] != 0) {
            continue;
        }
        $value['type_name'] = '';
        switch ($value['type']) {
            case Navi_Model::navitype_home:
            case Navi_Model::navitype_t:
            case Navi_Model::navitype_admin:
/*vot*/		$value['type_name'] = lang('system');
                break;
            case Navi_Model::navitype_sort:
/*vot*/		$value['type_name'] = '<font color="blue">'.lang('category').'</font>';
                break;
            case Navi_Model::navitype_page:
/*vot*/		$value['type_name'] = '<font color="#00A3A3">'.lang('page').'</font>';
                break;
            case Navi_Model::navitype_custom:
/*vot*/		$value['type_name'] = '<font color="#FF6633">'.lang('custom').'</font>';
                break;
        }
        doAction('adm_navi_display');
    
	?>  
      <tr>
		<td><input class="num_input" name="navi[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
<!--vot-->	<td><a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>" title="<?=lang('nav_edit')?>"><?php echo $value['naviname']; ?></a></td>
		<td class="tdcenter"><?php echo $value['type_name'];?></td>
		<td class="tdcenter">
		<?php if ($value['hide'] == 'n'): ?>
<!--vot-->	<a href="navbar.php?action=hide&amp;id=<?php echo $value['id']; ?>" title="<?=lang('nav_hide_click')?>"><?=lang('show')?></a>
		<?php else: ?>
<!--vot-->	<a href="navbar.php?action=show&amp;id=<?php echo $value['id']; ?>" title="<?=lang('nav_show_click')?>" style="color:red;"><?=lang('hide')?></a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $value['url']; ?>" target="_blank">
	  	<img src="./views/images/<?php echo $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif';?>" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $value['url']; ?></td>
        <td>
<!--vot-->	<a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>"><?=lang('edit')?></a>
        <?php if($value['isdefault'] == 'n'):?>
<!--vot-->	<a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'navi', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
        <?php endif;?>
        </td>
      </tr>
    <?php
		if(!empty($value['childnavi'])):
		foreach ($value['childnavi'] as $val):
	?>
        <tr>
		<td><input class="num_input" name="navi[<?php echo $val['id']; ?>]" value="<?php echo $val['taxis']; ?>" maxlength="4" /></td>
<!--vot-->	<td>---- <a href="navbar.php?action=mod&amp;navid=<?php echo $val['id']; ?>" title="<?=lang('nav_edit')?>"><?php echo $val['naviname']; ?></a></td>
		<td class="tdcenter"><?php echo $value['type_name'];?></td>
		<td class="tdcenter">
		<?php if ($val['hide'] == 'n'): ?>
<!--vot-->	<a href="navbar.php?action=hide&amp;id=<?php echo $val['id']; ?>" title="<?=lang('nav_hide_click')?>"><?=lang('show')?></a>
		<?php else: ?>
<!--vot-->	<a href="navbar.php?action=show&amp;id=<?php echo $val['id']; ?>" title="<?=lang('nav_show_click')?>" style="color:red;"><?=lang('hide')?></a>
		<?php endif;?>
		</td>
		<td class="tdcenter">
	  	<a href="<?php echo $val['url']; ?>" target="_blank">
	  	<img src="./views/images/<?php echo $val['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif';?>" align="absbottom" border="0" /></a>
	  	</td>
        <td><?php echo $val['url']; ?></td>
        <td>
<!--vot-->	<a href="navbar.php?action=mod&amp;navid=<?php echo $val['id']; ?>"><?=lang('edit')?></a>
        <?php if($val['isdefault'] == 'n'):?>
<!--vot-->	<a href="javascript: em_confirm(<?php echo $val['id']; ?>, 'navi', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
        <?php endif;?>
        </td>
      </tr>
      <?php endforeach;endif; ?>
	<?php endforeach;else:?>
<!--vot-->  <tr><td class="tdcenter" colspan="4"><?=lang('nav_no')?></td></tr>
	<?php endif;?>
    </tbody>
  </table>
<!--vot-->  <div class="list_footer"><input type="submit" value="<?=lang('order_change')?>" class="button" /></div>
</form>
<div id="navi_add">
<form action="navbar.php?action=add" method="post" name="navi" id="navi">
<div>
<!--vot--> <h1 onclick="displayToggle('navi_add_custom', 2);"><?=lang('nav_add_custom')?>+</h1>
	<ul id="navi_add_custom">
<!--vot--> <li><input maxlength="4" style="width:30px;" name="taxis" /> <?=lang('id')?></li>
<!--vot--> <li><input maxlength="200" style="width:100px;" name="naviname" /> <?=lang('nav_name')?><span class="required">*</span></li>
	<li>
<!--vot--> <input maxlength="200" style="width:168px;" name="url" id="url" /> <?=lang('nav_url_http')?><span class="required">*</span></li>
    <li>
            <select name="pid" id="pid" class="input">
<!--vot-->	<option value="0"><?=lang('no')?></option>
                <?php
                    foreach($navis as $key=>$value):
                        if($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                            continue;
                        }
                ?>
                <option value="<?php echo $value['id']; ?>"><?php echo $value['naviname']; ?></option>
                <?php endforeach; ?>
            </select>
<!--vot-->   <?=lang('nav_parent')?>
    </li>
<!--vot--> <li><?=lang('open_new_win')?> <input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" /></li>
<!--vot--> <li><input class="button" type="submit" name="" value="<?=lang('add')?>"  /></li>
	</ul>
</div>
</form>
<form action="navbar.php?action=add_sort" method="post" name="navi" id="navi">
<div>
<!--vot--> <h1 onclick="displayToggle('navi_add_sort', 2);"><?=lang('nav_add_category')?>+</h1>
	<ul id="navi_add_sort">
	<?php 
	if($sorts):
    foreach($sorts as $key=>$value):
	if ($value['pid'] != 0) {
		continue;
	}
    ?>
	<li>
        <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
		<?php echo $value['sortname']; ?>
	</li>
	<?php
		$children = $value['children'];
		foreach ($children as $key):
		$value = $sorts[$key];
	?>
    <li>
        &nbsp; &nbsp; &nbsp;  <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
        <?php echo $value['sortname']; ?>
	</li>
	<?php 
        endforeach;
   endforeach;
   ?>
<!--vot--> <li><input class="button" type="submit" name="" value="<?=lang('add')?>"  /></li>
	<?php else:?>
<!--vot--> <li><?=lang('no_categories')?>, <a href="sort.php"><?=lang('new_category')?></a></li>
	<?php endif;?> 
	</ul>
</div>
</form>
<form action="navbar.php?action=add_page" method="post" name="navi" id="navi">
<div>
<!--vot--> <h1 onclick="displayToggle('navi_add_page', 2);"><?=lang('nav_page_add')?>+</h1>
	<ul id="navi_add_page">
	<?php 
	if($pages):
	foreach($pages as $key=>$value): 
	?>
	<li>
        <input type="checkbox" style="vertical-align:middle;" name="pages[<?php echo $value['gid']; ?>]" value="<?php echo $value['title']; ?>" class="ids" />
		<?php echo $value['title']; ?>
	</li>
	<?php endforeach;?>
<!--vot--> <li><input type="submit" name="" value="<?=lang('add')?>"  /></li>
	<?php else:?>
<!--vot--> <li><?=lang('pages_no')?>, <a href="page.php"><?=lang('add_page')?></a></li>
	<?php endif;?> 
	</ul>
</div>
</form>
</div>
<script>
$("#navi_add_custom").css('display', $.cookie('em_navi_add_custom') ? $.cookie('em_navi_add_custom') : '');
$("#navi_add_sort").css('display', $.cookie('em_navi_add_sort') ? $.cookie('em_navi_add_sort') : '');
$("#navi_add_page").css('display', $.cookie('em_navi_add_page') ? $.cookie('em_navi_add_page') : '');
$(document).ready(function(){
	$("#adm_navi_list tbody tr:odd").addClass("tralt_b");
	$("#adm_navi_list tbody tr")
		.mouseover(function(){$(this).addClass("trover")})
		.mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>