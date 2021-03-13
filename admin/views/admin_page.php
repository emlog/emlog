<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
    <?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('page_deleted_ok')?></div><?php endif; ?>
    <?php if (isset($_GET['active_hide_n'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('page_published_ok')?></div><?php endif; ?>
    <?php if (isset($_GET['active_hide_y'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('page_disabled_ok')?></div><?php endif; ?>
    <?php if (isset($_GET['active_pubpage'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('page_saved_ok')?></div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?= lang('page_management') ?></h1>
<!--vot--><a href="./page.php?action=new" class="d-none d-sm-inline-block btn btn-success shadow-sm"><i class="fas fa-edit"></i> <?=lang('add_page')?></a>
    </div>
    <form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
<!--vot-->      <span class="badge badge-secondary"><?=lang('pages_total')?> <?php echo $pageNum; ?> <?=lang('_pages')?></span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"/></th>
<!--vot-->                  <th><?= lang('title') ?></th>
<!--vot-->                  <th><?= lang('template') ?></th>
<!--vot-->                  <th><?= lang('comments') ?></th>
<!--vot-->                  <th><?= lang('time') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($pages as $key => $value):
                            if (empty($navibar[$value['gid']]['url'])) {
                                $navibar[$value['gid']]['url'] = Url::log($value['gid']);
                            }
                            $isHide = $value['hide'] == 'y' ?
/*vot*/                         '<font color="red"> - ' . lang('draft') . '</font>' :
/*vot*/                         '<a href="' . $navibar[$value['gid']]['url'] . '" target="_blank" title="' . lang('page_view') . '"><img src="./views/images/vlog.gif" align="absbottom" border="0" /></a>';
                            ?>
                            <tr>
                                <td width="21"><input type="checkbox" name="page[]" value="<?php echo $value['gid']; ?>" class="ids"/></td>
                                <td width="440">
                                    <a href="page.php?action=mod&id=<?php echo $value['gid'] ?>"><?php echo $value['title']; ?></a>
                                    <?php echo $isHide; ?>
<!--vot-->                          <?php if ($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top" title="<?= lang('attachment_num') ?>: <?php echo $value['attnum']; ?>" /><?php endif; ?>
                                </td>
                                <td><?php echo $value['template']; ?></td>
                                <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                                <td class="small"><?php echo $value['date']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="list_footer">
                    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                    <input name="operate" id="operate" value="" type="hidden"/>
<!--vot-->          <a href="javascript:pageact('del');" class="care"><?=lang('delete')?></a> |
<!--vot-->          <a href="javascript:pageact('hide');"><?=lang('make_draft')?></a> |
<!--vot-->          <a href="javascript:pageact('pub');"><?=lang('publish')?></a>
                </div>
<!--vot-->      <div class="page"><?php echo $pageurl; ?></div>
            </div>
        </div>
    </form>
</div>
<script>
    $("#menu_page").addClass('active');
    setTimeout(hideActived, 2600);

    function pageact(act) {
        if (getChecked('ids') == false) {
/*vot*/     alert('<?=lang('select_page_to_operate')?>');
            return;
        }
/*vot*/ if(act == 'del' && !confirm('<?=lang('sure_delete_selected_pages')?>')) {
            return;
        }
        $("#operate").val(act);
        $("#form_page").submit();
    }
</script>
