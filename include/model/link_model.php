<?php

/**
 * links model
 * @package EMLOG
 * 
 */

class Link_Model
{

    private $db;
    private $table;

    /**
     * 构造函数，初始化数据库连接与表名
     */
    function __construct()
    {
        $this->db = Database::getInstance();
        $this->table = DB_PREFIX . 'link';
    }

    /**
     * 获取所有友情链接列表
     *
     * @return array
     */
    function getLinks()
    {
        $res = $this->db->query("SELECT * FROM $this->table ORDER BY taxis ASC");
        $links = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['sitename'] = htmlspecialchars($row['sitename']);
            $row['description'] = htmlClean($row['description'], false);
            $row['rss'] = isset($row['rss']) ? htmlspecialchars($row['rss']) : '';
            $links[] = $row;
        }
        return $links;
    }

    /**
     * 更新指定友情链接
     *
     * @param array $linkData
     * @param int $linkId
     * @return void
     */
    function updateLink($linkData, $linkId)
    {
        $Item = [];
        foreach ($linkData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update $this->table set $upStr where id=$linkId");
    }

    /**
     * 添加友情链接
     *
     * @param array $logData
     * @return int
     */
    public function addLink($logData)
    {
        $kItem = $dItem = [];
        foreach ($logData as $key => $data) {
            $kItem[] = $key;
            $dItem[] = $data;
        }
        $field = implode(',', $kItem);
        $values = "'" . implode("','", $dItem) . "'";
        $this->db->query("INSERT INTO $this->table ($field) VALUES ($values)");
        return $this->db->insert_id();
    }

    /**
     * 删除指定友情链接
     *
     * @param int $linkId
     * @return void
     */
    function deleteLink($linkId)
    {
        $this->db->query("DELETE FROM $this->table where id=$linkId");
    }
}
