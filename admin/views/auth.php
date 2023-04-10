<?php if (!defined('EMLOG_ROOT')) {
    exit('error!');
} ?>
<?php if (isset($_GET['active_reg'])): ?>
    <div class="alert alert-success">恭喜，注册成功了</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">注册失败</div><?php endif ?>
<?php if (!Register::isRegLocal()) : ?>
    <div class="container-fluid">
        <div>
            <?php if (isset($_GET['error_store'])): ?>
                <p class="lead text-danger mb-4">扩展商店用于下载模板和插件，仅开放给已完成注册用户</p>
            <?php endif ?>
            <p class="lead text-danger mb-4">您安装的emlog是尚未注册的普通版， 完成注册可升级到VIP版本，将获得如下权益：</p>
            <div class="">
                <li>1. 解锁在线升级功能，一键升级到最新版本，获得来自官方的安全和功能更新。</li>
                <li>2. 解锁应用商店，获得更多模板和插件，并支持应用在线一键更新。</li>
                <div>3. 去除所有未注册提示及功能限制。</div>
                <div>4. 加入专属Q群，获得官方技术指导问题解答。</div>
                <div>5. "投我以桃，报之以李"，您的支持也将帮助emlog变的更好并持续更新下去。</div>
            </div>
            <hr>
            <a href="#" class="btn btn-sm btn-primary shadow-lg" data-toggle="modal" data-target="#exampleModal">开始注册</a>
            <a href="https://emlog.net/register" target="_blank" class="btn btn-sm btn-success shadow-lg">支持一下，获取注册码-></a>
        </div>
    </div>
<?php else: ?>
    <div class="container-fluid">
        <div class="text-center">
            <p class="lead text-success mb-4">恭喜，您的emlog pro已完成注册！</p>
        </div>
    </div>
<?php endif ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">注册EMLOG PRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="auth.php?action=auth" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" id="emkey" name="emkey" placeholder="输入注册码" minlength="32" maxlength="32" required>
                    </div>
                    <div class="form-group">
                        <a href="https://www.emlog.net/register" target="_blank">获取注册码&rarr; </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">注册</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#menu_store").addClass('active');
    setTimeout(hideActived, 3600);
</script>
