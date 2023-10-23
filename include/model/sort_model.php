<?php
/**
 * article sort model
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Sort_Model {

    private $db;
    private $table;
    private $table_blog;

    function __construct() {
        $this->table = DB_PREFIX . 'sort';
        $this->table_blog = DB_PREFIX . 'blog';
        $this->db = Database::getInstance();
    }

    function getSorts() {
        $sorts = [];
        $query = $this->db->query("SELECT * FROM $this->table ORDER BY pid ASC,taxis ASC");
        while ($row = $this->db->fetch_array($query)) {
            $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE sortid=" . $row['sid'] . " AND hide='n' AND checked='y' AND type='blog'");
            $logNum = $data['total'];
            $sortData = array(
                'lognum'      => $logNum,
                'sortname'    => htmlspecialchars($row['sortname']),
                'alias'       => $row['alias'],
                'description' => htmlspecialchars($row['description']),
                'kw'          => $row['kw'],
                'sid'         => (int)$row['sid'],
                'taxis'       => (int)$row['taxis'],
                'pid'         => (int)$row['pid'],
                'template'    => htmlspecialchars($row['template']),
            );
            if ($sortData['pid'] == 0) {
                $sortData['children'] = [];
            } elseif (isset($sorts[$row['pid']])) {
                $sorts[$row['pid']]['children'][] = $row['sid'];
            }
            $sorts[$row['sid']] = $sortData;
        }
        return $sorts;
    }

    function updateSort($sortData, $sid) {
        $Item = [];
        foreach ($sortData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update $this->table set $upStr where sid=$sid");
    }

    public function addSort($data) {
        $kItem = $dItem = [];
        foreach ($data as $key => $val) {
            $kItem[] = $key;
            $dItem[] = $val;
        }
        $field = implode(',', $kItem);
        $values = "'" . implode("','", $dItem) . "'";
        $this->db->query("INSERT INTO $this->table ($field) VALUES ($values)");
        return $this->db->insert_id();
    }

    function deleteSort($sid) {
        $this->db->query("update $this->table_blog set sortid=-1 where sortid=$sid");
        $this->db->query("update $this->table set pid=0 where pid=$sid");
        $this->db->query("DELETE FROM $this->table where sid=$sid");
    }

    function getOneSortById($sid) {
        $sql = "select * from $this->table where sid=$sid";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);
        $sortData = [];
        if ($row) {
            $sortData = array(
                'sortname'    => htmlspecialchars(trim($row['sortname'])),
                'alias'       => $row['alias'],
                'pid'         => $row['pid'],
                'description' => htmlspecialchars(trim($row['description'])),
                'template'    => !empty($row['template']) ? htmlspecialchars(trim($row['template'])) : 'log_list',
            );
        }
        return $sortData;
    }

    function getSortName($sid) {
        if ($sid > 0) {
            $res = $this->db->query("SELECT sortname FROM $this->table WHERE sid = $sid");
            $row = $this->db->fetch_array($res);
            $sortName = htmlspecialchars($row['sortname']);
        } else {
            $sortName = '未分类';
        }
        return $sortName;
    }
}
