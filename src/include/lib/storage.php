<?php

/**
 * 数据存储接口 - 数据类型枚举
 */
class StorageType {
    /**
     * 字符串
     */
    const STRING = "string";

    /**
     * 数字
     */
    const NUMBER = "number";

    /**
     * 布尔
     */
    const BOOLEAN = "boolean";

    /**
     * 数组/对象
     */
    const ARRAY_OBJECT = "array";
}

class Storage {
    const API_VERSION = 1;

    /**
     * 默认数据数据存储类型
     * @var string 默认数据数据存储类型
     */
    private static $default_storage_type = "string";

    /**
     * 可用数据存储类型
     * @var array 可用数据存储类型
     */
    private static $available_storage_type = array("string", "number", "boolean", "array");

    /**
     * 当前调用的插件名
     * @var string 当前调用的插件名
     */
    private $plugin_name = NULL;

    /**
     * 数据库连接实例
     * @var MySql 数据库连接实例
     */
    private $db_conn = NULL;

    /**
     * 构造函数
     * @param string $plugin_name 插件名
     */
    private function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        $this->db_conn = Database::getInstance();
    }

    /**
     * 获取Storage实例
     * @param string $plugin_name 插件名
     * @return Storage Storage实例
     */
    public static function getInstance($plugin_name) {
        $plugin_name = self::_filterPlugin($plugin_name);
        return new Storage($plugin_name);
    }

    /**
     * 新增/更新数据
     * 当要更新的数据不存在时新建数据
     * 当要更新的数据存在时同时更新数据的类型和值
     * @param string $name 数据名称
     * @param mixed $value 数据值
     * @param string $type 数据类型
     */
    public function setValue($name, $value = NULL, $type = NULL) {
        $name = $this->_filterName($name);
        $type = $this->_filterType($type);

        switch ($type) {
            case "string":
                $db_value = (string)$value;
                break;
            case "number":
                $db_value = (string)$value;
                break;
            case "boolean":
                $db_value = ((bool)$value) === TRUE ? "TRUE" : "FALSE";
                break;
            case "array":
                $db_value = serialize($value);
                break;
        }

        if ($this->checkNameExist($name)) {
            $sql  = "UPDATE " . DB_PREFIX . "storage SET ";
            $sql .= "`value` = '" . $this->db_conn->escape_string($db_value) . "', ";
            $sql .= "`type` = '{$type}', ";
            $sql .= "`lastupdate` = " . time() . " ";
            $sql .= "WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' ";
            $sql .= "AND `name` = '" . $this->db_conn->escape_string($name) . "'";

            $this->db_conn->query($sql);
        }
        else {
            $sql  = "INSERT INTO " . DB_PREFIX . "storage (`plugin`, `name`, `type`, `value`, `createdate`, `lastupdate`) VALUE (";
            $sql .= "'" . $this->db_conn->escape_string($this->plugin_name) . "', ";
            $sql .= "'" . $this->db_conn->escape_string($name) . "', ";
            $sql .= "'{$type}', ";
            $sql .= "'" . $this->db_conn->escape_string($db_value) . "', ";
            $sql .= time() . ", ";
            $sql .= time() . ")";

            $this->db_conn->query($sql);
        }
    }

    /**
     * 更新数据
     * 当要更新的数据存在时更新数据的值
     * 当要更新的数据不存在时返回FALSE
     * @param string $name 数据名称
     * @param string $value 数据值
     * @return bool 更新结果
     */
    public function updateValue($name, $value = NULL) {
        $name = $this->_filterName($name);

        $sql = "SELECT `type` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);

        if ($result === FALSE) {
            return FALSE;
        }
        else {
            $type = $result['type'];
        }

        switch ($type) {
            case "string":
                $db_value = (string)$value;
                break;
            case "number":
                $db_value = (string)$value;
                break;
            case "boolean":
                $db_value = (bool)$value === TRUE ? "TRUE" : "FALSE";
                break;
            case "array":
                $db_value = serialize($value);
                break;
        }

        $sql  = "UPDATE " . DB_PREFIX . "storage SET ";
        $sql .= "`value` = '" . $this->db_conn->escape_string($db_value) . "', ";
        $sql .= "`lastupdate` = " . time() . " ";
        $sql .= "WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' ";
        $sql .= "AND `name` = '" . $this->db_conn->escape_string($name) . "'";

        $this->db_conn->query($sql);

        return TRUE;
    }

    /**
     * 获取数据的值
     * 当数据存在时，返回数据的值（自动类型转换）
     * 当数据不存在是，返回FALSE
     * @param string $name 数据名称
     * @return mixed/FALSE 数据值
     */
    public function getValue($name) {
        $name = $this->_filterName($name);

        $sql = "SELECT `type`, `value` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);

        if ($result === FALSE) {
            return FALSE;
        }

        $type = $result['type'];
        $value = $result['value'];

        switch ($type) {
            case "string":
                return (string)$value;
                break;
            case "number":
                return (float)$value;
                break;
            case "boolean":
                return $value === "TRUE";
                break;
            case "array":
                return unserialize($value);
                break;
        }
    }

    /**
     * 获取数据类型
     * 当数据存在时，返回数据的类型
     * 当数据不存在时，返回FALSE
     * @param string $name 数据名称
     * @return string/FALSE 数据值
     */
    public function getType($name) {
        $name = $this->_filterName($name);

        $sql = "SELECT `type` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);

        if ($result === FALSE) {
            return FALSE;
        }
        else {
            return $result['type'];
        }
    }

    /**
     * 获取所有数据名称
     * 返回当前插件创建的所有数据名称
     * @return array 数据名称
     */
    public function getAllName() {
        $names = array();
        $sql = "SELECT `name` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "'";
        $query = $this->db_conn->query($sql);
        while ($result = $this->db_conn->fetch_array($query)) {
            $names[] = $result['name'];
        }
        return $names;
    }

    /**
     * 统计数据数量
     * 返回当前插件创建的数据数量
     * @return integer 数据数量
     */
    public function countStorage() {
        $sql = "SELECT count(`name`) as 'count' FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);
        return (int)$result['count'];
    }

    /**
     * 检查数据是否存在
     * @param string $name 数据名称
     * @return bool 检查结果
     */
    public function checkNameExist($name) {
        $name = $this->_filterName($name);

        $sql = "SELECT count(`name`) as 'count' FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);

        return ($result['count'] > 0);
    }

    /**
     * 返回数据的创建时间
     * 数据存在是返回数据创建时间的时间戳
     * 数据不存在时返回FALSE
     * @param mixed $name 数据名称
     * @return integer/FALSE 创建时间
     */
    public function getNameCreateDate($name) {
        $name = $this->_filterName($name);

        $sql = "SELECT `createdate` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);

        if ($result === FALSE) {
            return FALSE;
        }
        else {
            return $result['createdate'];
        }
    }

    /**
     * 返回数据的最后修改时间
     * 数据存在是返回数据最后修改时间的时间戳
     * 数据不存在时返回FALSE
     * @param mixed $name 数据名称
     * @return integer/FALSE 修改时间
     */
    public function getNameLastUpdateDate($name) {
        $name = $this->_filterName($name);

        $sql = "SELECT `lastupdate` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $result = $this->db_conn->once_fetch_array($sql);

        if ($result === FALSE) {
            return FALSE;
        }
        else {
            return $result['lastupdate'];
        }
    }

    /**
     * 删除一个数据
     * @param mixed $name 数据名称
     */
    public function deleteName($name) {
        $name = $this->_filterName($name);

        $sql = "DELETE FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
        $this->db_conn->query($sql);
    }

    /**
     * 删除此插件创建的所有数据
     * @param mixed $confirm 请传入大写的"YES"来确认删除
     * @return mixed 删除结果
     */
    public function deleteAllName($confirm) {
        if ($confirm !== "YES") {
            return FALSE;
        }

        $sql = "DELETE FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "'";
        $this->db_conn->query($sql);
        return TRUE;
    }

    /**
     * 内部函数：过滤插件名
     * @param string $plugin 插件名
     * @return string 插件名
     */
    public static function _filterPlugin($plugin) {
        $plugin = trim($plugin);

        if (strlen($plugin) > 16) {
            $plugin = substr($plugin, 0, 16);
        }

        if (!preg_match("/^[\w_]+$/", $plugin)) {
            $plugin = "DefaultPlugin";
        }

        return $plugin;
    }

    /**
     * 内部函数：过滤数据名
     * @param string $plugin 数据名
     * @return string 数据名
     */
    public function _filterName($name) {
        $name = trim($name);

        if (strlen($name) > 16) {
            $name = substr($name, 0, 16);
        }

        if (!preg_match("/^[\w_]+$/", $name)) {
            $name = "DefaultName";
        }

        return $name;
    }

    /**
     * 内部函数：过滤类型名
     * @param string $plugin 类型名
     * @return string 类型名
     */
    public function _filterType($type) {
        $type = strtolower(trim($type));

        if (!in_array($type, self::$available_storage_type)) {
            $type = self::$default_storage_type;
        }

        return $type;
    }
}
