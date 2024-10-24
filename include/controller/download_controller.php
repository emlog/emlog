<?php

/**
 * Download Controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Download_Controller
{
    /**
     * @var User_Model
     */
    public $User_Model;
    /**
     * @var Media_Model
     */
    public $Media_Model;

    public $Cache;

    function index()
    {
        loginAuth::checkLogin();

        $this->Media_Model = new Media_Model();
        $resource_alias = Input::getStrVar('resource_alias');

        if (empty($resource_alias) || !preg_match('/^\w{16}$/', $resource_alias)) {
            show_404_page();
        }

        $r = $this->Media_Model->getDetailByAlias($resource_alias);
        if (!$this->isValidResource($r)) {
            show_404_page();
        }

        doAction('download_resource', $r);

        $this->Media_Model->incrDownloadCount($r['aid']);

        $this->download($r['filepath'], $r['filename'], BLOG_URL, getUA());
    }

    private function download($file_path, $file_name, $referer = '', $user_agent = '')
    {
        if (filter_var($file_path, FILTER_VALIDATE_URL)) {
            $file_url = $file_path;
            emDirect($file_url);
        } else {
            $file_url = EMLOG_ROOT . ltrim($file_path, '.');
        }
        $options = [
            'http' => [
                'header' => [
                    'Referer: ' . $referer,
                    'User-Agent: ' . $user_agent
                ]
            ]
        ];
        $context = stream_context_create($options);
        $file_content = file_get_contents($file_url, false, $context);
        if ($file_content === false) {
            show_404_page();
        }

        $mime_type = $this->getMimeTypeByExtension($file_name);

        // 防止输出缓存影响下载
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mime_type);
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($file_content));

        echo $file_content;
        exit;
    }

    private function getMimeTypeByExtension($file_name)
    {
        $extension = getFileSuffix($file_name);
        switch ($extension) {
            case 'zip':
                return 'application/zip';
            case 'rar':
                return 'application/x-rar-compressed';
            case '7z':
                return 'application/x-7z-compressed';
            case 'gz':
                return 'application/x-gzip';
            default:
                return 'application/octet-stream';
        }
    }

    private function isValidResource($resource)
    {
        $mime_type = $this->getMimeTypeByExtension($resource['filename']);
        return $resource && !empty($resource['filepath']) && in_array($mime_type, [
            'application/zip',
            'application/x-rar-compressed',
            'application/x-7z-compressed',
            'application/x-gzip'
        ]);
    }
}
