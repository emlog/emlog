<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800"><?php _lang('setting'); ?></h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link" href="./setting.php"><?php _lang('setting_basic'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=user"><?php _lang('setting_user'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=mail"><?php _lang('setting_mail'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=seo"><?php _lang('setting_seo'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./setting.php?action=api"><?php _lang('setting_api'); ?></a></li>
        <li class="nav-item"><a class="nav-link active" href="./setting.php?action=ai"><?php _lang('setting_ai'); ?></a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php"><?php _lang('setting_profile'); ?></a></li>
    </ul>
</div>

<!-- 文本对话模型区域 -->
<div class="card shadow mb-4 mt-2">
    <div class="card-header">
        <h5 class="mb-0"><?php _lang('ai_chat_model'); ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            // 筛选文本对话模型（没有type字段或type为chat的模型）
            $chatModels = array_filter($aiModels, function ($model) {
                return !isset($model['type']) || $model['type'] === 'chat';
            });
            foreach ($chatModels as $k => $val):
                $apiUrl = $val['api_url'];
                $apiUrlDomain = parse_url($apiUrl, PHP_URL_HOST);
                $apiKey = subString($val['api_key'], 0, 8, '******');
                $model = $val['model'];
                if (strpos($model, 'deepseek') !== false) {
                    $model = '🐳 ' . $model;
                }
            ?>
                <div class="col-md-4 mb-3">
                    <div class="card model-card">
                        <div class="card-body align-items-center justify-content-center">
                            <h4 class="card-title model-name">
                                <?php if ($k == $currentModelKey): ?>
                                    <?= $model ?>
                                    <span class="badge badge-success"><?php _lang('enabled'); ?></span>
                                <?php else: ?>
                                    <a href="./setting.php?action=ai_model&ai_model_key=<?= $k ?>&model_type=chat"><?= $model ?></a>
                                <?php endif; ?>
                            </h4>
                            <div class="my-3">
                                <span class="badge badge-gray" style="font-size: 1.2em;"><?= $apiUrlDomain ?></span><br>
                            </div>
                            <a href="#" class="edit-link small text-primary" data-toggle="modal" data-target="#editModelModal" data-model="<?= $val['model'] ?>" data-url="<?= $val['api_url'] ?>" data-api_key="<?= $apiKey ?>" data-model_key="<?= $k ?>" data-model_type="chat" style="position: absolute; bottom: 10px; right: 40px;"><?php _lang('edit'); ?></a>
                            <a href="javascript: em_confirm('<?= $k ?>', 'ai_model', '<?= LoginAuth::genToken() ?>');" class="delete-link small text-danger" style="position: absolute; bottom: 10px; right: 10px;"><?php _lang('delete'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <a type="button" class="" data-toggle="modal" data-target="#addModelModal" data-model-type="chat">
                            + <?php _lang('add_chat_model'); ?>
                        </a>
                        <p class="text-center small text-muted mt-3">
                            <a href="https://www.emlog.net/docs/ai/ai_emlog" class="text-muted" target="_blank"><?php _lang('view_supported_models'); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 图像生成模型区域 -->
<div class="card shadow mb-4">
    <div class="card-header">
        <h5 class="mb-0"><?php _lang('ai_image_model'); ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            // 筛选图像生成模型（type为image的模型）
            $imageModels = array_filter($aiModels, function ($model) {
                return isset($model['type']) && $model['type'] === 'image';
            });
            foreach ($imageModels as $k => $val):
                $apiUrl = $val['api_url'];
                $apiUrlDomain = parse_url($apiUrl, PHP_URL_HOST);
                $apiKey = subString($val['api_key'], 0, 8, '******');
                $model = $val['model'];
            ?>
                <div class="col-md-4 mb-3">
                    <div class="card model-card">
                        <div class="card-body align-items-center justify-content-center">
                            <h4 class="card-title model-name">
                                <?php if ($k == $currentImageModelKey): ?>
                                    <?= $model ?>
                                    <span class="badge badge-success"><?php _lang('enabled'); ?></span>
                                <?php else: ?>
                                    <a href="./setting.php?action=ai_model&ai_model_key=<?= $k ?>&model_type=image"><?= $model ?></a>
                                <?php endif; ?>
                            </h4>
                            <div class="my-3">
                                <span class="badge badge-gray" style="font-size: 1.2em;"><?= $apiUrlDomain ?></span><br>
                            </div>
                            <a href="#" class="edit-link small text-primary" data-toggle="modal" data-target="#editModelModal" data-model="<?= $val['model'] ?>" data-url="<?= $val['api_url'] ?>" data-api_key="<?= $apiKey ?>" data-model_key="<?= $k ?>" data-model_type="image" style="position: absolute; bottom: 10px; right: 40px;"><?php _lang('edit'); ?></a>
                            <a href="javascript: em_confirm('<?= $k ?>', 'ai_model', '<?= LoginAuth::genToken() ?>');" class="delete-link small text-danger" style="position: absolute; bottom: 10px; right: 10px;"><?php _lang('delete'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <a type="button" class="" data-toggle="modal" data-target="#addModelModal" data-model-type="image">
                            + <?php _lang('add_image_model'); ?>
                        </a>
                        <p class="text-center small text-muted mt-3">
                            <a href="https://www.emlog.net/docs/ai/ai_emlog" class="text-muted" target="_blank"><?php _lang('view_supported_models'); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 应用区域 -->
<div class="card shadow mb-4">
    <div class="card-header">
        <h5 class="mb-0"><?php _lang('ai_app'); ?></h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <a type="button" class="" data-toggle="modal" data-target="#aiChatModal">
                            💬 <?php _lang('chat_talk'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <a type="button" class="" data-toggle="modal" data-target="#aiImageModal">
                            🎨 <?php _lang('generate_image'); ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <a type="button" class="" href="store.php?action=plu&keyword=AI">
                            <?php _lang('more_ai_apps'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
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

    $(document).ready(function() {
        $('#edit-model-form').submit(function(event) {
            event.preventDefault();
            $('#editModelModal').modal('hide');
        });

        $('.edit-link').click(function() {
            var model = $(this).data('model');
            var url = $(this).data('url');
            var api_key = $(this).data('api_key');
            var model_key = $(this).data('model_key');
            var model_type = $(this).data('model_type') || 'chat';
            $('#editModelModal #edit_ai_model').val(model);
            $('#editModelModal #edit_ai_api_url').val(url);
            $('#editModelModal #edit_ai_api_key').val(api_key);
            $('#editModelModal #ai_model_key').val(model_key);
            $('#editModelModal #ai_model_type').val(model_type);
        });

        // 处理添加模型按钮点击
        $('[data-model-type]').click(function() {
            var modelType = $(this).data('model-type');
            $('#addModelModal #ai_model_type').val(modelType);
            if (modelType === 'image') {
                $('#addModelModal .modal-title').text('<?php _lang('add_image_model'); ?>');
                $('#more-config-details').html(getImageModelExamples());
            } else {
                $('#addModelModal .modal-title').text('<?php _lang('add_chat_model'); ?>');
                $('#more-config-details').html(getChatModelExamples());
            }
        });
    });

    // 获取文本对话模型示例配置
    function getChatModelExamples() {
        return `
            <a href="https://www.deepseek.com/" target="_blank">DeepSeek</a><br>
            API URL：https://api.deepseek.com/v1/chat/completions<br>
            API Key：<a href="https://platform.deepseek.com/api_keys" target="_blank"><?php _lang('generate_api_key'); ?></a>，格式如：sk-****<br>
            Model：deepseek-chat<br>
            <hr>
            <a href="https://bigmodel.cn/" target="_blank">智谱AI</a><br>
            API URL：https://open.bigmodel.cn/api/paas/v4/chat/completions<br>
            API Key：<a href="https://bigmodel.cn/usercenter/proj-mgmt/apikeys" target="_blank"><?php _lang('generate_api_key'); ?></a><br>
            Model：glm-4.6、glm-4.5、glm-4.5-flash<br>
            <hr>
            <a href="https://cloud.siliconflow.cn/" target="_blank">硅基流动</a><br>
            API URL：https://api.siliconflow.cn/v1/chat/completions<br>
            API Key：<a href="https://cloud.siliconflow.cn/me/account/ak" target="_blank"><?php _lang('generate_api_key'); ?></a><br>
            Model：Qwen/Qwen3-8B、THUDM/GLM-4-9B-0414<br>
            <hr>
            <?php _lang('support_openai_model'); ?>，<a href="https://www.emlog.net/docs/ai/ai_emlog" target="_blank"><?php _lang('more_ai_models'); ?></a><br>
        `;
    }

    // 获取图像生成模型示例配置
    function getImageModelExamples() {
        return `
            <a href="https://cloud.siliconflow.cn/" target="_blank">硅基流动</a><br>
            API URL：https://api.siliconflow.cn/v1/images/generations<br>
            API Key：<a href="https://cloud.siliconflow.cn/me/account/ak" target="_blank"><?php _lang('generate_api_key'); ?></a><br>
            Model：Kwai-Kolors/Kolors<br>
            <hr>
            <a href="https://console.volcengine.com/auth/login?redirectURI=%2Fark" target="_blank">豆包</a><br>
            API URL：https://ark.cn-beijing.volces.com/api/v3/images/generations<br>
            API Key：<a href="https://console.volcengine.com/auth/login?redirectURI=%2Fark" target="_blank"><?php _lang('generate_api_key'); ?></a><br>
            Model：doubao-seedream-3-0-t2i-250415<br>
            <hr>
            <?php _lang('support_openai_image_model'); ?>，<a href="https://www.emlog.net/docs/ai/ai_emlog" target="_blank"><?php _lang('more_ai_models'); ?></a><br>
        `;
    }
</script>

<!-- Modal for adding custom model -->
<div class="modal fade" id="addModelModal" tabindex="-1" role="dialog" aria-labelledby="addModelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="addModelModalLabel"><?php _lang('add_ai_model'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="setting.php?action=ai_save" method="post" name="setting_ai_form" id="setting_ai_form">
                <div class="modal-body">
                    <p>API URL：</p>
                    <div class="form-group">
                        <input type="url" class="form-control" name="ai_api_url" id="ai_api_url" value="" />
                    </div>
                    <p>API Key：</p>
                    <div class="form-group">
                        <input type="text" class="form-control" name="ai_api_key" id="ai_api_key" value="" />
                    </div>
                    <p>Model：</p>
                    <div class="form-group">
                        <input type="text" class="form-control" name="ai_model" id="ai_model" value="" />
                        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                        <input name="ai_model_type" id="ai_model_type" value="chat" type="hidden" />
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?php _lang('cancel'); ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?php _lang('save'); ?></button>
                </div>
                <div id="more-config-details" class="alert alert-warning m-2"></div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for editing custom model -->
<div class="modal fade" id="editModelModal" tabindex="-1" role="dialog" aria-labelledby="editModelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="editModelModalLabel"><?php _lang('edit_ai_model'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="setting.php?action=ai_update" method="post" name="edit_model_form" id="edit_model_form">
                <div class="modal-body">
                    <p>API URL：</p>
                    <div class="form-group">
                        <input type="url" class="form-control" value="" name="edit_ai_api_url" id="edit_ai_api_url" disabled />
                    </div>
                    <p>API Key：</p>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" name="edit_ai_api_key" id="edit_ai_api_key" disabled />
                    </div>
                    <p>Model：</p>
                    <div class="form-group">
                        <input type="text" class="form-control" name="edit_ai_model" id="edit_ai_model" value="" />
                        <input type="hidden" name="ai_model_key" id="ai_model_key" value="" />
                        <input type="hidden" name="ai_model_type" id="ai_model_type" value="chat" />
                        <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden" />
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal"><?php _lang('cancel'); ?></button>
                    <button type="submit" class="btn btn-sm btn-success"><?php _lang('save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AI Image Generation Modal -->
<div class="modal fade" id="aiImageModal" tabindex="-1" role="dialog" aria-labelledby="aiImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="aiImageModalLabel">🎨 <?php _lang('ai_generate_image'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="image-result" style="min-height: 300px; border: 1px solid #ddd; padding: 20px; margin-bottom: 15px; border-radius: 8px; text-align: center; background-color: #f8f9fa;">
                    <div class="text-muted">
                        <p></p>
                    </div>
                </div>
                <form id="image-form">
                    <div class="form-group">
                        <label for="image-prompt"><?php _lang('image_prompt'); ?>：</label>
                        <textarea class="form-control" id="image-prompt" placeholder="<?php _lang('image_prompt_placeholder'); ?>" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image-size"><?php _lang('size'); ?>：</label>
                                <select class="form-control" id="image-size">
                                    <option value="1024x1024">1024x1024 (<?php _lang('size_square'); ?>)</option>
                                    <option value="1792x1024">1792x1024 (<?php _lang('size_landscape'); ?>)</option>
                                    <option value="1024x1792">1024x1792 (<?php _lang('size_portrait'); ?>)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image-quality"><?php _lang('quality'); ?>：</label>
                                <select class="form-control" id="image-quality">
                                    <option value="standard"><?php _lang('standard'); ?></option>
                                    <option value="hd"><?php _lang('hd'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit" id="generate-btn">
                            <?php _lang('generate_image_btn'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // AI Image Generation
        $('#aiImageModal').on('shown.bs.modal', function() {
            $('#image-prompt').focus();
        });

        $('#image-form').submit(function(event) {
            event.preventDefault();
            var prompt = $('#image-prompt').val().trim();
            if (prompt === '') {
                alert('<?php _lang('enter_image_prompt'); ?>');
                return;
            }

            var size = $('#image-size').val();
            var quality = $('#image-quality').val();
            var $generateBtn = $('#generate-btn');
            var $imageResult = $('#image-result');

            // 显示生成中状态
            $generateBtn.prop('disabled', true).html('生成中...');
            $imageResult.html('<div class="text-center"><p>正在生成图像，请稍候...</p></div>');

            // 发送生成请求
            $.ajax({
                url: 'ai.php?action=generate_image',
                type: 'POST',
                data: {
                    prompt: prompt,
                    size: size,
                    quality: quality
                },
                dataType: 'json',
                timeout: 60000, // 60秒超时
                success: function(response) {
                    $generateBtn.prop('disabled', false).html('生成图像');

                    if (response.code === 0 && response.data) {
                        // 优先使用本地文件URL，如果没有则使用远程URL
                        var imageUrl = response.data.file_url || (response.data.data && response.data.data[0] && response.data.data[0].url);
                        var localPath = response.data.local_path || '';

                        $imageResult.html(
                            '<div class="text-center">' +
                            '<img src="' + imageUrl + '" class="img-fluid mb-3" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);" alt="生成的图像">' +
                            '<div class="mt-3">' +
                            '<div class="btn-group" role="group">' +
                            '<a href="' + imageUrl + '" target="_blank" class="btn btn-sm btn-outline-primary">查看原图</a>' +
                            '<a href="media.php" target="_blank" class="btn btn-sm btn-outline-success">资源管理</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    } else {
                        var errorMsg = response.msg || '生成失败，请检查AI模型配置';
                        $imageResult.html(
                            '<div class="text-center text-danger">' +
                            '<p>生成失败</p>' +
                            '<p class="small">' + errorMsg + '</p>' +
                            '</div>'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    $generateBtn.prop('disabled', false).html('生成图像');
                    var errorMsg = '请求失败';
                    if (status === 'timeout') {
                        errorMsg = '请求超时，请稍后重试';
                    } else if (xhr.responseJSON && xhr.responseJSON.msg) {
                        errorMsg = xhr.responseJSON.msg;
                    }

                    $imageResult.html(
                        '<div class="text-center text-danger">' +
                        '<p>生成失败</p>' +
                        '<p class="small">' + errorMsg + '</p>' +
                        '</div>'
                    );
                }
            });
        });
    });
</script>