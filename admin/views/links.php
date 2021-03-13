<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?= lang('link_management') ?></h1>
<!--vot--><a href="#" class="d-none d-sm-inline-block btn btn-success shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> <?= lang('link_add') ?></a>
    </div>
    <form action="link.php?action=link_taxis" method="post">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
<!--vot-->      <h6  class="badge badge-secondary"><?= lang('links_created') ?></h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
<!--vot-->              <th><?= lang('order') ?></th>
<!--vot-->              <th><?= lang('link') ?></th>
<!--vot-->              <th><?= lang('description') ?></th>
<!--vot-->              <th><?= lang('status') ?></th>
<!--vot-->              <th><?= lang('operation') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($links as $key => $value):
                        doAction('adm_link_display');
                        ?>
                        <tr>
                            <td><input class="form-control em-small" name="link[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4"/></td>
                            <td><a href="<?php echo $value['siteurl']; ?>" target="_blank"><?php echo $value['sitename']; ?></a></td>
                            <td><?php echo $value['description']; ?></td>
                            <td>
                                <?php if ($value['hide'] == 'n'): ?>
<!--vot-->                          <a href="link.php?action=hide&amp;linkid=<?php echo $value['id']; ?>" title="<?= lang('click_to_hide') ?>"><?= lang('visible') ?></a>
                                <?php else: ?>
<!--vot-->                          <a href="link.php?action=show&amp;linkid=<?php echo $value['id']; ?>" title="<?= lang('click_to_show') ?>" style="color:red;"><?= lang('hidden') ?></a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="#" class="badge badge-primary" data-toggle="modal" data-target="#editModal"
                                   data-linkid="<?php echo $value['id']; ?>"
                                   data-sitename="<?php echo $value['sitename']; ?>"
                                   data-siteurl="<?php echo $value['siteurl']; ?>"
<!--vot-->                         data-description="<?php echo $value['description']; ?>"><?=lang('edit')?>
                                </a>
<!--vot-->                      <a href="javascript: em_confirm(<?php echo $value['id']; ?>, 'link', '<?php echo LoginAuth::genToken(); ?>');" class="badge badge-danger"><?=lang('delete')?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="list_footer">
<!--vot-->  <input type="submit" value="<?=lang('order_change')?>" class="btn btn-success">
        </div>
    </form>
    <!--Add Link popup-->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
<!--vot-->          <h5 class="modal-title" id="exampleModalLabel"><?=lang('add_link')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="link.php?action=addlink" method="post" name="link" id="link">
                    <div class="modal-body">
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('name')?></label>
                            <input class="form-control" id="sitename" name="sitename">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="template"><?=lang('link_url')?></label>
                            <input class="form-control" id="siteurl" name="siteurl">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('description')?></label>
                            <textarea name="description" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
<!--vot-->              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->              <button type="submit" class="btn btn-success"><?=lang('save')?></button>
                        <span id="alias_msg_hook"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Edit Link popup-->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
<!--vot-->          <h5 class="modal-title" id="exampleModalLabel"><?=lang('')?>编辑链接</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="link.php?action=update_link" method="post" name="link" id="link">
                    <div class="modal-body">
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('')?>名称</label>
                            <input class="form-control" id="sitename" name="sitename">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="template"><?=lang('address')?></label>
                            <input class="form-control" id="siteurl" name="siteurl">
                        </div>
                        <div class="form-group">
<!--vot-->                  <label for="alias"><?=lang('description')?></label>
                            <textarea name="description" id="description" type="text" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" name="linkid" id="linkid"/>
<!--vot-->              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('cancel')?></button>
<!--vot-->              <button type="submit" class="btn btn-success"><?=lang('link_add')?></button>
                        <span id="alias_msg_hook"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
    $("#menu_link").addClass('active');
    setTimeout(hideActived, 3600);
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var linkid = button.data('linkid')
        var sitename = button.data('sitename')
        var siteurl = button.data('siteurl')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #sitename').val(sitename)
        modal.find('.modal-body #siteurl').val(siteurl)
        modal.find('.modal-body #description').val(description)
        modal.find('.modal-footer #linkid').val(linkid)
    })
</script>
