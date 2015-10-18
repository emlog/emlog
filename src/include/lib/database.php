<?php
/**
 * Route database operations
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Database {

    public static function getInstance() {
        if (class_exists('mysqli', FALSE)) {
            return MySqlii::getInstance();
        }
        else if (class_exists('mysql', FALSE)) {
            return MySql::getInstance();
        }
        else {
/*vot*/     emMsg(lang('php_mysql_not_supported'));
        }
    }

}
