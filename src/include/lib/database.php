<?php
/**
 * 数据库操作路由
 *
 * @copyright (c) Emlog All Rights Reserved
 */

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
