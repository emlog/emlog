<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php if(isset($_GET['active_taxis'])):?><span class="alert alert-success">排序更新成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="alert alert-success">删除导航成功</span><?php endif;?>
<?php if(isset($_GET['active_edit'])):?><span class="alert alert-success">修改导航成功</span><?php endif;?>
<?php if(isset($_GET['active_add'])):?><span class="alert alert-success">添加导航成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="alert alert-danger">导航名称和地址不能为空</span><?php endif;?>
<?php if(isset($_GET['error_b'])):?><span class="alert alert-danger">没有可排序的导航</span><?php endif;?>
<?php if(isset($_GET['error_c'])):?><span class="alert alert-danger">默认导航不能删除</span><?php endif;?>
<?php if(isset($_GET['error_d'])):?><span class="alert alert-danger">请选择要添加的分类</span><?php endif;?>
<?php if(isset($_GET['error_e'])):?><span class="alert alert-danger">请选择要添加的页面</span><?php endif;?>
<?php if(isset($_GET['error_f'])):?><span class="alert alert-danger">导航地址格式错误(需包含http等前缀)</span><?php endif;?>
<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">导航管理</h1>
<form action="navbar.php?action=taxis" method="post">
  <table class="table table-striped table-bordered table-hover dataTable no-footer">
    <thead>
      <tr>
        <th width="50"><b>序号</b></th>
        <th width="230"><b>导航</b></th>
        <th width="60" class="tdcenter"><b>类型</b></th>
        <th width="60" class="tdcenter"><b>状态</b></th>
        <th width="50" class="tdcenter"><b>查看</b></th>
        <th width="360"><b>地址</b></th>
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
                $value['type_name'] = '系统';
                break;
            case Navi_Model::navitype_sort:
                $value['type_name'] = '<font color="blue">分类</font>';
                break;
            case Navi_Model::navitype_page:
                $value['type_name'] = '<font color="#00A3A3">页面</font>';
                break;
            case Navi_Model::navitype_custom:
                $value['type_name'] = '<font color="#FF6633">自定</font>';
                break;
        }
        doAction('adm_navi_display');

    ?>
      <tr>
        <td><input class="form-control em-small" name="navi[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4" /></td>
        <td><a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>" title="编辑导航"><?php echo $value['naviname']; ?></a></td>
        <td class="tdcenter"><?php echo $value['type_name'];?></td>
        <td class="tdcenter">
        <?php if ($value['hide'] == 'n'): ?>
        <a href="navbar.php?action=hide&amp;id=<?php echo $value['id']; ?>" title="点击隐藏导航">显示</a>
        <?php else: ?>
        <a href="navbar.php?action=show&amp;id=<?php echo $value['id']; ?>" title="点击显示导航" style="color:red;">隐藏</a>
        <?php endif;?>
        </td>
        <td class="tdcenter">
        <a href="<?php echo $value['url']; ?>" target="_blank">
        <img src="./views/images/<?php echo $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif';?>" align="absbottom" border="0" /></a>
        </td>
        <td><?php echo $value['url']; ?></td>
        <td>
        <a href="navbar.php?action=mod&amp;navid=<?php echo $value['id']; ?>">编辑</a>
        <?php if($value['isdefault'] == 'n'):?>
        <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'navi', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
        <?php endif;?>
        </td>
      </tr>
    <?php
        if(!empty($value['childnavi'])):
        foreach ($value['childnavi'] as $val):
    ?>
        <tr>
        <td><input class="form-control em-small" name="navi[<?php echo $val['id']; ?>]" value="<?php echo $val['taxis']; ?>" maxlength="4" /></td>
        <td>---- <a href="navbar.php?action=mod&amp;navid=<?php echo $val['id']; ?>" title="编辑导航"><?php echo $val['naviname']; ?></a></td>
        <td class="tdcenter"><?php echo $value['type_name'];?></td>
        <td class="tdcenter">
        <?php if ($val['hide'] == 'n'): ?>
        <a href="navbar.php?action=hide&amp;id=<?php echo $val['id']; ?>" title="点击隐藏导航">显示</a>
        <?php else: ?>
        <a href="navbar.php?action=show&amp;id=<?php echo $val['id']; ?>" title="点击显示导航" style="color:red;">隐藏</a>
        <?php endif;?>
        </td>
        <td class="tdcenter">
        <a href="<?php echo $val['url']; ?>" target="_blank">
        <img src="./views/images/<?php echo $val['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif';?>" align="absbottom" border="0" /></a>
        </td>
        <td><?php echo $val['url']; ?></td>
        <td>
        <a href="navbar.php?action=mod&amp;navid=<?php echo $val['id']; ?>">编辑</a>
        <?php if($val['isdefault'] == 'n'):?>
        <a href="javascript: em_confirm(<?php echo $val['id']; ?>, 'navi', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
        <?php endif;?>
        </td>
      </tr>
      <?php endforeach;endif; ?>
    <?php endforeach;else:?>
      <tr><td class="tdcenter" colspan="4">还没有添加导航</td></tr>
    <?php endif;?>
    </tbody>
  </table>
  <div class="list_footer"><input type="submit" value="改变排序" class="btn btn-primary" /></div>
</form>
    <div class="card-deck">
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">添加自定义导航</h6>
            </div>
            <div class="card-body">
                <form action="navbar.php?action=add" method="post" name="navi" id="navi">
                    <div class="form-group">
                        <input class="form-control" name="naviname" placeholder="导航名称" />
                    </div>
                    <div class="form-group">
                        <input maxlength="200" class="form-control" placeholder="地址(带http)" name="url" id="url" />
                    </div>
                    <div class="form-group">
                        <label>父导航</label>
                        <select name="pid" id="pid" class="form-control">
                            <option value="0">无</option>
                            <?php
                            foreach($navis as $key=>$value):
                                if($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                                    continue;
                                }
                                ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['naviname']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="y" name="newtab">
                        <label class="form-check-label" for="exampleCheck1">在新窗口打开</label>
                    </div>
                    <button type="submit" id="addsort" class="btn btn-primary">提交</button><span id="alias_msg_hook"></span>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">添加分类到导航</h6>
            </div>
            <div class="card-body">
                <form action="navbar.php?action=add_sort" method="post" name="navi" id="navi">
                    <div class="form-group">
                        <?php
                        if($sorts):
                            foreach($sorts as $key=>$value):
                                if ($value['pid'] != 0) {
                                    continue;
                                }
                                ?>
                                <div class="form-group"><input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
                                    <?php echo $value['sortname']; ?>
                                </div>
                                <?php
                                $children = $value['children'];
                                foreach ($children as $key):
                                    $value = $sorts[$key];
                                    ?>
                                    <div class="form-group">
                                        &nbsp; &nbsp; &nbsp;  <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids" />
                                        <?php echo $value['sortname']; ?>
                                    </div>
                                <?php
                                endforeach;
                            endforeach;
                            ?>
                            <div class="form-group">
                                <input type="submit" name="" class="btn btn-primary" value="添加" />
                            </div>
                        <?php else:?>
                            还没有分类，<a href="sort.php">新建分类</a>
                        <?php endif;?>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">添加页面到导航</h6>
            </div>
            <div class="card-body">
                <form action="navbar.php?action=add_page" method="post" name="navi" id="navi">
                <?php
                if($pages):
                    foreach($pages as $key=>$value):
                        ?>
                        <div class="form-group">
                            <input type="checkbox" style="vertical-align:middle;" name="pages[<?php echo $value['gid']; ?>]" value="<?php echo $value['title']; ?>" class="ids" />
                            <?php echo $value['title']; ?>
                        </div>
                    <?php endforeach;?>
                    <div class="form-group"><input type="submit" class="btn btn-primary" name="" value="添加"  /></div>
                <?php else:?>
                    <div class="form-group">还没页面，<a href="page.php">新建页面</a></div>
                <?php endif;?>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script>
$("#navi_add_custom").css('display', $.cookie('em_navi_add_custom') ? $.cookie('em_navi_add_custom') : '');
$("#navi_add_sort").css('display', $.cookie('em_navi_add_sort') ? $.cookie('em_navi_add_sort') : '');
$("#navi_add_page").css('display', $.cookie('em_navi_add_page') ? $.cookie('em_navi_add_page') : '');
setTimeout(hideActived, 2600);
$("#menu_category_view").addClass('active');
$("#menu_view").addClass('in');
$("#menu_navi").addClass('active');
</script>
