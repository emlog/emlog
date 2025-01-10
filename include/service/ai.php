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
        if ($modelInfo === null || !isset($modelInfo['api_url'])) {
            echo "data: " . json_encode(["error" => "AI 模型未配置"]) . "\n\n";
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false); // Disable full response buffering
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

        $emcurl = new EmCurl(10);
        $post_data = json_encode([
            'messages' => $messages,
            'model' => $model,
            'frequency_penalty' => 0,
            'max_tokens' => 2048,
            'presence_penalty' => 0,
            'response_format' => ['type' => 'text'],
            'stream' => false,
            'temperature' => 1,
            'top_p' => 1,
            'tool_choice' => 'none',
            'logprobs' => false,
            //'stop' => '',
            //'stream_options' => null,
            //'tools' => null,
            //'top_logprobs' => null
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

    public static function getCurrentModelInfo()
    {
        $currentModel = Option::get('ai_model');
        $aiModels = json_decode(Option::get('ai_models'), true);

        if (isset($aiModels[$currentModel])) {
            return $aiModels[$currentModel];
        }

        return null;
    }
}
