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
                                    <h1 class="h4 text-gray-900 mb-4">登 录</h1>
                                </div>
                                <form method="post" class="user" action="./index.php?action=login&s=<?= $admin_path_code ?>">
									<?php if ($error_msg): ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<?= $error_msg ?>
                                        </div>
									<?php endif ?>
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="用户名" required
                                               autofocus>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="pw" name="pw" placeholder="密码" required>
                                    </div>
									<?php if ($ckcode): ?>
                                        <div class="form-group form-inline">
                                            <input type="text" name="imgcode" class="form-control form-control-user" id="imgcode" placeholder="验证码" required>
                                            <img src="../include/lib/checkcode.php" id="checkcode" class="mx-2">
                                        </div>
									<?php endif ?>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="ispersis" name="ispersis" value="1">
                                            <label class="custom-control-label" for="ispersis">记住我</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit">登录</button>
                                    <div><?php doAction('login_ext') ?></div>
                                    <hr>
                                    <div class="text-center"><a class="small" href="forgot-password.html">忘记密码?</a></div>
                                    <div class="text-center"><a class="small" href="./user.php?action=reg">注册账号</a></div>
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
        $(this).attr("src", "../include/lib/checkcode.php?" + timestamp);
    });
</script>
