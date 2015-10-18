<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('nav_modify')?></b></div>
<div class=line></div>
<form action="navbar.php?action=update" method="post">
<div class="form-group form-inline">
    <li>
<!--vot--><input size="40" class="form-control" value="<?php echo $naviname; ?>" name="naviname" /> <label><?=lang('nav_name')?></label>
    </li>
    <li>
<!--vot--><input size="100" class="form-control" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?> /> <label><?=lang('nav_address')?></label>
    </li>
    <li class="checkbox">
<!--vot--><label><input type="checkbox" value="y" name="newtab" <?php echo $conf_newtab; ?> /> <?=lang('open_new_win')?></label>
    </li>
    <?php if ($type == Navi_Model::navitype_custom && $pid != 0): ?>
    <li>
            <select name="pid" id="pid" class="form-control">
<!--vot-->      <option value="0"><?=lang('no')?></option>
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
<!--vot-->  <?=lang('nav_parent')?>
    </li>
    <?php endif; ?>
    <li>
    <input type="hidden" value="<?php echo $naviId; ?>" name="navid" />
    <input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault" />
<!--vot--> <input type="submit" value="<?=lang('save')?>" class="btn btn-primary" />
<!--vot--> <input type="button" value="<?=lang('cancel')?>" class="btn btn-default" onclick="javascript: window.history.back();" />
    </li>
</div>
</form>
<script>
$("#menu_navbar").addClass('active');
</script>
