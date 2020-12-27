<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle">
<?php if(isset($_GET['active_del'])):?><span class="alert alert-success">删除页面成功</span><?php endif;?>
<?php if(isset($_GET['active_hide_n'])):?><span class="alert alert-success">发布页面成功</span><?php endif;?>
<?php if(isset($_GET['active_hide_y'])):?><span class="alert alert-success">禁用页面成功</span><?php endif;?>
<?php if(isset($_GET['active_pubpage'])):?><span class="alert alert-success">页面保存成功</span><?php endif;?>
</div>
<div class=line></div>
<form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">页面管理</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">页面管理</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th></th>
                        <th>标题</th>
                        <th>模板</th>
                        <th>评论</th>
                        <th>时间</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($pages):
                    foreach($pages as $key => $value):
                    if (empty($navibar[$value['gid']]['url']))
                    {
                        $navibar[$value['gid']]['url'] = Url::log($value['gid']);
                    }
                    $isHide = $value['hide'] == 'y' ? 
                    '<font color="red"> - 草稿</font>' : 
                    '<a href="'.$navibar[$value['gid']]['url'].'" target="_blank" title="查看页面"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>';
                    ?>
                    <tr>
                        <td width="21"><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
                        <td width="440">
                        <a href="page.php?action=mod&id=<?php echo $value['gid']?>"><?php echo $value['title']; ?></a> 
                        <?php echo $isHide; ?>    
                        <?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="附件：<?php echo $value['attnum']; ?>" /><?php endif; ?>
                        </td>
                        <td><?php echo $value['template']; ?></td>
                        <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                        <td class="small"><?php echo $value['date']; ?></td>
                    </tr>
                    <?php endforeach;else:?>
                      <tr><td class="tdcenter" colspan="5">还没有页面</td></tr>
                    <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
</form>
<div class="list_footer">
<a href="javascript:void(0);" id="select_all">全选</a> 选中项：
<a href="javascript:pageact('del');" class="care">删除</a> | 
<a href="javascript:pageact('hide');">转为草稿</a> | 
<a href="javascript:pageact('pub');">发布</a>
</div>
<div style="margin:20px 0px 0px 0px;"><a href="page.php?action=new" class="btn btn-success">新建页面+</a></div>
<div class="page"><?php echo $pageurl; ?> (有<?php echo $pageNum; ?>个页面)</div>
<script>
$(document).ready(function(){
    $("#adm_comment_list tbody tr:odd").addClass("tralt_b");
    $("#adm_comment_list tbody tr")
        .mouseover(function(){$(this).addClass("trover")})
        .mouseout(function(){$(this).removeClass("trover")});
    selectAllToggle();
});
setTimeout(hideActived,2600);
function pageact(act){
    if (getChecked('ids') == false) {
        alert('请选择要操作的页面');
        return;}
    if(act == 'del' && !confirm('你确定要删除所选页面吗？')){return;}
    $("#operate").val(act);
    $("#form_page").submit();
}
$("#menu_page").addClass('active');
</script>
