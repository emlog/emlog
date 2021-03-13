<?php
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
$isdraft = $pid == 'draft' ? '&pid=draft' : '';
$isDisplaySort = !$sid ? "style=\"display:none;\"" : '';
$isDisplayTag = !$tagId ? "style=\"display:none;\"" : '';
$isDisplayUser = !$uid ? "style=\"display:none;\"" : '';
?>
<div class="container-fluid">
    <?php if (isset($_GET['active_del'])): ?>
        <div class="alert alert-success">删除成功</div><?php endif; ?>
    <?php if (isset($_GET['active_up'])): ?>
        <div class="alert alert-success">置顶成功</div><?php endif; ?>
    <?php if (isset($_GET['active_down'])): ?>
        <div class="alert alert-success">取消置顶成功</div><?php endif; ?>
    <?php if (isset($_GET['error_a'])): ?>
        <div class="alert alert-danger">请选择要处理的文章</div><?php endif; ?>
    <?php if (isset($_GET['error_b'])): ?>
        <div class="alert alert-danger">请选择要执行的操作</div><?php endif; ?>
    <?php if (isset($_GET['active_post'])): ?>
        <div class="alert alert-success">发布成功</div><?php endif; ?>
    <?php if (isset($_GET['active_move'])): ?>
        <div class="alert alert-success">移动成功</div><?php endif; ?>
    <?php if (isset($_GET['active_change_author'])): ?>
        <div class="alert alert-success">更改作者成功</div><?php endif; ?>
    <?php if (isset($_GET['active_hide'])): ?>
        <div class="alert alert-success">转入草稿箱成功</div><?php endif; ?>
    <?php if (isset($_GET['active_savedraft'])): ?>
        <div class="alert alert-success">草稿保存成功</div><?php endif; ?>
    <?php if (isset($_GET['active_savelog'])): ?>
        <div class="alert alert-success">保存成功</div><?php endif; ?>
    <?php if (isset($_GET['active_ck'])): ?>
        <div class="alert alert-success">文章审核成功</div><?php endif; ?>
    <?php if (isset($_GET['active_unck'])): ?>
        <div class="alert alert-success">文章驳回成功</div><?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
<!--vot--><h1 class="h3 mb-0 text-gray-800"><?=lang('post_manage')?></h1>
<!--vot--><a href="./write_log.php" class="d-none d-sm-inline-block btn btn-success shadow-sm"><i class="fas fa-edit"></i> <?=lang('article_add')?></a>
    </div>
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link <?php if ($pid != 'draft') {
                    echo 'active';
/*vot*/         } ?>" href="./admin_log.php"><?=lang('post_manage')?></a></li>
            <li class="nav-item"><a class="nav-link <?php if ($pid == 'draft') {
                    echo 'active';
/*vot*/         } ?>" href="./admin_log.php?pid=draft"><?=lang('draft_manage')?></a></li>
        </ul>
    </div>
    <form action="page.php?action=operate_page" method="post" name="form_page" id="form_page">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="filters">
                    <div id="f_title" class="row form-inline">
                        <div id="f_t_sort" class="mx-1">
                            <select name="bysort" id="bysort" onChange="selectSort(this);" class="form-control">
<!--vot-->                      <option value="" selected="selected"><?=lang('category_view')?>...</option>
                                <?php
                                foreach ($sorts as $key => $value):
                                    if ($value['pid'] != 0) {
                                        continue;
                                    }
                                    $flg = $value['sid'] == $sid ? 'selected' : '';
                                    ?>
                                    <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>><?php echo $value['sortname']; ?></option>
                                    <?php
                                    $children = $value['children'];
                                    foreach ($children as $key):
                                        $value = $sorts[$key];
                                        $flg = $value['sid'] == $sid ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $value['sid']; ?>" <?php echo $flg; ?>>&nbsp; &nbsp; &nbsp; <?php echo $value['sortname']; ?></option>
                                    <?php
                                    endforeach;
                                endforeach;
                                ?>
<!--vot-->  <option value="-1" <?php if ($sid == -1) echo 'selected'; ?>><?=lang('uncategorized')?></option>
                            </select>
                        </div>
                        <?php if (ROLE == ROLE_ADMIN && count($user_cache) > 1): ?>
                            <div id="f_t_user" class="mx-1">
                                <select name="byuser" id="byuser" onChange="selectUser(this);" class="form-control">
<!--vot-->                          <option value="" selected="selected"><?=lang('view_by_author')?>...</option>
                                    <?php
                                    foreach ($user_cache as $key => $value):
                                        $flg = $key == $uid ? 'selected' : '';
                                        ?>
                                        <option value="<?php echo $key; ?>" <?php echo $flg; ?>><?php echo $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
<!--vot-->              <span id="f_t_tag"><a href="javascript:void(0);"><?=lang('view_by_tag')?></a></span>
                    </div>
                    <div id="f_tag" class="my-3" <?php echo $isDisplayTag ?>>
<!--vot-->              <?=lang('tags')?>:
                        <?php
/*vot*/                 if (empty($tags)) echo lang('tags_no');
                        foreach ($tags as $val):
                            $a = 'tag_' . $val['tid'];
                            $$a = '';
                            $b = 'tag_' . $tagId;
                            $$b = "class=\"filter\"";
                            ?>
                            <span <?php echo $$a; ?>><a href="./admin_log.php?tagid=<?php echo $val['tid'] . $isdraft; ?>"><?php echo $val['tagname']; ?></a></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="admin_log.php?action=operate_log" method="post" name="form_log" id="form_log">
                    <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                    <table class="table table-bordered table-striped table-hover dataTable no-footer">
                        <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"/></th>
                            <th>标题</th>
                            <?php if ($pid != 'draft'): ?>
                                <th><b>查看</b></th>
                            <?php endif; ?>
                            <th>作者</th>
                            <th>分类</th>
                            <th><a href="./admin_log.php?sortDate=<?php echo $sortDate . $sorturl; ?>">时间</a></th>
                            <th><a href="./admin_log.php?sortComm=<?php echo $sortComm . $sorturl; ?>">评论</a></th>
                            <th><a href="./admin_log.php?sortView=<?php echo $sortView . $sorturl; ?>">阅读</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($logs as $key => $value):
/*vot*/                         $sortName = $value['sortid'] == -1 && !array_key_exists($value['sortid'], $sorts) ? lang('uncategorized') : $sorts[$value['sortid']]['sortname'];
                            $author = $user_cache[$value['author']]['name'];
                            $author_role = $user_cache[$value['author']]['role'];
                            ?>
                            <tr>
                                <td width="21"><input type="checkbox" name="blog[]" value="<?php echo $value['gid']; ?>" class="ids"/></td>
                                <td width="490"><a href="write_log.php?action=edit&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a>
<!--vot-->                              <?php if ($value['top'] == 'y'): ?><img src="./views/images/top.png" align="top"
                                                                                title="<?= lang('home_top') ?>" /><?php endif; ?>
<!--vot-->                              <?php if ($value['sortop'] == 'y'): ?><img src="./views/images/sortop.png" align="top"
                                                                                   title="<?= lang('category_top') ?>" /><?php endif; ?>
<!--vot-->                              <?php if ($value['attnum'] > 0): ?><img src="./views/images/att.gif" align="top"
                                                                                title="<?= lang('attachment_num') ?>: <?php echo $value['attnum']; ?>" /><?php endif; ?>
<!--vot-->                              <?php if ($pid != 'draft' && $value['checked'] == 'n'): ?>
<!--vot-->                                  <span style="color:red;"> - <?= lang('pending') ?></span><?php endif; ?>
                                    <div style="display:none; margin-left:8px;">
                                        <?php if ($pid != 'draft' && ROLE == ROLE_ADMIN && $value['checked'] == 'n'): ?>
<!--vot-->                                      <a href="./admin_log.php?action=operate_log&operate=check&gid=<?php echo $value['gid'] ?>&token=<?php echo LoginAuth::genToken(); ?>"><?= lang('check') ?></a>
                                        <?php elseif ($pid != 'draft' && ROLE == ROLE_ADMIN && $author_role == ROLE_WRITER): ?>
<!--vot-->                                      <a href="./admin_log.php?action=operate_log&operate=uncheck&gid=<?php echo $value['gid'] ?>&token=<?php echo LoginAuth::genToken(); ?>"><?= lang('uncheck') ?></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <?php if ($pid != 'draft'): ?>
                                    <td class="tdcenter">
                                        <a href="<?php echo Url::log($value['gid']); ?>" target="_blank"><img src="./views/images/vlog.gif" align="absbottom" border="0"/></a>
                                    </td>
                                <?php endif; ?>
                                <td><a href="./admin_log.php?uid=<?php echo $value['author'] . $isdraft; ?>"><?php echo $author; ?></a></td>
                                <td><a href="./admin_log.php?sid=<?php echo $value['sortid'] . $isdraft; ?>"><?php echo $sortName; ?></a></td>
                                <td class="small"><?php echo $value['date']; ?></td>
                                <td class="tdcenter"><a href="comment.php?gid=<?php echo $value['gid']; ?>"><?php echo $value['comnum']; ?></a></td>
                                <td class="tdcenter"><?php echo $value['views']; ?></a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                    <input name="operate" id="operate" value="" type="hidden"/>
                    <div class="list_footer form-inline">
<!--vot-->              <a href="javascript:logact('del');" class="care"><?=lang('delete')?></a> |
                        <?php if ($pid == 'draft'): ?>
<!--vot-->                  <a href="javascript:logact('pub');"><?=lang('publish')?></a>
                        <?php else: ?>
<!--vot-->                  <a href="javascript:logact('hide');"><?=lang('add_draft')?></a> |
                            <?php if (ROLE == ROLE_ADMIN): ?>
                                <select name="top" id="top" onChange="changeTop(this);" class="form-control mx-1">
<!--vot-->                          <option value="" selected="selected"><?=lang('top_action')?>...</option>
<!--vot-->                          <option value="top"><?=lang('home_top')?></option>
<!--vot-->                          <option value="sortop"><?=lang('category_top')?></option>
<!--vot-->                          <option value="notop"><?=lang('unstick')?></option>
                                </select>
                            <?php endif; ?>
                            <select name="sort" id="sort" onChange="changeSort(this);" class="form-control mx-1">
<!--vot-->                      <option value="" selected="selected"><?=lang('move_to_category')?>...</option>
                                <?php
                                foreach ($sorts as $key => $value):
                                    if ($value['pid'] != 0) {
                                        continue;
                                    }
                                    ?>
                                    <option value="<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></option>
                                    <?php
                                    $children = $value['children'];
                                    foreach ($children as $key):
                                        $value = $sorts[$key];
                                        ?>
                                        <option value="<?php echo $value['sid']; ?>">&nbsp; &nbsp;
                                            &nbsp; <?php echo $value['sortname']; ?></option>
                                    <?php
                                    endforeach;
                                endforeach;
                                ?>
<!--vot-->                      <option value="-1"><?=lang('uncategorized')?></option>
                            </select>
                            <?php if (ROLE == ROLE_ADMIN && count($user_cache) > 1): ?>
                                <select name="author" id="author" onChange="changeAuthor(this);" class="form-control mx-1">
<!--vot-->                          <option value="" selected="selected"><?=lang('user_edit')?>...</option>
                                    <?php foreach ($user_cache as $key => $val):
                                        $val['name'] = $val['name'];
                                        ?>
                                        <option value="<?php echo $key; ?>"><?php echo $val['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </form>
<!--vot-->      <div class="page"><?php echo $pageurl; ?> (<?=lang('have')?><?php echo $logNum; ?><?=lang('number_of_items')?><?php echo $pid == 'draft' ? lang('drafts') : lang('posts'); ?>)</div>
            </div>
        </div>
    </form>
</div>
<script>
    $("#menu_category_content").addClass('active');
    $("#menu_content").addClass('show');
    $("#menu_log").addClass('active');
    setTimeout(hideActived, 2600);

    $(document).ready(function () {
        $("#f_t_tag").click(function () {
            $("#f_tag").toggle();
            $("#f_sort").hide();
            $("#f_user").hide();
        });
        selectAllToggle();
    });

    function logact(act) {
        if (getChecked('ids') == false) {
/*vot*/     alert('<?=lang('select_page_to_operate')?>');
            return;
        }
/*vot*/ if (act == 'del' && !confirm('<?=lang('sure_delete_selected_pages')?>')) {
            return;
        }
        $("#operate").val(act);
        $("#form_log").submit();
    }

    // 更改分类
    function changeSort(obj) {
        if (getChecked('ids') == false) {
            alert('请选择要操作的文章');
            return;
        }
        if ($('#sort').val() == '') return;
        $("#operate").val('move');
        $("#form_log").submit();
    }

    // 更改作者
    function changeAuthor(obj) {
        if (getChecked('ids') == false) {
            alert('请选择要操作的文章');
            return;
        }
        if ($('#author').val() == '') return;
        $("#operate").val('change_author');
        $("#form_log").submit();
    }

    // 置顶
    function changeTop(obj) {
        if (getChecked('ids') == false) {
            alert('请选择要操作的文章');
            return;
        }
        if ($('#top').val() == '') return;
        $("#operate").val(obj.value);
        $("#form_log").submit();
    }

    // 按分类筛选
    function selectSort(obj) {
        window.open("./admin_log.php?sid=" + obj.value + "<?php echo $isdraft?>", "_self");
    }

    // 按用户筛选
    function selectUser(obj) {
        window.open("./admin_log.php?uid=" + obj.value + "<?php echo $isdraft?>", "_self");
    }
</script>
