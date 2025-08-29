<?php

/**
 * Service: AI
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Ai
{
    public static function chat($prompt, $system_prompt = '你是一个有用的助手')
    {
        $messages = [
            [
                "content" => $system_prompt,
                "role" => "system"
            ],
            [
                "content" => $prompt,
                "role" => "user"
            ]
        ];
        $response = self::send($messages);
        return self::formatResponse($response);
    }

    public static function chatStream($prompt, $system_prompt = '你是一个有用的助手')
    {
        $messages = [
            [
                "content" => $system_prompt,
                "role" => "system"
            ],
            [
                "content" => $prompt,
                "role" => "user"
            ]
        ];
        return self::sendStream($messages);
    }

    public static function sendStream($messages)
    {
        $modelInfo = self::getCurrentModelInfo();
        if (empty($modelInfo) || !isset($modelInfo['api_url'])) {
            echo "data: " . json_encode(["error" => "AI Model not configured"]) . "\n\n";
            return;
        }

        $apiUrl = $modelInfo['api_url'];
        $apiKey = $modelInfo['api_key'];
        $model = $modelInfo['model'];

        $post_data = json_encode([
            'messages' => $messages,
            'model' => $model,
            'stream' => true,
            'temperature' => 1,
            'max_tokens' => 2048
        ]);

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) {
            echo $data;
            ob_flush();
            flush();
            return strlen($data);
        });

        curl_exec($ch);
        if (curl_errno($ch)) {
            echo "data: [ERROR] " . curl_error($ch) . "\n\n";
        }

        curl_close($ch);
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
            'max_tokens' => 2048,
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
}
