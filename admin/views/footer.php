<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
</div>
</div>
<?php if (Option::get('ai_model')): ?>
    <a class="ai-chat-button" href="#" data-toggle="modal" data-target="#aiChatModal">
        <span>✨</span>
    </a>
<?php endif; ?>
<a class="scroll-to-top" href="#page-top">
    <i class="icofont-rounded-up"></i>
</a>
<!-- AI Chat Modal -->
<div class="modal fade" id="aiChatModal" tabindex="-1" role="dialog" aria-labelledby="aiChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aiChatModalLabel">✨AI 对话</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chat-box" style="height: 500px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
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
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#chat-form').submit(function(event) {
            event.preventDefault();
            var message = $('#chat-input').val().trim();
            if (message === '') return;

            // 显示用户消息
            $('#chat-box').append('<div><b>😄：</b> ' + $('<div>').text(message).html() + '</div>');
            $('#chat-input').val('');
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

            var $sendBtn = $('#send-btn');
            $sendBtn.prop('disabled', true).text('发送中...');

            // 初始化 EventSource 进行流式通信
            var eventSource = new EventSource('ai.php?action=chat_stream&message=' + encodeURIComponent(message));
            var $aiMessage = $('<div><b>🤖：</b> <span class="ai-typing"></span></div>');
            $('#chat-box').append($aiMessage);

            var fullMessage = '';

            eventSource.onmessage = function(event) {
                if (event.data === '[DONE]') {
                    $sendBtn.prop('disabled', false).text('发送');
                    eventSource.close();
                } else {
                    try {
                        var data = JSON.parse(event.data);
                        if (data.choices && data.choices[0].delta && data.choices[0].delta.content) {
                            var chunk = data.choices[0].delta.content;
                            fullMessage += chunk;

                            var $typing = $aiMessage.find('.ai-typing');
                            var currentContent = $typing.html();
                            $typing.html(currentContent + $('<div>').text(chunk).html());
                            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        }
                    } catch (err) {
                        console.error('解析流数据错误:', err);
                    }
                }
            };

            eventSource.onerror = function() {
                $('#chat-box').append('<div><b>🤖：</b> <span style="color:red;">连接出错，请稍后再试。</span></div>');
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                $sendBtn.prop('disabled', false).text('发送');
                eventSource.close();
            };
        });
    });
</script>
<footer class="sticky-footer bg-white">
    <div class="text-right my-auto mr-4">
        <small><a href="https://www.emlog.net" target="_blank">EMLOG</a> - <?= ucfirst(Option::EMLOG_VERSION) ?></small>
    </div>
</footer>
</div>
</div>
<?php doAction('adm_footer') ?>
<script src="./views/js/sb-admin-2.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
<script>
    $(function() {
        // Scroll to top button appear
        $(document).on('scroll', function() {
            var scrollDistance = $(this).scrollTop();
            if (scrollDistance > 100) {
                $('.scroll-to-top').fadeIn();
            } else {
                $('.scroll-to-top').fadeOut();
            }
        });
        // Smooth scrolling using jQuery easing
        $(document).on('click', 'a.scroll-to-top', function(e) {
            var $anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: ($($anchor.attr('href')).offset().top)
            }, 1000, 'easeInOutExpo');
            e.preventDefault();
        });
    });
</script>
</body>

</html>