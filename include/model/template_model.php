<?php
/**
 * Template model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Template_Model {

    function getTemplates() {
        $nonce_template = Option::get('nonce_templet');

        $templates = [];
        $handle = @opendir(TPLS_PATH) or die('emlog template path error!');
        $i = 1;
        while ($file = @readdir($handle)) {
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
                'tplfile'    => $file,
                'tplname'    => !empty($tplName[1]) ? subString(strip_tags(trim($tplName[1])), 0, 16) : $file,
                'version'    => !empty($tplVersion[1]) ? subString(strip_tags(trim($tplVersion[1])), 0, 16) : '',
                'tplurl'     => !empty($tplUrl[1]) ? subString(strip_tags(trim($tplUrl[1])), 0, 75) : '',
                'tpldes'     => !empty($tplDes[1]) ? subString(strip_tags(trim($tplDes[1])), 0, 40) : '',
                'author'     => !empty($author[1]) ? subString(strip_tags(trim($author[1])), 0, 16) : '',
                'author_url' => !empty($authorUrl[1]) ? subString(strip_tags(trim($authorUrl[1])), 0, 75) : '',
            ];

            if ($nonce_template === $file) {
                $templates[0] = $tplInfo;
            } else {
                $templates[$i] = $tplInfo;
            }
            $i++;
        }
        ksort($templates);
        closedir($handle);
        return $templates;
    }

    function getCustomTemplates($type) {
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
            }
        }
        return $php_files;
    }

    function getTemplateComment($filename) {
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

}
