<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=lang('template_install')?></h1>
<!--vot--><?php if (isset($_GET['error_a'])): ?><span class="alert alert-danger"><?=lang('template_zip_support')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_b'])): ?><span class="alert alert-danger"><?=lang('template_upload_failed_nonwritable')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_c'])): ?><span class="alert alert-danger"><?=lang('template_no_zip_install_manually')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_d'])): ?><span class="alert alert-danger"><?=lang('template_select_zip')?></span><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_e'])): ?><span class="alert alert-danger"><?=lang('template_non_standard')?></span><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div style="margin:20px 20px;">
            <div class="alert alert-danger">
<!--vot-->      <?=lang('template_install_manual')?>:<br/>
<!--vot-->      <?=lang('template_install_prompt1')?><br/>
<!--vot-->      <?=lang('template_install_prompt2')?><br/>
            </div>
        </div>
    <?php endif; ?>
    <form action="./template.php?action=upload_zip" method="post" enctype="multipart/form-data">
        <div style="margin:50px 0px 50px 20px;">
<!--vot-->  <p><?=lang('template_upload_prompt')?></p>
            <p>
                <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
                <input name="tplzip" type="file"/>
            </p>
            <p>
<!--vot-->      <input type="submit" value="<?=lang('upload_install')?>" class="btn btn-primary">
            </p>
        </div>
    </form>
<!--vot--><div style="margin:10px 20px;"><?=lang('template_get_more')?>: <a href="https://emlog.net/"><?=lang('app_center')?></a></div>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
