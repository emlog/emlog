<?php

/**
 * Service: Util
 *
 * @package EMLOG
 * 
 */

class Util
{

    /**
     * Check if the application is running in development environment
     *
     * @return bool
     */
    public static function isDevEnv()
    {
        return Option::get('is_dev_mode') === 'y';
    }
}
