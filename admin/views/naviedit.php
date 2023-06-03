<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<h1 class="h3 mb-4 text-gray-800">修改导航</h1>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="navbar.php?action=update" method="post" id="sort_new">
            <div class="form-group">
                <label for="sortname">导航名称</label>
                <input class="form-control" id="naviname" value="<?= $naviname ?>" name="naviname">
            </div>
            <div class="form-group">
                <label for="alias">导航地址</label>
                <input class="form-control" id="url" value="<?= $url ?>" name="url" <?= $conf_isdefault ?>>
            </div>
            <div class="form-group">
                <label>在新窗口打开</label>
                <input type="checkbox" value="y" name="newtab" <?= $conf_newtab ?> />
            </div>
            <?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
                <div class="form-group">
                    <label>父导航</label>
                    <select name="pid" id="pid" class="form-control">
                        <option value="0">无</option>
                        <?php
                        foreach ($navis as $key => $value):
                            if ($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                                continue;
                            }
                            $flg = $value['id'] == $pid ? 'selected' : '';
                            ?>
                            <option value="<?= $value['id'] ?>" <?= $flg ?>><?= $value['naviname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            <?php endif ?>
            <input type="hidden" value="<?= $naviId ?>" name="navid"/>
            <input type="hidden" value="<?= $isdefault ?>" name="isdefault"/>
            <input type="submit" value="保存" class="btn btn-sm btn-success"/>
            <input type="button" value="取消" class="btn btn-sm btn-secondary" onclick="javascript: window.history.back();"/>
        </form>
    </div>
</div>
<script>
    $(function () {
        $("#menu_navbar").addClass('active');
    });
</script>
