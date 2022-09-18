<?php
/**
 * Data storage class
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class StorageType {
	/**
	 * String
	 */
	const STRING = "string";

	/**
	 * Number
	 */
	const NUMBER = "number";

	/**
	 * Boolean
	 */
	const BOOLEAN = "boolean";

	/**
	 * Array/object
	 */
	const ARRAY_OBJECT = "array";
}

class Storage {
	const API_VERSION = 1;

	/**
	 * Default data storage type
	 * @var string Default data storage type
	 */
	private static $default_storage_type = "string";

	/**
	 * Available data storage types
	 * @var array Available data storage types
	 */
	private static $available_storage_type = array("string", "number", "boolean", "array");

	/**
	 * The name of the currently called plugin
	 * @var string The name of the currently called plugin
	 */
	private $plugin_name = NULL;

	/**
	 * Database connection instance
	 * @var MySql Database connection instance
	 */
	private $db_conn = NULL;

	/**
	 * Constructor
	 * @param string $plugin_name Plug-in name
	 */
	private function __construct($plugin_name) {
		$this->plugin_name = $plugin_name;
		$this->db_conn = Database::getInstance();
	}

	/**
	 * Get Storage instance
	 * @param string $plugin_name Plug-in name
	 * @return Storage Storage Instance
	 */
	public static function getInstance($plugin_name) {
		$plugin_name = self::_filterPlugin($plugin_name);
		return new Storage($plugin_name);
	}

	/**
	 * Add/update data
	 * Create new data when the data to be updated does not exist
	 * When the data to be updated exists, the type and value of the data are updated at the same time
	 * @param string $name Data name
	 * @param mixed $value Data value
	 * @param string $type Data type
	 */
	public function setValue($name, $value = NULL, $type = NULL) {
		$name = $this->_filterName($name);
		$type = $this->_filterType($type);

		switch ($type) {
			case "number":
			case "string":
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
			$sql = "UPDATE " . DB_PREFIX . "storage SET ";
			$sql .= "`value` = '" . $this->db_conn->escape_string($db_value) . "', ";
			$sql .= "`type` = '{$type}', ";
			$sql .= "`lastupdate` = " . time() . " ";
			$sql .= "WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' ";
			$sql .= "AND `name` = '" . $this->db_conn->escape_string($name) . "'";

			$this->db_conn->query($sql);
		} else {
			$sql = "INSERT INTO " . DB_PREFIX . "storage (`plugin`, `name`, `type`, `value`, `createdate`, `lastupdate`) VALUES (";
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
	 * Update data
	 * Update the value of the data when the data to be updated exists
	 * FALSE is returned when the data to be updated does not exist
	 * @param string $name Data name
	 * @param string $value Data value
	 * @return bool Update result
	 */
	public function updateValue($name, $value = NULL) {
		$name = $this->_filterName($name);

		$sql = "SELECT `type` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);

		if ($result === FALSE) {
			return FALSE;
		} else {
			$type = $result['type'];
		}

		switch ($type) {
			case "number":
			case "string":
				$db_value = (string)$value;
				break;
			case "boolean":
				$db_value = (bool)$value === TRUE ? "TRUE" : "FALSE";
				break;
			case "array":
				$db_value = serialize($value);
				break;
		}

		$sql = "UPDATE " . DB_PREFIX . "storage SET ";
		$sql .= "`value` = '" . $this->db_conn->escape_string($db_value) . "', ";
		$sql .= "`lastupdate` = " . time() . " ";
		$sql .= "WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' ";
		$sql .= "AND `name` = '" . $this->db_conn->escape_string($name) . "'";

		$this->db_conn->query($sql);

		return TRUE;
	}

	/**
	 * Get data value
	 * When the data exists, return the value of the data (automatic type conversion)
	 * When the data does not exist, return FALSE
	 * @param string $name Data name
	 * @return mixed/FALSE Data value
	 */
	public function getValue($name) {
		$name = $this->_filterName($name);

		$sql = "SELECT `type`, `value` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);

		if (empty($result)) {
			return false;
		}

		$type = $result['type'];
		$value = $result['value'];

		switch ($type) {
			case "string":
				return (string)$value;
			case "number":
				return (float)$value;
			case "boolean":
				return $value === "TRUE";
			case "array":
				return unserialize($value);
		}
	}

	/**
	 * Get data type
	 * When data exists, return the type of data
	 * When the data does not exist, return FALSE
	 * @param string $name Data name
	 * @return string/FALSE Data value
	 */
	public function getType($name) {
		$name = $this->_filterName($name);

		$sql = "SELECT `type` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);

		if ($result === FALSE) {
			return FALSE;
		} else {
			return $result['type'];
		}
	}

	/**
	 * Get all data names
	 * Return all data names created by the current plugin
	 * @return array Data name array
	 */
	public function getAllName() {
		$names = [];
		$sql = "SELECT `name` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "'";
		$query = $this->db_conn->query($sql);
		while ($result = $this->db_conn->fetch_array($query)) {
			$names[] = $result['name'];
		}
		return $names;
	}

	/**
	 * Number of statistics
	 * Returns the amount of data created by the current plugin
	 * @return integer Number of data
	 */
	public function countStorage() {
		$sql = "SELECT count(`name`) as 'count' FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);
		return (int)$result['count'];
	}

	/**
	 * Check if the data exists
	 * @param string $name Data name
	 * @return bool Test result
	 */
	public function checkNameExist($name) {
		$name = $this->_filterName($name);

		$sql = "SELECT count(`name`) as 'count' FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);

		return ($result['count'] > 0);
	}

	/**
	 * Returns the creation time of the data
	 * Data existence is the timestamp of when the data was created
	 * FALSE if the data does not exist
	 * @param mixed $name Data name
	 * @return integer/FALSE Creation time
	 */
	public function getNameCreateDate($name) {
		$name = $this->_filterName($name);

		$sql = "SELECT `createdate` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);

		if ($result === FALSE) {
			return FALSE;
		} else {
			return $result['createdate'];
		}
	}

	/**
	 * Return the last edit time of the data
	 * Data existence is to return the timestamp of the last modification time of the data
	 * FALSE if the data does not exist
	 * @param mixed $name Data name
	 * @return integer/FALSE Edit time
	 */
	public function getNameLastUpdateDate($name) {
		$name = $this->_filterName($name);

		$sql = "SELECT `lastupdate` FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$result = $this->db_conn->once_fetch_array($sql);

		if ($result === FALSE) {
			return FALSE;
		} else {
			return $result['lastupdate'];
		}
	}

	/**
	 * Delete a data
	 * @param mixed $name Data name
	 */
	public function deleteName($name) {
		$name = $this->_filterName($name);

		$sql = "DELETE FROM " . DB_PREFIX . "storage WHERE `plugin` = '" . $this->db_conn->escape_string($this->plugin_name) . "' AND `name` = '" . $this->db_conn->escape_string($name) . "'";
		$this->db_conn->query($sql);
	}

	/**
	 * Delete all data created by this plugin
	 * @param mixed $confirm Please pass in uppercase "YES" to confirm deletion
	 * @return bool Deleting result
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
	 * Internal function: filter plug-in name
	 * @param string $plugin Plug-in name
	 * @return string Plug-in name
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
	 * Internal function: filter data name
	 * @param string $name Data name
	 * @return string Data name
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
	 * Internal function: filter Type name
	 * @param string $type Type name
	 * @return string Type name
	 */
	public function _filterType($type) {
		$type = strtolower(trim($type));

		if (!in_array($type, self::$available_storage_type)) {
			$type = self::$default_storage_type;
		}

		return $type;
	}
}
