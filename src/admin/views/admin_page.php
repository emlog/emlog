<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="alert alert-success"><?=lang('page_deleted_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_hide_n'])):?><span class="alert alert-success"><?=lang('page_published_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_hide_y'])):?><span class="alert alert-success"><?=lang('page_disabled_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_pubpage'])):?><span class="alert alert-success"><?=lang('page_saved_ok')?></span><?php endif;?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?= lang('page_management') ?></h1>
<!--vot--><a href="./page.php?action=new" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="far fa-edit"></i> <?=lang('add_page')?></a>
    </div>
    <form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
<!--vot-->      <h6 class="m-0 font-weight-bold text-primary"><?= lang('page_management') ?></h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                            <th></th>
<!--vot-->                  <th><?= lang('title') ?></th>
<!--vot-->                  <th><?= lang('template') ?></th>
<!--vot-->                  <th><?= lang('comments') ?></th>
<!--vot-->                  <th><?= lang('time') ?></th>
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
/*vot*/                 '<font color="red"> - <?= lang('draft') ?></font>' : 
/*vot*/                 '<a href="'.$navibar[$value['gid']]['url'].'" target="_blank" title="<?= lang('page_view') ?>"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>';
                        ?>
                        <tr>
                            <td width="21"><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids" /></td>
                            <td width="440">
                            <a href="page.php?action=mod&id=<?php echo $value['gid']?>"><?php echo $value['title']; ?></a> 
                            <?php echo $isHide; ?>    
<!--vot-->                  <?php if($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="<?= lang('attachment_num') ?>: <?php echo $value['attnum']; ?>" /><?php endif; ?>
                            </td>
                            <td><?php echo $value['template']; ?></td>
                            <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                            <td class="small"><?php echo $value['date']; ?></td>
                        </tr>
                        <?php endforeach;else:?>
<!--vot-->              <tr><td class="tdcenter" colspan="5"><?= lang('no_pages') ?></td></tr>
                        <?php endif;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
    <div class="list_footer">
<!--vot--><a href="javascript:void(0);" id="select_all"><?=lang('select_all')?></a> <?=lang('selected_items')?>:
<!--vot--><a href="javascript:pageact('del');" class="care"><?=lang('delete')?></a> | 
<!--vot--><a href="javascript:pageact('hide');"><?=lang('make_draft')?></a> | 
<!--vot--><a href="javascript:pageact('pub');"><?=lang('publish')?></a>
    </div>
<!--vot--><div class="page"><?= $pageurl ?> (<?=lang('have')?><?= $pageNum ?><?=lang('_pages')?>)</div>
</div>
<!-- /.container-fluid -->
<script>
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
