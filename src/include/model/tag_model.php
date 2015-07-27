<?php
/**
 * Model: Tag Management
 * @copyright (c) Emlog All Rights Reserved
 */

class Tag_Model {

    private  $db;

    function __construct() {
        $this->db = Database::getInstance();
    }

    /**
	 * Get Post Tags
     *
     * @param int $blogId
     * @return array
     */
    function getTag($blogId = NULL) {
        $tags = array();

        $tag_ids = $this->getTagIdsFromBlogId($blogId);
        $tag_names = $this->getNamesFromIds($tag_ids);
        
        foreach ($tag_names as $key => $value)
        {
            $row = array();
            $row['tagname'] = htmlspecialchars($value);
            $row['tid'] = intval($key);
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
        $tagId = $this->getIdFromName($tagName);
        return $this->getTagById($tagId);
    }

    function getTagById($tagId) {
        $blogs = $this->getBlogIdsFromTagId($tagId);
        $blogIdStr = implode(',', $blogs);
        return $blogIdStr;
    }

    /**
	 * Add tags
     *
     * @param string $tagStr
     */
    function addTag($tagStr, $blogId) {
        $tagStr = trim($tagStr);
/*NOT translate!*/ $tagStr = str_replace('，', ',', $tagStr);
        
        if (empty($tagStr))
        {
            return;
        }

        // Split the tags string into a tag array and remove duplicates
        $tagNameArray = explode(',', $tagStr);
        $tagNameArray = array_unique($tagNameArray);

        $tags = array();
        foreach ($tagNameArray as $tagName)
        {
            $tagName = trim($tagName);

            if (empty($tagName))
            {
                continue;
            }

            // Get the tag ID from the tag name, if the tag does not exist, create the tag
            $tagId = $this->getIdFromName($tagName);
            
            if ( ! $tagId)
            {
                $tagId = $this->createTag($tagName);
            }

            // Insert the current article Id into the tag
            $this->addBlogIntoTag($tagId, $blogId);

            $tags[] = $tagId;
        }

        // Save the list of tag IDs associated with the current article
        $tag_string = implode(',', $tags);
        $sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($tag_string) . "' WHERE `gid` = " . $blogId;
        $this->db->query($sql);
    }

    /**
	 * Update Post Tags
     *
     * @param string $tagStr
     * @param int $blogId
     */
    function updateTag($tagStr, $blogId) {
        $tagStr = trim($tagStr);
/*NOT translate!*/ $tagStr = str_replace('，', ',', $tagStr);
        
        // List of old tag IDs
        $old_tags = $this->getTagIdsFromBlogId($blogId);

        // New tag ID list
        $new_tags = array();

        // Create a new tag id array
        if ( ! empty($tagStr))
        {
            // Split the tag string into a tag array and remove duplicates
            $tagNameArray = explode(',', $tagStr);
            $tagNameArray = array_unique($tagNameArray);

            foreach ($tagNameArray as $tagName)
            {
                $tagName = trim($tagName);

                if (empty($tagName))
                {
                    continue;
                }

                // Get the tag ID from the tag name, if the tag does not exist, create the tag
                $tagId = $this->getIdFromName($tagName);
                
                if ( ! $tagId)
                {
                    $tagId = $this->createTag($tagName);
                }

                $new_tags[] = $tagId;
            }
        }

        // If the old tag ID does not exist in the new tag ID array, delete the mapping from the Tag table
        foreach ($old_tags as $each_tag)
        {
            if ( ! in_array($each_tag, $new_tags))
            {
                $this->removeBlogIdFromTag($each_tag, $blogId);
            }
        }

        // If the new tag ID does not exist in the old tag ID array, create a mapping in the Tag table
        foreach ($new_tags as $each_tag)
        {
            if ( ! in_array($each_tag, $old_tags))
            {
                $this->addBlogIntoTag($each_tag, $blogId);
            }
        }

        // Update article Tag mapping
        $new_tag_string = implode(',', $new_tags);
        $sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($new_tag_string) . "' WHERE `gid` = " . $blogId;
        $this->db->query($sql);
    }

    function updateTagName($tagId, $tagName) {
        $sql="UPDATE ".DB_PREFIX."tag SET tagname='$tagName' WHERE tid=$tagId";
        $this->db->query($sql);
    }

    function deleteTag($tagId) {
        // To delete a tag, you need to check which articles have cited this tag first, and remove this tag from those references
        $linked_blogs = $this->getBlogIdsFromTagId($tagId);

        foreach ($linked_blogs as $blogId)
        {
            $this->removeTagIdFromBlog($blogId, $tagId);
        }

        $this->db->query("DELETE FROM ".DB_PREFIX."tag where tid=$tagId");
    }

    /**
     * Find tag ID from tag name
     * @param string $tagName Tag name
     * @return int|bool Tag ID | FALSE (Tag not found)
     */
    function getIdFromName($tagName)
    {
        $sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag` WHERE `tagname` = '" . $this->db->escape_string($tagName) . "'";
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) === 0)
        {
            return FALSE;
        }

        $result = $this->db->fetch_array($query);
        return $result['tid'];
    }

    /**
     * Find a bunch of tag IDs from a bunch of tag names
     * @param string $tagNames Tag name (separated by commas)
     * @return array Tag ID
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
     * Find a bunch of tag names from a bunch of tag IDs
     * @param array $tagIds Tag ID
     * @return array
     */
    function getNamesFromIds($tagIds = NULL)
    {
        $names = array();

        if ( ! empty($tagIds))
        {
            $tag_string = implode(',', $tagIds);
            $sql = "SELECT `tid`, `tagname` FROM `" . DB_PREFIX . "tag` WHERE `tid` IN (" . $this->db->escape_string($tag_string) . ")";
            $query = $this->db->query($sql);

            if ($this->db->num_rows($query) > 0)
            {
                while ($result = $this->db->fetch_array($query))
                {
                    $names[$result['tid']] = $result['tagname'];
                }
            }
        }

        return $names;
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
    function getTagIdsFromBlogId($blogId = NULL)
    {
        if (empty($blogId))
        {
            return $this->getAllTagIds();
        }
        
        $tags = array();

        $sql = "SELECT `tags` FROM `" . DB_PREFIX . "blog` WHERE `gid` = " . $blogId;

        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0)
        {
            $result = $this->db->fetch_array($query);

            if ( ! empty($result['tags']))
            {
                $tags = explode(',', $result['tags']);
            }
        }

        return $tags;
    }

    function getAllTagIds()
    {
        $tags = array();

        $sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag`";
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0)
        {
            while ($result = $this->db->fetch_array($query))
            {
                $tags [] = $result['tid'];
            }
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

        $sql = "SELECT `gid` FROM `" . DB_PREFIX . "tag` WHERE `tid` = " . $tagId;
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0)
        {
            $result = $this->db->fetch_array($query);

            if ( ! empty($result['gid']))
            {
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
