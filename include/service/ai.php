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

    private static function formatResponse($response)
    {
        $decodedResponse = json_decode($response, true);
        if (isset($decodedResponse['choices'][0]['message']['content'])) {
            return $decodedResponse['choices'][0]['message']['content'];
        }
        return '大模型处理异常，请稍后再试，错误信息：' . $response;
    }

    public static function send($messages)
    {
        $apiUrl = Option::get('ai_api_url');
        $apiKey = Option::get('ai_api_key');
        $model = Option::get('ai_model');

        $emcurl = new EmCurl(10);
        $post_data = json_encode([
            'messages' => $messages,
            'model' => $model,
            'frequency_penalty' => 0,
            'max_tokens' => 2048,
            'presence_penalty' => 0,
            'response_format' => ['type' => 'text'],
            'stop' => null,
            'stream' => false,
            'stream_options' => null,
            'temperature' => 1,
            'top_p' => 1,
            'tools' => null,
            'tool_choice' => 'none',
            'logprobs' => false,
            'top_logprobs' => null
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
}
