<?php

/**
 * log field model
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Log_Field_Model
{

    private $db;
    private $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'blog_fields';
    }

    public function addField($gid, $field_key, $field_value)
    {
        $query = "INSERT INTO %s (gid, field_key, field_value) VALUES (%d, '%s', '%s')";
        $this->db->query(sprintf($query, $this->table, $gid, $field_key, $field_value));
    }

    public function getFields($gid)
    {
        $query = "SELECT * FROM $this->table WHERE gid=$gid";
        return $this->db->fetch_all($query);
    }

    public function deleteField($gid)
    {
        $this->db->query("DELETE FROM $this->table WHERE gid=$gid");
    }
}
