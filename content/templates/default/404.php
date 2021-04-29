<?php
/**
 * 自定义404页面
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<!doctype html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>错误提示-页面未找到</title>
    <style type="text/css">
        body {
            background-color: #F7F7F7;
            font-family: Arial;
            font-size: 12px;
            line-height: 150%;
        }

        .main {
            background-color: #FFFFFF;
            font-size: 12px;
            color: #666666;
            width: 650px;
            margin: 60px auto 0px;
            padding: 30px 10px;
            box-shadow: 0 2px 8px 0 rgba(0, 0, 0, .02);
            border-radius: 10px;
            transition: box-shadow 0.4s;
        }

        .main p {
            text-align: center;
            font-weight: 600;
            font-size: 2rem;
        }

        .main p a {
            border: 1px solid #ccc !important;
            padding: 14px;
            border-radius: 16px !important;
            color: #929292;
            font-size: initial;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="main">
    <p>404 Not Found ！</p>
    <p><a href="javascript:history.back(-1);">返回</a></p>
</div>
</body>
</html>
