<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_hide_n'])): ?>
    <div class="alert alert-success"><?= _lang('publish_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_hide_y'])): ?>
    <div class="alert alert-success"><?= _lang('page_draft_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_pubpage'])): ?>
    <div class="alert alert-success"><?= _lang('save_success') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('page') ?></h1>
    <a href="page.php?action=new" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-plus"></i>
        <?= _lang('new_page') ?></a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <div id="f_t_order" class="mx-1">
                    <select name="order" id="order" onChange="selectOrder(this);" class="form-control">
                        <option value="date" <?= (empty($order)) ? 'selected' : '' ?>><?= _lang('latest_post') ?></option>
                        <option value="comm" <?= ($order === 'comm') ? 'selected' : '' ?>><?= _lang('comment_most') ?></option>
                        <option value="view" <?= ($order === 'view') ? 'selected' : '' ?>><?= _lang('view_most') ?></option>
                    </select>
                </div>
            </div>
            <form action="page.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" class="form-control m-1 small" placeholder="<?= _lang('search_title') ?>" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="icofont-search-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body">
        <form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAllItem" /></th>
                            <th><?= _lang('title') ?></th>
                            <th><?= _lang('comment') ?></th>
                            <th><?= _lang('views') ?></th>
                            <th><?= _lang('alias') ?></th>
                            <th><?= _lang('template') ?></th>
                            <th><?= _lang('time') ?></th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php foreach ($pages as $key => $value): ?>
                            <tr>
                                <td style="width: 19px;">
                                    <input type="checkbox" name="page[]" value="<?= $value['gid'] ?>" class="ids" />
                                </td>
                                <td>
                                    <a href="page.php?action=mod&id=<?= $value['gid'] ?>"><?= $value['title'] ?></a>
                                    <a href="<?= Url::log($value['gid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                                    <?php if ($value['hide'] == 'y'): ?>
                                        <span class="badge small badge-secondary"><?= _lang('draft') ?></span>
                                    <?php endif; ?>
                                    <?php if ($value['gid'] == Option::get('home_page_id')): ?>
                                        <span class="badge small badge-danger"><?= _lang('home') ?></span>
                                    <?php endif; ?>
                                    <?php if ($value['gid'] == Option::get('home_page_id')): ?>
                                        <br>
                                        <span class="text-secondary small">
                                            <?= _lang('set_home_page_tip') ?><a href="<?= BLOG_URL ?>posts" target="_blank"><?= BLOG_URL ?>posts</a>
                                        </span>
                                    <?php endif; ?>
                                    <br>
                                    <span class="small"> ID:<?= $value['gid'] ?></span>
                                    <?php if ($value['alias']): ?> <span class="small">(<?= $value['alias'] ?>)</span><?php endif ?>
                                    <?php if ($value['allow_remark'] === 'y'): ?> <span class="small" title="<?= _lang('enable_comment') ?>">💬</span><?php endif ?>
                                    <?php if ($value['link']): ?><span class="small" title="<?= _lang('jump_link') ?>">🔗</span><?php endif ?>
                                </td>
                                <td>
                                    <a href="comment.php?gid=<?= $value['gid'] ?>" class="badge badge-primary mx-1 px-2"><?= $value['comnum'] ?></a>
                                </td>
                                <td>
                                    <a href="<?= Url::log($value['gid']) ?>" class="badge badge-success mx-1 px-2" target="_blank"><?= $value['views'] ?></a>
                                </td>
                                <td><?= $value['alias'] ?></td>
                                <td><?= $value['template'] ?></td>
                                <td class="small"><?= $value['date'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="list_footer">
                <div class="btn-group">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"><?= _lang('operation') ?></button>
                    <div class="dropdown-menu">
                        <a href="javascript:pageact('hide');" class="dropdown-item"><?= _lang('to_draft') ?></a>
                        <a href="javascript:pageact('pub');" class="dropdown-item"><?= _lang('publish') ?></a>
                        <a href="javascript:pageact('del');" class="dropdown-item text-danger"><?= _lang('delete') ?></a>
                    </div>
                </div>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input name="operate" id="operate" value="" type="hidden" />
            </div>
        </form>
    </div>
</div>
<div class="page"><?= $pageurl ?></div>
<div class="text-center small"><?= _lang('total') ?> <?= $pageNum ?></div>
<script>
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_page").addClass('active');
    });

    function pageact(act) {
        if (getChecked('ids') === false) {
            infoAlert('<?= _lang('select_operate_page') ?>');
            return;
        }
        if (act === 'del') {
            delAlert2('', '<?= _lang('delete_page_confirm') ?>', function() {
                $("#operate").val(act);
                $("#form_page").submit();
            })
            return;
        }
        $("#operate").val(act);
        $("#form_page").submit();
    }

    function selectOrder(obj) {
        window.open("./page.php?order=" + obj.value, "_self");
    }
</script>