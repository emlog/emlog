<?php

/**
 * 加密文章输入密码页面
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<!doctype html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= _langTpl('enter_password_title') ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #f8fafc;
            color: #334155;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 360px;
            padding: 32px 28px;
            text-align: center;
        }

        .card p {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 20px;
        }

        .card form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .card input {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            transition: border-color .15s;
        }

        .card input:focus {
            border-color: #3b82f6;
        }

        .card button {
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            color: #fff;
            background: #3b82f6;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background .15s;
        }

        .card button:hover {
            background: #2563eb;
        }

        .card a {
            display: inline-block;
            margin-top: 20px;
            color: #64748b;
            font-size: 13px;
            text-decoration: none;
        }

        .card a:hover {
            color: #3b82f6;
        }
    </style>
</head>

<body>
    <div class="card">
        <p><?= _langTpl('enter_password_title') ?></p>
        <form action="" method="post">
            <input type="password" id="logpwd" name="logpwd" placeholder="<?= _langTpl('enter_password_title') ?>" required autofocus autocomplete="current-password">
            <button type="submit"><?= _langTpl('submit') ?></button>
        </form>
        <a href="<?= BLOG_URL ?>">&larr; <?= _langTpl('back_to_home') ?></a>
    </div>
</body>

</html>