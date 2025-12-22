<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<h1 class="h4 mb-4 text-gray-800"><?= _lang('edit_navi') ?></h1>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="navbar.php?action=update" method="post" id="sort_new">
            <div class="form-group">
                <label for="naviname"><?= _lang('navi_name') ?></label>
                <input class="form-control" id="naviname" value="<?= $naviname ?>" name="naviname">
            </div>
            <div class="form-group">
                <label for="url"><?= _lang('navi_url') ?></label>
                <input class="form-control" id="url" value="<?= $url ?>" name="url" <?= $conf_isdefault ?>>
            </div>
            <div class="form-group">
                <input type="checkbox" value="y" name="newtab" id="newtab" <?= $conf_newtab ?> />
                <label for="newtab"><?= _lang('open_new_tab') ?></label>
            </div>
            <?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
                <div class="form-group">
                    <label><?= _lang('parent_navi') ?></label>
                    <select name="pid" id="pid" class="form-control">
                        <option value="0"><?= _lang('none') ?></option>
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
            <input type="hidden" value="<?= $naviId ?>" name="navid" />
            <input type="hidden" value="<?= $isdefault ?>" name="isdefault" />
            <input type="submit" value="<?= _lang('save') ?>" class="btn btn-sm btn-success" />
            <input type="button" value="<?= _lang('cancel') ?>" class="btn btn-sm btn-secondary" onclick="javascript: window.history.back();" />
        </form>
    </div>
</div>
<script>
    $(function() {
        $("#menu_navbar").addClass('active');
    });
</script>