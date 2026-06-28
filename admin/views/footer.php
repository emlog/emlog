<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
</div>
</div>
<a class="scroll-to-top" href="#page-top">
    <i class="icofont-rounded-up"></i>
</a>
<footer class="sticky-footer bg-white">
    <div class="text-right my-auto mr-4">
        <small><a href="https://www.emlog.net" target="_blank">EMLOG</a> - <?= ucfirst(Option::EMLOG_VERSION) ?></small>
    </div>
</footer>
<!-- AI Chat Modal -->
<div class="modal fade" id="aiChatModal" tabindex="-1" role="dialog" aria-labelledby="aiChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="aiChatModalLabel">💬 <?= _lang('ai_chat') ?></h5>
                <button type="button" class="btn btn-xs btn-outline-danger ml-auto mr-3" id="clear-chat-btn" title="清空对话历史">
                    <i class="icofont-trash"></i> 清空历史
                </button>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chat-box" style="height: 500px; overflow-y: scroll; border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 8px;">
                    <!-- Chat messages will appear here -->
                </div>
                <form id="chat-form">
                    <div class="input-group">
                        <textarea class="form-control" id="chat-input" placeholder="<?= _lang('input_message') ?>" rows="1" style="resize: none; overflow: hidden;"></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" id="send-btn"><?= _lang('send') ?></button>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-xs btn-outline-info" id="btn-em-help" style="font-size: 11px; padding: 2px 6px;"><i class="icofont-search-document"></i> @em-help 询问emlog问题</button>
                    </div>
                    <div class="text-muted text-xs mt-1"><?= _lang('model_label') ?><?= AI::model() ? AI::model() : _lang('no_ai_model') ?>，<?= _lang('shift_enter_tip') ?></div>
                </form>
                <script>
                    $(document).ready(function() {
                        $('#chat-input').on('input', function() {
                            this.style.height = 'auto';
                            this.style.height = (this.scrollHeight) + 'px';
                            $('#send-btn').css('height', this.style.height);
                        });

                        $('#chat-input').on('keydown', function(event) {
                            if (event.key === 'Enter' && !event.shiftKey) {
                                event.preventDefault();
                                $('#send-btn').click();
                            }
                        });

                        $('#chat-form').submit(function() {
                            $('#chat-input').css('height', 'auto');
                            $('#send-btn').css('height', 'auto');
                        });

                        $('#btn-em-help').click(function() {
                            var $input = $('#chat-input');
                            var val = $input.val();
                            if (!val.startsWith('@em-help ')) {
                                $input.val('@em-help ' + val);
                            }
                            $input.focus();
                            $input.trigger('input');
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- Shortcut Modal -->
<div class="modal fade" id="shortcutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="shortcutModalLabel"><?= _lang('shortcut') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="index.php?action=add_shortcut" method="post">
                <div class="modal-body" id="shortcutModalBody">
                    <p class="text-center"><?= _lang('loading') ?></p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?= _lang('cancel') ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?= _lang('save') ?></button>
                </div>
            </form>

        </div>
    </div>
</div>
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

        // 时间选择控件
        $.timepicker.regional['zh-CN'] = {
            timeOnlyTitle: '<?= _lang('select_time') ?>',
            timeText: '<?= _lang('time') ?>',
            hourText: '<?= _lang('hour') ?>',
            minuteText: '<?= _lang('minute') ?>',
            secondText: '<?= _lang('second') ?>',
            millisecText: '<?= _lang('millisecond') ?>',
            microsecText: '<?= _lang('microsecond') ?>',
            timezoneText: '<?= _lang('timezone') ?>',
            currentText: '<?= _lang('current_time') ?>',
            closeText: '<?= _lang('close') ?>',
            timeFormat: 'HH:mm',
            timeSuffix: '',
            amNames: ['AM', 'A'],
            pmNames: ['PM', 'P'],
            isRTL: false,
            prevText: '<?= _lang('prev_month') ?>',
            nextText: '<?= _lang('next_month') ?>',
            showMonthAfterYear: true,
            weekHeader: '<?= _lang('week') ?>',
            yearSuffix: '<?= _lang('year') ?>',
        };
        $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
        let dayNamesMin = <?= json_encode(_lang('day_names_min')) ?>;
        let monthNamesShort = <?= json_encode(_lang('month_names_short')) ?>;
        const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
        let _left = screenWidth < 1200 ? 0 : 50;
        $(".datepicker").length && $(".datepicker").datetimepicker({
            controlType: "select",
            dayNamesMin: dayNamesMin,
            monthNamesShort: monthNamesShort,
            changeMonth: true,
            changeYear: true,
            yearRange: "c-30:c+10",
            showSecond: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss",
            beforeShow: function(input, inst) {
                setTimeout(function() {
                    inst.dpDiv.css({
                        top: $(".datepicker.active").offset().top + 50,
                        left: $(".datepicker.active").offset().left - _left
                    });
                }, 0);
            },
            onClose: function(dateText, inst) {
                typeof onDatepickerClose === "function" && onDatepickerClose(dateText, inst);
            }
        });
        $('body').on('focus', '.datepicker', function() {
            let _this = $(this)
            $('.datepicker').removeClass('active')
            _this.addClass('active')
        })

        // AI Chat
        function formatChunk(text) {
            return $('<div>').text(text).html().replace(/\n/g, '<br>');
        }

        function getCleanHtml(text) {
            // 过滤掉 <tool_call ...>...</tool_call> 标签及其内容
            var cleanText = text.replace(/<tool_call\s+name="[^"]*">[\s\S]*?<\/tool_call>/g, '');
            // 过滤掉可能还没闭合的首半截 <tool_call ...
            cleanText = cleanText.replace(/<tool_call\s+name="[^"]*">[\s\S]*$/g, '');
            cleanText = cleanText.replace(/<tool_call\s*$/g, '');
            return formatChunk(cleanText);
        }

        var isHistoryLoaded = false;

        function loadChatHistory() {
            $('#chat-box').html('<div class="text-center text-muted my-3"><i class="icofont-spinner rotate"></i> 正在加载历史记录...</div>');
            $.getJSON('ai.php?action=get_history', function(res) {
                $('#chat-box').empty();
                if (res.data && res.data.length > 0) {
                    res.data.forEach(function(item) {
                        if (item.role === 'user') {
                            $('#chat-box').append('<div style="background-color:#69b4ff; color:#FFFFFF; border-radius: 10px; padding: 10px; margin: 5px 0;"><b>😄：</b> ' + $('<div>').text(item.content).html() + '</div>');
                        } else if (item.role === 'assistant') {
                            var cleanHtml = getCleanHtml(item.content);
                            $('#chat-box').append(
                                '<div class="ai-chat-message">' +
                                '<div><b>🤖：</b></div>' +
                                '<div class="ai-answer-wrap">' +
                                '<div class="ai-answer-content">' + cleanHtml + '</div>' +
                                '</div>' +
                                '</div>'
                            );
                        }
                    });
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                } else {
                    $('#chat-box').append('<div class="text-center text-muted my-3">暂无对话记录，开始聊聊吧！</div>');
                }
                isHistoryLoaded = true;
            }).fail(function() {
                $('#chat-box').html('<div class="text-center text-danger my-3">加载历史记录失败</div>');
            });
        }

        $('#aiChatModal').on('shown.bs.modal', function() {
            $('#chat-input').focus();
            if (!isHistoryLoaded) {
                loadChatHistory();
            }
        });

        $('#clear-chat-btn').click(function() {
            if (confirm('确定要清空所有 AI 对话历史记录吗？')) {
                $.post('ai.php?action=clear_history', function() {
                    $('#chat-box').html('<div class="text-center text-muted my-3">对话历史已清空</div>');
                    isHistoryLoaded = true;
                });
            }
        });

        $('#chat-form').submit(function(event) {
            event.preventDefault();
            var message = $('#chat-input').val().trim();
            if (message === '') return;

            $('#chat-box').append('<div style="background-color:#69b4ff; color:#FFFFFF; border-radius: 10px; padding: 10px; margin: 5px 0;"><b>😄：</b> ' + $('<div>').text(message).html() + '</div>');
            $('#chat-input').val('');
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

            var $sendBtn = $('#send-btn');
            $sendBtn.prop('disabled', true).text('<?= _lang('sending') ?>');

            var eventSource = new EventSource('ai.php?action=chat_stream&message=' + encodeURIComponent(message));
            var $aiMessage = $(
                '<div class="ai-chat-message">' +
                '<div><b>🤖：</b></div>' +
                '<div class="ai-thought-wrap d-none">' +
                '<div class="ai-thought-content"></div>' +
                '</div>' +
                '<div class="ai-answer-wrap">' +
                '<div class="ai-answer-content"></div>' +
                '</div>' +
                '</div>'
            );
            $('#chat-box').append($aiMessage);
            var $thoughtWrap = $aiMessage.find('.ai-thought-wrap');
            var $thoughtContent = $aiMessage.find('.ai-thought-content');
            var $answerContent = $aiMessage.find('.ai-answer-content');
            var hasReasoning = false;
            var rawAnswer = '';

            eventSource.onmessage = function(event) {
                if (event.data === '[DONE]') {
                    if (!hasReasoning) {
                        $thoughtWrap.remove();
                    }
                    $sendBtn.prop('disabled', false).text('<?= _lang('send') ?>');
                    eventSource.close();

                    // 对话输出完毕后，尝试提取 tool_call
                    var toolCallRegex = /<tool_call\s+name="([^"]+)">([\s\S]*?)<\/tool_call>/g;
                    var match;
                    while ((match = toolCallRegex.exec(rawAnswer)) !== null) {
                        var toolName = match[1];
                        var paramsStr = match[2].trim();
                        executeToolCall(toolName, paramsStr, $aiMessage);
                    }
                } else {
                    try {
                        var data = JSON.parse(event.data);
                        var choice = data.choices && data.choices[0] ? data.choices[0] : {};
                        var delta = choice.delta || {};
                        var messageData = choice.message || {};
                        var chunk = delta.content || messageData.content || '';
                        var rchunk = delta.reasoning_content || delta.reasoning || messageData.reasoning_content || messageData.reasoning || '';
                        if (chunk || rchunk) {
                            if (typeof rchunk === 'string' && $.trim(rchunk) !== '') {
                                hasReasoning = true;
                                $thoughtWrap.removeClass('d-none');
                                $thoughtContent.html($thoughtContent.html() + formatChunk(rchunk));
                            }
                            if (chunk) {
                                rawAnswer += chunk;
                                $answerContent.html(getCleanHtml(rawAnswer));
                            }
                            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                        }
                    } catch (err) {
                        console.error('解析流数据错误:', err);
                    }
                }
            };

            eventSource.onerror = function() {
                if (!hasReasoning) {
                    $thoughtWrap.remove();
                }
                $answerContent.html($answerContent.html() + "<?= _lang('connect_error') ?>");
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                $sendBtn.prop('disabled', false).text('<?= _lang('send') ?>');
                eventSource.close();
            };
        });

        // 执行 AI 工具请求与卡片渲染
        function executeToolCall(name, paramsJson, $aiMessage) {
            var toolNamesMap = {
                'query_database': '查询/操作数据库'
            };
            var friendlyName = toolNamesMap[name] || name;

            var sql = '';
            try {
                var paramsObj = JSON.parse(paramsJson);
                sql = paramsObj.sql || '';
            } catch (e) {}

            var isWriteOp = !/^\s*(select|show|desc|describe|explain)\b/i.test(sql);

            var $card = $(
                '<div class="card mt-2 shadow-sm border-left-primary">' +
                '<div class="card-body py-2 px-3">' +
                '<div class="d-flex align-items-center justify-content-between">' +
                '<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' +
                '<i class="icofont-tools-bag mr-1"></i> AI 博客助手操作' +
                '</div>' +
                '<span class="badge badge-info status-badge">' +
                (isWriteOp ? '<i class="icofont-warning-alt"></i> 等待确认' : '<i class="icofont-spinner-alt-3 rotate"></i> 正在执行...') +
                '</span>' +
                '</div>' +
                '<div class="text-sm text-gray-800 action-details">' +
                (isWriteOp ? '检测到敏感的数据或表结构变更操作。' : '正在为您：' + friendlyName + '...') +
                '</div>' +
                '</div>' +
                '</div>'
            );
            $aiMessage.find('.ai-answer-wrap').append($card);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

            if (isWriteOp) {
                // 显示确认界面
                var confirmHtml =
                    '<div class="confirm-wrap mt-2 p-2 bg-light border rounded">' +
                    '<div class="text-xs text-muted mb-1">该操作将修改数据库：<code>' + $('<div>').text(sql).html() + '</code></div>' +
                    '<div class="text-xs font-weight-bold text-danger mb-2">敏感操作警告！确认是否执行该操作？</div>' +
                    '<button class="btn btn-xs btn-danger run-confirm-btn mr-2">确认执行</button>' +
                    '<button class="btn btn-xs btn-light cancel-confirm-btn">取消</button>' +
                    '</div>';
                $card.find('.action-details').append(confirmHtml);
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

                // 取消按钮
                $card.find('.cancel-confirm-btn').on('click', function() {
                    $card.removeClass('border-left-primary').addClass('border-left-secondary');
                    $card.find('.status-badge').removeClass('badge-info').addClass('badge-secondary').html('<i class="icofont-close-circled"></i> 已取消');
                    $card.find('.action-details').html('<span class="text-muted">操作已取消。</span>');
                });

                // 确认执行按钮
                $card.find('.run-confirm-btn').on('click', function() {
                    $card.find('.confirm-wrap').remove();
                    $card.find('.status-badge').removeClass('badge-info').addClass('badge-info').html('<i class="icofont-spinner-alt-3 rotate"></i> 正在执行...');
                    $card.find('.action-details').html('正在为您执行敏感操作，请稍候...');
                    sendAjaxRequest('confirm');
                });
            } else {
                // 非写操作直接发送
                sendAjaxRequest('');
            }

            function sendAjaxRequest(confirmCode) {
                $.ajax({
                    url: 'ai.php?action=execute_tool',
                    type: 'POST',
                    data: {
                        name: name,
                        params: paramsJson,
                        confirm_code: confirmCode
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.code === 0) {
                            $card.removeClass('border-left-primary').addClass('border-left-success');
                            $card.find('.status-badge').removeClass('badge-info').addClass('badge-success').html('<i class="icofont-check-circled"></i> 执行成功');

                            var data = response.data || {};
                            var detailHtml = '';
                            if (name === 'query_database') {
                                var list = data.results || [];
                                if (list.length === 0) {
                                    detailHtml = '操作成功，没有返回任何数据（这在执行 DELETE/UPDATE 时是正常的）。';
                                } else {
                                    detailHtml = '<div class="table-responsive"><table class="table table-bordered table-sm text-xs mb-0"><thead><tr>';
                                    var keys = Object.keys(list[0]);
                                    var filteredKeys = keys.filter(function(k) {
                                        return isNaN(k);
                                    });
                                    filteredKeys.forEach(function(key) {
                                        detailHtml += '<th>' + $('<div>').text(key).html() + '</th>';
                                    });
                                    detailHtml += '</tr></thead><tbody>';
                                    list.forEach(function(row) {
                                        detailHtml += '<tr>';
                                        filteredKeys.forEach(function(key) {
                                            var val = row[key];
                                            if (key === 'date') {
                                                val = new Date(parseInt(val) * 1000).toLocaleString();
                                            }
                                            detailHtml += '<td>' + $('<div>').text(val).html() + '</td>';
                                        });
                                        detailHtml += '</tr>';
                                    });
                                    detailHtml += '</tbody></table></div>';
                                }
                            } else if (data.message) {
                                detailHtml = data.message;
                            } else {
                                detailHtml = '操作执行完毕。';
                            }
                            $card.find('.action-details').html(detailHtml);
                        } else {
                            showError(response.msg || '执行失败');
                        }
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                    },
                    error: function(xhr, status, error) {
                        showError('网络连接异常：' + error);
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                    }
                });
            }

            function showError(errorMsg) {
                $card.removeClass('border-left-primary').addClass('border-left-danger');
                $card.find('.status-badge').removeClass('badge-info').addClass('badge-danger').html('<i class="icofont-close-circled"></i> 执行失败');
                $card.find('.action-details').html('<span class="text-danger">' + errorMsg + '</span>');
            }
        }

        // Initialize shortcut bar hover effect
        initShortcutBar();
        $('#shortcutModal').on('show.bs.modal', function(event) {
            const modalBody = $('#shortcutModalBody');
            modalBody.html('<p class="text-center"><?= _lang('loading') ?></p>');
            const currentShortcuts = <?php echo json_encode($shortcuts); ?>;
            $.ajax({
                url: 'index.php?action=get_all_shortcuts',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (!response.code && response.data) {
                        modalBody.empty();
                        if (!response.data.length) {
                            modalBody.html('<p class="text-center"><?= _lang('no_shortcuts') ?></p>');
                            return;
                        }
                        response.data.forEach((item, index) => {
                            const isChecked = currentShortcuts.some(s =>
                                s.name === item.name && s.url === item.url
                            );
                            var $div = $('<div class="custom-control custom-checkbox custom-control-inline mb-2 mr-3"></div>');
                            var $checkbox = $('<input>', {
                                type: 'checkbox',
                                name: 'shortcut[]',
                                id: 'shortcut-' + index,
                                value: item.name + '||' + item.url,
                                checked: isChecked,
                                class: 'custom-control-input'
                            });
                            var $label = $('<label>', {
                                for: 'shortcut-' + index,
                                class: 'custom-control-label',
                                style: 'cursor: pointer;',
                                text: item.name
                            });
                            $div.append($checkbox, $label);
                            modalBody.append($div);
                        });
                    } else {
                        modalBody.html('<?= _lang('load_failed') ?>' + (response.msg || '<?= _lang('unknown_error') ?>'));
                    }
                },
                error: (_, __, error) => modalBody.html('<?= _lang('load_failed') ?>' + error)
            });
        });
    });
</script>
</body>

</html>