<?php

/**
 * View control
 * @package EMLOG
 * 
 */

class View
{
    public static function getView($template, $ext = '.php')
    {
        if (strpos($template, '..') !== false) {
            emMsg('禁止包含主题外部文件');
        }
        if (!is_dir(TEMPLATE_PATH)) {
            emMsg('当前使用的模板已被删除或损坏，请登录后台更换其他模板。', BLOG_URL . 'admin/template.php');
        }
        return TEMPLATE_PATH . $template . $ext;
    }

    public static function getAdmView($template, $ext = '.php')
    {
        if (!is_dir(ADMIN_TEMPLATE_PATH)) {
            emMsg('后台模板已损坏', BLOG_URL);
        }
        return ADMIN_TEMPLATE_PATH . $template . $ext;
    }

    public static function isTplExist($template, $ext = '.php')
    {
        if (file_exists(TEMPLATE_PATH . $template . $ext)) {
            return true;
        }
        return false;
    }

    public static function output()
    {
        $content = ob_get_clean();
        ob_start();
        doAction('before_output_view', $content);
        echo $content;
        ob_end_flush();
        exit;
    }

    /**
     * 渲染无数据空状态 HTML
     *
     * @param string $title 主提示文案
     * @param string $desc 辅助说明文案（可选）
     * @param string $actionHtml 快捷操作按钮或链接 HTML（可选）
     * @param string $extraClass 额外的容器 class（可选）
     * @return string
     */
    public static function renderEmpty($title, $desc = '', $actionHtml = '', $extraClass = '')
    {
        $html = '<div class="em-empty-box' . ($extraClass ? ' ' . htmlspecialchars($extraClass, ENT_QUOTES, 'UTF-8') : '') . '">';
        if (!empty($title)) {
            $html .= '<div class="em-empty-title">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</div>';
        }
        if (!empty($desc)) {
            $html .= '<div class="em-empty-desc">' . htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') . '</div>';
        }
        if (!empty($actionHtml)) {
            $html .= '<div class="em-empty-action">' . $actionHtml . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * 渲染表格内的无数据空状态占位行 (tr > td[colspan])
     *
     * @param int $colspan 跨列数
     * @param string $title 主提示文案
     * @param string $desc 辅助说明文案（可选）
     * @param string $actionHtml 快捷操作按钮或链接 HTML（可选）
     * @return string
     */
    public static function renderEmptyTableRow($colspan, $title, $desc = '', $actionHtml = '')
    {
        $colspan = (int)$colspan;
        return '<tr><td colspan="' . $colspan . '" class="p-0 border-0">' . self::renderEmpty($title, $desc, $actionHtml) . '</td></tr>';
    }
}
