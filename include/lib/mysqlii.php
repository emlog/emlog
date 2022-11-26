<?php
/**
 * MySQLi Database Class
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class MySqlii {

	/**
	 * 查询次数
	 * @var int
	 */
	private $queryCount = 0;

	/**
	 * 内部数据连接对象
	 * @var mysqli
	 */
	private $conn;

	/**
	 * 内部数据结果
	 * @var mysqli_result
	 */
	private $result;

	/**
	 * 内部实例对象
	 * @var object MySql
	 */
	private static $instance = null;

	private function __construct() {
		if (!class_exists('mysqli')) {
			emMsg('服务器PHP不支持mysqli函数');
		}

		@$this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
		if ($this->conn->connect_error) {
			switch ($this->conn->connect_errno) {
				case 1044:
				case 1045:
					emMsg("连接MySQL数据库失败，数据库用户名或密码错误");
					break;
				case 1049:
					emMsg("连接MySQL数据库失败，未找到你填写的数据库");
					break;
				case 2003:
				case 2005:
				case 2006:
					emMsg("连接MySQL数据库失败，数据库地址错误或者数据库服务器不可用");
					break;
				default :
					emMsg("连接MySQL数据库失败，请检查数据库信息。错误信息：" . $this->conn->connect_error);
					break;
			}
		}

		$this->conn->set_charset('utf8mb4');
	}

	/**
	 * 静态方法，返回数据库连接实例
	 */
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new MySqlii();
		}

		return self::$instance;
	}

	/**
	 * 关闭数据库连接
	 */
	function close() {
		return $this->conn->close();
	}

	/**
	 * 发送查询语句
	 */
	function query($sql, $ignore_err = FALSE) {
		$this->result = $this->conn->query($sql);
		$this->queryCount++;
		if (!$ignore_err && 1046 == $this->geterrno()) {
			emMsg("连接数据库失败，请填写数据库名");
		}
		if (!$ignore_err && 1286 == $this->geterrno()) {
			emMsg("数据库不支持InnoDB引擎，建议使用MySQL5.6或更高版本");
		}
		if (!$ignore_err && !$this->result) {
			emMsg("SQL执行错误: $sql<br /><br />" . $this->geterror());
		} else {
			return $this->result;
		}
	}

	/**
	 * 从结果集中取得一行作为关联数组/数字索引数组
	 */
	function fetch_array(mysqli_result $query, $type = MYSQLI_ASSOC) {
		return $query->fetch_array($type);
	}

	function once_fetch_array($sql) {
		$this->result = $this->query($sql);
		return $this->fetch_array($this->result);
	}

	/**
	 * 从结果集中取得一行作为数字索引数组
	 */
	function fetch_row(mysqli_result $query) {
		return $query->fetch_row();
	}

	/**
	 * 取得行的数目
	 *
	 */
	function num_rows(mysqli_result $query) {
		return $query->num_rows;
	}

	/**
	 * 取得结果集中字段的数目
	 */
	function num_fields(mysqli_result $query) {
		return $query->field_count;
	}

	/**
	 * 取得上一步 INSERT 操作产生的 ID
	 */
	function insert_id() {
		return $this->conn->insert_id;
	}

	/**
	 * 获取mysql错误
	 */
	function geterror() {
		return $this->conn->error;
	}

	/**
	 * 获取mysql错误编码
	 */
	function geterrno() {
		return $this->conn->errno;
	}

	/**
	 * Get number of affected rows in previous MySQL operation
	 */
	function affected_rows() {
		return $this->conn->affected_rows;
	}

	/**
	 * 取得数据库版本信息
	 */
	function getMysqlVersion() {
		return $this->conn->server_info;
	}

	/**
	 * 取得数据库查询次数
	 */
	function getQueryCount() {
		return $this->queryCount;
	}

	/**
	 *  Escapes special characters
	 */
	function escape_string($sql) {
		return $this->conn->real_escape_string($sql);
	}
}
