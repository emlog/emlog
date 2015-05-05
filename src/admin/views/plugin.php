<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1><?=lang('plugin_manage')?></h1>
    <div class="containertitle">
    <?php if(isset($_GET['activate_install'])):?><span class="alert alert-success"><?=lang('plugin_upload_ok')?></span><?php endif;?>
    <?php if(isset($_GET['active'])):?><span class="alert alert-success"><?=lang('plugin_active_ok')?></span><?php endif;?>
    <?php if(isset($_GET['activate_del'])):?><span class="alert alert-success"><?=lang('deleted_ok')?></span><?php endif;?>
    <?php if(isset($_GET['active_error'])):?><span class="alert alert-danger"><?=lang('plugin_active_failed')?></span><?php endif;?>
    <?php if(isset($_GET['inactive'])):?><span class="alert alert-success"><?=lang('plugin_disable_ok')?></span><?php endif;?>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger"><?=lang('plugin_delete_failed')?></span><?php endif;?>
    </div>
</section>
<section class="content">
<div class=line></div>
  <table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr>
        <th width="200"></th>
<!--vot--><th width="40" class="tdcenter"><b><?=lang('status')?></b></th>
<!--vot--><th width="60" class="tdcenter"><b><?=lang('version')?></b></th>
<!--vot--><th width="450" class="tdcenter"><b><?=lang('description')?></b></th>
        <th width="60" class="tdcenter"></th>
      </tr>
  </thead>
  <tbody>
    <?php 
    if($plugins):
    $i = 0;
    foreach($plugins as $key=>$val):
        $plug_state = 'inactive';
        $plug_action = 'active';
/*vot*/        $plug_state_des = lang('plugin_active_ok');
        if (in_array($key, $active_plugins))
        {
            $plug_state = 'active';
            $plug_action = 'inactive';
/*vot*/            $plug_state_des = lang('plugin_disable_ok');
        }
        $i++;
        if (TRUE === $val['Setting']) {
/*vot*/        $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"".lang('plugin_settings_click')."\">{$val['Name']} <img src=\"./views/images/set.png\" border=\"0\" /></a>";
        }
    ?>    
      <tr>
        <td class="tdcenter"><?php echo $val['Name']; ?></td>
        <td class="tdcenter" id="plugin_<?php echo $i;?>">
        <a href="./plugin.php?action=<?php echo $plug_action;?>&plugin=<?php echo $key;?>&token=<?php echo LoginAuth::genToken(); ?>"><img src="./views/images/plugin_<?php echo $plug_state; ?>.gif" title="<?php echo $plug_state_des; ?>" align="absmiddle" border="0"></a>
        </td>
        <td class="tdcenter"><?php echo $val['Version']; ?></td>
        <td>
        <?php echo $val['Description']; ?>
<!--vot-->    <?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank"><?=lang('more_info')?></a><?php endif;?>
        <div style="margin-top:5px;">
<!--vot-->        <?php if ($val['ForEmlog'] != ''):?><?=lang('ok_for_emlog')?>: <?php echo $val['ForEmlog'];?>&nbsp | &nbsp<?php endif;?>
        <?php if ($val['Author'] != ''):?>
<!--vot-->        <?=lang('user')?>: <?php if ($val['AuthorUrl'] != ''):?>
            <a href="<?php echo $val['AuthorUrl'];?>" target="_blank"><?php echo $val['Author'];?></a>
            <?php else:?>
            <?php echo $val['Author'];?>
            <?php endif;?>
        <?php endif;?>
        </div>
        </td>
        <td class="tdcenter">
<!--vot-->         <a href="javascript: em_confirm('<?php echo $key; ?>', 'plu', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a>
        </td>
      </tr>
    <?php endforeach;else: ?>
      <tr>
<!--vot-->  <td class="tdcenter" colspan="5"><?=lang('plugin_no_installed')?></td>
      </tr>
    <?php endif;?>
    </tbody>
  </table>
<div><a href="./plugin.php?action=install" class="btn btn-success"><?=lang('plugin_install')?></a></div>
<script>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
    .mouseover(function(){$(this).addClass("trover")})
    .mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
$("#menu_category_sys").addClass('active');
$("#menu_plug").addClass('active').parent().parent().addClass('active');
</script>
