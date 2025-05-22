<?php

/**
 * Service: Util
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Util
{

    /**
     * Check if the application is running in development environment
     */
    public static function isDevEnv()
    {
        return getenv('EMLOG_ENV') === 'develop' || (defined('ENVIRONMENT') && ENVIRONMENT === 'develop');
    }
}
