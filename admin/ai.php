<?php

/**
 * media
 * @package EMLOG
 * @link https://www.emlog.net
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
