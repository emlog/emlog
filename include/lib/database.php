<?php
/**
 * 数据库操作路由
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
            emMsg('服务器空间PHP不支持MySql数据库');
        }
    }

}
