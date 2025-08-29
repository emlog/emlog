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
 * 生成图像并保存到本地媒体库
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
    
    // 下载并保存图像到本地
    $localPath = '';
    try {
        // 下载图像
        $imageData = file_get_contents($imageUrl);
        if ($imageData === false) {
            Output::error('下载生成的图像失败');
        }
        
        // 生成文件名和路径
        $extension = 'png'; // 默认为PNG格式
        $fileName = 'ai_generated_' . time() . '_' . substr(md5($prompt), 0, 8) . '.' . $extension;
        $uploadPath = Option::UPLOADFILE_PATH . 'ai_images/';
        $uploadFullPath = Option::UPLOADFILE_FULL_PATH . 'ai_images/';
        
        // 确保目录存在
        if (!createDirectoryIfNeeded($uploadFullPath)) {
            Output::error('创建AI图像保存目录失败');
        }
        
        $filePath = $uploadPath . $fileName;
        $fullFilePath = $uploadFullPath . $fileName;
        
        // 保存文件
        if (file_put_contents($fullFilePath, $imageData) === false) {
            Output::error('保存AI生成图像失败');
        }
        
        // 获取图像信息
        $fileSize = filesize($fullFilePath);
        $imageInfo = getimagesize($fullFilePath);
        $width = $imageInfo ? $imageInfo[0] : 0;
        $height = $imageInfo ? $imageInfo[1] : 0;
        $mimeType = $imageInfo ? $imageInfo['mime'] : 'image/png';
        
        // 构建文件信息数组
        $fileInfo = array(
            'file_name' => $fileName,
            'size' => $fileSize,
            'file_path' => $filePath,
            'mime_type' => $mimeType,
            'width' => $width,
            'height' => $height
        );
        
        // 添加到媒体库
        $Media_Model = new Media_Model();
        $mediaId = $Media_Model->addMedia($fileInfo, 0, UID);
        
        if ($mediaId) {
            $localPath = $filePath;
            // 返回成功结果，包含本地路径信息
            $result['local_path'] = $localPath;
            $result['media_id'] = $mediaId;
            $result['file_url'] = getFileUrl($filePath);
        }
        
    } catch (Exception $e) {
        // 如果保存失败，仍然返回原始结果，但不包含本地路径
        error_log('AI图像保存失败: ' . $e->getMessage());
    }
    
    Output::ok($result);
}
