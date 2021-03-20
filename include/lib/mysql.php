<?php
/**
 * 数据库操作路由 (仅仅兼容旧的插件，不推荐使用)
 *
 * @package EMLOG (www.emlog.net)
 */

class MySql {

    public static function getInstance() {
        if (class_exists('mysql2i', FALSE)) {
            return MySqlii::getInstance();
        } else {
            emMsg('服务器空间PHP不支持MySql数据库');
        }
    }

}
