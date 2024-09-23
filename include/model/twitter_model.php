<?php

/**
 * notes model
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Twitter_Model
{

    private $db;
    private $parsedown;
    private $table;

    function __construct()
    {
        $this->db = Database::getInstance();
        $this->parsedown = new Parsedown();
        $this->table = DB_PREFIX . 'twitter';
    }

    function addTwitter($tData)
    {
        $kItem = [];
        $dItem = [];
        foreach ($tData as $key => $data) {
            $kItem[] = $key;
            $dItem[] = $data;
        }
        $field = implode(',', $kItem);
        $values = "'" . implode("','", $dItem) . "'";
        $this->db->query("INSERT INTO $this->table ($field) VALUES ($values)");
        return $this->db->insert_id();
    }

    function update($data, $id)
    {
        $Item = [];
        foreach ($data as $key => $value) {
            $Item[] = "$key='$value'";
        }
        $upStr = implode(',', $Item);
        $this->db->query("update $this->table set $upStr where id=$id");
    }

    function getCount($uid = UID)
    {
        $author = $uid ? 'and author=' . $uid : '';
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM $this->table WHERE 1=1 $author");
        return $data['total'];
    }

    /**
     * 获取微语
     * @param int $uid 用户ID
     * @param int $page 页码
     * @param int $perpage_num 每页数量
     * @param bool $private 是否返回私密微语
     * @return array
     */
    function getTwitters($uid, $page = 1, $perpage_num = 20, $private = false)
    {
        $start_limit = !empty($page) ? ($page - 1) * $perpage_num : 0;
        $author = $uid ? 'and author=' . $uid : '';
        $privateCondition = $private ? '' : 'AND private="n"';
        $limit = "LIMIT $start_limit, $perpage_num";
        $sql = "SELECT * FROM $this->table WHERE 1=1 $author $privateCondition ORDER BY id DESC $limit";
        $res = $this->db->query($sql);
        $tws = [];
        while ($row = $this->db->fetch_array($res)) {
            $row['t'] = $this->parsedown->text($row['content']);
            $row['t_raw'] = $row['content'];
            $row['t_img'] = getFirstImage($row['content']);
            $row['date'] = smartDate($row['date']);
            $tws[] = $row;
        }
        return $tws;
    }

    function delTwitter($tid)
    {
        $author = User::haveEditPermission() ? '' : 'and author=' . UID;
        $query = $this->db->query("select img from $this->table where id=$tid $author");
        $row = $this->db->fetch_array($query);

        // del tw
        $this->db->query("DELETE FROM $this->table where id=$tid $author");
        if ($this->db->affected_rows() < 1) {
            emMsg('权限不足！', './');
        }
        // del pic
        if (!empty($row['img'])) {
            $fpath = str_replace('thum-', '', $row['img']);
            if ($fpath != $row['img']) {
                @unlink('../' . $fpath);
            }
            @unlink('../' . $row['img']);
        }
    }
}
