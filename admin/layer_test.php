<?php
/**
 * Layer.js 替换方案兼容性测试文件
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Layer Mini Test</title>
    <script src="./views/js/jquery.min.3.5.1.js"></script>
    <script src="./views/components/layer/layer.js"></script>
</head>
<body>
    <h1>Layer Mini 兼容性测试</h1>
    <button id="btnAlert">测试 Alert</button>
    <button id="btnConfirm2">测试 Confirm (2 按钮)</button>
    <button id="btnConfirm3">测试 Confirm (3 按钮)</button>
    <button id="btnPrompt">测试 Prompt</button>

    <div id="result" style="margin-top: 20px; padding: 10px; background: #eee; min-height: 50px;">
        等待操作...
    </div>

    <script>
        $('#btnAlert').click(function() {
            layer.alert('这是一个简单的 Alert 提示框！', {
                title: '测试标题',
                icon: 1
            }, function(index) {
                $('#result').html('点击了 Alert 的确定。Index: ' + index);
                layer.close(index);
            });
        });

        $('#btnConfirm2').click(function() {
            layer.confirm('你确定要删除这个项目吗？', {
                title: '删除确认',
                icon: 3,
                btn: ['彻底删除', '取消']
            }, function(index) {
                $('#result').html('点击了第一个按钮：彻底删除。Index: ' + index);
                layer.close(index);
            }, function(index) {
                $('#result').html('点击了第二个按钮：取消。Index: ' + index);
                layer.close(index);
            });
        });

        $('#btnConfirm3').click(function() {
            layer.confirm('要将文章保存到草稿箱还是彻底删除？', {
                title: '文章操作',
                icon: 0,
                btn: ['保存草稿', '<span class="text-danger">彻底删除</span>', '取消']
            }, function(index) {
                $('#result').html('点击了第一个按钮：保存草稿。Index: ' + index);
                layer.close(index);
            }, function(index) {
                $('#result').html('点击了第二个按钮：彻底删除。Index: ' + index);
                layer.close(index);
            }, function(index) {
                $('#result').html('点击了第三个按钮：取消。Index: ' + index);
                layer.close(index);
            });
        });

        $('#btnPrompt').click(function() {
            layer.prompt({
                title: '请输入新的作者ID',
                value: '10'
            }, function(value, index) {
                $('#result').html('输入的值为: ' + value + '，Index: ' + index);
                layer.close(index);
            });
        });
    </script>
</body>
</html>
