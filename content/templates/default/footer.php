<?php

/**
 * 页面底部信息
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<footer class="blog-footer">
    <div class="container footinfo">
        <?php
        if (!empty($icp)) {
            echo '<div><a href="https://beian.miit.gov.cn/" target="_blank">' . $icp . '</a></div>';
        }
        ?>
        <?= $footer_info ?>
        <?php doAction('index_footer') ?>
    </div>
</footer>
<div class="side-toolbar">
    <div class="side-btn" id="back-to-top" title="返回顶部" style="display: none;">
        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="19" x2="12" y2="5"></line>
            <polyline points="5 12 12 5 19 12"></polyline>
        </svg>
    </div>
    <div class="side-btn" id="theme-toggle" title="切换主题">
        <svg class="icon-moon" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
        <svg class="icon-sun" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
    </div>
</div>
<div class="auth-modal-mask" id="auth-modal-mask" style="display: none;"></div>
<div class="auth-modal" id="auth-modal" style="display: none;" aria-hidden="true" data-msg-signup-success="<?= _lang('register_success_login') ?>" data-msg-reset-success="<?= _lang('reset_pwd_verify_email') ?>" data-msg-error="操作失败，请稍后重试">
    <div class="auth-modal-card" role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">
        <button type="button" class="auth-modal-close" id="auth-modal-close" aria-label="<?= _lang('close') ?>">×</button>
        <div class="auth-modal-head">
            <h3 id="auth-modal-title"><?= _lang('login') ?></h3>
        </div>
        <div class="auth-modal-alert" id="auth-modal-alert"></div>
        <?php
        $adminSignInS = defined('ADMIN_PATH_CODE') ? '&s=' . rawurlencode((string)constant('ADMIN_PATH_CODE')) : '';
        ?>
        <div class="auth-modal-panel" data-auth-panel="signin" data-title="<?= _lang('login') ?>" data-subtitle="<?= _lang('login') ?>">
            <form id="auth-signin-form" action="<?= BLOG_URL ?>admin/account.php?action=dosignin<?= $adminSignInS ?>" method="post">
                <div class="auth-form-row">
                    <input type="text" name="user" placeholder="<?= _lang('username_email') ?>" autocomplete="username" required />
                </div>
                <div class="auth-form-row">
                    <input type="password" name="pw" placeholder="<?= _lang('password') ?>" autocomplete="current-password" required />
                </div>
                <?php if (Option::get('login_code') === 'y'): ?>
                    <div class="auth-form-row auth-captcha-row">
                        <input type="text" name="login_code" placeholder="<?= _lang('captcha') ?>" autocomplete="off" required />
                        <img src="<?= BLOG_URL ?>include/lib/checkcode.php" data-auth-captcha="signin" alt="<?= _lang('captcha') ?>" />
                    </div>
                <?php endif; ?>
                <label class="auth-checkbox">
                    <input type="checkbox" name="persist" value="1" />
                    <span><?= _lang('remember_me') ?></span>
                </label>
                <button type="submit" class="btn auth-submit"><?= _lang('login') ?></button>
            </form>
            <div class="auth-modal-switch">
                <?php if (Option::get('is_signup') === 'y'): ?>
                    <a href="javascript:void(0);" data-auth-open="signup"><?= _lang('register_account') ?></a>
                <?php endif; ?>
                <a href="javascript:void(0);" data-auth-open="reset"><?= _lang('reset_password') ?></a>
            </div>
            <div class="auth-login-ext" id="auth-login-ext">
                <?php doAction('login_ext') ?>
            </div>
        </div>
        <?php if (Option::get('is_signup') === 'y'): ?>
            <div class="auth-modal-panel" data-auth-panel="signup" data-title="<?= _lang('register_account') ?>" data-subtitle="<?= _lang('register_account') ?>" style="display: none;">
                <form id="auth-signup-form" action="<?= BLOG_URL ?>admin/account.php?action=dosignup" method="post">
                    <div class="auth-form-row">
                        <input type="email" name="mail" placeholder="<?= _lang('email') ?>" autocomplete="email" required />
                    </div>
                    <div class="auth-form-row">
                        <input type="password" name="passwd" minlength="6" placeholder="<?= _lang('password') ?>" autocomplete="new-password" required />
                    </div>
                    <div class="auth-form-row">
                        <input type="password" name="repasswd" minlength="6" placeholder="<?= _lang('confirm_password') ?>" autocomplete="new-password" required />
                    </div>
                    <?php if (Option::get('email_code') === 'y'): ?>
                        <div class="auth-form-row auth-inline-row">
                            <input type="text" name="mail_code" placeholder="<?= _lang('email_code') ?>" required />
                            <button type="button" class="btn auth-inline-btn" id="auth-send-mail-code"><?= _lang('send_email_code') ?></button>
                        </div>
                    <?php endif; ?>
                    <?php if (Option::get('login_code') === 'y'): ?>
                        <div class="auth-form-row auth-captcha-row">
                            <input type="text" name="login_code" placeholder="<?= _lang('captcha') ?>" autocomplete="off" required />
                            <img src="<?= BLOG_URL ?>include/lib/checkcode.php" data-auth-captcha="signup" alt="<?= _lang('captcha') ?>" />
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn auth-submit"><?= _lang('register') ?></button>
                </form>
                <div class="auth-modal-switch">
                    <a href="javascript:void(0);" data-auth-open="signin"><?= _lang('login') ?></a>
                    <a href="javascript:void(0);" data-auth-open="reset"><?= _lang('reset_password') ?></a>
                </div>
                <div class="auth-login-ext" id="auth-login-ext">
                    <?php doAction('signup_ext') ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="auth-modal-panel" data-auth-panel="reset" data-title="<?= _lang('reset_password') ?>" data-subtitle="<?= _lang('reset_pwd_verify_email') ?>" style="display: none;">
            <form id="auth-reset-form" action="<?= BLOG_URL ?>admin/account.php?action=doreset" method="post">
                <div class="auth-form-row">
                    <input type="email" name="mail" placeholder="<?= _lang('email') ?>" autocomplete="email" required />
                </div>
                <?php if (Option::get('login_code') === 'y'): ?>
                    <div class="auth-form-row auth-captcha-row">
                        <input type="text" name="login_code" placeholder="<?= _lang('captcha') ?>" autocomplete="off" required />
                        <img src="<?= BLOG_URL ?>include/lib/checkcode.php" data-auth-captcha="reset" alt="<?= _lang('captcha') ?>" />
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn auth-submit"><?= _lang('submit') ?></button>
            </form>
            <div class="auth-modal-switch">
                <a href="javascript:void(0);" data-auth-open="signin"><?= _lang('login') ?></a>
                <?php if (Option::get('is_signup') === 'y'): ?>
                    <a href="javascript:void(0);" data-auth-open="signup"><?= _lang('register_account') ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>

</html>