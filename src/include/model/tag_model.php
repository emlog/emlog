<?php
/**
 * 标签管理
 * @copyright (c) Emlog All Rights Reserved
 */

class Tag_Model {

	private $db;

	function __construct() {
		$this->db = Database::getInstance();
	}

	/**
	 * 获取标签
	 *
	 * @param int $blogId
	 * @return array
	 */
	function getTag($blogId = '') {
		$tags = array();
		$condition = $blogId ? "WHERE gid LIKE '%,$blogId,%'" : '';
		$query = $this->db->query("select tagname,tid from ".DB_PREFIX."tag $condition");
		while ($row = $this->db->fetch_array($query)) {
			$row['tagname'] = htmlspecialchars($row['tagname']);
			$row['tid'] = intval($row['tid']);
			$tags[] = $row;
		}
		return $tags;
	}

	function getOneTag($tagId) {
		$tag = array();
		$row = $this->db->once_fetch_array("SELECT tagname,tid FROM ".DB_PREFIX."tag WHERE tid=$tagId");
		$tag['tagname'] = htmlspecialchars(trim($row['tagname']));
		$tag['tagid'] = intval($row['tid']);
		return $tag;
	}

	function getTagByName($tagName) {
		$tag = array();
		$row = $this->db->once_fetch_array("SELECT tagname,gid FROM ".DB_PREFIX."tag WHERE tagname='$tagName'");
		if (empty($row)) {
			return false;
		}
		$blogIdStr  = substr(trim($row['gid']),1,-1);
		return $blogIdStr;
	}

	function getTagById($tagId) {
		$tag = array();
		$row = $this->db->once_fetch_array("SELECT tagname,gid FROM ".DB_PREFIX."tag WHERE tid=$tagId");
		if (empty($row)) {
			return false;
		}
		$blogIdStr  = substr(trim($row['gid']),1,-1);
		return $blogIdStr;
	}

	/**
	 * 添加标签
	 *
	 * @param string $tagStr
	 */
	function addTag($tagStr, $blogId) {
		$tag = !empty($tagStr) ? preg_split ("/[,\s]|(，)/", $tagStr) : array();
		$tag = array_filter(array_unique($tag));
		foreach ($tag as $tagName) {
			$result = $this->db->once_fetch_array("SELECT tagname FROM ".DB_PREFIX."tag WHERE tagname='$tagName'");
			if (empty($result)) {
				$query="INSERT INTO ".DB_PREFIX."tag (tagname,gid) VALUES('".$tagName."',',$blogId,')";
				$this->db->query($query);
			} else {
				$query="UPDATE ".DB_PREFIX."tag SET gid=concat(gid,'$blogId,') where tagname = '$tagName'";
				$this->db->query($query);
			}
		}
	}

	/**
	 * 更新标签
	 *
	 * @param string $tagStr
	 * @param int $blogId
	 */
	function updateTag($tagStr, $blogId) {
		$tag = !empty($tagStr) ? preg_split ("/[,\s]|(，)/", $tagStr) : array();
		$query = $this->db->query("SELECT tagname FROM ".DB_PREFIX."tag WHERE gid LIKE '%".$blogId."%' ");
		$old_tag = array();
		while ($row = $this->db->fetch_array($query)) {
			$old_tag[] = addslashes($row['tagname']);
		}
		if (empty($old_tag)) {
			$old_tag = array('');
		}
		$dif_tag = findArray(array_filter(array_unique($tag)),$old_tag);
		for ($n = 0; $n < count($dif_tag); $n++) {
			$a = 0;
			for ($j=0 ; $j<count($old_tag);$j++) {
				if ($dif_tag[$n] == $old_tag[$j]) {
					$this->db->query("UPDATE ".DB_PREFIX."tag SET gid= REPLACE(gid,',$blogId,',',') WHERE tagname='".$dif_tag[$n]."' ");
					$this->db->query("DELETE FROM ".DB_PREFIX."tag WHERE gid=',' ");
					break;
				} elseif($j == count($old_tag)-1) {
					$result = $this->db->once_fetch_array("SELECT tagname FROM ".DB_PREFIX."tag WHERE tagname='".trim($dif_tag[$n])."' ");
					if (empty($result)) {
						$query="INSERT INTO ".DB_PREFIX."tag (tagname,gid) VALUES('".$dif_tag[$n]."',',$blogId,')";
						$this->db->query($query);
					} else {
						$query="UPDATE ".DB_PREFIX."tag SET gid=concat(gid,'$blogId,') where tagname = '".$dif_tag[$n]."' ";
						$this->db->query($query);
					}
				}
			}
		}
	}

	function updateTagName($tagId, $tagName) {
		$sql="UPDATE ".DB_PREFIX."tag SET tagname='$tagName' WHERE tid=$tagId";
		$this->db->query($sql);
	}

	function deleteTag($tagId) {
		$this->db->query("DELETE FROM ".DB_PREFIX."tag where tid=$tagId");
	}

    /**
     * 从标签名查找标签ID
     * @param string $tagName 标签名
     * @return int|bool 标签ID | FALSE(未找到标签)
     */
    function getIdFromName($tagName)
    {
        $sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag` WHERE `tagname` = " . $this->db->excape_string($tagName);
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) === 0)
        {
            return FALSE;
        }

        $result = $this->db->fetch_array($query);
        return $result['tagname'];
    }

    /**
     * 从一堆标签名查找一堆标签ID
     * @param string $tagNames 标签名 (以半角逗号分隔)
     * @return array 标签ID
     */
    function getIdsFromNames($tagNames)
    {
        $result = array();
        $tagNameArray = explode(',', $tagNames);

        foreach ($tagNameArray as $each)
        {
            $each = trim($each);

            if (empty($each))
            {
                continue;
            }

            $each_id = $this->getIdFromName($each);

            if ($each_id !== FALSE)
            {
                $result[] = $each_id;
            }
        }

        return $result;
    }

    /**
     * 创建一个新的标签
     * @param string $tagName 标签名
     * @return int 标签ID
     */
    function createTag($tagName)
    {
        $existTag = $this->getIdFromName($tagName);
        
        if ( ! $existTag)
        {
            $this->db->query("INSERT INTO `".DB_PREFIX."tag` (`tagname`) VALUES('" . $this->db->escape_string($tagName) . "')");
            $existTag = $this->db->insert_id();
        }

        return $existTag;
    }

    /**
     * 创建一堆新标签
     * @param mixed $tagNames 标签名 (以半角逗号分隔)
     */
    function createTags($tagNames)
    {
        $tagNameArray = explode(',', $tagNames);

        foreach ($tagNameArray as $each)
        {
            $each = trim($each);

            if (empty($each))
            {
                continue;
            }

            $this->createTag($each);
        }
    }

    /**
     * 从BlogId获取到TagId列表 (获取到文章所使用的Tag列表)
     * @param int $blogId 文章ID
     * @return array 标签ID列表
     */
    function getTagIdsFromBlogId($blogId)
    {
        $tags = array();

        $sql = "SELECT `tags` FROM `" . DB_PREFIX . "tagmap` WHERE `gid` = " . $blogId;
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0)
        {
            $result = $this->db->fetch_array($query);
            $tags = explode(',', $result['tags']);
        }

        return $tags;
    }

    /**
     * 从TagId获取到BlogId列表 (获取到一个Tag下所有的文章)
     * @param int $tagId 标签ID
     * @return array 文章ID列表
     */
    function getBlogIdsFromTagId($tagId)
    {
        $blogs = array();

        $sql = "SELECT `gid` FROM `" . DB_PREFIX . "tag` WHERE `gid` = " . $tagId;
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0)
        {
            $result = $this->db->fetch_array($query);
            $blogs = explode(',', $result['gid']);
        }

        return $blogs;
    }

    /**
     * 从Tag表的Tag删除掉一篇文章引用
     * @param int $tagId 
     * @param int $blogId 
     */
    function removeBlogIdFromTag($tagId, $blogId)
    {
        $blogs = $this->getBlogIdsFromTagId($tagId);

        if (empty($blogs))
        {
            return;
        }

        // 如果blogId存在，则构建一个新的不包含这个blogId的Blog数组，并保存到数据库
        if (in_array($blogId, $blogs))
        {
            $new_blogs = array();

            foreach ($blogs as $each)
            {
                if ($each != $blogId)
                {
                    $new_blogs[] = $each;
                }
            }

            $blog_string = implode(',', $new_blogs);
            $sql = "UPDATE `" . DB_PREFIX . "tag` SET `gid` = '" . $this->db->escape_string($blog_string) . "' WHERE `tid` = " . $tagId; 
            $this->db->query($sql);
        }
    }

    /**
     * 从TagMap表里的gid删除掉一个标签引用
     * @param int $blogId 
     * @param int $tagId 
     */
    function removeTagIdFromBlog($blogId, $tagId)
    {
        $tags = $this->getTagIdsFromBlogId($blogId);

        if (empty($tags))
        {
            return;
        }

        // 如果tagId存在，则构建一个新的不包含这个TagId的Tag数组，并保存到数据库
        if (in_array($tagId, $tags))
        {
            $new_tags = array();

            foreach ($tags as $each)
            {
                if ($each != $tagId)
                {
                    $new_tags[] = $each;
                }

                $tag_string = implode(',', $new_tags);
                $sql = "UPDATE `" . DB_PREFIX . "tagmap` SET `tags` = '" . $this->db->escape_string($tag_string) . "' WHERE `gid` = " . $blogId;
                $this->db->query($sql);
            }
        }
    }

    /**
     * 将BlogId插入到Tag表里
     * @param int $tagId 标签ID
     * @param int $blogId 文章ID
     */
    function addBlogIntoTag($tagId, $blogId)
    {
        $exist_blogs = $this->getBlogIdsFromTagId($tagId);
        
        if ( ! in_array($blogId, $exist_blogs))
        {
            $exist_blogs[] = $blogId;

            $blog_string = implode(',', $exist_blogs);
            $sql = "UPDATE `" . DB_PREFIX . "tag` SET `gid` = '" . $this->db->escape_string($blog_string) . "' WHERE `tid` = " . $tagId; 
            $this->db->query($sql);
        }
    }
}
