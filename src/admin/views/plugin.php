<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<section class="content-header">
    <h1>插件管理</h1>
    <div class="containertitle">
    <?php if(isset($_GET['activate_install'])):?><span class="alert alert-success">插件上传成功，请激活使用</span><?php endif;?>
    <?php if(isset($_GET['active'])):?><span class="alert alert-success">插件激活成功</span><?php endif;?>
    <?php if(isset($_GET['activate_del'])):?><span class="alert alert-success">删除成功</span><?php endif;?>
    <?php if(isset($_GET['active_error'])):?><span class="alert alert-danger">插件激活失败</span><?php endif;?>
    <?php if(isset($_GET['inactive'])):?><span class="alert alert-success">插件禁用成功</span><?php endif;?>
    <?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">删除失败，请检查插件文件权限</span><?php endif;?>
    </div>
</section>
<section class="content">
<div class=line></div>
  <table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr>
        <th width="200"></th>
        <th width="40" class="tdcenter"><b>状态</b></th>
        <th width="60" class="tdcenter"><b>版本</b></th>
        <th width="450" class="tdcenter"><b>描述</b></th>
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
        $plug_state_des = '点击激活插件';
        if (in_array($key, $active_plugins))
        {
            $plug_state = 'active';
            $plug_action = 'inactive';
            $plug_state_des = '点击禁用插件';
        }
        $i++;
        if (TRUE === $val['Setting']) {
            $val['Name'] = "<a href=\"./plugin.php?plugin={$val['Plugin']}\" title=\"点击设置插件\">{$val['Name']} <img src=\"./views/images/set.png\" border=\"0\" /></a>";
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
        <?php if ($val['Url'] != ''):?><a href="<?php echo $val['Url'];?>" target="_blank">更多信息&raquo;</a><?php endif;?>
        <div style="margin-top:5px;">
        <?php if ($val['ForEmlog'] != ''):?>适用于emlog：<?php echo $val['ForEmlog'];?>&nbsp | &nbsp<?php endif;?>
        <?php if ($val['Author'] != ''):?>
        作者：<?php if ($val['AuthorUrl'] != ''):?>
            <a href="<?php echo $val['AuthorUrl'];?>" target="_blank"><?php echo $val['Author'];?></a>
            <?php else:?>
            <?php echo $val['Author'];?>
            <?php endif;?>
        <?php endif;?>
        </div>
        </td>
        <td class="tdcenter">
            <a href="javascript: em_confirm('<?php echo $key; ?>', 'plu', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
        </td>
      </tr>
    <?php endforeach;else: ?>
      <tr>
        <td class="tdcenter" colspan="5">还没有安装插件</td>
      </tr>
    <?php endif;?>
    </tbody>
  </table>
<div><a href="./plugin.php?action=install" class="btn btn-success">安装插件</a></div>
<script>
$("#adm_plugin_list tbody tr:odd").addClass("tralt_b");
$("#adm_plugin_list tbody tr")
    .mouseover(function(){$(this).addClass("trover")})
    .mouseout(function(){$(this).removeClass("trover")})
setTimeout(hideActived,2600);
$("#menu_category_sys").addClass('active');
$("#menu_plug").addClass('active').parent().parent().addClass('active');
</script>
