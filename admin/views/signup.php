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
                                    <h1 class="h4 text-gray-900 mb-4">注册账号</h1>
                                </div>
								<?php if (isset($_GET['err_ckcode'])): ?>
                                    <div class="alert alert-danger">验证错误，请重新输入</div><?php endif ?>
								<?php if (isset($_GET['error_login'])): ?>
                                    <div class="alert alert-danger">错误的邮箱格式</div><?php endif ?>
								<?php if (isset($_GET['error_exist'])): ?>
                                    <div class="alert alert-danger">该邮箱已被注册</div><?php endif ?>
								<?php if (isset($_GET['error_pwd_len'])): ?>
                                    <div class="alert alert-danger">密码不小于6位</div><?php endif ?>
								<?php if (isset($_GET['error_pwd2'])): ?>
                                    <div class="alert alert-danger">两次输入的密码不一致</div><?php endif ?>
                                <form method="post" class="user" action="./account.php?action=dosignup">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="mail" name="mail" aria-describedby="emailHelp" placeholder="邮箱" required
                                               autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="passwd" name="passwd" placeholder="密码" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd" placeholder="再次输入密码" required>
                                    </div>
									<?php if ($login_code): ?>
                                        <div class="form-group form-inline">
                                            <input type="text" name="login_code" class="form-control form-control-user" id="login_code" placeholder="验证码" required>
                                            <img src="../include/lib/checkcode.php" id="checkcode" class="mx-2">
                                        </div>
									<?php endif ?>
                                    <button class="btn btn-success btn-user btn-block" type="submit">注册</button>
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
    setTimeout(hideActived, 6000);
    $('#checkcode').click(function () {
        var timestamp = new Date().getTime();
        $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
    });
</script>
