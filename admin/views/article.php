<?php
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
$isdraft = $draft ? '&draft=1' : '';
?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">删除成功</div><?php endif ?>
<?php if (isset($_GET['active_up'])): ?>
    <div class="alert alert-success">置顶成功</div><?php endif ?>
<?php if (isset($_GET['active_down'])): ?>
    <div class="alert alert-success">取消置顶成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">请选择要处理的文章</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">请选择要执行的操作</div><?php endif ?>
<?php if (isset($_GET['active_post'])): ?>
    <div class="alert alert-success">发布成功</div><?php endif ?>
<?php if (isset($_GET['active_move'])): ?>
    <div class="alert alert-success">移动成功</div><?php endif ?>
<?php if (isset($_GET['active_change_author'])): ?>
    <div class="alert alert-success">更改作者成功</div><?php endif ?>
<?php if (isset($_GET['active_hide'])): ?>
    <div class="alert alert-success">转入草稿箱成功</div><?php endif ?>
<?php if (isset($_GET['active_savedraft'])): ?>
    <div class="alert alert-success">草稿保存成功</div><?php endif ?>
<?php if (isset($_GET['active_savelog'])): ?>
    <div class="alert alert-success">保存成功</div><?php endif ?>
<?php if (isset($_GET['active_ck'])): ?>
    <div class="alert alert-success">文章审核成功</div><?php endif ?>
<?php if (isset($_GET['active_unck'])): ?>
    <div class="alert alert-success">文章驳回成功</div><?php endif ?>
<?php if (isset($_GET['error_post_per_day'])): ?>
    <div class="alert alert-danger">超出每日发文数量</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <?php if (User::haveEditPermission()): ?>
        <h1 class="h3 mb-0 text-gray-800"><?= $draft ? '草稿箱' : '文章' ?></h1>
        <a href="./article.php?action=write" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-pencil-alt-5"></i> 写新文章</a>
    <?php else: ?>
        <h1 class="h3 mb-0 text-gray-800"><?= $draft ? '草稿' : Option::get("posts_name") ?></h1>
        <div>
            <?php if (!$draft) : ?>
                <a href="article.php?draft=1" class="btn btn-sm btn-primary shadow-sm mt-4">草稿箱</a>
            <?php else: ?>
                <a href="article.php" class="btn btn-sm btn-primary shadow-sm mt-4"><?= Option::get("posts_name") ?></a>
            <?php endif; ?>
            <a href="./article.php?action=write" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-plus"></i> 发新<?= Option::get("posts_name") ?></a>
        </div>
    <?php endif; ?>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <div id="f_t_sort" class="mx-1">
                    <select name="bysort" id="bysort" onChange="selectSort(this);" class="form-control">
                        <option value="" selected="selected">按分类查看</option>
                        <?php
                        foreach ($sorts as $key => $value):
                            if ($value['pid'] != 0) {
                                continue;
                            }
                            $flg = $value['sid'] == $sid ? 'selected' : '';
                            ?>
                            <option value="<?= $value['sid'] ?>" <?= $flg ?>><?= $value['sortname'] ?></option>
                            <?php
                            $children = $value['children'];
                            foreach ($children as $key):
                                $value = $sorts[$key];
                                $flg = $value['sid'] == $sid ? 'selected' : '';
                                ?>
                                <option value="<?= $value['sid'] ?>" <?= $flg ?>>&nbsp; &nbsp; &nbsp; <?= $value['sortname'] ?></option>
                            <?php
                            endforeach;
                        endforeach;
                        ?>
                        <option value="-1" <?php if ($sid == -1)
                            echo 'selected' ?>>未分类
                        </option>
                    </select>
                </div>
            </div>
            <form action="article.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" class="form-control m-1 small" placeholder="搜索标题..." aria-label="Search" aria-describedby="basic-addon2">
                    <input type="hidden" name="draft" value="<?= $draft ?>">
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
        <form action="article.php?action=operate_log" method="post" name="form_log" id="form_log">
            <input type="hidden" name="draft" value="<?= $draft ?>">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable no-footer">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"/></th>
                        <th>标题</th>
                        <th><a href="article.php?sortComm=<?= $sortComm . $sorturl ?>">评论</a></th>
                        <th><a href="article.php?sortView=<?= $sortView . $sorturl ?>">浏览</a></th>
                        <th>作者</th>
                        <th>分类</th>
                        <th><a href="article.php?sortDate=<?= $sortDate . $sorturl ?>">时间</a></th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logs as $key => $value):
                        $sortName = isset($sorts[$value['sortid']]['sortname']) ? $sorts[$value['sortid']]['sortname'] : '未知分类';
                        $sortName = $value['sortid'] == -1 ? '未分类' : $sortName;
                        $author = isset($user_cache[$value['author']]['name']) ? $user_cache[$value['author']]['name'] : '未知作者';
                        $author_role = isset($user_cache[$value['author']]['role']) ? $user_cache[$value['author']]['role'] : '未知角色';
                        ?>
                        <tr>
                            <td style="width: 20px;"><input type="checkbox" name="blog[]" value="<?= $value['gid'] ?>" class="ids"/></td>
                            <td>
                                <a href="article.php?action=edit&gid=<?= $value['gid'] ?>"><?= $value['title'] ?></a><br>
                                <?php if ($value['top'] == 'y'): ?><span class="badge small badge-success">首页置顶</span><?php endif ?>
                                <?php if ($value['sortop'] == 'y'): ?><span class="badge small badge-info">分类置顶</span><?php endif ?>
                                <?php if (!$draft && $value['timestamp'] > time()): ?><span class="badge small badge-warning">定时发布</span><?php endif ?>
                                <?php if ($value['password']): ?><span class="small">🔒</span><?php endif ?>
                                <?php if ($value['link']): ?><span class="small">🔗</span><?php endif ?>
                                <?php if (!$draft && $value['checked'] == 'n'): ?>
                                    <span class="badge small badge-secondary">待审核</span><br>
                                    <small class="text-secondary"><?= $value['feedback'] ? '审核反馈：' . $value['feedback'] : '' ?></small>
                                <?php endif ?>
                            </td>
                            <td><a href="comment.php?gid=<?= $value['gid'] ?>" class="badge badge-info mx-2 px-2"><?= $value['comnum'] ?></a></td>
                            <td><a href="<?= Url::log($value['gid']) ?>" class="badge badge-secondary  mx-2 px-2" target="_blank"><?= $value['views'] ?></a></td>
                            <td class="small"><a href="article.php?uid=<?= $value['author'] . $isdraft ?>"><?= $author ?></a></td>
                            <td class="small"><a href="article.php?sid=<?= $value['sortid'] . $isdraft ?>"><?= $sortName ?></a></td>
                            <td class="small"><?= $value['date'] ?></td>
                            <td>
                                <?php if (!$draft && User::haveEditPermission() && $value['checked'] == 'n'): ?>
                                    <a class="badge badge-success"
                                       href="article.php?action=operate_log&operate=check&gid=<?= $value['gid'] ?>&token=<?= LoginAuth::genToken() ?>">审核</a>
                                <?php endif ?>
                                <?php if (!$draft && User::haveEditPermission() && $author_role == User::ROLE_WRITER): ?>
                                    <a class="badge badge-warning"
                                       href="#" data-gid="<?= $value['gid'] ?>" data-toggle="modal" data-target="#uncheckModel">驳回</a>
                                <?php endif ?>
                                <?php if ($draft): ?>
                                    <a href="javascript: em_confirm(<?= $value['gid'] ?>, 'draft', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
                                <?php else: ?>
                                    <a href="javascript: em_confirm(<?= $value['gid'] ?>, 'article', '<?= LoginAuth::genToken() ?>');" class="badge badge-danger">删除</a>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
            <input name="operate" id="operate" value="" type="hidden"/>
            <div class="form-inline">
                <?php if (User::haveEditPermission()): ?>
                    <select name="top" id="top" onChange="changeTop(this);" class="form-control m-1">
                        <option value="" selected="selected">选择置顶</option>
                        <option value="top">首页置顶</option>
                        <option value="sortop">分类置顶</option>
                        <option value="notop">取消置顶</option>
                    </select>
                <?php endif ?>
                <select name="sort" id="sort" onChange="changeSort(this);" class="form-control m-1">
                    <option value="" selected="selected">移动到分类</option>
                    <?php
                    foreach ($sorts as $key => $value):
                        if ($value['pid'] != 0) {
                            continue;
                        }
                        ?>
                        <option value="<?= $value['sid'] ?>"><?= $value['sortname'] ?></option>
                        <?php
                        $children = $value['children'];
                        foreach ($children as $key):
                            $value = $sorts[$key];
                            ?>
                            <option value="<?= $value['sid'] ?>">&nbsp; &nbsp;
                                &nbsp; <?= $value['sortname'] ?></option>
                        <?php
                        endforeach;
                    endforeach;
                    ?>
                    <option value="-1">未分类</option>
                </select>
                <?php
                $c = count($user_cache);
                if (User::haveEditPermission() && $c > 1 && $c < 50):
                    ?>
                    <select name="author" id="author" onChange="changeAuthor(this);" class="form-control m-1">
                        <option value="" selected="selected">更改作者</option>
                        <?php foreach ($user_cache as $key => $val): ?>
                            <option value="<?= $key ?>"><?= $val['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                <?php endif ?>
                <div class="btn-group btn-group-sm ml-1" role="group">
                    <?php if ($draft): ?>
                        <a href="javascript:logact('del_draft');" class="btn btn-sm btn-danger">删除</a>
                        <a href="javascript:logact('pub');" class="btn btn-sm btn-success">发布</a>
                    <?php else: ?>
                        <a href="javascript:logact('del');" class="btn btn-sm btn-danger">删除</a>
                        <a href="javascript:logact('hide');" class="btn btn-sm btn-success">放入草稿箱</a>
                    <?php endif ?>
                </div>
            </div>
        </form>
        <div class="page"><?= $pageurl ?> </div>
        <div class="text-center small">(有 <?= $logNum ?> 篇<?= $draft ? '草稿' : '文章' ?>)</div>
    </div>
</div>
<!--驳回文章-->
<div class="modal fade" id="uncheckModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">驳回文章</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="article.php?action=operate_log&operate=uncheck&token=<?= LoginAuth::genToken() ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="feedback" type="text" maxlength="512" class="form-control" placeholder="请填写驳回文章的理由，不填请留空。"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" value="" name="gid" id="gid"/>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-sm btn-warning">驳回</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function logact(act) {
        if (getChecked('ids') === false) {
            Swal.fire("", "请选择要操作的文章!", "info");
            return;
        }

        if (act === 'del') {
            Swal.fire({
                title: '确定要删除所选文章吗',
                text: '彻底删除将无法恢复',
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: true,
                cancelButtonText: '取消',
                confirmButtonText: '放入草稿',
                denyButtonText: '彻底删除',
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#operate").val("hide");
                    $("#form_log").submit();
                } else if (result.isDenied) {
                    $("#operate").val(act);
                    $("#form_log").submit();
                }
            });
            return;
        }

        if (act === 'del_draft') {
            Swal.fire({
                title: '确定要删除所选草稿吗',
                text: '删除将无法恢复',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: '取消',
                confirmButtonText: '确定',
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#operate").val("del");
                    $("#form_log").submit();
                }
            });
            return;
        }

        $("#operate").val(act);
        $("#form_log").submit();
    }

    function changeSort(obj) {
        if (getChecked('ids') === false) {
            Swal.fire("", "请选择要操作的文章!", "info");
            return;
        }
        if ($('#sort').val() === '') return;
        $("#operate").val('move');
        $("#form_log").submit();
    }

    function changeAuthor(obj) {
        if (getChecked('ids') === false) {
            Swal.fire("", "请选择要操作的文章!", "info");
            return;
        }
        if ($('#author').val() === '') return;
        $("#operate").val('change_author');
        $("#form_log").submit();
    }

    function changeTop(obj) {
        if (getChecked('ids') === false) {
            Swal.fire("", "请选择要操作的文章!", "info");
            return;
        }
        if ($('#top').val() === '') return;
        $("#operate").val(obj.value);
        $("#form_log").submit();
    }

    function selectSort(obj) {
        window.open("./article.php?sid=" + obj.value + "<?= $isdraft?>", "_self");
    }

    function selectUser(obj) {
        window.open("./article.php?uid=" + obj.value + "<?= $isdraft?>", "_self");
    }

    $(function () {
        $("#menu_category_content").addClass('active');
        $("#menu_content").addClass('show');
        $("#menu_<?= $draft ? 'draft' : 'log' ?>").addClass('active');
        setTimeout(hideActived, 3600);

        $('#uncheckModel').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var gid = button.data('gid')
            var modal = $(this)
            modal.find('.modal-footer #gid').val(gid)
        })
    });
</script>
