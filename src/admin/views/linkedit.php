<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">链接编辑</h1>
    <form action="link.php?action=update_link" method="post">
        <div class="item_edit">
            <li><input size="40" value="<?php echo $sitename; ?>" class="form-control" name="sitename"/> 名称<span class="required">*</span></li>
            <li><input size="40" value="<?php echo $siteurl; ?>" class="form-control" name="siteurl"/> 地址<span class="required">*</span></li>
            <li>链接描述<br/><textarea name="description" rows="3" class="form-control" cols="42"><?php echo $description; ?></textarea></li>
            <li>
                <input type="hidden" value="<?php echo $linkId; ?>" name="linkid"/>
                <input type="submit" value="保 存" class="btn btn-primary"/>
                <input type="button" value="取 消" class="btn btn-default" onclick="javascript: window.history.back();"/></li>
        </div>
    </form>
</div>
<script>
    $("#menu_link").addClass('active');
</script>
