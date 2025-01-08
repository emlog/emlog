<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php">基础设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user">用户设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail">邮件通知</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api">API</a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=ai">🤖AI</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人信息</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="setting.php?action=ai_save" method="post" name="setting_ai_form" id="setting_ai_form">
            <p>API URL：</p>
            <div class="form-group">
                <input type="url" class="form-control" name="ai_api_url" id="ai_api_url" value="<?= $aiApiUrl ?>" />
            </div>
            <p>API Key：</p>
            <div class="form-group">
                <input type="text" class="form-control" name="ai_api_key" id="ai_api_key" value="<?= $aiApiKey ?>" />
            </div>
            <p>Model：</p>
            <div class="form-group">
                <input type="text" class="form-control" name="ai_model" id="ai_model" value="<?= $aiModel ?>" />
            </div>
            <div class="form-group mt-3">
                <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                <button type="submit" class="btn btn-success btn-sm">保存设置</button>
                <button type="button" class="btn btn-primary btn-sm" id="more-config" onclick="$('#more-config-details').toggle();">配置示例</button>
            </div>
            <div id="more-config-details" class="alert alert-warning" style="display:none;">
                <b>仅支持配置openai协议的大模型</b><br>
                <a href="https://www.deepseek.com/" target="_blank">DeepSeek</a> 配置示例：<br>
                API URL：https://api.deepseek.com/v1/chat/completions<br>
                API Key：<a href="https://platform.deepseek.com/api_keys" target="_blank">生成api key</a>，格式如：sk-****<br>
                Model：deepseek-chat<br>
                <hr>
                <a href="https://bigmodel.cn/" target="_blank">智谱AI</a> 配置示例：<br>
                API URL：https://open.bigmodel.cn/api/paas/v4/chat/completions<br>
                API Key：<a href="https://bigmodel.cn/usercenter/proj-mgmt/apikeys" target="_blank">生成api key</a><br>
                Model：glm-4-plus<br>
                <hr>
                <a href="https://www.moonshot.cn/" target="_blank">Moonshot</a> 配置示例：<br>
                API URL：https://api.moonshot.cn/v1/chat/completions<br>
                API Key：<a href="https://platform.moonshot.cn/console/api-keys" target="_blank">生成api key</a>，格式如：sk-****<br>
                Model：moonshot-v1-8k、moonshot-v1-32k、moonshot-v1-128k 等<br>
            </div>
        </form>
    </div>
</div>
<script>
    $(function() {
        $("#menu_category_sys").addClass('active');
        $("#menu_sys").addClass('show');
        $("#menu_setting").addClass('active');
        setTimeout(hideActived, 3600);
    });
    $("#setting_ai_form").submit(function(event) {
        event.preventDefault();
        submitForm("#setting_ai_form");
    });
</script>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <h5 class="card-title">AI 对话聊天</h5>
        <div id="chat-box" style="height: 300px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
            <!-- Chat messages will appear here -->
        </div>
        <form id="chat-form">
            <div class="input-group">
                <input type="text" class="form-control" id="chat-input" placeholder="输入消息...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="send-btn">发送</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#chat-form').submit(function(event) {
            event.preventDefault();
            var message = $('#chat-input').val();
            if (message.trim() === '') return;

            $('#chat-box').append('<div><b>😄：</b> ' + $('<div>').text(message).html() + '</div>');
            $('#chat-input').val('');

            var formData = new FormData();
            formData.append('message', message);

            var $sendBtn = $('#send-btn');
            $sendBtn.prop('disabled', true).text('发送中...');

            $.ajax({
                url: 'setting.php?action=ai_chat',
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    var aiMessage = response.data.replace(/\n/g, '<br>');
                    $('#chat-box').append('<div><b>🤖：</b> ' + $('<div>').html(aiMessage).html() + '</div>');
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                },
                error: function() {
                    $('#chat-box').append('<div><b>🤖：</b> 出错了，可能是 AI 配置错误或网络问题。</div>');
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                },
                complete: function() {
                    $sendBtn.prop('disabled', false).text('发送');
                }
            });
        });
    });
</script>