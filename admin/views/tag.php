<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_add'])): ?>
    <div class="alert alert-success"><?= _lang('add_tag_success') ?></div><?php endif ?>
<?php if (isset($_GET['active_edit'])): ?>
    <div class="alert alert-success"><?= _lang('edit_tag_success') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger"><?= _lang('select_tag') ?></div><?php endif ?>
<?php if (isset($_GET['error_exist'])): ?>
    <div class="alert alert-danger"><?= _lang('tag_exists') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('tag_management') ?></h1>
    <div class="d-flex align-items-center">
        <form action="tag.php" method="get" class="mr-2">
            <div class="form-inline search-inputs-nowrap">
                <input type="text" name="keyword" value="<?= $keyword ?>" class="form-control m-1 small" placeholder="<?= _lang('search_tag_placeholder') ?>">
                <div class="input-group-append">
                    <button class="btn btn-sm btn-success" type="submit">
                        <i class="icofont-search-2"></i>
                    </button>
                </div>
            </div>
        </form>
        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addModal">
            <i class="icofont-plus"></i> <?= _lang('add_tag') ?>
        </button>
    </div>
</div>
<div class="card shadow mb-4">
    <form action="tag.php?action=operate_tag" method="post" name="form_tag" id="form_tag">
        <div class="card-body checkboxContainer">
            <?php if ($tags): ?>
                <?php foreach ($tags as $key => $v):
                    $count = empty($v['gid']) ? 0 : count(explode(',', $v['gid']));
                    $count_style = $count > 0 ? 'text-muted' : 'text-danger';
                ?>
                    <div class="badge badge-light m-3 p-2">
                        <h5><a href="#" data-toggle="modal" data-target="#editModal" data-tid="<?= $v['tid'] ?>"
                                data-tagname="<?= $v['tagname'] ?>" data-kw="<?= $v['kw'] ?>" data-title="<?= $v['title'] ?>" data-desc="<?= $v['description'] ?>"><?= $v['tagname'] ?></a>
                        </h5>
                        <a href="<?= Url::tag($v['tagname']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                        <span class="<?= $count_style ?>">（<a href="./article.php?tagid=<?= $v['tid'] ?>" target="_blank"><?= _lang('article') ?>: <?= $count ?></a>）</span>
                        <input type="checkbox" name="tids[]" value="<?= $v['tid'] ?>" class="tids align-top" />
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p class="m-3"><?= _lang('no_tags') ?></p>
            <?php endif ?>
        </div>
        <div class="form-row align-items-center mx-4 mb-4">
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
            <input name="operate" id="operate" value="" type="hidden" />
            <div class="col-auto my-1">
                <div class="custom-control custom-checkbox mr-sm-2">
                    <input type="checkbox" class="custom-control-input" id="checkAllItem">
                    <label class="custom-control-label" for="checkAllItem"><?= _lang('select_all') ?></label>
                </div>
            </div>
            <div class="col-auto my-1 form-inline">
                <a href="javascript:tagact('del');" class="btn btn-sm btn-outline-danger"><?= _lang('delete') ?></a>
            </div>
        </div>
    </form>
</div>
<div class="page"><?= $pageurl ?></div>
<div class="text-center small"><?= _lang('total') ?> <?= $tags_count ?></div>

<!-- 添加标签模态窗口 -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="addModalLabel"><?= _lang('add_tag') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="tag.php?action=add_tag">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_tagname"><?= _lang('tag_name') ?></label>
                        <input type="text" class="form-control" id="add_tagname" name="tagname" required>
                    </div>
                    <div class="form-group">
                        <label for="add_title"><?= _lang('tag_title') ?></label>
                        <input type="text" class="form-control" id="add_title" name="title">
                        <small class="form-text text-muted"><?= _lang('support_variable') ?>: {{site_title}}, {{site_name}}, {{tag_name}}</small>
                    </div>
                    <div class="form-group">
                        <label for="add_kw"><?= _lang('tag_keywords') ?></label>
                        <input type="text" class="form-control" id="add_kw" name="kw">
                    </div>
                    <div class="form-group">
                        <label for="add_description"><?= _lang('tag_description') ?></label>
                        <textarea name="description" id="add_description" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" name="token" value="<?= LoginAuth::genToken() ?>" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('add_tag') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 编辑标签模态窗口 -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel"><?= _lang('edit_tag') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="tag.php?action=update_tag">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tagname"><?= _lang('tag_name') ?></label>
                        <input type="text" class="form-control" id="tagname" name="tagname" required>
                    </div>
                    <div class="form-group">
                        <label for="title"><?= _lang('tag_title') ?></label>
                        <input type="text" class="form-control" id="title" name="title">
                        <small class="form-text text-muted"><?= _lang('support_variable') ?>: {{site_title}}, {{site_name}}, {{tag_name}}</small>
                    </div>
                    <div class="form-group">
                        <label for="kw"><?= _lang('tag_keywords') ?></label>
                        <input type="text" class="form-control" id="kw" name="kw">
                    </div>
                    <div class="form-group">
                        <label for="description"><?= _lang('tag_description') ?></label>
                        <textarea name="description" id="description" type="text" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <input type="hidden" value="" id="tid" name="tid" />
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                    <a class="btn btn-sm btn-outline-danger" href="javascript:deltags();"><?= _lang('delete') ?></a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_tag").addClass('active');
        setTimeout(hideActived, 3600);

        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var tagname = button.data('tagname')
            var kw = button.data('kw')
            var title = button.data('title')
            var desc = button.data('desc')
            var tid = button.data('tid')
            var modal = $(this)
            modal.find('.modal-body #tagname').val(tagname)
            modal.find('.modal-body #title').val(title)
            modal.find('.modal-body #kw').val(kw)
            modal.find('.modal-body #description').val(desc)
            modal.find('.modal-footer input').val(tid)
        })
    });

    function tagact(act) {
        if (getChecked('tids') === false) {
            infoAlert('<?= _lang('select_tag') ?>');
            return;
        }

        if (act === 'del') {
            delAlert2('', '<?= _lang('confirm_delete_tag') ?>', function() {
                $("#operate").val(act);
                $("#form_tag").submit();
            })
            return;
        }
        $("#operate").val(act);
        $("#form_tag").submit();
    }

    function deltags() {
        var tid = $('#tid').val()
        delAlert2('', '<?= _lang('confirm_delete_tag') ?>', function() {
            window.open("./tag.php?action=del_tag&token=<?= LoginAuth::genToken() ?>&tid=" + tid, "_self");
        })
    }
</script>