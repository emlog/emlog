<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
    <div class="alert alert-success">排序更新成功</div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除导航成功</div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success">修改导航成功</div><?php endif ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success">添加导航成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">导航名称和地址不能为空</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">没有可排序的导航</div><?php endif ?>
<?php if (isset($_GET['error_c'])): ?>
    <div class="alert alert-danger">默认导航不能删除</div><?php endif ?>
<?php if (isset($_GET['error_d'])): ?>
    <div class="alert alert-danger">请选择要添加的分类</div><?php endif ?>
<?php if (isset($_GET['error_e'])): ?>
    <div class="alert alert-danger">请选择要添加的页面</div><?php endif ?>
<?php if (isset($_GET['error_f'])): ?>
    <div class="alert alert-danger">导航地址格式错误(需包含http等前缀)</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">导航</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="navbar.php?action=taxis" method="post">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>导航</th>
                        <th>类型</th>
                        <th>查看</th>
                        <th>地址</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if ($navis):
						foreach ($navis as $key => $value):
							if ($value['pid'] != 0) {
								continue;
							}
							$value['type_name'] = '';
							switch ($value['type']) {
								case Navi_Model::navitype_home:
								case Navi_Model::navitype_t:
								case Navi_Model::navitype_admin:
									$value['type_name'] = '系统';
									$value['url'] = '/' . $value['url'];
									break;
								case Navi_Model::navitype_sort:
									$value['type_name'] = '<span class="text-primary">分类</span>';
									break;
								case Navi_Model::navitype_page:
									$value['type_name'] = '<span class="text-success">页面</span>';
									break;
								case Navi_Model::navitype_custom:
									$value['type_name'] = '<span class="text-danger">自定</span>';
									break;
							}
							doAction('adm_navi_display');

							?>
                            <tr>
                                <td><input class="form-control em-small" name="navi[<?= $value['id'] ?>]" value="<?= $value['taxis'] ?>" maxlength="4"/></td>
                                <td><a href="navbar.php?action=mod&amp;navid=<?= $value['id'] ?>"><?= $value['naviname'] ?></a></td>
                                <td><?= $value['type_name'] ?></td>
                                <td>
                                    <a href="<?= $value['url'] ?>" target="_blank">
                                        <img src="./views/images/<?= $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif' ?>" align="absbottom" border="0"/>
                                    </a>
                                </td>
                                <td><?= $value['url'] ?></td>
                                <td>
									<?php if ($value['hide'] == 'n'): ?>
                                        <a href="navbar.php?action=hide&amp;id=<?= $value['id'] ?>" class="badge badge-primary">显示</a>
									<?php else: ?>
                                        <a href="navbar.php?action=show&amp;id=<?= $value['id'] ?>" class="badge badge-warning">隐藏</a>
									<?php endif ?>
									<?php if ($value['isdefault'] == 'n'): ?>
                                        <a href="javascript: em_confirm(<?= $value['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');"
                                           class="badge badge-danger">删除</a>
									<?php endif ?>
                                </td>
                            </tr>
							<?php
							if (!empty($value['childnavi'])):
								foreach ($value['childnavi'] as $val):
									?>
                                    <tr>
                                        <td><input class="form-control em-small" name="navi[<?= $val['id'] ?>]" value="<?= $val['taxis'] ?>" maxlength="4"/></td>
                                        <td>---- <a href="navbar.php?action=mod&amp;navid=<?= $val['id'] ?>"><?= $val['naviname'] ?></a></td>
                                        <td><?= $value['type_name'] ?></td>
                                        <td>
                                            <a href="<?= $val['url'] ?>" target="_blank">
                                                <img src="./views/images/<?= $val['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif' ?>" align="absbottom" border="0"/></a>
                                        </td>
                                        <td><?= $val['url'] ?></td>
                                        <td>
											<?php if ($val['hide'] == 'n'): ?>
                                                <a href="navbar.php?action=hide&amp;id=<?= $val['id'] ?>" class="badge badge-primary">显示</a>
											<?php else: ?>
                                                <a href="navbar.php?action=show&amp;id=<?= $val['id'] ?>" class="badge badge-warning">隐藏</a>
											<?php endif ?>
											<?php if ($val['isdefault'] == 'n'): ?>
                                                <a href="javascript: em_confirm(<?= $val['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');"
                                                   class="badge badge-danger">删除</a>
											<?php endif ?>
                                        </td>
                                    </tr>
								<?php endforeach;endif ?>
						<?php endforeach; else: ?>
                        <tr>
                            <td colspan="4">还没有添加导航</td>
                        </tr>
					<?php endif ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer"><input type="submit" value="改变排序" class="btn btn-sm btn-success"/></div>
        </form>
    </div>
</div>
<div class="card-deck">
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">添加自定义导航</h6>
        </div>
        <div class="card-body">
            <form action="navbar.php?action=add" method="post" name="navi" id="navi">
                <div class="form-group">
                    <input class="form-control" name="naviname" placeholder="导航名称" required/>
                </div>
                <div class="form-group">
                    <textarea maxlength="512" class="form-control" placeholder="地址（URL）" name="url" id="url" required/></textarea>
                </div>
                <div class="form-group">
                    <label>父导航</label>
                    <select name="pid" id="pid" class="form-control">
                        <option value="0">无</option>
						<?php
						foreach ($navis as $key => $value):
							if ($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
								continue;
							}
							?>
                            <option value="<?= $value['id'] ?>"><?= $value['naviname'] ?></option>
						<?php endforeach ?>
                    </select>
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" value="y" name="newtab">
                    <label class="form-check-label" for="exampleCheck1">在新窗口打开</label>
                </div>
                <button type="submit" class="btn btn-sm btn-success">保存</button>
                <span id="alias_msg_hook"></span>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">添加分类到导航</h6>
        </div>
        <div class="card-body">
            <form action="navbar.php?action=add_sort" method="post" name="navi" id="navi">
                <div class="form-group">
					<?php
					if ($sorts):
						foreach ($sorts as $key => $value):
							if ($value['pid'] != 0) {
								continue;
							}
							?>
                            <div class="form-group"><input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?= $value['sid'] ?>" class="ids"/>
								<?= $value['sortname'] ?>
                            </div>
							<?php
							$children = $value['children'];
							foreach ($children as $key):
								$value = $sorts[$key];
								?>
                                <div class="form-group">
                                    &nbsp; &nbsp; &nbsp; <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?= $value['sid'] ?>" class="ids"/>
									<?= $value['sortname'] ?>
                                </div>
							<?php
							endforeach;
						endforeach;
						?>
                        <div class="form-group">
                            <input type="submit" name="" class="btn btn-sm btn-success" value="保存"/>
                        </div>
					<?php else: ?>
                        还没有分类，<a href="sort.php">新建分类</a>
					<?php endif ?>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">添加页面到导航</h6>
        </div>
        <div class="card-body">
            <form action="navbar.php?action=add_page" method="post" name="navi" id="navi">
				<?php
				if ($pages):
					foreach ($pages as $key => $value):
						?>
                        <div class="form-group">
                            <input type="checkbox" style="vertical-align:middle;" name="pages[<?= $value['gid'] ?>]" value="<?= $value['title'] ?>" class="ids"/>
							<?= $value['title'] ?>
                        </div>
					<?php endforeach ?>
                    <div class="form-group"><input type="submit" class="btn btn-sm btn-success" name="" value="保存"/></div>
				<?php else: ?>
                    <div class="form-group">还没页面，<a href="page.php?action=new">新建页面</a></div>
				<?php endif ?>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(hideActived, 3600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
    $("#menu_navi").addClass('active');
</script>
