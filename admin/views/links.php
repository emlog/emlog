<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
    <div class="alert alert-success">排序更新成功</div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改成功</div><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加成功</div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">站点名称和地址不能为空</div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">没有可排序的链接</div><?php endif; ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">链接管理</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-edit"></i> 新建链接</a>
    </div>
    <p class="mb-4">友情链接管理，可以在侧边栏管理中将该处添加的链接展示在首页侧边栏。</p>
    <form action="link.php?action=link_taxis" method="post">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">已创建的链接</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%"
                       cellspacing="0">
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
                    if ($links):
                        foreach ($links as $key => $value):
                            doAction('adm_link_display');
                            ?>
                            <tr>
                                <td><input class="form-control em-small" name="link[<?php echo $value['id']; ?>]"
                                           value="<?php echo $value['taxis']; ?>" maxlength="4"/></td>
                                <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"
                                       title="修改链接"><?php echo $value['sitename']; ?></a></td>
                                <td>
                                    <?php if ($value['hide'] == 'n'): ?>
                                        <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>"
                                           title="点击隐藏链接">显示</a>
                                    <?php else: ?>
                                        <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>"
                                           title="点击显示链接" style="color:red;">隐藏</a>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="查看链接">
                                        <img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                                </td>
                                <td><?php echo $value['description']; ?></td>
                                <td>
                                    <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>">编辑</a>
                                    <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');"
                                       class="care">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; else:?>
                        <tr>
                            <td class="tdcenter" colspan="6">还没有添加链接</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="list_footer">
            <input type="submit" value="改变排序" class="btn btn-primary"/>
        </div>
    </form>
    <!--添加链接弹窗-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新建标签</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="link.php?action=addlink" method="post" name="link" id="link">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sortname">序号</label>
                            <input class="form-control" id="taxis" name="taxis">
                        </div>
                        <div class="form-group">
                            <label for="alias">名称</label>
                            <input class="form-control" id="sitename" name="sitename">
                        </div>
                        <div class="form-group">
                            <label for="template">地址</label>
                            <input class="form-control" id="siteurl" name="siteurl">
                        </div>
                        <div class="form-group">
                            <label for="alias">描述</label>
                            <textarea name="description" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="addsort" class="btn btn-primary">提交</button>
                        <span id="alias_msg_hook"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#menu_link").addClass('active');
    setTimeout(hideActived, 2600);
</script>
