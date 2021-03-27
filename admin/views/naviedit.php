<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!--vot--><h1 class="h3 mb-4 text-gray-800"><?=lang('nav_modify')?></h1>
<form action="navbar.php?action=update" method="post" id="sort_new" style="margin-top: 30px;">
    <div class="form-group">
<!--vot--><label for="sortname"><?=lang('nav_name')?></label>
        <input class="form-control" id="naviname" value="<?php echo $naviname; ?>" name="naviname">
    </div>
    <div class="form-group">
<!--vot--><label for="alias"><?=lang('nav_address')?></label>
        <input class="form-control" id="url" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?>>
    </div>
    <div class="form-group">
<!--vot--><label><?=lang('open_new_win')?></label>
        <input type="checkbox" value="y" name="newtab" <?php echo $conf_newtab; ?> />
    </div>
    <?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
        <div class="form-group">
<!--vot-->  <label><?=lang('nav_parent')?></label>
            <select name="pid" id="pid" class="form-control">
<!--vot-->      <option value="0"><?=lang('no')?></option>
                <?php
                foreach ($navis as $key => $value):
                    if ($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                        continue;
                    }
                    $flg = $value['id'] == $pid ? 'selected' : '';
                    ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo $flg; ?>><?php echo $value['naviname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
    <input type="hidden" value="<?php echo $naviId; ?>" name="navid"/>
    <input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault"/>
<!--vot--><input type="submit" value="<?=lang('_save_')?>" class="btn btn-success"/>
<!--vot--><input type="button" value="<?=lang('_cancel_')?>" class="btn btn-default" onclick="javascript: window.history.back();"/>
</form>
<script>
    $("#menu_navbar").addClass('active');
</script>
