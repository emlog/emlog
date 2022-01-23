<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_reg'])): ?>
    <div class="alert alert-success">恭喜，注册成功了</div><?php endif ?>
<?php if (isset($_GET['error_b'])): ?>
    <div class="alert alert-danger">注册失败</div><?php endif ?>
<?php if (!Register::isRegLocal()) : ?>
    <div class="container-fluid">
        <div class="text-center">
			<?php if (isset($_GET['error_store'])): ?>
                <p class="lead text-danger mb-4">扩展商店用于下载模板和插件，仅开放给已完成注册用户</p>
			<?php endif ?>
			<?php if (isset($_GET['error_article'])): ?>
                <p class="lead text-danger mb-4">文章数量已经超过未注册版本限额</p>
			<?php endif ?>
            <p class="lead text-danger mb-4">抱歉！您的emlog pro尚未完成注册， 完成注册来解锁emlog pro的全部功能</p>
            <p><a href="<?= OFFICIAL_SERVICE_HOST ?>register" target="_blank">获取注册码&rarr; </a></p>
            <hr>
            <a href="#" class="btn btn-sm btn-success shadow-lg" data-toggle="modal" data-target="#exampleModal">开始注册</a>
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
                        <input class="form-control" id="emkey" name="emkey" placeholder="输入注册码" required>
                    </div>
                    <div class="form-group">
                        <a href="<?= OFFICIAL_SERVICE_HOST ?>register" target="_blank">获取注册码&rarr; </a>
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
