/**
 * AI 助手聊天交互管理对象
 */
var AIChat = {
    currentEventSource: null,
    isHistoryLoaded: false,
    emptyChatHtml: '',

    /**
     * 初始化 AI Chat 事件绑定与状态
     */
    init: function () {
        var self = this;
        self.initHtml();
        self.bindEvents();
    },

    /**
     * 初始化空聊天引导 HTML
     */
    initHtml: function () {
        this.emptyChatHtml = `
            <div class="p-3 text-muted" id="empty-chat-guide">
                <p class="font-weight-bold mb-3"><i class="icofont-info-circle mr-1"></i> ${_langJS.ai_chat_guide}</p>
                <ul class="list-unstyled pl-0" style="line-height: 1.8;">
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_query_posts}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_query_posts}”</li>
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_change_name}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_change_name}”</li>
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_delete_comment}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_delete_comment}”</li>
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_add_category}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_add_category}”</li>
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_write_article}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_write_article}”</li>
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_gen_cat_img}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_gen_cat_img}”</li>
                    <li class="mb-2 chat-example-suggest" data-text="${_langJS.ai_suggest_make_cover_for_post}" style="cursor: pointer;"><i class="icofont-double-right text-primary mr-1"></i> “${_langJS.ai_suggest_make_cover_for_post}”</li>
                </ul>
            </div>`;
    },

    /**
     * 绑定页面上的所有交互事件
     */
    bindEvents: function () {
        var self = this;

        // 动态调整AI聊天输入框及发送按钮的高度
        $('#chat-input').on('input', function () {
            self.adjustInputHeight();
        });

        // 绑定回车发送事件，Shift+Enter换行
        $('#chat-input').on('keydown', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                $('#send-btn').click();
            }
        });

        // 绑定帮助按钮点击
        $('#btn-em-help').click(function () {
            var $input = $('#chat-input');
            var val = $input.val();
            if (!val.startsWith('@em-help ')) {
                $input.val('@em-help ' + val);
            }
            $input.focus();
            self.adjustInputHeight();
        });

        // 建议示例点击
        $(document).on('click', '.chat-example-suggest, .btn-chat-example', function () {
            var text = $(this).data('text');
            var $input = $('#chat-input');
            $input.val(text);
            $input.focus();
            self.adjustInputHeight();
        });

        // AI Chat 模态框显示时加载历史记录
        $('#aiChatModal').on('shown.bs.modal', function () {
            $('#chat-input').focus();
            if (!self.isHistoryLoaded) {
                self.loadChatHistory();
            }
        });

        // 清空历史记录
        $('#clear-chat-btn').click(function () {
            $.post('ai.php?action=clear_history', function () {
                $('#chat-box').html(self.emptyChatHtml);
                self.isHistoryLoaded = true;
            });
        });

        // 表单提交发送消息
        $('#chat-form').submit(function (event) {
            event.preventDefault();
            if (self.currentEventSource) {
                self.resetChatStatus();
                return;
            }
            var message = $('#chat-input').val().trim();
            if (message === '') return;
            self.sendAiMessage(message, false);
            // 发送后重置输入框高度
            $('#chat-input').css('height', 'auto').css('overflow-y', 'hidden');
            $('#send-btn').css('height', 'auto');
        });
    },

    /**
     * 动态计算并调整输入框及发送按钮的高度
     */
    adjustInputHeight: function () {
        var $input = $('#chat-input');
        var $btn = $('#send-btn');
        $input.css('height', 'auto');
        $btn.css('height', 'auto');
        
        var scrollHeight = $input[0].scrollHeight;
        if (scrollHeight > 200) {
            scrollHeight = 200;
            $input.css('overflow-y', 'auto');
        } else {
            $input.css('overflow-y', 'hidden');
        }
        $input.css('height', scrollHeight + 'px');
        $btn.css('height', scrollHeight + 'px');
    },

    /**
     * 重置聊天发送按钮和连接状态
     */
    resetChatStatus: function () {
        if (this.currentEventSource) {
            this.currentEventSource.close();
            this.currentEventSource = null;
        }
        var $sendBtn = $('#send-btn');
        $sendBtn.removeClass('btn-danger').addClass('btn-primary').prop('disabled', false).text(_langJS.send);
    },

    /**
     * 将文本中的换行符转换为 HTML 换行标签，并防止 XSS 攻击
     * 
     * @param {string} text 待转换的纯文本
     * @returns {string} 带有 <br> 的 HTML 文本
     */
    formatChunk: function (text) {
        return $('<div>').text(text).html().replace(/\n/g, '<br>');
    },

    /**
     * 过滤掉不需要渲染在正文中的标签内容（如 tool_call 和 think 思考过程）
     * 
     * @param {string} text 原始文本
     * @returns {string} 过滤后的 Markdown 文本
     */
    getCleanMarkdown: function (text) {
        // 过滤掉 <tool_call ...>...</tool_call> 标签及其内容
        var cleanText = text.replace(/<tool_call\s+name="[^"]*">[\s\S]*?<\/tool_call>/g, '');
        cleanText = cleanText.replace(/<tool_call\s+name="[^"]*">[\s\S]*$/g, '');
        cleanText = cleanText.replace(/<tool_call\s*$/g, '');

        // 过滤掉 <think>...</think> 标签及其内容 (避免历史记录里泄露思考过程)
        cleanText = cleanText.replace(/<think>[\s\S]*?<\/think>/g, '');
        cleanText = cleanText.replace(/<think>[\s\S]*$/g, '');
        return cleanText;
    },

    /**
     * 渲染 Markdown 文本为 HTML
     * 
     * @param {string} text 待渲染的文本
     * @returns {string} 渲染后的 HTML 代码
     */
    renderMarkdown: function (text) {
        var cleanMd = this.getCleanMarkdown(text);
        if (typeof marked === 'function') {
            return marked(cleanMd);
        }
        return this.formatChunk(cleanMd);
    },

    /**
     * 从后台获取并加载AI助手聊天历史记录
     */
    loadChatHistory: function () {
        var self = this;
        $('#chat-box').html(`<div class="text-center text-muted my-3"><i class="icofont-spinner rotate"></i> ${_langJS.loading_history}</div>`);
        $.getJSON('ai.php?action=get_history', function (res) {
            $('#chat-box').empty();
            if (res.data && res.data.length > 0) {
                res.data.forEach(function (item) {
                    if (item.role === 'user') {
                        $('#chat-box').append('<div style="background-color:#69b4ff; color:#FFFFFF; border-radius: 10px; padding: 10px; margin: 5px 0;"> ' + $('<div>').text(item.content).html() + '</div>');
                    } else if (item.role === 'assistant') {
                        var cleanHtml = self.renderMarkdown(item.content);
                        $('#chat-box').append(
                            '<div class="ai-chat-message">' +
                            '<div class="ai-answer-wrap">' +
                            '<div class="ai-answer-content markdown">' + cleanHtml + '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                });
                $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            } else {
                $('#chat-box').append(self.emptyChatHtml);
            }
            self.isHistoryLoaded = true;
        }).fail(function () {
            $('#chat-box').html(`<div class="text-center text-danger my-3">${_langJS.load_history_failed}</div>`);
        });
    },

    /**
     * 向 AI 助手发送消息并进行流式接收和卡片渲染
     * 
     * @param {string} message 消息文本内容
     * @param {boolean} isSystemFeedback 是否为系统回传的工具执行结果反馈
     */
    sendAiMessage: function (message, isSystemFeedback) {
        var self = this;
        $('#empty-chat-guide').remove();

        if (!isSystemFeedback) {
            // 用户发送的真实消息
            $('#chat-box').append('<div style="background-color:#69b4ff; color:#FFFFFF; border-radius: 10px; padding: 10px; margin: 5px 0;"> ' + $('<div>').text(message).html() + '</div>');
            $('#chat-input').val('').trigger('input');
        } else {
            // 系统自动回传的工具执行结果提示
            $('#chat-box').append('<div class="text-center text-muted my-2 text-xs"><i class="icofont-exchange"></i> [系统提示] 工具执行结果已自动反馈给 AI 助手</div>');
        }
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

        var $sendBtn = $('#send-btn');
        $sendBtn.removeClass('btn-primary').addClass('btn-danger').text(_langJS.stop_streaming);

        if (self.currentEventSource) {
            self.currentEventSource.close();
        }
        self.currentEventSource = new EventSource('ai.php?action=chat_stream&message=' + encodeURIComponent(message));
        var $aiMessage = $(
            '<div class="ai-chat-message">' +
            '<div class="ai-thought-wrap d-none">' +
            '<div class="ai-thought-content"></div>' +
            '</div>' +
            '<div class="ai-answer-wrap">' +
            '<div class="ai-answer-content markdown"></div>' +
            '</div>' +
            '</div>'
        );
        $('#chat-box').append($aiMessage);
        var $thoughtWrap = $aiMessage.find('.ai-thought-wrap');
        var $thoughtContent = $aiMessage.find('.ai-thought-content');
        var $answerContent = $aiMessage.find('.ai-answer-content');
        var hasReasoning = false;
        var rawAnswer = '';
        var rawReasoning = '';
        var mainAnswer = '';

        self.currentEventSource.onmessage = function (event) {
            if (event.data === '[DONE]') {
                if (!hasReasoning) {
                    $thoughtWrap.remove();
                }
                self.resetChatStatus();

                // 对话输出完毕后，尝试从过滤了思考过程的正文中提取 tool_call
                var toolCallRegex = /<tool_call\s+name="([^"]+)">([\s\S]*?)<\/tool_call>/g;
                var match;
                while ((match = toolCallRegex.exec(mainAnswer)) !== null) {
                    var toolName = match[1];
                    var paramsStr = match[2].trim();
                    self.executeToolCall(toolName, paramsStr, $aiMessage);
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
                            rawReasoning += rchunk;
                            $thoughtContent.html(self.formatChunk(rawReasoning));
                        }
                        if (chunk) {
                            rawAnswer += chunk;

                            var thinkText = '';
                            var mainText = rawAnswer;

                            // 判断是否包含 <think> 标签以提取思考过程 (DeepSeek-R1 兼容)
                            if (rawAnswer.indexOf('<think>') >= 0) {
                                hasReasoning = true;
                                $thoughtWrap.removeClass('d-none');

                                var thinkMatch = rawAnswer.match(/<think>([\s\S]*?)(?:<\/think>|$)/);
                                if (thinkMatch) {
                                    thinkText = thinkMatch[1];
                                }

                                mainText = rawAnswer.replace(/<think>[\s\S]*?<\/think>/, '');
                                if (rawAnswer.indexOf('</think>') < 0) {
                                    mainText = '';
                                }
                            }

                            mainAnswer = mainText;

                            if (thinkText) {
                                $thoughtContent.html(self.formatChunk(thinkText));
                            }

                            if (mainText) {
                                $answerContent.html(self.renderMarkdown(mainText));
                            }
                        }
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                    }
                } catch (err) {
                    console.error('解析流数据错误:', err);
                }
            }
        };

        self.currentEventSource.onerror = function () {
            if (!hasReasoning) {
                $thoughtWrap.remove();
            }
            $answerContent.html($answerContent.html() + _langJS.connect_error);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
            self.resetChatStatus();
        };
    },

    /**
     * 执行 AI 工具请求与卡片渲染
     * 
     * @param {string} name 工具名称
     * @param {string} paramsJson JSON格式的参数字符串
     * @param {jQuery} $aiMessage AI消息DOM容器对象
     */
    executeToolCall: function (name, paramsJson, $aiMessage) {
        var self = this;
        var toolNamesMap = {
            'query_database': _langJS.ai_tool_query_database,
            'update_config': _langJS.ai_tool_update_config,
            'write_article': _langJS.ai_tool_write_article,
            'generate_image': _langJS.ai_tool_generate_image
        };
        var friendlyName = toolNamesMap[name] || name;

        var sql = '';
        var configKey = '';
        var configAction = '';
        var configValue = '';
        try {
            var paramsObj = JSON.parse(paramsJson);
            sql = paramsObj.sql || '';
            configKey = paramsObj.key || '';
            configAction = paramsObj.action || '';
            configValue = paramsObj.value !== undefined ? JSON.stringify(paramsObj.value) : '';
        } catch (e) {}

        var isWriteOp = name === 'update_config' || name === 'write_article' || (name === 'query_database' && !/^\s*(select|show|desc|describe|explain)\b/i.test(sql));

        var waitSensitiveText = name === _langJS.ai_tool_config_wait_sensitive;

        var $card = $(
            '<div class="card mt-2 shadow-sm border-left-primary">' +
            '<div class="card-body py-2 px-3">' +
            '<div class="d-flex align-items-center justify-content-between">' +
            '<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">' +
            '<i class="icofont-tools-bag mr-1"></i> ' + _langJS.ai_tool_operation +
            '</div>' +
            '<span class="badge badge-info status-badge">' +
            (isWriteOp ? '<i class="icofont-warning-alt"></i> ' + _langJS.ai_tool_wait_confirm : '<i class="icofont-spinner-alt-3 rotate"></i> ' + _langJS.ai_tool_executing) +
            '</span>' +
            '</div>' +
            '<div class="text-sm text-gray-800 action-details">' +
            (isWriteOp ? '' : _langJS.ai_tool_executing_for_you.replace('%s', friendlyName)) +
            '</div>' +
            '</div>' +
            '</div>'
        );
        $aiMessage.find('.ai-answer-wrap').append($card);
        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

        if (isWriteOp) {
            // 显示确认界面
            var tipText = '';
            if (name === 'update_config') {
                var actionText = configAction === 'add' ? '新增' : (configAction === 'delete' ? '删除' : '修改');
                tipText = '即将修改 config.php 配置文件。操作：【' + actionText + '】，配置项：<code>' + $('<div>').text(configKey).html() + '</code>' + (configAction !== 'delete' ? '，新值：<code>' + $('<div>').text(configValue).html() + '</code>' : '');
            } else if (name === 'write_article') {
                var articleTitle = '';
                try {
                    articleTitle = JSON.parse(paramsJson).title || '';
                } catch (e) {}
                tipText = '即将发布新文章。标题：<code>' + $('<div>').text(articleTitle).html() + '</code>';
            } else {
                tipText = _langJS.ai_tool_modify_db_tip + '<code>' + $('<div>').text(sql).html() + '</code>';
            }
            var confirmHtml =
                '<div class="confirm-wrap mt-2">' +
                '<div class="text-sm mb-2">' + tipText + '</div>' +
                '<div class="text-sm font-weight-bold text-danger mb-2">' + _langJS.ai_tool_warning + '</div>' +
                '<button class="btn btn-xs btn-danger run-confirm-btn mr-2">' + _langJS.ai_tool_confirm_btn + '</button>' +
                '<button class="btn btn-xs btn-light cancel-confirm-btn">' + _langJS.cancel + '</button>' +
                '</div>';
            $card.find('.action-details').html(confirmHtml);
            $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

            // 取消按钮
            $card.find('.cancel-confirm-btn').on('click', function () {
                $card.removeClass('border-left-primary').addClass('border-left-secondary');
                $card.find('.status-badge').removeClass('badge-info').addClass('badge-secondary').html('<i class="icofont-close-circled"></i> ' + _langJS.ai_tool_cancelled);
                $card.find('.action-details').html('<span class="text-muted">' + _langJS.ai_tool_cancelled_tip + '</span>');
            });

            // 确认执行按钮
            $card.find('.run-confirm-btn').on('click', function () {
                $card.find('.confirm-wrap').remove();
                $card.find('.status-badge').removeClass('badge-info').addClass('badge-info').html('<i class="icofont-spinner-alt-3 rotate"></i> ' + _langJS.ai_tool_executing);
                $card.find('.action-details').html(waitSensitiveText);
                sendAjaxRequest('confirm');
            });
        } else {
            // 非写操作直接发送
            sendAjaxRequest('');
        }

        /**
         * 向后台发送执行 AI 工具的 AJAX 请求
         * 
         * @param {string} confirmCode 确认码
         */
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
                success: function (response) {
                    var resultsTextForAi = '';
                    if (response.code === 0) {
                        var data = response.data || {};
                        if (data.need_config) {
                            $card.removeClass('border-left-primary').addClass('border-left-warning');
                            $card.find('.status-badge').removeClass('badge-info').addClass('badge-warning').html('<i class="icofont-warning"></i> 未配置模型');
                            var configTip = '<div>' + $('<div>').text(data.message).html() + '</div>' +
                                '<div class="mt-2"><a href="./setting.php?action=ai" class="btn btn-xs btn-primary"><i class="icofont-gear"></i> 前往配置图像生成模型</a></div>';
                            $card.find('.action-details').html(configTip);
                            resultsTextForAi = '[工具执行结果] 拦截：用户尚未配置图像生成模型。提示用户前往 [系统设置->AI服务] 页面配置图像生成模型。';
                        } else {
                            $card.removeClass('border-left-primary').addClass('border-left-success');
                            $card.find('.status-badge').removeClass('badge-info').addClass('badge-success').html('<i class="icofont-check-circled"></i> ' + _langJS.ai_tool_success);

                            var detailHtml = '';
                            if (name === 'query_database') {
                                var list = data.results || [];
                                if (list.length === 0) {
                                    detailHtml = _langJS.ai_tool_no_data;
                                    resultsTextForAi = '[工具执行结果] 成功，没有返回任何数据（这在执行 DELETE/UPDATE 等写操作时是正常的）。';
                                } else {
                                    detailHtml = '<div class="table-responsive"><table class="table table-bordered table-sm text-xs mb-0"><thead><tr>';
                                    var keys = Object.keys(list[0]);
                                    var filteredKeys = keys.filter(function (keyName) {
                                        return isNaN(keyName);
                                    });
                                    filteredKeys.forEach(function (key) {
                                        detailHtml += '<th>' + $('<div>').text(key).html() + '</th>';
                                    });
                                    detailHtml += '</tr></thead><tbody>';
                                    list.forEach(function (row) {
                                        detailHtml += '<tr>';
                                        filteredKeys.forEach(function (key) {
                                            var val = row[key];
                                            if (key === 'date') {
                                                val = new Date(parseInt(val) * 1000).toLocaleString();
                                            }
                                            detailHtml += '<td>' + $('<div>').text(val).html() + '</td>';
                                        });
                                        detailHtml += '</tr>';
                                    });
                                    detailHtml += '</tbody></table></div>';

                                    resultsTextForAi = '[工具执行结果] 成功，查询到的数据如下：\n' + JSON.stringify(list);
                                }
                            } else if (name === 'generate_image') {
                                var imgUrl = data.image_url || '';
                                detailHtml = '<div>' + (data.message || '图像生成成功！') + '</div>' +
                                    (imgUrl ? '<div class="mt-2 text-center"><a href="' + imgUrl + '" target="_blank"><img src="' + imgUrl + '" class="img-fluid rounded shadow-sm" style="max-height: 260px;" /></a></div>' : '');
                                resultsTextForAi = '[工具执行结果] 成功：图像已成功生成并保存到媒体库。图片访问URL: ' + imgUrl;
                            } else if (data.message) {
                                detailHtml = data.message;
                                resultsTextForAi = '[工具执行结果] 成功：' + data.message;
                            } else {
                                detailHtml = _langJS.ai_tool_complete;
                                resultsTextForAi = '[工具执行结果] 成功：操作执行完毕。';
                            }
                            $card.find('.action-details').html(detailHtml);
                        }
                    } else {
                        var errorMsg = response.msg || _langJS.ai_tool_failed;
                        showError(errorMsg);
                    }
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);

                    // 仅当执行成功，且为只读操作或生成图片等非确认类中间步骤时，自动回传结果给 AI 触发后续回复
                    if (response.code === 0 && !isWriteOp && resultsTextForAi) {
                        setTimeout(function () {
                            self.sendAiMessage(resultsTextForAi, true);
                        }, 1500);
                    }
                },
                error: function (xhr, status, error) {
                    var errorMsg = _langJS.ai_tool_network_error + error;
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response && response.msg) {
                            errorMsg = response.msg;
                        }
                    } catch (e) {
                        // 解析失败，保留原有的网络异常信息
                    }
                    showError(errorMsg);
                    $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                }
            });
        }

        /**
         * 在卡片中显示错误信息，并更新卡片状态
         * 
         * @param {string} errorMsg 错误提示信息
         */
        function showError(errorMsg) {
            $card.removeClass('border-left-primary').addClass('border-left-danger');
            $card.find('.status-badge').removeClass('badge-info').addClass('badge-danger').html('<i class="icofont-close-circled"></i> ' + _langJS.ai_tool_failed);
            $card.find('.action-details').html('<span class="text-danger">' + errorMsg + '</span>');
        }
    }
};
