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
                                    <h1 class="h4 text-gray-900 mb-4">找回密码：重置密码</h1>
                                </div>
                                <form method="post" class="user" action="./account.php?action=doreset2">
									<?php if (isset($_GET['succ_mail'])): ?>
                                        <div class="alert alert-success">邮件验证码已发送到你的邮箱，请查收后填写</div><?php endif ?>
									<?php if (isset($_GET['err_mail_code'])): ?>
                                        <div class="alert alert-danger">邮件验证码错误</div><?php endif ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="mail_code" name="mail_code" placeholder="邮件验证码(请查收邮件)" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="passwd" autocomplete="new-password" name="passwd"
                                               placeholder="新的密码" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" minlength="6" id="repasswd" name="repasswd" placeholder="确认新密码" required>
                                    </div>
                                    <button class="btn btn-success btn-user btn-block" type="submit">提交</button>
                                    <hr>
                                    <div class="text-center"><a class="small" href="./">登录</a></div>
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
