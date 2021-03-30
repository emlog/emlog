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
    <h1 class="h3 mb-0 text-gray-800">页面管理</h1>
    <a href="./page.php?action=new" class="d-none d-sm-inline-block btn btn-success shadow-sm"><i class="icofont-plus"></i> 新建页面</a>
</div>
<form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th>标题</th>
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
							'<font color="red"> - 草稿</font>' :
							'<a href="' . $navibar[$value['gid']]['url'] . '" target="_blank" title="查看页面"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>';
						?>
                        <tr>
                            <td width="21"><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids"/></td>
                            <td width="440">
                                <a href="page.php?action=mod&id=<?php echo $value['gid'] ?>"><?php echo $value['title']; ?></a>
								<?php echo $isHide; ?>
								<?php if ($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="附件：<?php echo $value['attnum']; ?>" /><?php endif; ?>
                            </td>
                            <td><?php echo $value['template']; ?></td>
                            <td><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                            <td class="small"><?php echo $value['date']; ?></td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input name="operate" id="operate" value="" type="hidden"/>
                <a href="javascript:pageact('del');" class="care">删除</a> |
                <a href="javascript:pageact('hide');">转为草稿</a> |
                <a href="javascript:pageact('pub');">发布</a>
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
        if (act == 'del' && !confirm('你确定要删除所选页面吗？')) {
            return;
        }
        $("#operate").val(act);
        $("#form_page").submit();
    }
</script>
