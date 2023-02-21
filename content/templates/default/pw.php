<?php
/**
 * 加密文章输入密码页面
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>请输入文章访问密码</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        form {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 500px;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            color: #333333;
            margin: 0 0 20px;
            text-align: center;
        }

        input[type="password"] {
            border-radius: 3px;
            border: 1px solid #ccc;
            font-size: 14px;
            height: 25px;
            padding: 8px;
            width: calc(100% - 100px);
        }

        button[type="submit"] {
            background-color: #007bff;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            height: 40px;
            margin-left: 10px;
            transition: all .3s ease-in-out;
            width: 100px;
        }

        button[type="submit"]:hover {
            background-color: #0069d9;
        }

        a {
            color: #007bff;
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <h1>请输入文章访问密码</h1>
    <div style="display: flex;">
        <input type="password" id="logpwd" name="logpwd" required autofocus>
        <button type="submit">提交</button>
    </div>
    <a href="<?= BLOG_URL ?>">&larr;返回首页</a>
</form>
</body>
</html>


