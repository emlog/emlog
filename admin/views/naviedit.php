<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
          <h1 class="h3 mb-4 text-gray-800"><?=lang('nav_modify')?></h1>
<form action="navbar.php?action=update" method="post" id="sort_new" style="margin-top: 30px;">
    <div class="form-group">
          <label for="sortname"><?=lang('nav_name')?></label>
        <input class="form-control" id="naviname" value="<?= $naviname ?>" name="naviname">
    </div>
    <div class="form-group">
          <label for="alias"><?=lang('nav_address')?></label>
        <input class="form-control" id="url" value="<?= $url ?>" name="url" <?= $conf_isdefault ?>>
    </div>
    <div class="form-group">
          <label><?=lang('open_new_win')?></label>
        <input type="checkbox" value="y" name="newtab" <?= $conf_newtab ?> />
    </div>
	<?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
        <div class="form-group">
            <label><?=lang('nav_parent')?></label>
            <select name="pid" id="pid" class="form-control">
                <option value="0"><?=lang('no')?></option>
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
          <input type="submit" value="<?=lang('save')?>" class="btn btn-sm btn-success"/>
          <input type="button" value="<?=lang('cancel')?>" class="btn btn-sm btn-secondary" onclick="javascript: window.history.back();"/>
</form>
<script>
    $("#menu_navbar").addClass('active');
</script>
