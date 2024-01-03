<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<?php if (isset($_GET['active_reg'])): ?>
    <div class="alert alert-success">🎉 恭喜，注册成功 🎉</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">注册失败了，可能是注册码不正确，或服务器无法访问官网 emlog.net</div><?php endif ?>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <?php if (!Register::isRegLocal()) : ?>
            <div>
                <?php if (isset($_GET['error_store'])): ?>
                    <p class="lead text-danger mb-4">扩展商店用于下载模板和插件，仅开放给已完成注册用户</p>
                <?php endif ?>
                <h1 class="lead text-danger mb-4">您安装的emlog尚未注册，完成注册可使用全部功能，包括如下：</h1>
                <ul>
                    <li>1. 解锁在线升级功能，一键升级到最新版本，获得来自官方的安全和功能更新。</li>
                    <li>2. 解锁应用商店，获得更多模板和插件，并支持应用在线一键更新。</li>
                    <li>3. 去除所有未注册提示及功能限制。</li>
                    <li>4. 加入专属Q群，获得官方技术指导问题解答。</li>
                    <li>5. 附赠多款收费应用（限铁杆SVIP）。</li>
                    <li>6. "投我以桃，报之以李"，您的支持也将帮助emlog变的更好并持续更新下去。</li>
                </ul>
            </div>
            <hr>
            <form action="auth.php?action=auth" method="post" class="mt-5">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="emkey" name="emkey" placeholder="请输入注册码" minlength="32" maxlength="32" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit" id="button-addon2">注册</button>
                        <a class="btn btn-primary" href="https://www.emlog.net/register" type="button" target="_blank">获取注册码</a>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <a href="https://www.emlog.net/register" target="_blank">获取注册码&rarr; </a>
                </div>
            </form>
        <?php else: ?>
            <div class="text-center">
                <p class="lead text-success mb-4">恭喜，您的emlog pro已完成注册！</p>
            </div>
        <?php endif ?>
    </div>
</div>

<script>
    $(function () {
        $("#menu_store").addClass('active');
        setTimeout(hideActived, 10000);
    });
</script>
