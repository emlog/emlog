<?php

/**
 * Database operation routing
 *
 * @package EMLOG
 * 
 */

class Database
{

    public static function getInstance()
    {
        if (defined('USE_MYSQL_PDO') && USE_MYSQL_PDO === true) {
            if (class_exists('pdo', false)) {
                return DatabasePDO::getInstance();
            } else {
                emMsg('服务器PHP未启用PDO扩展。');
            }
        } else {
            if (class_exists('mysqli', FALSE)) {
                return MySqlii::getInstance();
            }

            if (class_exists('pdo', false)) {
                return DatabasePDO::getInstance();
            }

            emMsg('服务器PHP不支持MySQL数据库扩展。');
        }
    }
}
