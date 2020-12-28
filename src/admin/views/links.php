<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class="containertitle">
<!--vot--><?php if(isset($_GET['active_taxis'])):?><span class="alert alert-success"><?=lang('order_update_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_edit'])):?><span class="alert alert-success"><?=lang('edit_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_add'])):?><span class="alert alert-success"><?=lang('add_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('site_and_url_empty')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_b'])):?><span class="alert alert-danger"><?=lang('no_link_order')?></span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= lang('link_management') ?></h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('link_management') ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= lang('sort') ?></th>
                            <th><?= lang('links') ?></th>
                            <th><?= lang('status') ?></th>
                            <th><?= lang('view') ?></th>
                            <th><?= lang('description') ?></th>
                            <th></th>
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
                        <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>" title="<?= lang('edit_link') ?>"><?php echo $value['sitename']; ?></a></td>
                        <td class="tdcenter">
                        <?php if ($value['hide'] == 'n'): ?>
                        <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="<?= lang('click_to_hide') ?>"><?= lang('visible') ?></a>
                        <?php else: ?>
                        <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="<?= lang('click_to_show') ?>" style="color:red;"><?= lang('hidden') ?></a>
                        <?php endif;?>
                        </td>
                        <td class="tdcenter">
                        <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<?= lang('view_link') ?>">
                        <img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
                        </td>
                        <td><?php echo $value['description']; ?></td>
                        <td>
                        <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"><?= lang('edit') ?></a>
                        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?= lang('delete') ?></a>
                        </td>
                      </tr>
                    <?php endforeach;else:?>
                      <tr><td class="tdcenter" colspan="6"><?= lang('no_links') ?></td></tr>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
  <div class="list_footer">
<!--vot--><input type="submit" value="<?=lang('order_change')?>" class="btn btn-primary"> 
<!--vot--><a href="javascript:displayToggle('link_new', 2);" class="btn btn-success"><?=lang('link_add')?></a>
  </div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link" class="form-inline">
<div id="link_new" class="form-group">
    <li>
        <input maxlength="4" style="width:30px;" class="form-control" name="taxis">
<!--vot--><label><?=lang('id')?></label>
    </li>
    <li>
        <input maxlength="200" style="width:232px;" class="form-control" name="sitename">
<!--vot--><label><?=lang('name')?><span class="required">*</sapn></label>
    </li>
    <li>
        <input maxlength="200" style="width:232px;" class="form-control" name="siteurl">
<!--vot--><label><?=lang('address')?><span class="required">*</sapn></label>
    </li>
<!--vot--><li><?=lang('description')?></li>
    <li><textarea name="description" type="text" class="form-control" style="width:230px;height:60px;overflow:auto;"></textarea></li>
<!--vot--><li><input type="submit" class="btn btn-primary" name="" value="<?=lang('link_add')?>"></li>
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
