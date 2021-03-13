<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
<!--vot--><?php if (isset($_GET['active_taxis'])): ?><div class="alert alert-success"><?=lang('nav_cat_update_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_del'])): ?><div class="alert alert-success"><?=lang('nav_delete_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_edit'])): ?><div class="alert alert-success"><?=lang('nav_edit_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['active_add'])): ?><div class="alert alert-success"><?=lang('nav_add_ok')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger"><?=lang('nav_name_url_empty')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_b'])): ?><div class="alert alert-danger"><?=lang('nav_no_order')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_c'])): ?><div class="alert alert-danger"><?=lang('nav_default_nodelete')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_d'])): ?><div class="alert alert-danger"><?=lang('nav_select_category')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_e'])): ?><div class="alert alert-danger"><?=lang('nav_select_page')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_f'])): ?><div class="alert alert-danger"><?=lang('nav_url_invalid')?></div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('nav_manage')?></h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
<!--vot-->  <h6 class="m-0 font-weight-bold"><?=lang('nav_manage')?></h6>
        </div>
        <div class="card-body">
            <form action="navbar.php?action=taxis" method="post">
                <table class="table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                    <tr>
<!--vot-->                  <th width="50"><b><?=lang('id')?></b></th>
<!--vot-->                  <th width="230"><b><?=lang('navigation')?></b></th>
<!--vot-->                  <th width="60" class="tdcenter"><b><?=lang('type')?></b></th>
<!--vot-->                  <th width="60" class="tdcenter"><b><?=lang('status')?></b></th>
<!--vot-->                  <th width="50" class="tdcenter"><b><?=lang('view')?></b></th>
<!--vot-->                  <th width="360"><b><?=lang('address')?></b></th>
                        <th width="100"></th>
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
/*vot*/                     $value['type_name'] = lang('system');
                                    break;
                                case Navi_Model::navitype_sort:
/*vot*/                     $value['type_name'] = '<font color="blue">'.lang('category').'</font>';
                                    break;
                                case Navi_Model::navitype_page:
/*vot*/                     $value['type_name'] = '<font color="#00A3A3">'.lang('page').'</font>';
                                    break;
                                case Navi_Model::navitype_custom:
/*vot*/                     $value['type_name'] = '<font color="#FF6633">'.lang('custom').'</font>';
                                    break;
                            }
                            doAction('adm_navi_display');

                            ?>
                            <tr>
                                <td><input class="form-control em-small" name="navi[<?php echo $value['id']; ?>]" value="<?php echo $value['taxis']; ?>" maxlength="4"/></td>
<!--vot-->                      <td><a href="navbar.php?action=mod&amp;navid=<?= $value['id'] ?>" title="<?=lang('nav_edit')?>"><?= $value['naviname'] ?></a></td>
                                <td class="tdcenter"><?php echo $value['type_name']; ?></td>
                                <td class="tdcenter">
                                    <?php if ($value['hide'] == 'n'): ?>
<!--vot-->                              <a href="navbar.php?action=hide&amp;id=<?= $value['id'] ?>" title="<?=lang('nav_hide_click')?>"><?=lang('show')?></a>
                                    <?php else: ?>
<!--vot-->                              <a href="navbar.php?action=show&amp;id=<?= $value['id'] ?>" title="<?=lang('nav_show_click')?>" style="color:red;"><?=lang('hide')?></a>
                                    <?php endif; ?>
                                </td>
                                <td class="tdcenter">
                                    <a href="<?php echo $value['url']; ?>" target="_blank">
                                        <img src="./views/images/<?php echo $value['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif'; ?>" align="absbottom" border="0"/></a>
                                </td>
                                <td><?php echo $value['url']; ?></td>
                                <td>
<!--vot-->                          <a href="navbar.php?action=mod&amp;navid=<?= $value['id'] ?>"><?=lang('edit')?></a>
                                    <?php if ($value['isdefault'] == 'n'): ?>
<!--vot-->                              <a href="javascript: em_confirm(<?= $value['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');" class="care"><?=lang('delete')?></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                            if (!empty($value['childnavi'])):
                                foreach ($value['childnavi'] as $val):
                                    ?>
                                    <tr>
                                        <td><input class="form-control em-small" name="navi[<?php echo $val['id']; ?>]" value="<?php echo $val['taxis']; ?>" maxlength="4"/></td>
<!--vot-->                              <td>---- <a href="navbar.php?action=mod&amp;navid=<?= $val['id'] ?>" title="<?=lang('nav_edit')?>"><?= $val['naviname'] ?></a></td>
                                        <td class="tdcenter"><?php echo $value['type_name']; ?></td>
                                        <td class="tdcenter">
                                            <?php if ($val['hide'] == 'n'): ?>
<!--vot-->                                      <a href="navbar.php?action=hide&amp;id=<?= $val['id'] ?>" title="<?=lang('nav_hide_click')?>"><?=lang('show')?></a>
                                            <?php else: ?>
<!--vot-->                                      <a href="navbar.php?action=show&amp;id=<?= $val['id'] ?>" title="<?=lang('nav_show_click')?>" style="color:red;"><?=lang('hide')?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="tdcenter">
                                            <a href="<?php echo $val['url']; ?>" target="_blank">
                                                <img src="./views/images/<?php echo $val['newtab'] == 'y' ? 'vlog.gif' : 'vlog2.gif'; ?>" align="absbottom" border="0"/></a>
                                        </td>
                                        <td><?php echo $val['url']; ?></td>
                                        <td>
<!--vot-->                                  <a href="navbar.php?action=mod&amp;navid=<?= $val['id'] ?>"><?=lang('edit')?></a>
                                            <?php if ($val['isdefault'] == 'n'): ?>
<!--vot-->                                      <a href="javascript: em_confirm(<?= $val['id'] ?>, 'navi', '<?= LoginAuth::genToken() ?>');" class="care"><?=lang('delete')?></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach;endif; ?>
                        <?php endforeach; else: ?>
                        <tr>
<!--vot-->                  <td class="tdcenter" colspan="4"><?=lang('nav_no')?></td></tr>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
<!--vot-->          <div class="list_footer"><input type="submit" value="<?=lang('order_change')?>" class="btn btn-success"/></div>
            </form>
        </div>
    </div>
    <div class="card-deck">
        <div class="card">
            <div class="card-header py-3">
<!--vot-->      <h6 class="m-0 font-weight-bold"><?=lang('nav_add_custom')?></h6>
            </div>
            <div class="card-body">
                <form action="navbar.php?action=add" method="post" name="navi" id="navi">
                    <div class="form-group">
<!--vot-->              <input class="form-control" name="naviname" placeholder="<?=lang('nav_name')?>"/>
                    </div>
                    <div class="form-group">
<!--vot-->              <input maxlength="200" class="form-control" placeholder="<?=lang('nav_url_http')?>" name="url" id="url"/>
                    </div>
                    <div class="form-group">
<!--vot-->              <label><?=lang('nav_parent')?></label>
                        <select name="pid" id="pid" class="form-control">
<!--vot-->                  <option value="0"><?=lang('no')?></option>
                            <?php
                            foreach ($navis as $key => $value):
                                if ($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                                    continue;
                                }
                                ?>
                                <option value="<?php echo $value['id']; ?>"><?php echo $value['naviname']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="y" name="newtab">
<!--vot-->              <label class="form-check-label" for="exampleCheck1"><?=lang('open_new_win')?></label>
                    </div>
<!--vot-->          <button type="submit" class="btn btn-success"><?=lang('save')?></button>
                    <span id="alias_msg_hook"></span>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-3">
<!--vot-->      <h6 class="m-0 font-weight-bold"><?=lang('nav_add_category')?></h6>
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
                                <div class="form-group"><input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>" class="ids"/>
                                    <?php echo $value['sortname']; ?>
                                </div>
                                <?php
                                $children = $value['children'];
                                foreach ($children as $key):
                                    $value = $sorts[$key];
                                    ?>
                                    <div class="form-group">
                                        &nbsp; &nbsp; &nbsp; <input type="checkbox" style="vertical-align:middle;" name="sort_ids[]" value="<?php echo $value['sid']; ?>"
                                                                    class="ids"/>
                                        <?php echo $value['sortname']; ?>
                                    </div>
                                <?php
                                endforeach;
                            endforeach;
                            ?>
                            <div class="form-group">
<!--vot-->                      <input type="submit" name="" class="btn btn-success" value="<?=lang('save')?>">
                            </div>
                        <?php else: ?>
<!--vot-->                  <?=lang('no_categories')?>, <a href="sort.php"><?=lang('category_add')?></a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header py-3">
<!--vot-->      <h6 class="m-0 font-weight-bold"><?=lang('nav_page_add')?></h6>
            </div>
            <div class="card-body">
                <form action="navbar.php?action=add_page" method="post" name="navi" id="navi">
                    <?php
                    if ($pages):
                        foreach ($pages as $key => $value):
                            ?>
                            <div class="form-group">
                                <input type="checkbox" style="vertical-align:middle;" name="pages[<?php echo $value['gid']; ?>]" value="<?php echo $value['title']; ?>" class="ids"/>
                                <?php echo $value['title']; ?>
                            </div>
                        <?php endforeach; ?>
<!--vot-->              <div class="form-group"><input type="submit" class="btn btn-success" name="" value="<?=lang('save')?>"></div>
                    <?php else: ?>
<!--vot-->              <div class="form-group"><?=lang('pages_no')?>, <a href="page.php"><?=lang('add_page')?></a></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // $("#navi_add_custom").css('display', $.cookie('em_navi_add_custom') ? $.cookie('em_navi_add_custom') : '');
    // $("#navi_add_sort").css('display', $.cookie('em_navi_add_sort') ? $.cookie('em_navi_add_sort') : '');
    // $("#navi_add_page").css('display', $.cookie('em_navi_add_page') ? $.cookie('em_navi_add_page') : '');
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('show');
    $("#menu_navi").addClass('active');
</script>
