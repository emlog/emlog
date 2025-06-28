<?php

/**
 * Service: Template
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Template
{

    public static function isActive($template_alias)
    {
        $nonce_template = Option::get('nonce_templet');
        if (empty($nonce_template) || empty($template_alias)) {
            return false;
        }
        if ($template_alias === $nonce_template) {
            return true;
        }
        return false;
    }
}
