<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<!--vot--><div class=containertitle><b><?=lang('link_management')?></b>
<!--vot--><?php if(isset($_GET['active_taxis'])):?><span class="alert alert-success"><?=lang('order_update_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="alert alert-success"><?=lang('edit_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_add'])):?><span class="alert alert-success"><?=lang('add_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('site_and_url_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="alert alert-danger"><?=lang('no_link_order')?></span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table class="table table-striped table-bordered table-hover dataTable no-footer">
    <thead>
      <tr>
<!--vot--><th width="50"><b><?=lang('id')?></b></th>
<!--vot--><th width="230"><b><?=lang('link')?></b></th>
<!--vot--><th width="80" class="tdcenter"><b><?=lang('status')?></b></th>
<!--vot--><th width="80" class="tdcenter"><b><?=lang('views')?></b></th>
<!--vot--><th width="400"><b><?=lang('description')?></b></th>
        <th width="100"></th>
      </tr>
    </thead>
    <tbody>
    <?php 
    if($links):
    foreach($links as $key=>$value):
    doAction('adm_link_display');
    ?>  
      <tr>
        <td><input class="form-control em-small" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
<!--vot-->    <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>" title="<?=lang('edit_link')?>"><?php echo $value['sitename']; ?></a></td>
        <td class="tdcenter">
        <?php if ($value['hide'] == 'n'): ?>
<!--vot-->    <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="<?=lang('link_hide')?>"><?=lang('visible')?></a>
        <?php else: ?>
<!--vot-->    <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="<?=lang('link_show')?>" style="color:red;"><?=lang('hidden')?></a>
        <?php endif;?>
        </td>
        <td class="tdcenter">
<!--vot-->      <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<?=lang('view_link')?>">
        <img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
        </td>
        <td><?php echo $value['description']; ?></td>
        <td>
<!--vot--> <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"><?=lang('edit')?></a>
<!--vot--> <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
        </td>
      </tr>
    <?php endforeach;else:?>
<!--vot--><tr><td class="tdcenter" colspan="6"><?=lang('no_links')?></td></tr>
    <?php endif;?>
    </tbody>
  </table>
  <div class="list_footer">
<!--vot--><input type="submit" value="<?=lang('order_change')?>" class="btn btn-primary" /> 
<!--vot--><a href="javascript:displayToggle('link_new', 2);" class="btn btn-success"><?=lang('link_add')?>+</a>
  </div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link" class="form-inline">
<div id="link_new" class="form-group">
    <li>
        <input maxlength="4" style="width:30px;" class="form-control" name="taxis" />
<!--vot--><label><?=lang('order_num')?></label>
    </li>
    <li>
        <input maxlength="200" style="width:232px;" class="form-control" name="sitename" />
<!--vot--><label><?=lang('name')?><span class="required">*</sapn></label>
    </li>
    <li>
        <input maxlength="200" style="width:232px;" class="form-control" name="siteurl" />
<!--vot--><label><?=lang('address')?><span class="required">*</sapn></label>
    </li>
<!--vot--><li><?=lang('description')?></li>
    <li><textarea name="description" type="text" class="form-control" style="width:230px;height:60px;overflow:auto;"></textarea></li>
<!--vot--><li><input type="submit" class="btn btn-primary" name="" value="<?=lang('link_add')?>"  /></li>
</div>
</form>
<script>
$("#link_new").css('display', $.cookie('em_link_new') ? $.cookie('em_link_new') : 'none');
$(document).ready(function(){
    $("#adm_link_list tbody tr:odd").addClass("tralt_b");
    $("#adm_link_list tbody tr")
        .mouseover(function(){$(this).addClass("trover")})
        .mouseout(function(){$(this).removeClass("trover")})
});
setTimeout(hideActived,2600);
$("#menu_link").addClass('active');
</script>
