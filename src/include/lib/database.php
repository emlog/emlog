<?php
/**
 * Database operation routing
 *
 * @copyright (c) Emlog All Rights Reserved
 */

/*vot*/ load_language('database');

class Database {

    public static function getInstance() {
        switch (Option::DEFAULT_MYSQLCONN) {
            case 'mysqli':
                return MySqlii::getInstance();
                break;
            case 'mysql':
            default :
                return MySql::getInstance();
                break;
        }
    }

}
