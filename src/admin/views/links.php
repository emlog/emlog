<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_taxis'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('order_update_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('deleted_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_edit'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('edit_ok')?></div><?php endif; ?>
<?php if (isset($_GET['active_add'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('add_ok')?></div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('site_and_url_empty')?></div><?php endif; ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('no_link_order')?></div><?php endif; ?>
<div class="container-fluid">
<!--vot--><h1 class="h3 mb-2 text-gray-800"><?= lang('link_management') ?></h1>
    <form action="link.php?action=link_taxis" method="post">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
<!--vot-->      <h6 class="m-0 font-weight-bold text-primary"><?= lang('link_management') ?></h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
<!--vot-->              <th><?= lang('order') ?></th>
<!--vot-->              <th><?= lang('link') ?></th>
<!--vot-->              <th><?= lang('status') ?></th>
<!--vot-->              <th><?= lang('view') ?></th>
<!--vot-->              <th><?= lang('description') ?></th>
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
<!--vot-->                      <td><a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"
                                       title="<?= lang('edit_link') ?>"><?php echo $value['sitename']; ?></a></td>
                                <td class="tdcenter">
                                    <?php if ($value['hide'] == 'n'): ?>
<!--vot-->                              <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>"
                                           title="<?= lang('click_to_hide') ?>"><?= lang('visible') ?></a>
                                    <?php else: ?>
<!--vot-->                              <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>"
                                           title="<?= lang('click_to_show') ?>" style="color:red;"><?= lang('hidden') ?></a>
                                    <?php endif; ?>
                                </td>
                                <td class="tdcenter">
<!--vot-->                          <a href="<?php echo $value['siteurl']; ?>" target="_blank" title="<?= lang('view_link') ?>">
                                        <img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                                </td>
                                <td><?php echo $value['description']; ?></td>
                                <td>
<!--vot-->                          <a href="link.php?action=mod_link&amp;linkid=<?php echo $value['id']; ?>"><?= lang('edit') ?></a>
<!--vot-->                          <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');"
                                       class="care"><?= lang('delete') ?></a>
                                </td>
                            </tr>
                        <?php endforeach; else:?>
                        <tr>
<!--vot-->                  <td class="tdcenter" colspan="6"><?= lang('no_links') ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="list_footer">
<!--vot-->  <input type="submit" value="<?=lang('order_change')?>" class="btn btn-primary">
<!--vot-->  <a href="javascript:displayToggle('link_new', 2);" class="btn btn-success"><?=lang('link_add')?></a>
        </div>
    </form>
    <form action="link.php?action=addlink" method="post" name="link" id="link" style="margin-top: 30px;">
        <div class="form-group">
<!--vot-->  <label for="sortname"><?=lang('id')?></label>
            <input class="form-control" id="taxis" name="taxis">
        </div>
        <div class="form-group">
<!--vot-->  <label for="alias"><?=lang('name')?></label>
            <input class="form-control" id="sitename" name="sitename">
        </div>
        <div class="form-group">
<!--vot-->  <label for="template"><?=lang('address')?></label>
            <input class="form-control" id="siteurl" name="siteurl">
        </div>
        <div class="form-group">
<!--vot-->  <label for="alias"><?=lang('description')?></label>
            <textarea name="description" type="text" class="form-control"></textarea>
        </div>
<!--vot--><button type="submit" id="addsort" class="btn btn-primary"><?=lang('link_add')?></button>
        <span id="alias_msg_hook"></span>
    </form>
</div>
<script>
    $("#link_new").css('display', $.cookie('em_link_new') ? $.cookie('em_link_new') : 'none');
    setTimeout(hideActived, 2600);
    $("#menu_link").addClass('active');
</script>
