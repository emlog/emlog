<?php
/**
 * MySQL数据库操作类-PDO  兼容接口
 * For PHPv7 
 * @copyright (c) DXkite All Rights Reserved
 */

// 兼容MySQL PHP<7
defined ('MYSQL_ASSOC') or define('MYSQL_ASSOC' ,PDO::FETCH_ASSOC);
defined ('MYSQL_BOTH') or define('MYSQL_BOTH' ,PDO::FETCH_BOTH);
defined ('MYSQL_NUM') or define('MYSQL_NUM' ,PDO::FETCH_NUM);

class MySql {
    /**
    * PDO对象
    * @var object
    */
    private $pdo=null;
    private $stmt=null;

    /**
     * 查询次数
     * @var int
     */
    private $queryCount = 0;
    /**
     * 内部实例对象
     * @var object MySql
     */
    private static $instance = null;

    private function __construct() {
        try {
            $this->pdo=new PDO('mysql:dbname='.DB_NAME.';dbhost='.DB_HOST,DB_USER,DB_PASSWD);
        } catch (PDOException $e) {
            switch ($e->getCode()) {
                 case 2005:
                    emMsg("连接数据库失败，数据库地址错误或者数据库服务器不可用");
                    break;
                case 2003:
                    emMsg("连接数据库失败，数据库端口错误");
                    break;
                case 2006:
                    emMsg("连接数据库失败，数据库服务器不可用");
                    break;
                case 1045:
                    emMsg("连接数据库失败，数据库用户名或密码错误");
                    break;
                default :
                    emMsg("连接数据库失败，请检查数据库信息。错误编号：". $e->getCode());
                    break;
            }
        }
    }

    /**
     * 静态方法，返回数据库连接实例
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new MySql();
        }
        return self::$instance;
    }

    /**
     * 关闭数据库连接
     */
    function close() {
        $this->pdo=null;
        return true;
    }

    /**
     * 发送查询语句
     *
     */
    function query($sql, $ignore_err = FALSE) {
        $this->stmt =$this->pdo->query($sql);
        $this->queryCount++;
        return $this->stmt;
        /*
        if (!$ignore_err && !$this->result) {
            emMsg("SQL语句执行错误：$sql <br />" . $this->geterror());
        }else {
            return $this->result;
        }*/
    }

    /**
     * 从结果集中取得一行作为关联数组/数字索引数组
     *
     */
    function fetch_array($query , $type = MYSQL_ASSOC) {
        return $this->stmt->fetch($type);
    }

    function once_fetch_array($sql) {
        $this->query($sql);
        return $this->fetch_array(null);
    }

    /**
     * 从结果集中取得一行作为数字索引数组
     *
     */
    function fetch_row($query) {
        return $this->stmt->fetch(PDO::FETCH_NUM);
    }

    /**
     * 取得行的数目
     *
     */
    function num_rows($query) {
        //return mysql_num_rows($query);
        return $this->stmt->rowCount();
    }

    /**
     * 取得结果集中字段的数目
     */
    function num_fields($query) {
        //return mysql_num_fields($query);
        return $this->stmt->columnCount();
    }
    /**
     * 取得上一步 INSERT 操作产生的 ID
     */
    function insert_id() {
        return $this->pdo->lastInsertId();
    }

    /**
     * 获取mysql错误
     */
    function geterror() {
        return $this->stmt->errorInfo();
    }

    /**
     * 获取mysql错误编码
     */
    function geterrno() {
        return $this->stmt->errorCode();
    }

    /**
     * Get number of affected rows in previous MySQL operation
     */
    function affected_rows() {
        return $this->stmt->rowCount();
        //return mysql_affected_rows();
    }

    /**
     * 取得数据库版本信息
     */
    function getMysqlVersion() {
        return  $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    /**
     * 取得数据库查询次数
     */
    function getQueryCount() {
        return $this->queryCount;
    }

    /**
     *  notice  :PDO中无需这个，被废弃了 
     *  这里用QOUTE方法代替 
     *  Escapes special characters
     */
    function escape_string($sql) {
        return $this->pdo->quote($sql);
        ///return mysql_real_escape_string($sql);
    }
}
