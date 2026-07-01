<?php

/**
 * Service: AI
 *
 * @package EMLOG
 * 
 */

class Ai
{
    /**
     * AI 对话函数
     * @param string $prompt 用户提问
     * @param string $system_prompt 系统提示词
     * @param bool $useHistory 是否使用历史对话记录作为上下文（最近10条）
     * @return string AI回复内容
     */
    public static function chat($prompt, $system_prompt = '你是一个有用的助手', $useHistory = false)
    {
        $orig_prompt = $prompt;
        $isEmHelp = false;
        $searchQuery = '';
        if (preg_match('/^\s*@em-help\s+(.*)$/is', $prompt, $m)) {
            $isEmHelp = true;
            $searchQuery = trim($m[1]);
        }

        if ($isEmHelp) {
            if (empty($searchQuery)) {
                return '请输入您要询问的 emlog 使用问题。例如：`@em-help 挂载点`';
            }
            $searchResults = self::searchEmlog($searchQuery);
            $system_prompt = "你是一个专业的 Emlog 博客系统解答专家。以下是关于用户问题“" . $searchQuery . "”从 Emlog 官网 FAQ（https://www.emlog.net/docs/faq）及互联网搜索到的相关参考资料：\n\n" . $searchResults . "\n\n请结合上述参考资料以及你自身的知识，专业、详细地回答用户的问题。特别注意：如果参考资料中包含【优先参考：Emlog 官方 FAQ】且有匹配的问题与解答，你必须【绝对优先】采用官方 FAQ 的答案作为你的回答核心，然后再用互联网搜索结果或自身知识进行补充。如果参考资料中有具体的步骤或代码，请尽量提供给用户。请使用中文回答，并保持语气友好、专业。";
            $prompt = $searchQuery;
        }

        $messages = [];
        if (!empty($system_prompt)) {
            $messages[] = [
                "content" => $system_prompt,
                "role" => "system"
            ];
        }

        $history = [];
        if ($useHistory) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $history = isset($_SESSION['ai_chat_history']) && is_array($_SESSION['ai_chat_history']) ? $_SESSION['ai_chat_history'] : [];
            foreach ($history as $msg) {
                $messages[] = [
                    "role" => $msg['role'],
                    "content" => $msg['content']
                ];
            }
        }

        $messages[] = [
            "content" => $prompt,
            "role" => "user"
        ];

        $response = self::send($messages);
        $assistant_response = self::formatResponse($response);

        if ($useHistory && !empty($assistant_response) && strpos($assistant_response, '大模型处理异常') !== 0 && strpos($assistant_response, 'AI 模型未配置') !== 0) {
            $history[] = [
                'role' => 'user',
                'content' => $orig_prompt
            ];
            $history[] = [
                'role' => 'assistant',
                'content' => $assistant_response
            ];
            if (count($history) > 10) {
                $history = array_slice($history, -10);
            }
            $_SESSION['ai_chat_history'] = $history;
        }

        return $assistant_response;
    }

    /**
     * AI 流式对话函数
     * @param string $prompt 用户提问
     * @param string $system_prompt 系统提示词
     * @param bool $useHistory 是否使用历史对话记录作为上下文（最近10条）
     * @return string AI回复完整内容
     */
    public static function chatStream($prompt, $system_prompt = '你是一个有用的助手', $useHistory = false)
    {
        $orig_prompt = $prompt;
        $isEmHelp = false;
        $searchQuery = '';
        if (preg_match('/^\s*@em-help\s+(.*)$/is', $prompt, $m)) {
            $isEmHelp = true;
            $searchQuery = trim($m[1]);
        }

        if ($isEmHelp) {
            if (empty($searchQuery)) {
                echo "data: " . json_encode(["choices" => [["delta" => ["content" => "请输入您要询问的 emlog 使用问题。例如：`@em-help 挂载点`"]]]]) . "\n\n";
                echo "data: [DONE]\n\n";
                return '';
            }
            $searchResults = self::searchEmlog($searchQuery);
            $system_prompt = "你是一个专业的 Emlog 博客系统解答专家。以下是关于用户问题“" . $searchQuery . "”从 Emlog 官网 FAQ（https://www.emlog.net/docs/faq）及互联网搜索到的相关参考资料：\n\n" . $searchResults . "\n\n请结合上述参考资料以及你自身的知识，专业、详细地回答用户的问题。特别注意：如果参考资料中包含【优先参考：Emlog 官方 FAQ】且有匹配的问题与解答，你必须【绝对优先】采用官方 FAQ 的答案作为你的回答核心，然后再用互联网搜索结果或自身知识进行补充。如果参考资料中有具体的步骤或代码，请尽量提供给用户。请使用中文回答，并保持语气友好、专业。";
            $prompt = $searchQuery;
        }

        $messages = [];
        if (!empty($system_prompt)) {
            $messages[] = [
                "content" => $system_prompt,
                "role" => "system"
            ];
        }

        $history = [];
        if ($useHistory) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $history = isset($_SESSION['ai_chat_history']) && is_array($_SESSION['ai_chat_history']) ? $_SESSION['ai_chat_history'] : [];
            foreach ($history as $msg) {
                $messages[] = [
                    "role" => $msg['role'],
                    "content" => $msg['content']
                ];
            }
        }

        $messages[] = [
            "content" => $prompt,
            "role" => "user"
        ];

        $assistant_response = self::sendStream($messages);

        if ($useHistory && !empty($assistant_response)) {
            $history[] = [
                'role' => 'user',
                'content' => $orig_prompt
            ];
            $history[] = [
                'role' => 'assistant',
                'content' => $assistant_response
            ];
            if (count($history) > 10) {
                $history = array_slice($history, -10);
            }
            $_SESSION['ai_chat_history'] = $history;
        }

        return $assistant_response;
    }

    /**
     * 发送流式对话请求并输出，同时返回拼装后的完整回复
     * @param array $messages 对话消息列表
     * @return string 完整回复文本
     */
    public static function sendStream($messages)
    {
        $modelInfo = self::getCurrentModelInfo();
        if (empty($modelInfo) || !isset($modelInfo['api_url'])) {
            echo "data: " . json_encode(["error" => "AI Model not configured"]) . "\n\n";
            return '';
        }

        $apiUrl = $modelInfo['api_url'];
        $apiKey = $modelInfo['api_key'];
        $model = $modelInfo['model'];

        $post_data = json_encode([
            'messages' => $messages,
            'model' => $model,
            'stream' => true,
            'temperature' => 1,
            'max_tokens' => 4096
        ]);

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ];

        $full_response = '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) use (&$full_response) {
            echo $data;
            ob_flush();
            flush();

            // 解析大模型返回的数据片段并拼装
            $lines = explode("\n", $data);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, 'data:') === 0) {
                    $jsonStr = trim(substr($line, 5));
                    if ($jsonStr === '[DONE]') {
                        continue;
                    }
                    $json = json_decode($jsonStr, true);
                    if (is_array($json)) {
                        $chunk = '';
                        if (isset($json['choices'][0]['delta']['content'])) {
                            $chunk = $json['choices'][0]['delta']['content'];
                        } elseif (isset($json['choices'][0]['message']['content'])) {
                            $chunk = $json['choices'][0]['message']['content'];
                        }
                        if ($chunk !== '') {
                            $full_response .= $chunk;
                        }
                    }
                }
            }

            return strlen($data);
        });

        curl_exec($ch);
        if (curl_errno($ch)) {
            echo "data: [ERROR] " . curl_error($ch) . "\n\n";
        }

        curl_close($ch);

        return $full_response;
    }

    public static function send($messages, $stream = false)
    {
        $model = self::getCurrentModelInfo();
        if ($model === null || !isset($model['api_url'])) {
            return 'AI 模型未配置';
        }
        $apiUrl = $model['api_url'];
        $apiKey = $model['api_key'];
        $model = $model['model'];

        $emcurl = new EmCurl(600);
        $post_data = json_encode([
            'messages' => $messages,
            'model' => $model,
            'max_tokens' => 4096,
            'response_format' => ['type' => 'text'],
            'stream' => false,
            'temperature' => 1,
        ]);

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Bearer ' . $apiKey
        ];

        $emcurl->setPost($post_data);
        $emcurl->request($apiUrl, $headers);
        $retStatus = $emcurl->getHttpStatus();
        if ($retStatus !== MSGCODE_SUCCESS) {
            return $retStatus . '.' . $emcurl->getError();
        }
        $response = $emcurl->getRespone();
        return $response;
    }

    private static function formatResponse($response)
    {
        $decodedResponse = json_decode($response, true);
        if (isset($decodedResponse['choices'][0]['message']['content'])) {
            return $decodedResponse['choices'][0]['message']['content'];
        }
        return '大模型处理异常，请稍后再试，错误信息：' . $response;
    }

    /**
     * 获取当前AI模型信息
     * @return array|null
     */
    public static function getCurrentModelInfo()
    {
        $currentModelKey = Option::get('ai_model');
        if (empty($currentModelKey)) {
            return null;
        }

        $models = self::models();
        return isset($models[$currentModelKey]) ? $models[$currentModelKey] : null;
    }

    /**
     * 获取当前图像生成模型信息
     * @return array|null
     */
    public static function getCurrentImageModelInfo()
    {
        $currentModelKey = Option::get('ai_image_model');
        if (empty($currentModelKey)) {
            return null;
        }

        $models = self::models();
        return isset($models[$currentModelKey]) ? $models[$currentModelKey] : null;
    }

    /**
     * 获取指定类型的模型列表
     * @param string $type 模型类型 chat|image
     * @return array
     */
    public static function getModelsByType($type = 'chat')
    {
        $allModels = self::models();
        $filteredModels = array();

        foreach ($allModels as $key => $model) {
            $modelType = isset($model['type']) ? $model['type'] : 'chat';
            if ($modelType === $type) {
                $filteredModels[$key] = $model;
            }
        }

        return $filteredModels;
    }

    /**
     * 文生图功能
     * @param string $prompt 图片描述
     * @param array $options 可选参数
     * @return array
     */
    public static function generateImage($prompt, $options = array())
    {
        $modelInfo = self::getCurrentImageModelInfo();
        if (!$modelInfo) {
            return array('error' => '未配置图像生成模型');
        }

        $apiUrl = $modelInfo['api_url'];
        $apiKey = $modelInfo['api_key'];
        $model = $modelInfo['model'];

        // 构建请求数据
        $data = array(
            'model' => $model,
            'prompt' => $prompt,
            'n' => isset($options['n']) ? $options['n'] : 1,
            'size' => isset($options['size']) ? $options['size'] : '1024x1024',
            'quality' => isset($options['quality']) ? $options['quality'] : 'standard'
        );

        // 豆包模型去水印
        if (strpos($model, 'doubao-seedream') !== false) {
            $data['watermark'] = false;
        }

        // 发送请求
        $response = self::sendImageRequest($apiUrl, $apiKey, $data);
        return $response;
    }

    /**
     * 发送文生图请求
     * @param string $apiUrl API地址
     * @param string $apiKey API密钥
     * @param array $data 请求数据
     * @return array
     */
    private static function sendImageRequest($apiUrl, $apiKey, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return array('error' => 'CURL错误: ' . $error);
        }

        if ($httpCode !== 200) {
            return array('error' => 'HTTP错误: ' . $httpCode);
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return array('error' => 'JSON解析错误');
        }

        return $result;
    }

    /**
     * 生成图像并保存到媒体库
     * @param string $prompt 图像描述提示词
     * @param array $options 可选参数 (size, quality)
     * @return array 返回结果包含media_id, file_url, local_path等信息
     */
    public static function generateImageAndSave($prompt, $options = array())
    {
        // 验证输入参数
        if (empty($prompt)) {
            return array('error' => '请输入图像描述提示词');
        }

        // 设置默认参数
        $size = isset($options['size']) ? $options['size'] : '1024x1024';
        $quality = isset($options['quality']) ? $options['quality'] : 'standard';

        // 调用AI图像生成服务
        $generateOptions = array(
            'size' => $size,
            'quality' => $quality,
            'n' => 1
        );

        $result = self::generateImage($prompt, $generateOptions);

        // 检查生成结果
        if (isset($result['error'])) {
            return array('error' => $result['error']);
        }

        if (!isset($result['data']) || empty($result['data'])) {
            return array('error' => '图像生成失败，未返回有效数据');
        }

        $imageUrl = $result['data'][0]['url'];
        if (empty($imageUrl)) {
            return array('error' => '图像生成失败，未获取到图像URL');
        }

        // 下载图像数据
        $imageData = file_get_contents($imageUrl);
        if ($imageData === false) {
            return array('error' => '下载生成的图像失败');
        }

        // 生成临时文件来模拟文件上传
        $extension = 'png';
        $fileName = substr(md5($imageUrl), 0, 4) . time() . '.' . $extension;
        $tmpFile = sys_get_temp_dir() . '/' . $fileName;

        // 使用upload2local方法上传图片，先创建临时文件
        if (file_put_contents($tmpFile, $imageData) === false) {
            return array('error' => '创建临时文件失败');
        }

        // 构造模拟的$_FILES数组格式
        $attach = array(
            'name' => $fileName,
            'tmp_name' => $tmpFile,
            'size' => strlen($imageData),
            'type' => 'image/png',
            'error' => 0
        );

        // 使用upload2local方法处理文件上传
        $uploadResult = '';

        // 添加上传处理钩子，支持云存储插件
        addAction('upload_media', 'upload2local');
        doOnceAction('upload_media', $attach, $uploadResult);

        // 检查upload2local的返回结果格式
        if (is_array($uploadResult) && isset($uploadResult['success'])) {
            // upload2local已经返回了正确的格式，无需再次处理
        } else {
            // 如果返回格式不正确，设置默认错误信息
            $uploadResult = array(
                'success' => 0,
                'message' => '上传失败',
                'url' => '',
                'file_info' => array(),
            );
        }

        // 清理临时文件
        if (file_exists($tmpFile)) {
            unlink($tmpFile);
        }

        // 检查上传结果
        if (empty($uploadResult['success'])) {
            return array('error' => $uploadResult['message'] ? $uploadResult['message'] : '图像保存失败');
        }

        // 添加到媒体库
        $Media_Model = new Media_Model();
        $mediaId = $Media_Model->addMedia($uploadResult['file_info']);

        if ($mediaId) {
            // 返回成功结果
            return array(
                'success' => true,
                'media_id' => $mediaId,
                'file_url' => $uploadResult['url'],
                'local_path' => $uploadResult['file_info']['file_path'],
                'message' => '图像生成并保存成功'
            );
        } else {
            return array('error' => '添加到媒体库失败');
        }
    }

    public static function model()
    {
        $currentModelKey = Option::get('ai_model');
        if (!$currentModelKey) {
            return '';
        }
        $aiModels = self::models();
        if (isset($aiModels[$currentModelKey])) {
            return $aiModels[$currentModelKey]['model'];
        }
        return '';
    }

    public static function models()
    {
        $aiModels = Option::get('ai_models');
        if (empty($aiModels)) {
            return [];
        }
        $aiModels = json_decode(Option::get('ai_models'), true);
        if ($aiModels) {
            return $aiModels;
        }
        return [];
    }

    /**
     * AI 通用 SQL 执行与缓存自动刷新方法
     * 
     * 自动对传入的 SQL 语句进行安全校验。除只读查询（SELECT/SHOW/DESCRIBE 等）外，
     * 所有敏感的数据或表结构变更操作（写操作）均统一强制要求匹配确认码（确认操作），并且在执行成功后自动刷新系统全部缓存。
     * 自动将 SQL 中的系统表名补全为带有真实表前缀的格式。
     *
     * @param string $sql 待执行的 SQL 语句
     * @param string $confirm_code 敏感写操作时所必需的二次确认文字
     * @return array 返回查询结果数组（仅 SELECT/SHOW 等只读查询时有数据返回，写操作返回空数组）
     * @throws Exception 当 SQL 校验未通过、执行出错或写操作确认码不匹配时抛出异常
     */
    public static function queryDatabase($sql, $confirm_code = '')
    {
        $db = Database::getInstance();
        $clean_sql = trim($sql);

        // 1. 提取首单词，判定是否为只读操作
        $first_word = '';
        if (preg_match('/^\s*([a-zA-Z]+)\b/', $clean_sql, $m)) {
            $first_word = strtoupper($m[1]);
        }

        $readonly_commands = ['SELECT', 'SHOW', 'DESC', 'DESCRIBE', 'EXPLAIN'];
        $is_write_op = !in_array($first_word, $readonly_commands);

        // 2. 禁止多语句执行分号（防堆叠注入）
        if (strpos($clean_sql, ';') !== false) {
            $clean_sql_no_end = rtrim($clean_sql, ';');
            if (strpos($clean_sql_no_end, ';') !== false) {
                throw new Exception("权限限制：禁止多语句执行");
            }
        }

        // 3. 二次确认码安全防线：针对敏感的数据/表变更（写操作）进行确认验证
        if ($is_write_op) {
            if (trim($confirm_code) !== 'confirm') {
                throw new Exception("敏感操作拦截：执行敏感操作需要确认");
            }
        }

        // 4. 自动补全系统表前缀
        // 提取 Emlog 所有核心系统表
        $system_tables = [
            'blog',
            'comment',
            'options',
            'sort',
            'tag',
            'navi',
            'attachment',
            'link',
            'user',
            'reply',
            'twitter',
            'like',
            'log_field',
            'media',
            'mediasort',
            'order'
        ];

        foreach ($system_tables as $tbl) {
            // 匹配常用 SQL 关键字（FROM, JOIN, UPDATE, INTO, TABLE 等）后面跟着的不带前缀的表名，自动添加真实前缀
            $clean_sql = preg_replace(
                '/\b(from|join|update|into|truncate(?:\s+table)?|table|describe|desc)\s+`?' . preg_quote($tbl, '/') . '`?\b/i',
                '$1 `' . DB_PREFIX . $tbl . '`',
                $clean_sql
            );
        }

        // 自动查询数据表字段信息并补全缺失的必填无默认值字段，防止 strict 模式下 INSERT 报错
        if (strtoupper($first_word) === 'INSERT') {
            $tableName = '';
            if (preg_match('/insert\s+into\s+`?(\w+)`?/i', $clean_sql, $matches)) {
                $tableName = $matches[1];
            }

            if (!empty($tableName) && preg_match('/^\w+$/', $tableName)) {
                try {
                    $cols_query = @$db->query("SHOW COLUMNS FROM `{$tableName}`", true);
                    if ($cols_query) {
                        $fields_info = [];
                        while ($row = $db->fetch_array($cols_query)) {
                            $fields_info[$row['Field']] = [
                                'Null' => $row['Null'],
                                'Default' => $row['Default'],
                                'Type' => $row['Type'],
                                'Extra' => $row['Extra']
                            ];
                        }

                        // 筛选出不允许为 NULL 且无默认值且非自增的字段
                        $required_fields = [];
                        foreach ($fields_info as $fieldName => $info) {
                            $is_nullable = (strtoupper($info['Null']) === 'YES');
                            $has_default = ($info['Default'] !== null);
                            $is_auto_increment = (strpos(strtolower($info['Extra']), 'auto_increment') !== false);
                            
                            if (!$is_nullable && !$has_default && !$is_auto_increment) {
                                $type = strtolower($info['Type']);
                                if (strpos($type, 'int') !== false || strpos($type, 'decimal') !== false || strpos($type, 'float') !== false || strpos($type, 'double') !== false) {
                                    $default_value = 0;
                                } elseif (strpos($type, 'date') !== false || strpos($type, 'time') !== false) {
                                    if (strpos($type, 'datetime') !== false || strpos($type, 'timestamp') !== false) {
                                        $default_value = '1970-01-01 00:00:00';
                                    } else {
                                        $default_value = '1970-01-01';
                                    }
                                } else {
                                    $default_value = '';
                                }
                                $required_fields[$fieldName] = $default_value;
                            }
                        }

                        if (!empty($required_fields)) {
                            $missing_fields = [];
                            // 格式 A：INSERT INTO table (col1, col2) VALUES (val1, val2)
                            if (preg_match('/insert\s+into\s+`?\w+`?\s*\(([^)]+)\)\s*values\s*(.+)/is', $clean_sql, $insert_matches)) {
                                $cols_str = $insert_matches[1];
                                $vals_part = trim($insert_matches[2]);
                                
                                $existing_cols = array_map(function($c) {
                                    return trim($c, " \t\n\r\0\x0B`'");
                                }, explode(',', $cols_str));
                                
                                foreach ($required_fields as $f => $def) {
                                    if (!in_array($f, $existing_cols)) {
                                        $missing_fields[$f] = $def;
                                    }
                                }
                                
                                if (!empty($missing_fields)) {
                                    $append_cols = [];
                                    $append_vals = [];
                                    foreach ($missing_fields as $f => $def) {
                                        $append_cols[] = "`{$f}`";
                                        if (is_int($def) || is_float($def)) {
                                            $append_vals[] = $def;
                                        } else {
                                            $append_vals[] = "'" . addslashes($def) . "'";
                                        }
                                    }
                                    
                                    $new_cols_str = $cols_str . ", " . implode(', ', $append_cols);
                                    
                                    // 鲁棒解析并追加值，支持包含括号的字符串
                                    $new_vals_part = '';
                                    $len = strlen($vals_part);
                                    $in_string = false;
                                    $string_char = '';
                                    $bracket_depth = 0;
                                    $current_group = '';
                                    
                                    for ($i = 0; $i < $len; $i++) {
                                        $char = $vals_part[$i];
                                        if (($char === "'" || $char === '"') && ($i === 0 || $vals_part[$i - 1] !== '\\')) {
                                            if ($in_string && $string_char === $char) {
                                                $in_string = false;
                                            } elseif (!$in_string) {
                                                $in_string = true;
                                                $string_char = $char;
                                            }
                                        }
                                        
                                        if (!$in_string) {
                                            if ($char === '(') {
                                                $bracket_depth++;
                                                if ($bracket_depth === 1) {
                                                    $new_vals_part .= $char;
                                                    $current_group = '';
                                                    continue;
                                                }
                                            } elseif ($char === ')') {
                                                $bracket_depth--;
                                                if ($bracket_depth === 0) {
                                                    $new_vals_part .= $current_group . ", " . implode(', ', $append_vals) . $char;
                                                    continue;
                                                }
                                            }
                                        }
                                        
                                        if ($bracket_depth > 0) {
                                            $current_group .= $char;
                                        } else {
                                            $new_vals_part .= $char;
                                        }
                                    }
                                    
                                    $cols_pos = strpos($clean_sql, $cols_str);
                                    if ($cols_pos !== false) {
                                        $sql_replaced_cols = substr_replace($clean_sql, $new_cols_str, $cols_pos, strlen($cols_str));
                                        $vals_pos = strpos($sql_replaced_cols, $vals_part, $cols_pos + strlen($new_cols_str));
                                        if ($vals_pos !== false) {
                                            $clean_sql = substr_replace($sql_replaced_cols, $new_vals_part, $vals_pos, strlen($vals_part));
                                        } else {
                                            $clean_sql = $sql_replaced_cols;
                                        }
                                    }
                                }
                            }
                            // 格式 B：INSERT INTO table SET col1=val1, col2=val2
                            elseif (preg_match('/insert\s+into\s+`?\w+`?\s+set\s+(.+)/is', $clean_sql, $insert_matches)) {
                                $set_str = $insert_matches[1];
                                preg_match_all('/`?(\w+)`?\s*=/i', $set_str, $set_cols_matches);
                                $existing_cols = isset($set_cols_matches[1]) ? $set_cols_matches[1] : [];
                                
                                foreach ($required_fields as $f => $def) {
                                    if (!in_array($f, $existing_cols)) {
                                        $missing_fields[$f] = $def;
                                    }
                                }
                                
                                if (!empty($missing_fields)) {
                                    $append_sets = [];
                                    foreach ($missing_fields as $f => $def) {
                                        if (is_int($def) || is_float($def)) {
                                            $append_sets[] = "`{$f}`={$def}";
                                        } else {
                                            $append_sets[] = "`{$f}`='" . addslashes($def) . "'";
                                        }
                                    }
                                    $new_set_str = $set_str . ", " . implode(', ', $append_sets);
                                    $set_pos = strpos($clean_sql, $set_str);
                                    if ($set_pos !== false) {
                                        $clean_sql = substr_replace($clean_sql, $new_set_str, $set_pos, strlen($set_str));
                                    }
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    // 容错处理：获取字段结构失败时，直接使用原始 SQL 执行
                }
            }
        }

        // 自动将 NOW() 替换为 UNIX_TIMESTAMP() 容错，以适配 emlog 的整型时间戳字段
        $clean_sql = preg_replace('/\bNOW\(\)/i', 'UNIX_TIMESTAMP()', $clean_sql);

        // 5. 执行 SQL 语句，使用 @ 抑制可能抛出的 Warning 警告并设置第二个参数为 true 忽略直接报错退出
        $ret = @$db->query($clean_sql, true);
        if (!$ret) {
            $errorInfo = $db->geterror();
            $errorMsg = 'SQL执行失败';
            if (is_array($errorInfo)) {
                $errorMsg = isset($errorInfo[2]) ? $errorInfo[2] : (isset($errorInfo[0]) ? $errorInfo[0] : 'SQL执行失败');
            } elseif (is_string($errorInfo) && !empty($errorInfo)) {
                $errorMsg = $errorInfo;
            }
            throw new Exception("SQL执行错误: " . $errorMsg);
        }

        // 6. 执行成功后，如果是写操作，则强制刷新系统全部缓存与文章缓存
        if ($is_write_op) {
            $CACHE = Cache::getInstance();
            $CACHE->updateCache();        // 更新系统全局核心缓存
            $CACHE->updateArticleCache(); // 刷新文章与页面相关的关联缓存
        }

        // 7. 处理返回数据
        $results = [];
        if (!$is_write_op) {
            while ($row = $db->fetch_array($ret)) {
                $results[] = $row;
            }
        }

        return $results;
    }

    /**
     * 计算模糊重合得分
     * @param string $query 用户提问
     * @param string $text 目标对比文本
     * @return float 匹配相似度 (0 到 1 之间)
     */
    private static function getFuzzyScore($query, $text)
    {
        $queryClean = preg_replace('/[^\p{L}\p{N}]/u', '', mb_strtolower($query));
        $textClean = preg_replace('/[^\p{L}\p{N}]/u', '', mb_strtolower($text));
        if (empty($queryClean) || empty($textClean)) {
            return 0;
        }

        $queryChars = [];
        $len = mb_strlen($queryClean);
        for ($i = 0; $i < $len; $i++) {
            $queryChars[] = mb_substr($queryClean, $i, 1);
        }
        $queryChars = array_unique($queryChars);

        $hit = 0;
        foreach ($queryChars as $char) {
            if (mb_strpos($textClean, $char) !== false) {
                $hit++;
            }
        }

        return $hit / count($queryChars);
    }

    /**
     * Emlog 问题搜索与聚合 (优先匹配 FAQ 文档)
     * @param string $query 查询词
     * @return string 格式化的搜索结果上下文
     */
    public static function searchEmlog($query)
    {
        $faqContext = "";

        // 1. 优先抓取并解析官方 FAQ 页面
        // 使用核心封装的 EmCurl 方法读取官网 FAQ 页面（使用带斜杠的规范URL以避免301重定向）
        $emcurl = new EmCurl(8);
        $emcurl->request('https://www.emlog.net/docs/faq/');
        $faqHtml = '';
        if ($emcurl->getHttpStatus() === 200) {
            $faqHtml = $emcurl->getRespone();
        }
        if (!empty($faqHtml)) {
            $parts = preg_split('/<(h[23])\b[^>]*>/i', $faqHtml);
            $faqItems = [];

            for ($i = 1; $i < count($parts); $i++) {
                $part = $parts[$i];
                $headingEnd = strpos($part, '</h');
                if ($headingEnd === false) {
                    continue;
                }

                $heading = trim(strip_tags(substr($part, 0, $headingEnd)));
                // 清理 VitePress 锚点字符或特殊空白符
                $heading = preg_replace('/[#\x{200B}-\x{200D}]/u', '', $heading);
                $heading = trim($heading);

                $body = substr($part, $headingEnd);
                $bodyText = trim(strip_tags($body));
                $bodyText = preg_replace('/\s+/', ' ', $bodyText);
                $bodyText = mb_strimwidth($bodyText, 0, 500, '...');

                if (!empty($heading) && !empty($bodyText)) {
                    $score = self::getFuzzyScore($query, $heading);
                    if ($score >= 0.4) {
                        $faqItems[] = [
                            'question' => $heading,
                            'answer' => $bodyText,
                            'score' => $score
                        ];
                    }
                }
            }

            if (!empty($faqItems)) {
                // 按照匹配得分从高到低排序
                usort($faqItems, function($a, $b) {
                    return $b['score'] <=> $a['score'];
                });

                // 最多保留前 3 个最相关的 FAQ
                $topFaqs = array_slice($faqItems, 0, 3);
                $faqIndex = 1;
                foreach ($topFaqs as $faq) {
                    $faqContext .= "[官方 FAQ 匹配 - $faqIndex]\n";
                    $faqContext .= "标题 (问题): " . $faq['question'] . "\n";
                    $faqContext .= "链接 (参考): https://www.emlog.net/docs/faq#" . urlencode($faq['question']) . "\n";
                    $faqContext .= "解答内容: " . $faq['answer'] . "\n\n";
                    $faqIndex++;
                }
            }
        }

        // 2. 发起原来的 Bing 互联网检索作为补充
        $results = [];
        $q1 = "emlog.net " . $query;
        $q2 = "emlog " . $query;

        $queries = [$q1, $q2];
        foreach ($queries as $q) {
            $html = self::fetchSearchHtml('https://cn.bing.com/search?q=' . urlencode($q));
            if (empty($html)) {
                continue;
            }

            preg_match_all('/<li[^>]+class="[^"]*b_algo[^"]*"[^>]*>(.*?)<\/li>/is', $html, $blocks);
            if (empty($blocks[0])) {
                continue;
            }

            foreach ($blocks[0] as $block) {
                $url = '';
                $title = '';
                $snippet = '';

                if (preg_match('/<h2[^>]*>\s*<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>\s*<\/h2>/is', $block, $m)) {
                    $url = $m[1];
                    $title = trim(html_entity_decode(strip_tags($m[2])));
                }

                if (empty($url) || empty($title)) {
                    continue;
                }

                // 链接去重
                if (isset($results[$url])) {
                    continue;
                }

                if (preg_match('/<p[^>]*>(.*?)<\/p>/is', $block, $m)) {
                    $snippet = trim(html_entity_decode(strip_tags($m[1])));
                } else {
                    $snippet_html = preg_replace('/<h2[^>]*>.*?<\/h2>/is', '', $block);
                    $snippet = trim(html_entity_decode(strip_tags($snippet_html)));
                    $snippet = mb_strimwidth($snippet, 0, 300, '...');
                }
                $snippet = preg_replace('/\s+/', ' ', $snippet);

                $results[$url] = [
                    'title' => $title,
                    'snippet' => $snippet
                ];

                // 达到数量限制时提前退出
                if (count($results) >= 6) {
                    break 2;
                }
            }
        }

        // 3. 将 FAQ 匹配与 Bing 搜索结果整合
        $webContext = "";
        if (!empty($results)) {
            $index = 1;
            foreach ($results as $url => $item) {
                $webContext .= "[互联网搜索结果 - $index]\n";
                $webContext .= "标题: " . $item['title'] . "\n";
                $webContext .= "链接: " . $url . "\n";
                $webContext .= "摘要: " . $item['snippet'] . "\n\n";
                $index++;
            }
        }

        $finalContext = "";
        if (!empty($faqContext)) {
            $finalContext .= "=== 优先参考：Emlog 官方 FAQ ===\n" . $faqContext;
        }
        if (!empty($webContext)) {
            $finalContext .= "=== 补充参考：全网搜索结果 ===\n" . $webContext;
        }

        if (empty($finalContext)) {
            return "暂未搜索到相关的互联网参考资料。";
        }

        return $finalContext;
    }

    /**
     * 发起搜索网页抓取请求
     * @param string $url 搜索URL
     * @return string HTML内容
     */
    private static function fetchSearchHtml($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 8);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return '';
        }
        return $html;
    }

    /**
     * 修改 system config (config.php) 的特定常量配置项
     * 
     * @param string $key 配置常量键名
     * @param string $action 操作：add, update, delete
     * @param mixed $value 配置值
     * @return bool 修改成功返回 true
     * @throws Exception
     */
    public static function updateConfig($key, $action, $value = null)
    {
        $allowed_keys = [
            'ADMIN_PATH_CODE',
            'APP_UPLOAD_FORBID',
            'ENVIRONMENT',
            'UPLOAD_MAX_SIZE',
            'UPLOAD_ATT_TYPE',
            'USE_MYSQL_PDO',
            'UPLOAD_PATH_RELATIVE',
            'ARTICLE_AUTOSAVE_OFF',
            'SWITCH_TEMPLATE',
            'EMLOG_LANG'
        ];

        if (!in_array($key, $allowed_keys)) {
            throw new Exception("权限限制：只允许修改特定的配置项目");
        }

        if ($action !== 'delete') {
            if ($key === 'ADMIN_PATH_CODE') {
                if (!preg_match('/^[a-zA-Z0-9]{8,16}$/', $value)) {
                    throw new Exception("ADMIN_PATH_CODE 格式不正确，必须是8-16位的字母数字，不得包含特殊字符");
                }
            }
            if ($key === 'UPLOAD_MAX_SIZE') {
                if (!is_numeric($value) || intval($value) <= 0) {
                    throw new Exception("UPLOAD_MAX_SIZE 必须是大于0的整数");
                }
                $value = intval($value);
            }
            $bool_keys = ['APP_UPLOAD_FORBID', 'USE_MYSQL_PDO', 'UPLOAD_PATH_RELATIVE', 'ARTICLE_AUTOSAVE_OFF', 'SWITCH_TEMPLATE'];
            if (in_array($key, $bool_keys)) {
                if (is_string($value)) {
                    $val_lower = strtolower(trim($value));
                    if ($val_lower === 'true' || $val_lower === '1') {
                        $value = true;
                    } elseif ($val_lower === 'false' || $val_lower === '0') {
                        $value = false;
                    } else {
                        throw new Exception("{$key} 必须是布尔值（true 或 false）");
                    }
                } else {
                    $value = (bool)$value;
                }
            }
        }

        $config_file = EMLOG_ROOT . '/config.php';
        if (!file_exists($config_file)) {
            throw new Exception("配置文件 config.php 不存在");
        }

        if (!is_writable($config_file)) {
            throw new Exception("配置文件 config.php 不可写");
        }

        $content = file_get_contents($config_file);
        if ($content === false) {
            throw new Exception("读取配置文件 config.php 失败");
        }

        $formatted_value = '';
        if ($action !== 'delete') {
            if (is_bool($value)) {
                $formatted_value = $value ? 'true' : 'false';
            } elseif (is_int($value) || is_float($value)) {
                $formatted_value = $value;
            } else {
                $formatted_value = "'" . addslashes($value) . "'";
            }
        }

        $pattern = '/const\s+' . preg_quote($key, '/') . '\s*=\s*.*?;/i';
        $has_const = preg_match($pattern, $content);

        if ($action === 'delete') {
            if ($has_const) {
                $content = preg_replace('/const\s+' . preg_quote($key, '/') . '\s*=\s*.*?;[ \t]*\r?\n?/i', '', $content);
            }
        } else {
            $new_line = "const {$key} = {$formatted_value};";
            if ($has_const) {
                $content = preg_replace($pattern, $new_line, $content);
            } else {
                $content = rtrim($content);
                if (substr($content, -2) === '?>') {
                    $content = substr($content, 0, -2) . "\r\n" . $new_line . "\r\n?>";
                } else {
                    $content = $content . "\r\n" . $new_line . "\r\n";
                }
            }
        }

        if (file_put_contents($config_file, $content) === false) {
            throw new Exception("写入配置文件 config.php 失败");
        }

        return true;
    }
}
