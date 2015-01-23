<?php
/**
 * Model: Blog Categories
 * @copyright (c) Emlog All Rights Reserved
 */

class Sort_Model {

    private $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    function getSorts() {
        $res = $this->db->query("SELECT * FROM ".DB_PREFIX."sort ORDER BY taxis ASC");
        $sorts = array();
        while($row = $this->db->fetch_array($res)) {
            $row['sortname'] = htmlspecialchars($row['sortname']);
            $sorts[] = $row;
        }
        return $sorts;
    }

    function updateSort($sortData, $sid) {
        $Item = array();
        foreach ($sortData as $key => $data) {
            $Item[] = "$key='$data'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update ".DB_PREFIX."sort set $upStr where sid=$sid");
    }

    function addSort($name, $alias, $taxis, $pid, $description, $template) {
        $sql="insert into ".DB_PREFIX."sort (sortname,alias,taxis,pid,description,template) values('$name','$alias',$taxis,$pid,'$description', '$template')";
        $this->db->query($sql);
    }

    function deleteSort($sid) {
        $this->db->query("update ".DB_PREFIX."blog set sortid=-1 where sortid=$sid");
        $this->db->query("update ".DB_PREFIX."sort set pid=0 where pid=$sid");
        $this->db->query("DELETE FROM ".DB_PREFIX."sort where sid=$sid");
    }

    function getOneSortById($sid) {
        $sql = "select * from ".DB_PREFIX."sort where sid=$sid";
        $res = $this->db->query($sql);
        $row = $this->db->fetch_array($res);
        $sortData = array();
        if ($row) {
            $sortData = array(
                    'sortname' => htmlspecialchars(trim($row['sortname'])),
                    'alias' => $row['alias'],
                    'pid' => $row['pid'],
                    'description' => htmlspecialchars(trim($row['description'])),
                    'template' => !empty($row['template']) ? htmlspecialchars(trim($row['template'])) : 'log_list',
            );
        }
        return $sortData;
    }

    function getSortName($sid) {
        if ($sid > 0) {
            $res = $this->db->query("SELECT sortname FROM ". DB_PREFIX ."sort WHERE sid = $sid");
            $row = $this->db->fetch_array($res);
            $sortName = htmlspecialchars($row['sortname']);
        } else {
/*vot*/     $sortName = lang('uncategorized');
        }
        return $sortName;
    }
}
