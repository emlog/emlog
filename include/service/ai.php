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
                'content' => $prompt
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
                'content' => $prompt
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
                '/\b(from|join|update|into|truncate(?:\s+table)?|table)\s+`?' . preg_quote($tbl, '/') . '`?\b/i',
                '$1 `' . DB_PREFIX . $tbl . '`',
                $clean_sql
            );
        }

        // 5. 执行 SQL 语句
        $ret = $db->query($clean_sql);
        if (!$ret) {
            throw new Exception("SQL执行失败");
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
}
