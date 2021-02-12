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
        <!--
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
            border-radius: 10px;
            padding: 30px 10px;
            list-style: none;
            border: #DFDFDF 1px solid;
        }

        .main p {
            line-height: 18px;
            margin: 5px 20px;
        }

        -->
    </style>
</head>
<body>
<div class="main">
    <p>抱歉，你所请求的页面不存在！</p>
    <p><a href="javascript:history.back(-1);">&laquo;点击返回</a></p>
</div>
</body>
</html>