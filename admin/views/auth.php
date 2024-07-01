<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">注册失败了，可能是注册码不正确，或服务器无法访问官网 emlog.net</div><?php endif ?>
<div class="d-sm-flex align-items-center mb-4">
    <h1 class="h4 mb-0 text-gray-800">正版注册</h1>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <?php if (!Register::isRegLocal()) : ?>
            <form action="auth.php?action=auth" method="post" class="mt-2">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="emkey" name="emkey" placeholder="请输入注册码" minlength="32" maxlength="32" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="button-addon2">提交注册</button>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <a href="https://www.emlog.net/register" target="_blank" class="text-danger">获取注册码&rarr; </a>
                </div>
            </form>
        <?php else: ?>
            <div class="text-center">
                <p class="lead text-success my-5">🎉 恭喜，成功完成注册 🎉</p>
            </div>
        <?php endif ?>
    </div>
</div>
