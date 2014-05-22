<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['nav_edit']; ?></b></div>
<div class=line></div>
<form action="navbar.php?action=update" method="post">
<div class="item_edit">
	<li><input size="20" value="<?php echo $naviname; ?>" name="naviname" /> <? echo $lang['nav_name']; ?></li>
	<li>
	<input size="50" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?> /> <? echo $lang['nav_url']; ?>,
	<? echo $lang['open_new_window']; ?> <input type="checkbox" style="vertical-align:middle;" value="y" name="newtab" <?php echo $conf_newtab; ?> />
    </li>
    <?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
    <li>
            <select name="pid" id="pid" class="input">
                <option value="0"><? echo $lang['none']; ?></option>
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
            <? echo $lang['nav_parent']; ?>
    </li>
    <?php endif; ?>
	<li>
	<input type="hidden" value="<?php echo $naviId; ?>" name="navid" />
	<input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault" />
	<input type="submit" value="<? echo $lang['save']; ?>" class="button" />
	<input type="button" value="<? echo $lang['cancel']; ?>" class="button" onclick="javascript: window.history.back();" />
	</li>
</div>
</form>
<script>
$("#menu_navbar").addClass('sidebarsubmenu1');
</script>