<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<h1 class="h3 mb-4 text-gray-800">修改导航</h1>
<form action="navbar.php?action=update" method="post" id="sort_new" style="margin-top: 30px;">
    <div class="form-group">
        <label for="sortname">导航名称</label>
        <input class="form-control" id="naviname" value="<?php echo $naviname; ?>" name="naviname">
    </div>
    <div class="form-group">
        <label for="alias">导航地址</label>
        <input class="form-control" id="url" value="<?php echo $url; ?>" name="url" <?php echo $conf_isdefault; ?>>
    </div>
    <div class="form-group">
        <label>在新窗口打开</label>
        <input type="checkbox" value="y" name="newtab" <?php echo $conf_newtab; ?> />
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
                    <option value="<?php echo $value['id']; ?>" <?php echo $flg; ?>><?php echo $value['naviname']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>
    <input type="hidden" value="<?php echo $naviId; ?>" name="navid"/>
    <input type="hidden" value="<?php echo $isdefault; ?>" name="isdefault"/>
    <input type="submit" value="保 存" class="btn btn-success"/>
    <input type="button" value="取 消" class="btn btn-default" onclick="javascript: window.history.back();"/>
</form>
<script>
    $("#menu_navbar").addClass('active');
</script>
