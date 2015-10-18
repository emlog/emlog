<?php
/**
 * Cache class
 *
 * @copyright (c) Emlog All Rights Reserved
 */

class Cache {

    private $db;
    private static $instance = null;

    private $options_cache;
    private $user_cache;
    private $sta_cache;
    private $comment_cache;
    private $tags_cache;
    private $sort_cache;
    private $link_cache;
    private $navi_cache;
    private $newlog_cache;
    private $record_cache;
    private $logtags_cache;
    private $logsort_cache;
    private $logalias_cache;

    private function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Static method, Returns the database connection instance
     *
     * @return Cache
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Cache();
        }
        return self::$instance;
    }
    /**
     * Update cache
     * 
     * @param array/string $cacheMethodName need to update the cache, Update multiple uses an array of methods: array('options', 'user'), Using a single string by:  'options', blank for All
     * @return unknown_type
     */
    function updateCache($cacheMethodName = null) {
        // Update a single cache
        if (is_string($cacheMethodName)) {
            if (method_exists($this, 'mc_' . $cacheMethodName)) {
                call_user_func(array($this, 'mc_' . $cacheMethodName));
            }
            return;
        }
        // Update multiple cache
        if (is_array($cacheMethodName)) {
            foreach ($cacheMethodName as $name) {
                if (method_exists($this, 'mc_' . $name)) {
                    call_user_func(array($this, 'mc_' . $name));
                }
            }
            return;
        }
        // Update all cache
        if ($cacheMethodName == null) {
            // Automatically run all the cache update methods (Such method name must start with the mc_)
            $cacheMethodNames = get_class_methods($this);
            foreach ($cacheMethodNames as $method) {
                if (preg_match('/^mc_/', $method)) {
                    call_user_func(array($this, $method));
                }
            }
        }
    }
    /**
     * Site Configuration Cache
     * Note that the update cache method must begin with mc
     */
    private function mc_options() {
        $options_cache = array();
        $res = $this->db->query("SELECT * FROM " . DB_PREFIX . "options");
        while ($row = $this->db->fetch_array($res)) {
            if (in_array($row['option_name'], array('site_key', 'blogname', 'bloginfo', 'blogurl', 'icp'))) {
                $row['option_value'] = htmlspecialchars($row['option_value']);
            }
            $options_cache[$row['option_name']] = $row['option_value'];
        }
        $cacheData = serialize($options_cache);
        $this->cacheWrite($cacheData, 'options');
    }
    /**
     * User Info Cache
     */
    private function mc_user() {
        $user_cache = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "user");
        while ($row = $this->db->fetch_array($query)) {
            $photo = array();
            $avatar = '';
            if(!empty($row['photo'])){
                $photosrc = str_replace("../", '', $row['photo']);
                $imgsize = chImageSize($row['photo'], Option::ICON_MAX_W, Option::ICON_MAX_H);
                $photo['src'] = htmlspecialchars($photosrc);
                $photo['width'] = $imgsize['w'];
                $photo['height'] = $imgsize['h'];

                $avatar = strstr($photosrc, 'thum') ? str_replace('thum', 'thum52', $photosrc) : preg_replace("/^(.*)\/(.*)$/", "\$1/thum52-\$2", $photosrc);
                $avatar = file_exists('../' . $avatar) ? $avatar : $photosrc;
            }
            $row['nickname'] = empty($row['nickname']) ? $row['username'] : $row['nickname'];
            $user_cache[$row['uid']] = array(
                'photo' => $photo,
                'avatar' => $avatar,
                'name_orig' => $row['nickname'],
                'name' => htmlspecialchars($row['nickname']),
                'mail' => htmlspecialchars($row['email']),
                'des' => htmlClean($row['description']),
                'ischeck' => htmlspecialchars($row['ischeck']),
                'role' => $row['role'],
                );
        }
        $cacheData = serialize($user_cache);
        $this->cacheWrite($cacheData, 'user');
    }
    /**
     * Site Statistics cache
     */
    private function mc_sta() {
        $sta_cache = array();
        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type='blog' AND hide='n' AND checked='y' ");
        $lognum = $data['total'];

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type='blog' AND hide='y'");
        $draftnum = $data['total'];		

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE type='blog' AND hide='n' AND checked='n' ");
        $checknum = $data['total'];			

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE hide='n' ");
        $comnum = $data['total'];	

        $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE hide='y' ");
        $hidecom = $data['total'];

        $sta_cache = array(
            'lognum' => $lognum,
            'draftnum' => $draftnum,
            'comnum' => $comnum,
            'comnum_all' => $comnum + $hidecom,
            'hidecomnum' => $hidecom,
            'checknum' => $checknum,
        );

        $query = $this->db->query("SELECT uid FROM " . DB_PREFIX . "user");
        while ($row = $this->db->fetch_array($query)) {
            $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE author={$row['uid']} AND hide='n' and type='blog'");
            $logNum = $data['total'];
            
            $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE author={$row['uid']} AND hide='y' AND type='blog'");
            $draftNum = $data['total'];
            
            $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment AS a, " . DB_PREFIX . "blog AS b WHERE a.gid = b.gid AND b.author={$row['uid']}");
            $commentNum = $data['total'];			

            $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment AS a, " . DB_PREFIX . "blog AS b WHERE a.gid=b.gid and a.hide='y' AND b.author={$row['uid']}");
            $hidecommentNum = $data['total'];			
            
            $sta_cache[$row['uid']] = array(
                'lognum' => $logNum,
                'draftnum' => $draftNum,
                'commentnum' => $commentNum,
                'hidecommentnum' => $hidecommentNum,
            );
        }

        $cacheData = serialize($sta_cache);
        $this->cacheWrite($cacheData, 'sta');
    }
    /**
     * Last comments cache
     */
    private function mc_comment() {
        $query = $this->db->query("SELECT option_value,option_name FROM " . DB_PREFIX . "options WHERE option_name IN('index_comnum','comment_subnum','comment_paging','comment_pnum','comment_order')");
        while($row = $this->db->fetch_array($query)) {
            ${$row['option_name']} = $row['option_value'];
        }
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "comment WHERE hide='n' ORDER BY date DESC LIMIT 0, $index_comnum");
        $com_cache = array();
        $com_cids = array();
        while ($show_com = $this->db->fetch_array($query)) {
            $com_page = '';
            if($comment_paging == 'y') {
                $pid = $show_com['pid'];
                $cid = $show_com['cid'];
                $order = $comment_order == 'newer' ? 'DESC' : '';
                while($pid != 0) {
                    $show_pid = $this->db->once_fetch_array("SELECT cid,pid FROM " . DB_PREFIX . "comment WHERE cid=$pid");
                    $pid = $show_pid['pid'];
                    $cid = $show_pid['cid'];
                }
                if(!isset($com_cids[$show_com['gid']])) {
                    $com_cids[$show_com['gid']] = array();
                    $query2 = $this->db->query("SELECT cid FROM " . DB_PREFIX . "comment WHERE gid=" . $show_com['gid'] . " AND pid=0 AND hide='n' ORDER BY date $order");
                    while($show_cid = $this->db->fetch_array($query2)) {
                        $com_cids[$show_com['gid']][] = $show_cid['cid'];
                    }
                }
                $com_page = intval(floor(array_search($cid, $com_cids[$show_com['gid']]) / $comment_pnum)) + 1;
            }
            $com_cache[] = array(
                'cid' => $show_com['cid'],
                'gid' => $show_com['gid'],
                'name' => htmlspecialchars($show_com['poster']),
                'date' => $show_com['date'],
                'page' => $com_page,
                'mail' => $show_com['mail'],
                'content' => htmlClean(subString($show_com['comment'], 0, $comment_subnum), false),
                );
        }
        $cacheData = serialize($com_cache);
        $this->cacheWrite($cacheData, 'comment');
    }
    /**
     * Sidebar tags cache
     */
    private function mc_tags() {
        $tag_cache = array();
        $query = $this->db->query("SELECT gid FROM " . DB_PREFIX . "tag");
        $tagnum = 0;
        $maxuse = 0;
        $minuse = 0;
        while ($row = $this->db->fetch_array($query)) {
            $usenum = substr_count($row['gid'], ',') - 1;
            if ($maxuse == 0) {
                $maxuse = $minuse = $usenum;
            }
            if ($usenum > $maxuse) {
                $maxuse = $usenum;
            }
            if ($usenum < $minuse) {
                $minuse = $usenum;
            }
            $tagnum++;
        }
        $spread = ($tagnum > 12?12:$tagnum);
        $rank = $maxuse - $minuse;
        $rank = ($rank == 0?1:$rank);
        $rank = $spread / $rank;
        // Get draft id
        $hideGids = array();
        $query = $this->db->query("SELECT gid FROM " . DB_PREFIX . "blog where (hide='y' or checked='n') and type='blog'");
        while ($row = $this->db->fetch_array($query)) {
            $hideGids[] = $row['gid'];
        }
        $query = $this->db->query("SELECT tagname,gid FROM " . DB_PREFIX . "tag");
        while ($show_tag = $this->db->fetch_array($query)) {
            // Exclude draft post tags from the statistics
            foreach ($hideGids as $val) {
                $show_tag['gid'] = str_replace(',' . $val . ',', ',', $show_tag['gid']);
            }
            if ($show_tag['gid'] == ',') {
                continue;
            }
            $usenum = substr_count($show_tag['gid'], ',') - 1;
            $fontsize = 10 + round(($usenum - $minuse) * $rank); //maxfont:22pt,minfont:10pt
            $tag_cache[] = array(
                    'tagurl' => urlencode($show_tag['tagname']),
                    'tagname' => htmlspecialchars($show_tag['tagname']),
                    'fontsize' => $fontsize,
                    'usenum' => $usenum
                    );
        }
        $cacheData = serialize($tag_cache);
        $this->cacheWrite($cacheData, 'tags');
    }
    /**
     * Sidebar Categories cache
     */
    private function mc_sort() {
        $sort_cache = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sort ORDER BY pid ASC,taxis ASC");
        while ($row = $this->db->fetch_array($query)) {
            $data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "blog WHERE sortid=" . $row['sid'] . " AND hide='n' AND checked='y' AND type='blog'");
            $logNum = $data['total'];
            $sortData = array(
                'lognum' => $logNum,
                'sortname' => htmlspecialchars($row['sortname']),
                'description' => htmlspecialchars($row['description']),
                'alias' =>$row['alias'],
                'sid' => intval($row['sid']),
                'taxis' => intval($row['taxis']),
                'pid' => intval($row['pid']),
                'template' => htmlspecialchars($row['template']),
                );
            if ($sortData['pid'] == 0) {
                $sortData['children'] = array();
            } elseif (isset($sort_cache[$row['pid']])) {
                $sort_cache[$row['pid']]['children'][] = $row['sid'];
            }
            $sort_cache[$row['sid']] = $sortData;
        }
        $cacheData = serialize($sort_cache);
        $this->cacheWrite($cacheData, 'sort');
    }
    /**
     * Friendly Links Cache
     */
    private function mc_link() {
        $link_cache = array();
        $query = $this->db->query("SELECT siteurl,sitename,description FROM " . DB_PREFIX . "link WHERE hide='n' ORDER BY taxis ASC");
        while ($show_link = $this->db->fetch_array($query)) {
            $link_cache[] = array(
                'link' => htmlspecialchars($show_link['sitename']),
                'url' => htmlspecialchars($show_link['siteurl']),
                'des' => htmlspecialchars($show_link['description'])
                );
        }
        $cacheData = serialize($link_cache);
        $this->cacheWrite($cacheData, 'link');
    }
    /**
     * Navigation Cache
     */
    private function mc_navi() {
        $navi_cache = array();
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "navi WHERE hide='n' ORDER BY pid ASC, taxis ASC");
        $sorts = $this->readCache('sort');
        while ($row = $this->db->fetch_array($query)) {
            $children = array();
            $url = Url::navi($row['type'], $row['type_id'], $row['url']);

            if ($row['type'] == Navi_Model::navitype_sort && !empty($sorts[$row['type_id']]['children'])) {
                foreach ($sorts[$row['type_id']]['children'] as $sortid) {
                    $children[] = $sorts[$sortid];
                }
            }
            $naviData = array(
                    'id' => intval($row['id']),
                    'naviname' => htmlspecialchars(trim($row['naviname'])),
                    'url' => htmlspecialchars(trim($url)),
                    'newtab' => $row['newtab'],
                    'isdefault' => $row['isdefault'],
                    'type' => intval($row['type']),
                    'typeId' => intval($row['type_id']),
                    'taxis' => intval($row['taxis']),
                    'hide' => $row['hide'],
                    'pid' => intval($row['pid']),
                    'children' => $children,
                    );
            if ($row['type'] == Navi_Model::navitype_custom) {
                if($naviData['pid'] == 0) {
                    $naviData['childnavi'] = array();
                } elseif (isset($navi_cache[$row['pid']])) {
                    $navi_cache[$row['pid']]['childnavi'][] = $naviData;
                }
            }
            $navi_cache[$row['id']] = $naviData;
        }
        $cacheData = serialize($navi_cache);
        $this->cacheWrite($cacheData, 'navi');
    }
    /**
     * Latest Posts
     */
    private function mc_newlog() {
        $row = $this->db->fetch_array($this->db->query("SELECT option_value FROM " . DB_PREFIX . "options where option_name='index_newlognum'"));
        $index_newlognum = $row['option_value'];
        $sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' and checked='y' and type='blog' ORDER BY date DESC LIMIT 0, $index_newlognum";
        $res = $this->db->query($sql);
        $logs = array();
        while ($row = $this->db->fetch_array($res)) {
            $row['gid'] = intval($row['gid']);
            $row['title'] = htmlspecialchars($row['title']);
            $logs[] = $row;
        }
        $cacheData = serialize($logs);
        $this->cacheWrite($cacheData, 'newlog');
    }
    /**
     * Post Archive Cache
     */
    private function mc_record() {
        $query = $this->db->query('select date from ' . DB_PREFIX . "blog WHERE hide='n' and checked='y' and type='blog' ORDER BY date DESC");
        $record = 'xxxx_x';
        $p = 0;
        $lognum = 1;
        $record_cache = array();
        while ($show_record = $this->db->fetch_array($query)) {
            $f_record = gmdate('Y_n', $show_record['date']);
            if ($record != $f_record) {
                $h = $p-1;
                if ($h != -1) {
                    $record_cache[$h]['lognum'] = $lognum;
                }
                $record_cache[$p] = array(
/*vot*/             'record' => gmdate(lang('cache_date_format'), $show_record['date']),
                    'date' => gmdate('Ym', $show_record['date'])
                    );
                $p++;
                $lognum = 1;
            }else {
                $lognum++;
                continue;
            }
            $record = $f_record;
        }
        $j = $p-1;
        if ($j >= 0) {
            $record_cache[$j]['lognum'] = $lognum;
        }

        $cacheData = serialize($record_cache);
        $this->cacheWrite($cacheData, 'record');
    }
    /**
     * Post tags cache
     */
    private function mc_logtags() {
        $tag_model = new Tag_Model();
        $newlog = $this->readCache("newlog");

        $log_cache_tags = array();
        foreach ($newlog as $each)
        {
            $gid = $each['gid'];
            $tag_ids = $tag_model->getTagIdsFromBlogId($gid);
            $tag_names = $tag_model->getNamesFromIds($tag_ids);

            $tags = array();
            foreach ($tag_names as $key => $value)
            {
                $tag = array();
                $tag['tagurl'] = rawurlencode($value);
                $tag['tagname'] = htmlspecialchars($value);
                $tag['tid'] = intval($key);
                $tags[] = $tag;
            }

            $log_cache_tags[$gid] = $tags;
        }

        $cacheData = serialize($log_cache_tags);
        $this->cacheWrite($cacheData, 'logtags');
    }
    /**
     * Blog Categories cache
     */
    private function mc_logsort() {
        $sql = "SELECT gid,sortid FROM " . DB_PREFIX . "blog where type='blog'";
        $query = $this->db->query($sql);
        $log_cache_sort = array();
        while ($row = $this->db->fetch_array($query)) {
            if ($row['sortid'] > 0) {
                $res = $this->db->query("SELECT sid,sortname,alias FROM " . DB_PREFIX . "sort where sid=" . $row['sortid']);
                $srow = $this->db->fetch_array($res);
                $log_cache_sort[$row['gid']] = array(
                    'name' => htmlspecialchars($srow['sortname']),
                    'id' => htmlspecialchars($srow['sid']),
                    'alias' => htmlspecialchars($srow['alias']),
                );
            }
        }
        $cacheData = serialize($log_cache_sort);
        $this->cacheWrite($cacheData, 'logsort');
    }
    /**
     * Post aliases cache
     */
    private function mc_logalias() {
        $sql = "SELECT gid,alias FROM " . DB_PREFIX . "blog where alias!=''";
        $query = $this->db->query($sql);
        $log_cache_alias = array();
        while ($row = $this->db->fetch_array($query)) {
            $log_cache_alias[$row['gid']] = $row['alias'];
        }
        $cacheData = serialize($log_cache_alias);
        $this->cacheWrite($cacheData, 'logalias');
    }

    /**
     * Write cache
     */
    function cacheWrite ($cacheData, $cacheName) {
        $cachefile = EMLOG_ROOT . '/content/cache/' . $cacheName . '.php';
        $cacheData = "<?php exit;//" . $cacheData;
/*vot*/        @ $fp = fopen($cachefile, 'wb') OR emMsg(lang('cache_read_error'));
/*vot*/        @ $fw = fwrite($fp, $cacheData) OR emMsg(lang('cache_not_writable'));
        $this->{$cacheName.'_cache'} = null;
        fclose($fp);
    }

    /**
     * Read cache file
     */
    function readCache($cacheName) {
        if ($this->{$cacheName.'_cache'} != null) {
            return $this->{$cacheName.'_cache'};
        } else {
            $cachefile = EMLOG_ROOT . '/content/cache/' . $cacheName . '.php';
            // If the cache file does not exist, the cache file is automatically generated
            if (!is_file($cachefile) || filesize($cachefile) <= 0) {
                if (method_exists($this, 'mc_' . $cacheName)) {
                    call_user_func(array($this, 'mc_' . $cacheName));
                }
            }
            if ($fp = fopen($cachefile, 'r')) {
                $data = fread($fp, filesize($cachefile));
                fclose($fp);
                clearstatcache();
                $this->{$cacheName.'_cache'} = unserialize(str_replace("<?php exit;//", '', $data));
                return $this->{$cacheName.'_cache'};
            }
        }
    }
}
