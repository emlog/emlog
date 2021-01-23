<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php if(isset($_GET['active_taxis'])):?><span class="alert alert-success">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="alert alert-success">删除成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="alert alert-success">修改成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="alert alert-success">添加成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">站点名称和地址不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="alert alert-danger">没有可排序的链接</span><?php endif;?>
<!-- Begin Page Content -->
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">链接管理</h1>
<form action="link.php?action=link_taxis" method="post">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">链接管理</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>排序</th>
                            <th>链接</th>
                            <th>状态</th>
                            <th>查看</th>
                            <th>描述</th>
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
                        <img src="./templates/<?php echo ADMIN_TEMPLATE; ?>/images/vlog.gif" align="absbottom" border="0" /></a>
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
            </div>
        </div>
    </div>
  <div class="list_footer">
      <input type="submit" value="改变排序" class="btn btn-primary" /> 
      <a href="javascript:displayToggle('link_new', 2);" class="btn btn-success">添加链接+</a>
  </div>
</form>
<form action="link.php?action=addlink" method="post" name="link" id="link" class="form-inline">
<div id="link_new" class="form-group">
    <li>
        <input maxlength="4" style="width:30px;" class="form-control" name="taxis" />
        <label>序号</label>
    </li>
    <li>
        <input maxlength="200" style="width:232px;" class="form-control" name="sitename" />
        <label>名称<span class="required">*</sapn></label>
    </li>
    <li>
        <input maxlength="200" style="width:232px;" class="form-control" name="siteurl" />
        <label>地址<span class="required">*</sapn></label>
    </li>
    <li>描述</li>
    <li><textarea name="description" type="text" class="form-control" style="width:230px;height:60px;overflow:auto;"></textarea></li>
    <li><input type="submit" class="btn btn-primary" name="" value="添加链接"  /></li>
</div>
</form>
</div>
<!-- /.container-fluid -->
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
