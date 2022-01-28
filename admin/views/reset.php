<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-10 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">找回密码</h1>
                                </div>
                                <form method="post" class="user" action="./account.php?action=register&s=<?= $admin_path_code ?>">
									<?php if ($error_msg): ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<?= $error_msg ?>
                                        </div>
									<?php endif ?>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="邮箱" required
                                               autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="passwd" name="passwd" placeholder="验证码" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="passwd" name="passwd" placeholder="新的密码" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd" placeholder="确认新密码" required>
                                    </div>
									<?php if ($ckcode): ?>
                                        <div class="form-group form-inline">
                                            <input type="text" name="imgcode" class="form-control form-control-user" id="imgcode" placeholder="验证码" required>
                                            <img src="../include/lib/checkcode.php" id="checkcode" class="mx-2">
                                        </div>
									<?php endif ?>
                                    <button class="btn btn-success btn-user btn-block" type="submit">提交</button>
                                    <div><?php doAction('login_ext') ?></div>
                                    <hr>
                                    <div class="text-center"><a class="small" href="/admin">登录</a></div>
                                    <hr>
                                    <div class="text-center"><a href="../" class="small" role="button">&larr;返回首页</a></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    setTimeout(hideActived, 3600);
    $('#checkcode').click(function () {
        var timestamp = new Date().getTime();
        $(this).attr("src", "../include/include/lib/checkcode.php?" + timestamp);
    });
</script>
