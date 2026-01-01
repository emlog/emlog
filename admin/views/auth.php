<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger"><?= _lang('reg_failed_msg') ?></div><?php endif ?>
<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?= _lang('reg_official') ?></h1>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <?php if (!Register::isRegLocal()) : ?>
            <form action="auth.php?action=auth" method="post" class="mt-2">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="emkey" name="emkey" placeholder="<?= _lang('input_reg_code') ?>" minlength="32" maxlength="32" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="button-addon2"><?= _lang('submit') ?></button>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <a href="https://www.emlog.net/register" target="_blank" class="text-danger"><?= _lang('get_reg_code') ?>&rarr; </a>
                </div>
            </form>
        <?php else: ?>
            <div class="text-center">
                <p class="lead text-success my-5"><?= _lang('reg_success_msg') ?></p>
            </div>
        <?php endif ?>
    </div>
</div>