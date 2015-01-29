<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=containertitle><b>友情链接管理</b>
<?php if(isset($_GET['active_taxis'])):?><span class="actived">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">删除成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="actived">修改成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="actived">添加成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">站点名称和地址不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="error">没有可排序的链接</span><?php endif;?>
</div>
<div class=line></div>
<form action="link.php?action=link_taxis" method="post">
  <table width="100%" id="adm_link_list" class="item_list">
    <thead>
      <tr>
        <th width="50"><b>序号</b></th>
        <th width="230"><b>链接</b></th>
        <th width="80" class="tdcenter"><b>状态</b></th>
        <th width="80" class="tdcenter"><b>查看</b></th>
        <th width="400"><b>描述</b></th>
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
        <td><input class="num_input" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
        <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>" title="修改链接"><?php echo $value['sitename']; ?></a></td>
        <td class="tdcenter">
        <?php if ($value['hide'] == 'n'): ?>
        <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="点击隐藏链接">显示</a>
        <?php else: ?>
        <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="点击显示链接" style="color:red;">隐藏</a>
        <?php endif;?>
        </td>
        <td class="tdcenter">
        <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="查看链接">
        <img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
        </td>
        <td><?php echo $value['description']; ?></td>
        <td>
        <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>">编辑</a>
        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
        </td>
      </tr>
    <?php endforeach;else:?>
      <tr><td class="tdcenter" colspan="6">还没有添加链接</td></tr>
    <?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="改变排序" class="button" /></div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link">
<div style="margin:30px 0px 10px 0px;"><a href="javascript:displayToggle('link_new', 2);" class="button">添加链接+</a></div>
<div id="link_new" class="item_edit">
    <li><input maxlength="4" style="width:30px;" class="input" name="taxis" /> 序号</li>
    <li><input maxlength="200" style="width:232px;" class="input" name="sitename" /> 名称<span class="required">*</sapn></li>
    <li><input maxlength="200" style="width:232px;" class="input" name="siteurl" /> 地址<span class="required">*</sapn></li>
    <li>描述</li>
    <li><textarea name="description" type="text" class="textarea" style="width:230px;height:60px;overflow:auto;"></textarea></li>
    <li><input type="submit" name="" value="添加链接"  /></li>
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
$("#menu_link").addClass('sidebarsubmenu1');
</script>