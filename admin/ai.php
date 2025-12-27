<?php

/**
 * media
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action == 'chat') {
    $message = Input::postStrVar('message');
    $r = Ai::chat($message);
    Output::ok($r);
}

if ($action == 'chat_stream') {
    $message = Input::getStrVar('message');

    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');

    Ai::chatStream($message);
    exit;
}

if ($action == 'genBio') {
    $prompt = '从名言、歌词、电影台词、小说、诗词、名人名言中找出一句话，作为你的个性签名，避免输出引号、冒号等任何提示性内容。';
    $r = Ai::chat($prompt);
    Output::ok($r);
}

if ($action == 'genReply') {
    $comment = Input::postStrVar('comment');
    $prompt = $comment . '。=== 请礼貌而专业的回复 === 前面这段用户评论，避免输出任何提示性内容。';
    $r = Ai::chat($prompt);
    Output::ok($r);
}

/**
 * AI图像生成功能
 * 生成图像并保存到媒体库（兼容云存储插件）
 */
if ($action == 'generate_image') {
    $prompt = Input::postStrVar('prompt');
    $size = Input::postStrVar('size', '1024x1024');
    $quality = Input::postStrVar('quality', 'standard');

    // 调用封装的AI图像生成和保存方法
    $options = array(
        'size' => $size,
        'quality' => $quality
    );

    $result = Ai::generateImageAndSave($prompt, $options);

    // 检查结果并返回
    if (isset($result['error'])) {
        Output::error($result['error']);
    }

    Output::ok($result);
}
