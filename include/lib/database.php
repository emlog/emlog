<?php
/**
 * Route database operations
 *
 * @package EMLOG
 */

class Database {

    public static function getInstance() {
        if (class_exists('mysqli', FALSE)) {
            return MySqlii::getInstance();
        } else {
/*vot*/     emMsg(lang('php_mysql_not_supported'));
        }
    }

}
