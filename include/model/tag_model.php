<?php
/**
 * tags model
 * @package EMLOG
 * @link https://www.emlog.net
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
	function getTag($blogId = NULL) {
		$tags = [];

		$tag_ids = $this->getTagIdsFromBlogId($blogId);
		$tag_names = $this->getNamesFromIds($tag_ids);

		foreach ($tag_names as $key => $value) {
			$row = [];
			$row['tagname'] = htmlspecialchars($value);
			$row['tid'] = (int)$key;
			$tags[] = $row;
		}

		return $tags;
	}

	function getOneTag($tagId) {
		$tag = [];
		$row = $this->db->once_fetch_array("SELECT tagname,tid FROM " . DB_PREFIX . "tag WHERE tid=$tagId");
		$tag['tagname'] = htmlspecialchars(trim($row['tagname']));
		$tag['tagid'] = (int)$row['tid'];
		return $tag;
	}

	function getTagByName($tagName) {
		$tagId = $this->getIdFromName($tagName);
		if (!$tagId) {
			return false;
		}
		return $this->getTagById($tagId);
	}

	function getTagById($tagId) {
		$blogs = $this->getBlogIdsFromTagId($tagId);
		$blogIdStr = implode(',', $blogs);
		return $blogIdStr;
	}

	function addTag($tagStr, $blogId) {
		$tagStr = trim($tagStr);
		$tagStr = str_replace('，', ',', $tagStr);

		if (empty($tagStr)) {
			return;
		}

		// 将标签string切割成标签array，并且去重
		$tagNameArray = explode(',', $tagStr);
		$tagNameArray = array_unique($tagNameArray);

		$tags = [];
		foreach ($tagNameArray as $tagName) {
			$tagName = trim($tagName);

			if (empty($tagName)) {
				continue;
			}

			// 从标签名获取到标签Id，如果标签不存在，则创建标签
			$tagId = $this->getIdFromName($tagName);

			if (!$tagId) {
				$tagId = $this->createTag($tagName, $blogId);
			}

			// 将当前文章Id插入到标签里
			$this->addBlogIntoTag($tagId, $blogId);

			$tags[] = $tagId;
		}

		// 保存当前文章关联的标签Id列表
		$tag_string = implode(',', $tags);
		$sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($tag_string) . "' WHERE `gid` = " . $blogId;
		$this->db->query($sql);
	}

	function updateTag($tagStr, $blogId) {
		$tagStr = trim($tagStr);
		$tagStr = str_replace('，', ',', $tagStr);

		// 旧的标签Id列表
		$old_tags = $this->getTagIdsFromBlogId($blogId);

		// 新的标签Id列表
		$new_tags = [];

		// 建立新的标签id数组
		if (!empty($tagStr)) {
			// 将标签string切割成标签array，并且去重
			$tagNameArray = explode(',', $tagStr);
			$tagNameArray = array_unique($tagNameArray);

			foreach ($tagNameArray as $tagName) {
				$tagName = trim($tagName);

				if (empty($tagName)) {
					continue;
				}

				// 从标签名获取到标签Id，如果标签不存在，则创建标签
				$tagId = $this->getIdFromName($tagName);

				if (!$tagId) {
					$tagId = $this->createTag($tagName);
				}

				$new_tags[] = $tagId;
			}
		}

		// 如果旧的标签Id在新的标签Id数组里不存在，则从Tag表里删除掉映射
		foreach ($old_tags as $each_tag) {
			if (!in_array($each_tag, $new_tags)) {
				$this->removeBlogIdFromTag($each_tag, $blogId);
			}
		}

		// 如果新的标签Id在旧的标签Id数组里不存在，则在Tag表里建立映射
		foreach ($new_tags as $each_tag) {
			if (!in_array($each_tag, $old_tags)) {
				$this->addBlogIntoTag($each_tag, $blogId);
			}
		}

		// 更新文章Tag映射
		$new_tag_string = implode(',', $new_tags);
		$sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($new_tag_string) . "' WHERE `gid` = " . $blogId;
		$this->db->query($sql);
	}

	function updateTagName($tagId, $tagName) {
		$sql = "UPDATE " . DB_PREFIX . "tag SET tagname='$tagName' WHERE tid=$tagId";
		$this->db->query($sql);
	}

	function deleteTag($tagId) {
		// 要删除一个标签，需要先检查哪些文章有引用这个标签，并把这个标签从那些引用中删除
		$linked_blogs = $this->getBlogIdsFromTagId($tagId);

		foreach ($linked_blogs as $blogId) {
			$this->removeTagIdFromBlog($blogId, $tagId);
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "tag WHERE tid=$tagId");
	}

	/**
	 * 从标签名查找标签ID
	 * @param string $tagName 标签名
	 * @return int|bool 标签ID | FALSE(未找到标签)
	 */
	function getIdFromName($tagName) {
		$sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag` WHERE `tagname` = '" . $tagName . "'";
		$query = $this->db->query($sql);

		if ($this->db->num_rows($query) === 0) {
			return FALSE;
		}

		$result = $this->db->fetch_array($query);
		return $result['tid'];
	}

	/**
	 * 从一堆标签名查找一堆标签ID
	 * @param string $tagNames 标签名 (以半角逗号分隔)
	 * @return array 标签ID
	 */
	function getIdsFromNames($tagNames) {
		$result = [];
		$tagNameArray = explode(',', $tagNames);

		foreach ($tagNameArray as $each) {
			$each = trim($each);

			if (empty($each)) {
				continue;
			}

			$each_id = $this->getIdFromName($each);

			if ($each_id !== FALSE) {
				$result[] = $each_id;
			}
		}
		return $result;
	}

	/**
	 * 从一堆标签ID查找一堆标签名
	 * @param array $tagIds 标签ID
	 * @return array
	 */
	function getNamesFromIds($tagIds = NULL) {
		$names = [];

		if (!empty($tagIds)) {
			$tag_string = implode(',', $tagIds);
			$sql = "SELECT `tid`, `tagname` FROM `" . DB_PREFIX . "tag` WHERE `tid` IN (" . $this->db->escape_string($tag_string) . ")";
			$query = $this->db->query($sql);

			if ($this->db->num_rows($query) > 0) {
				while ($result = $this->db->fetch_array($query)) {
					$names[$result['tid']] = $result['tagname'];
				}
			}
		}

		return $names;
	}

	/**
	 * 创建一个新的标签
	 * @param string $tagName 标签名
	 * @param string $blogId
	 * @return int 标签ID
	 */
	function createTag($tagName, $blogId = '') {
		$existTag = $this->getIdFromName($tagName);

		if (!$existTag) {
			$this->db->query("INSERT INTO `" . DB_PREFIX . "tag` (`tagname`,`gid`) VALUES('" . $this->db->escape_string($tagName) . "', '$blogId')");
			$existTag = $this->db->insert_id();
		}

		return $existTag;
	}

	/**
	 * 创建一堆新标签
	 * @param mixed $tagNames 标签名 (以半角逗号分隔)
	 */
	function createTags($tagNames) {
		$tagNameArray = explode(',', $tagNames);

		foreach ($tagNameArray as $each) {
			$each = trim($each);

			if (empty($each)) {
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
	function getTagIdsFromBlogId($blogId = NULL) {
		if (empty($blogId)) {
			return $this->getAllTagIds();
		}

		$tags = [];

		$sql = "SELECT `tags` FROM `" . DB_PREFIX . "blog` WHERE `gid` = " . $blogId;

		$query = $this->db->query($sql);

		if ($this->db->num_rows($query) > 0) {
			$result = $this->db->fetch_array($query);

			if (!empty($result['tags'])) {
				$tags = explode(',', $result['tags']);
			}
		}

		return $tags;
	}

	function getAllTagIds() {
		$tags = [];

		$sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag`";
		$query = $this->db->query($sql);

		if ($this->db->num_rows($query) > 0) {
			while ($result = $this->db->fetch_array($query)) {
				$tags [] = $result['tid'];
			}
		}

		return $tags;
	}

	function getTags($page_count = 50, $page = 1) {
		$startId = ($page - 1) * $page_count;
		$limit = "LIMIT $startId, " . $page_count;

		$tags = [];

		$sql = "SELECT `tid`,`tagname` FROM `" . DB_PREFIX . "tag` ORDER BY `tid` DESC $limit";
		$query = $this->db->query($sql);

		if ($this->db->num_rows($query) > 0) {
			while ($result = $this->db->fetch_array($query)) {
				$tags [] = $result;
			}
		}

		return $tags;
	}

	function getTagsCount() {
		$data = $this->db->once_fetch_array("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "tag");
		return $data['total'];
	}


	/**
	 * 从TagId获取到BlogId列表 (获取到一个Tag下所有的文章)
	 * @param int $tagId 标签ID
	 * @return array 文章ID列表
	 */
	function getBlogIdsFromTagId($tagId) {
		$blogs = [];

		$sql = "SELECT `gid` FROM `" . DB_PREFIX . "tag` WHERE `tid` = " . $tagId;
		$query = $this->db->query($sql);

		if ($this->db->num_rows($query) > 0) {
			$result = $this->db->fetch_array($query);

			if (!empty($result['gid'])) {
				$blogs = explode(',', $result['gid']);
			}
		}

		return $blogs;
	}

	/**
	 * 从Tag表的Tag删除掉一篇文章引用
	 * @param int $tagId
	 * @param int $blogId
	 */
	function removeBlogIdFromTag($tagId, $blogId) {
		$blogs = $this->getBlogIdsFromTagId($tagId);

		if (empty($blogs)) {
			return;
		}

		// 如果blogId存在，则构建一个新的不包含这个blogId的Blog数组，并保存到数据库
		if (in_array($blogId, $blogs)) {
			$new_blogs = [];

			foreach ($blogs as $each) {
				if ($each != $blogId) {
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
	function removeTagIdFromBlog($blogId, $tagId) {
		$tags = $this->getTagIdsFromBlogId($blogId);

		if (empty($tags)) {
			return;
		}

		// 如果tagId存在，则构建一个新的不包含这个TagId的Tag数组，并保存到数据库
		if (in_array($tagId, $tags)) {
			$new_tags = [];

			foreach ($tags as $each) {
				if ($each != $tagId) {
					$new_tags[] = $each;
				}

				$tag_string = implode(',', $new_tags);
				$sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($tag_string) . "' WHERE `gid` = " . $blogId;
				$this->db->query($sql);
			}
		}
	}

	/**
	 * 将BlogId插入到Tag表里
	 * @param int $tagId 标签ID
	 * @param int $blogId 文章ID
	 */
	function addBlogIntoTag($tagId, $blogId) {
		$exist_blogs = $this->getBlogIdsFromTagId($tagId);

		if (!in_array($blogId, $exist_blogs)) {
			$exist_blogs[] = $blogId;

			$blog_string = implode(',', $exist_blogs);
			$sql = "UPDATE `" . DB_PREFIX . "tag` SET `gid` = '" . $this->db->escape_string($blog_string) . "' WHERE `tid` = " . $tagId;
			$this->db->query($sql);
		}
	}
}
