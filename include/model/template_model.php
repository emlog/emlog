<?php

/**
 * Template model
 * @package EMLOG
 * 
 */

class Template_Model
{

    /**
     * 获取系统所有可用模板信息
     *
     * @return array
     */
    function getTemplates()
    {
        $nonce_template = Option::get('nonce_templet');

        $templates = [];
        $handle = @opendir(TPLS_PATH) or die('emlog template path error!');
        while ($file = @readdir($handle)) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir(TPLS_PATH . $file)) {
                continue;
            }
            if (!file_exists(TPLS_PATH . $file . '/header.php')) {
                continue;
            }
            $tplData = implode('', @file(TPLS_PATH . $file . '/header.php'));
            preg_match("/Template Name:(.*)/i", $tplData, $tplName);
            preg_match("/Template Url:(.*)/i", $tplData, $tplUrl);
            preg_match("/Version:(.*)/i", $tplData, $tplVersion);
            preg_match("/Author:(.*)/i", $tplData, $author);
            preg_match("/Description:(.*)/i", $tplData, $tplDes);
            preg_match("/Author Url:(.*)/i", $tplData, $authorUrl);
            $tplInfo = [
                'tplfile'       => $file,
                'tplname'       => !empty($tplName[1]) ? subString(strip_tags(trim($tplName[1])), 0, 16) : $file,
                'version'       => !empty($tplVersion[1]) ? subString(strip_tags(trim($tplVersion[1])), 0, 16) : '',
                'tplurl'        => !empty($tplUrl[1]) ? subString(strip_tags(trim($tplUrl[1])), 0, 75) : '',
                'tpldes'        => !empty($tplDes[1]) ? subString(strip_tags(trim($tplDes[1])), 0, 40) : '',
                'author'        => !empty($author[1]) ? subString(strip_tags(trim($author[1])), 0, 16) : '',
                'author_url'    => !empty($authorUrl[1]) ? subString(strip_tags(trim($authorUrl[1])), 0, 75) : '',
                'last_modified' => filemtime(TPLS_PATH . $file),
            ];

            $previewPath = TPLS_PATH . $file . '/preview.jpg';
            $tplInfo['preview'] = file_exists($previewPath) ? (TPLS_URL . $file . '/preview.jpg') : './views/images/theme.png';

            $templates[] = $tplInfo;
        }
        closedir($handle);

        // 按主题添加/修改时间倒序排序
        usort($templates, function ($a, $b) {
            return $b['last_modified'] - $a['last_modified'];
        });

        // 将正在使用的主题移动到第一位
        foreach ($templates as $k => $v) {
            if ($v['tplfile'] === $nonce_template) {
                unset($templates[$k]);
                array_unshift($templates, $v);
                break;
            }
        }
        return array_values($templates);
    }

    function getCustomTemplates($type)
    {
        $nonce_template = Option::get('nonce_templet') . '/';
        if (!is_dir(TPLS_PATH . $nonce_template)) {
            return false;
        }
        $files = scandir(TPLS_PATH . $nonce_template . '/');
        $php_files = [];
        foreach ($files as $file) {
            switch ($type) {
                case 'sort':
                    if (strpos($file, 'log_list_') === 0 && strpos($file, '.php') !== false) {
                        $php_files[] = [
                            'filename' => str_replace('.php', '', $file),
                            'comment'  => $this->getTemplateComment($file),
                        ];
                    }
                    break;
                case 'page':
                    if (strpos($file, 'page_') === 0 && strpos($file, '.php') !== false) {
                        $php_files[] = [
                            'filename' => str_replace('.php', '', $file),
                            'comment'  => $this->getTemplateComment($file),
                        ];
                    }
                    break;
                case 'log':
                    if (strpos($file, 'echo_log_') === 0 && strpos($file, '.php') !== false) {
                        $php_files[] = [
                            'filename' => str_replace('.php', '', $file),
                            'comment'  => $this->getTemplateComment($file),
                        ];
                    }
                    break;
            }
        }
        return $php_files;
    }

    function getCustomFields()
    {
        $nonce_template = Option::get('nonce_templet') . '/';
        if (!is_dir(TPLS_PATH . $nonce_template)) {
            return false;
        }

        $customFieldsPath = TPLS_PATH . $nonce_template . 'custom_fields.php';
        if (file_exists($customFieldsPath)) {
            include $customFieldsPath;
            if (isset($custom_fields)) {
                return $custom_fields;
            }
        }

        return [];
    }

    function getTemplateComment($filename)
    {
        $nonce_template = Option::get('nonce_templet') . '/';
        $comment = '';
        $file = fopen(TPLS_PATH . $nonce_template . $filename, 'rb');
        while (!feof($file)) {
            $line = fgets($file);
            if (strpos($line, "/*@name") !== false) {
                $start = strpos($line, "/*@name") + strlen("/*@name");
                $end = strpos($line, "*/", $start);
                $comment = trim(substr($line, $start, $end - $start));
                break;
            }
        }
        fclose($file);
        if (empty($comment)) {
            $comment = str_replace('.php', '', $filename);
        }
        return $comment;
    }

    // init callback
    public function initCallback($tplName)
    {
        $callback_file = "../content/templates/$tplName/callback.php";
        if (file_exists($callback_file)) {
            require_once $callback_file;
            if (function_exists('callback_init')) {
                callback_init();
            }
        }
    }

    // delete callback
    public function rmCallback($tplName)
    {
        $callback_file = "../content/templates/$tplName/callback.php";
        if (file_exists($callback_file)) {
            require_once $callback_file;
            if (function_exists('callback_rm')) {
                callback_rm();
            }
        }
    }

    // upgrade callback
    public function upCallback($tplName)
    {
        $callback_file = "../content/templates/$tplName/callback.php";
        if (file_exists($callback_file)) {
            require_once $callback_file;
            if (function_exists('callback_up')) {
                callback_up();
            }
        }
    }
}
