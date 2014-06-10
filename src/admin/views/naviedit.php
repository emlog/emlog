<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<--vot--><div class=containertitle><b><?=lang('nav_modify')?></b></div>
<div class=line></div>
<form action="navbar.php?action=update" method="post">
<div class="item_edit">
<--vot--> <li><input size="20" value="<?php echo $naviname; ?>" name="naviname" /> <?=lang('nav_name')?></li>
	<li>
<--vot--> <input size="50" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?> /> <?=lang('nav_address')?>
<--vot--> <?=lang('open_new_win')?> <input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" <?php echo $conf_newtab; ?> />
    </li>
    <?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
    <li>
            <select name="pid" id="pid" class="input">
<--vot-->	<option value="0"><?=lang('no')?></option>
                <?php
                    foreach($navis as $key=>$value):
                        if($value['type'] != Navi_Model::navitype_custom || $value['pid'] != 0) {
                            continue;
                        }
                        $flg = $value['id'] == $pid ? 'selected' : '';
                ?>
                <option value="<?php echo $value['id']; ?>" <?php echo $flg;?>><?php echo $value['naviname']; ?></option>
                <?php endforeach; ?>
            </select>
<--vot-->   <?=lang('nav_parent')?>
    </li>
    <?php endif; ?>
	<li>
	<input type="hidden" value="<?php echo $naviId; ?>" name="navid" />
	<input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault" />
<--vot--> <input type="submit" value="<?=lang('save')?>" class="button" />
<--vot--> <input type="button" value="<?=lang('cancel')?>" class="button" onclick="javascript: window.history.back();" />
	</li>
</div>
</form>
<script>
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>