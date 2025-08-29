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

/**
 * AI图像生成功能
 * 生成图像并保存到媒体库（兼容云存储插件）
 */
if ($action == 'generate_image') {
    $prompt = Input::postStrVar('prompt');
    $size = Input::postStrVar('size', '1024x1024');
    $quality = Input::postStrVar('quality', 'standard');

    // 验证输入参数
    if (empty($prompt)) {
        Output::error('请输入图像描述提示词');
    }

    // 调用AI图像生成服务
    $options = array(
        'size' => $size,
        'quality' => $quality,
        'n' => 1
    );

    $result = Ai::generateImage($prompt, $options);

    // 检查生成结果
    if (isset($result['error'])) {
        Output::error($result['error']);
    }

    if (!isset($result['data']) || empty($result['data'])) {
        Output::error('图像生成失败，未返回有效数据');
    }

    $imageUrl = $result['data'][0]['url'];
    if (empty($imageUrl)) {
        Output::error('图像生成失败，未获取到图像URL');
    }

    // 下载图像数据
    $imageData = file_get_contents($imageUrl);
    if ($imageData === false) {
        Output::error('下载生成的图像失败');
    }

    // 生成临时文件来模拟文件上传
    $extension = 'png';
    $fileName = substr(md5($imageUrl), 0, 4) . time() . '.' . $extension;
    $tmpFile = sys_get_temp_dir() . '/' . $fileName;

    // 使用upload2local方法上传图片，先创建临时文件
    if (file_put_contents($tmpFile, $imageData) === false) {
        Output::error('创建临时文件失败');
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
        $uploadResult = [
            'success' => 0,
            'message' => '上传失败',
            'url' => '',
            'file_info' => [],
        ];
    }

    // 清理临时文件
    if (file_exists($tmpFile)) {
        unlink($tmpFile);
    }

    // 检查上传结果
    if (empty($uploadResult['success'])) {
        Output::error($uploadResult['message'] ?: '图像保存失败');
    }

    // 添加到媒体库
    $Media_Model = new Media_Model();
    $mediaId = $Media_Model->addMedia($uploadResult['file_info']);

    if ($mediaId) {
        // 返回成功结果
        $result['media_id'] = $mediaId;
        $result['file_url'] = $uploadResult['url'];
        $result['local_path'] = $uploadResult['file_info']['file_path'];
        $result['message'] = '图像生成并保存成功';
    } else {
        Output::error('添加到媒体库失败');
    }
    Output::ok($result);
}
