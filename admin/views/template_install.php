<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<div class="container-fluid">
<!--vot--><?php if (isset($_GET['error_a'])): ?><div class="alert alert-danger"><?=lang('template_zip_support')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_b'])): ?><div class="alert alert-danger"><?=lang('template_upload_failed_nonwritable')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_c'])): ?><div class="alert alert-danger"><?=lang('template_no_zip_install_manually')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_d'])): ?><div class="alert alert-danger"><?=lang('template_select_zip')?></div><?php endif; ?>
<!--vot--><?php if (isset($_GET['error_e'])): ?><div class="alert alert-danger"><?=lang('template_non_standard')?></div><?php endif; ?>
    <?php if (isset($_GET['error_c'])): ?>
        <div style="margin:20px 20px;">
            <div class="alert alert-danger">
<!--vot-->      <?=lang('template_install_manual')?>:<br/>
<!--vot-->      <?=lang('template_install_prompt1')?><br/>
<!--vot-->      <?=lang('template_install_prompt2')?><br/>
            </div>
        </div>
    <?php endif; ?>
<!--vot--><h1 class="h3 mb-4 text-gray-800"><?=lang('template_install')?></h1>
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
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_view").addClass('active');
    $("#menu_view").addClass('in');
    $("#menu_tpl").addClass('active');
</script>
