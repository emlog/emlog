<?php
/**
 * Database operation routing
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Database {

    public static function getInstance() {

        $db_type = getenv('EMLOG_DB_TYPE');
        if ($db_type === 'sqlite') {
            return DatabasePDO::getInstance('sqlite');
        }

        if (class_exists('mysqli', FALSE)) {
            return MySqlii::getInstance();
        }

        if (class_exists('pdo', false)) {
            return DatabasePDO::getInstance();
        }

        emMsg('服务器PHP不支持MySQL数据库');
    }

}
