<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
$isdraft = $pid == 'draft' ? '&pid=draft' : '';
$isDisplaySort = !$sid ? "style=\"display:none;\"" : '';
$isDisplayTag = !$tagId ? "style=\"display:none;\"" : '';
$isDisplayUser = !$uid ? "style=\"display:none;\"" : '';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">文章管理</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">文章管理</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>标题</th>
                            <th>查看</th>
                            <th>作者</th>
                            <th>分类</th>
                            <th>时间</th>
                            <th>评论</th>
                            <th>阅读</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($logs):
                        foreach($logs as $key=>$value):
                        $sortName = $value['sortid'] == -1 && !array_key_exists($value['sortid'], $sorts) ? '未分类' : $sorts[$value['sortid']]['sortname'];
                        $author = $user_cache[$value['author']]['name'];
                        $author_role = $user_cache[$value['author']]['role'];
                        ?>
                        <tr>
                        <td width="21"><input type="checkbox" name="blog[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
                        <td width="490"><a href="write_log.php?action=edit&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a>
                        <?php if($value['top'] == 'y'): ?><img src="./views/images/top.png" align="top" title="首页置顶" /><?php endif; ?>
                        <?php if($value['sortop'] == 'y'): ?><img src="./views/images/sortop.png" align="top" title="分类置顶" /><?php endif; ?>
                        <?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="附件：<?php echo $value['attnum']; ?>" /><?php endif; ?>
                        <?php if($pid != 'draft' && $value['checked'] == 'n'): ?><sapn style="color:red;"> - 待审</sapn><?php endif; ?>
                        <span style="display:none; margin-left:8px;">
                            <?php if($pid != 'draft' && ROLE == ROLE_ADMIN && $value['checked'] == 'n'): ?>
                            <a href="./admin_log.php?action=operate_log&operate=check&gid=<?php echo $value['gid']?>&token=<?php echo LoginAuth::genToken(); ?>">审核</a> 
                            <?php elseif($pid != 'draft' && ROLE == ROLE_ADMIN && $author_role == ROLE_WRITER):?>
                            <a href="./admin_log.php?action=operate_log&operate=uncheck&gid=<?php echo $value['gid']?>&token=<?php echo LoginAuth::genToken(); ?>">驳回</a> 
                            <?php endif;?>
                        </span>
                        </td>
                        <?php if ($pid != 'draft'): ?>
                        <td class="tdcenter">
                        <a href="<?php echo Url::log($value['gid']); ?>" target="_blank" title="在新窗口查看">
                        <img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>
                        </td>
                        <?php endif; ?>
                        <td><a href="./admin_log.php?uid=<?php echo $value['author'].$isdraft;?>"><?php echo $author; ?></a></td>
                        <td><a href="./admin_log.php?sid=<?php echo $value['sortid'].$isdraft;?>"><?php echo $sortName; ?></a></td>
                        <td class="small"><?php echo $value['date']; ?></td>
                        <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                        <td class="tdcenter"><?php echo $value['views']; ?></a></td>
                        </tr>
                        <?php endforeach;else:?>
                        <tr><td class="tdcenter" colspan="8">还没有文章</td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<script>
$(document).ready(function(){
    $("#f_t_tag").click(function(){$("#f_tag").toggle();$("#f_sort").hide();$("#f_user").hide();});
    selectAllToggle();
});
setTimeout(hideActived,2600);
function logact(act){
    if (getChecked('ids') == false) {
        alert('请选择要操作的文章');
        return;}
    if(act == 'del' && !confirm('你确定要删除所选文章吗？')){return;}
    $("#operate").val(act);
    $("#form_log").submit();
}
function changeSort(obj) {
    if (getChecked('ids') == false) {
        alert('请选择要操作的文章');
        return;}
    if($('#sort').val() == '')return;
    $("#operate").val('move');
    $("#form_log").submit();
}
function changeAuthor(obj) {
    if (getChecked('ids') == false) {
        alert('请选择要操作的文章');
        return;}
    if($('#author').val() == '')return;
    $("#operate").val('change_author');
    $("#form_log").submit();
}
function changeTop(obj) {
    if (getChecked('ids') == false) {
        alert('请选择要操作的文章');
        return;}
    if($('#top').val() == '')return;
    $("#operate").val(obj.value);
    $("#form_log").submit();
}
function selectSort(obj) {
    window.open("./admin_log.php?sid=" + obj.value + "<?php echo $isdraft?>", "_self");
}
function selectUser(obj) {
    window.open("./admin_log.php?uid=" + obj.value + "<?php echo $isdraft?>", "_self");
}
<?php if ($isdraft) :?>
$("#menu_draft").addClass('active');
<?php else:?>
$("#menu_log").addClass('active');
<?php endif;?>
</script>
