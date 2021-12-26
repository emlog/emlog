<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_reg'])): ?>
<!--vot--><div class="alert alert-success"><?=lang('em_reg_ok')?></div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
<!--vot--><div class="alert alert-danger"><?=lang('reg_failed')?></div><?php endif ?>
<?php if (!Register::isRegLocal()) : ?>
    <div class="container-fluid">
        <div class="text-center">
			<?php if (isset($_GET['error_store'])): ?>
<!--vot-->      <p class="lead text-danger mb-4"><?=lang('ext_store_info')?></p>
			<?php endif ?>
			<?php if (isset($_GET['error_article'])): ?>
<!--vot-->      <p class="lead text-danger mb-4"><?=lang('too_many_articles')?></p>
			<?php endif ?>
<!--vot-->  <p class="lead text-danger mb-4"><?=lang('emlog_notregistered')?></p>
<!--vot-->  <p><a href="<?= OFFICIAL_SERVICE_HOST ?>register" target="_blank"><?=lang('get_emkey')?>&rarr; </a></p>
            <hr>
<!--vot-->  <a href="#" class="btn btn-sm btn-success shadow-lg" data-toggle="modal" data-target="#exampleModal"><?=lang('ok_register_now')?></a>
        </div>
    </div>
<?php else: ?>
    <div class="container-fluid">
        <div class="text-center">
<!--vot-->  <p class="lead text-success mb-4"><?=lang('emlog_reg_ok')?></p>
        </div>
    </div>
<?php endif ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--vot-->      <h5 class="modal-title" id="exampleModalLabel"><?=lang('register_emlog')?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="register.php?action=register" method="post">
                <div class="modal-body">
                    <div class="form-group">
<!--vot-->              <input class="form-control" id="emkey" name="emkey" placeholder="<?=lang('enter_reg_code')?>" required>
                    </div>
                    <div class="form-group">
<!--vot-->              <a href="<?= OFFICIAL_SERVICE_HOST ?>register" target="_blank"><?=lang('get_emkey')?>&rarr; </a>
                    </div>
                </div>
                <div class="modal-footer">
<!--vot-->          <button type="submit" class="btn btn-sm btn-success"><?=lang('register')?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#menu_store").addClass('active');
    setTimeout(hideActived, 3600);
</script>
