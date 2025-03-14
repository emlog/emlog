<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_hide_n'])): ?>
    <div class="alert alert-success">发布页面成功</div><?php endif ?>
<?php if (isset($_GET['active_hide_y'])): ?>
    <div class="alert alert-success">转为草稿成功</div><?php endif ?>
<?php if (isset($_GET['active_pubpage'])): ?>
    <div class="alert alert-success">页面保存成功</div><?php endif ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">页面</h1>
    <a href="page.php?action=new" class="btn btn-sm btn-success shadow-sm mt-4"><i class="icofont-plus"></i>
        新建页面</a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row justify-content-between">
            <div class="form-inline">
                <div id="f_t_order" class="mx-1">
                    <select name="order" id="order" onChange="selectOrder(this);" class="form-control">
                        <option value="date" <?= (empty($order)) ? 'selected' : '' ?>>最新发布</option>
                        <option value="comm" <?= ($order === 'comm') ? 'selected' : '' ?>>评论最多</option>
                        <option value="view" <?= ($order === 'view') ? 'selected' : '' ?>>浏览最多</option>
                    </select>
                </div>
            </div>
            <form action="page.php" method="get">
                <div class="form-inline search-inputs-nowrap">
                    <input type="text" name="keyword" class="form-control m-1 small" placeholder="搜索标题..." aria-label="Search" aria-describedby="basic-addon2">
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
                            <th>标题</th>
                            <th>评论</th>
                            <th>浏览</th>
                            <th>别名</th>
                            <th>模板</th>
                            <th>时间</th>
                        </tr>
                    </thead>
                    <tbody class="checkboxContainer">
                        <?php foreach ($pages as $key => $value):
                            $isHide = '';
                            if ($value['hide'] == 'y') {
                                $isHide = '<span class="text-danger ml-2"> - 草稿</span>';
                            }
                        ?>
                            <tr>
                                <td style="width: 19px;">
                                    <input type="checkbox" name="page[]" value="<?= $value['gid'] ?>" class="ids" />
                                </td>
                                <td>
                                    <a href="page.php?action=mod&id=<?= $value['gid'] ?>"><?= $value['title'] ?></a>
                                    <a href="<?= Url::log($value['gid']) ?>" target="_blank" class="text-muted ml-2"><i class="icofont-external-link"></i></a>
                                    <?= $isHide ?>
                                    <?php if ($value['gid'] == Option::get('home_page_id')): ?>
                                        <br>
                                        <span class="text-secondary">
                                            <span class="badge small badge-danger">首页</span> 已设为首页，原默认首页：<a href="<?= BLOG_URL ?>posts" target="_blank"><?= BLOG_URL ?>posts</a>
                                        </span>
                                    <?php endif; ?>
                                    <br>
                                    <span class="small"> ID:<?= $value['gid'] ?></span>
                                    <?php if ($value['alias']): ?> <span class="small">(<?= $value['alias'] ?>)</span><?php endif ?>
                                    <?php if ($value['allow_remark'] === 'y'): ?> <span class="small">💬</span><?php endif ?>
                                    <?php if ($value['link']): ?><span class="small">🔗</span><?php endif ?>
                                </td>
                                <td>
                                    <a href="comment.php?gid=<?= $value['gid'] ?>" class="badge badge-primary mx-2 px-3"><?= $value['comnum'] ?></a>
                                </td>
                                <td>
                                    <a href="<?= Url::log($value['gid']) ?>" class="badge badge-success mx-2 px-3" target="_blank"><?= $value['views'] ?></a>
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
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">操作</button>
                    <div class="dropdown-menu">
                        <a href="javascript:pageact('hide');" class="dropdown-item">转为草稿</a>
                        <a href="javascript:pageact('pub');" class="dropdown-item">发布</a>
                        <a href="javascript:pageact('del');" class="dropdown-item text-danger">删除</a>
                    </div>
                </div>
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <input name="operate" id="operate" value="" type="hidden" />
            </div>
        </form>
    </div>
</div>
<div class="page"><?= $pageurl ?></div>
<div class="text-center small">有 <?= $pageNum ?> 个页面</div>
<script>
    $(function() {
        setTimeout(hideActived, 3600);
        $("#menu_category_view").addClass('active');
        $("#menu_view").addClass('show');
        $("#menu_page").addClass('active');
    });

    function pageact(act) {
        if (getChecked('ids') === false) {
            infoAlert('请选择要操作的页面');
            return;
        }
        if (act === 'del') {
            delAlert2('', '删除所选页面？', function() {
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