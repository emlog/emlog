<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="containertitle">
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('page_deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_hide_n'])):?><span class="alert alert-success"><?=lang('page_published_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_hide_y'])):?><span class="alert alert-success"><?=lang('page_disabled_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_pubpage'])):?><span class="alert alert-success"><?=lang('page_saved_ok')?></span><?php endif;?>
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
/*vot*/    '<font color="red"> - '.lang('draft').'</font>' : 
/*vot*/    '<a href="'.$navibar[$value['gid']]['url'].'" target="_blank" title="'.lang('page_view').'"><img src="./views/images/vlog.gif" align="absbottom" border="0"></a>';
                    ?>
                    <tr>
                        <td width="21"><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
                        <td width="440">
        <a href="page.php?action=mod&id=<?= $value['gid']?>"><?= $value['title'] ?></a> 
        <?= $isHide ?>    
<!--vot--><?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="<?=lang('attachments')?>: <?= $value['attnum'] ?>"><?php endif; ?>
                        </td>
                        <td><?php echo $value['template']; ?></td>
                        <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                        <td class="small"><?php echo $value['date']; ?></td>
                    </tr>
                    <?php endforeach;else:?>
<!--vot--><tr><td class="tdcenter" colspan="5"><?=lang('no_pages')?></td></tr>
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
<!--vot--><a href="javascript:void(0);" id="select_all"><?=lang('select_all')?></a> <?=lang('selected_items')?>:
<!--vot--><a href="javascript:pageact('del');" class="care"><?=lang('delete')?></a> | 
<!--vot--><a href="javascript:pageact('hide');"><?=lang('make_draft')?></a> | 
<!--vot--><a href="javascript:pageact('pub');"><?=lang('publish')?></a>
</div>
<!--vot--><div style="margin:20px 0px 0px 0px;"><a href="page.php?action=new" class="btn btn-success"><?=lang('add_page')?>+</a></div>
<!--vot--><div class="page"><?= $pageurl ?> (<?=lang('have')?><?= $pageNum ?><?=lang('_pages')?>)</div>
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
/*vot*/ alert('<?=lang('select_page_to_operate')?>');
        return;}
/*vot*/ if(act == 'del' && !confirm('<?=lang('sure_delete_selected_pages')?>')){return;}
    $("#operate").val(act);
    $("#form_page").submit();
}
$("#menu_page").addClass('active');
</script>
