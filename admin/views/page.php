<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除页面成功</div><?php endif; ?>
<?php if (isset($_GET['active_hide_n'])): ?>
    <div class="alert alert-success">发布页面成功</div><?php endif; ?>
<?php if (isset($_GET['active_hide_y'])): ?>
    <div class="alert alert-success">禁用页面成功</div><?php endif; ?>
<?php if (isset($_GET['active_pubpage'])): ?>
    <div class="alert alert-success">页面保存成功</div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">页面</h1>
    <a href="page.php?action=new" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-plus"></i> 新建页面</a>
</div>
<form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th>标题</th>
                        <th>查看</th>
                        <th>模板</th>
                        <th>评论</th>
                        <th>时间</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ($pages as $key => $value):
						if (empty($navibar[$value['gid']]['url'])) {
							$navibar[$value['gid']]['url'] = Url::log($value['gid']);
						}
						$isHide = $value['hide'] == 'y' ?
							'<span class="text-danger">[草稿]</span>' :
							'<a href="' . $navibar[$value['gid']]['url'] . '" target="_blank" title="查看页面"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>';
						?>
                        <tr>
                            <td><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids"/></td>
                            <td>
                                <a href="page.php?action=mod&id=<?php echo $value['gid'] ?>"><?php echo $value['title']; ?></a>
                            </td>
                            <td><?php echo $isHide; ?></td>
                            <td><?php echo $value['template']; ?></td>
                            <td><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                            <td class="small"><?php echo $value['date']; ?></td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="javascript:pageact('del');" class="btn btn-sm btn-danger">删除</a>
                    <a href="javascript:pageact('hide');" class="btn btn-sm btn-success">转为草稿</a>
                    <a href="javascript:pageact('pub');" class="btn btn-sm btn-success">发布</a>
                </div>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input name="operate" id="operate" value="" type="hidden"/>
            </div>
            <div class="page"><?php echo $pageurl; ?> （有 <?php echo $pageNum; ?> 个页面）</div>
        </div>
    </div>
</form>

<script>
    $("#menu_page").addClass('active');
    setTimeout(hideActived, 2600);

    function pageact(act) {
        if (getChecked('ids') == false) {
            alert('请选择要操作的页面');
            return;
        }
        if (act == 'del' && !confirm('确定要删除所选页面吗？')) {
            return;
        }
        $("#operate").val(act);
        $("#form_page").submit();
    }
</script>
