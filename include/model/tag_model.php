<?php
/**
 * Model: Tag Management
 * @package EMLOG (www.emlog.net)
 */

class Tag_Model
{

    private $db;

    function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get Post Tags
     *
     * @param int $blogId
     * @return array
     */
    function getTag($blogId = NULL)
    {
        $tags = array();

        $tag_ids = $this->getTagIdsFromBlogId($blogId);
        $tag_names = $this->getNamesFromIds($tag_ids);

        foreach ($tag_names as $key => $value) {
            $row = array();
            $row['tagname'] = htmlspecialchars($value);
            $row['tid'] = intval($key);
            $tags[] = $row;
        }

        return $tags;
    }

    function getOneTag($tagId)
    {
        $tag = array();
        $row = $this->db->once_fetch_array("SELECT tagname,tid FROM " . DB_PREFIX . "tag WHERE tid=$tagId");
        $tag['tagname'] = htmlspecialchars(trim($row['tagname']));
        $tag['tagid'] = intval($row['tid']);
        return $tag;
    }

    function getTagByName($tagName)
    {
        $tagId = $this->getIdFromName($tagName);
        return $this->getTagById($tagId);
    }

    function getTagById($tagId)
    {
        $blogs = $this->getBlogIdsFromTagId($tagId);
        $blogIdStr = implode(',', $blogs);
        return $blogIdStr;
    }

    function addTag($tagStr, $blogId)
    {
     */
        $tagStr = trim($tagStr);
//vot: DO NOT TRANSLATE BELOW LINE!!
        $tagStr = str_replace('，', ',', $tagStr);

        if (empty($tagStr)) {
            return;
        }

        // Split the Tag string into the Tag array, and remove duplications
        $tagNameArray = explode(',', $tagStr);
        $tagNameArray = array_unique($tagNameArray);

        $tags = array();
        foreach ($tagNameArray as $tagName) {
            $tagName = trim($tagName);

            if (empty($tagName)) {
                continue;
            }

            // Get from the tag name to Tag Id, If the tag does not exist, Create Tag
            $tagId = $this->getIdFromName($tagName);

            if (!$tagId) {
                $tagId = $this->createTag($tagName, $blogId);
            }

            // insert the current blog Id into the tag
            $this->addBlogIntoTag($tagId, $blogId);

            $tags[] = $tagId;
        }

        // Save the current blog associated Tag Id list
        $tag_string = implode(',', $tags);
        $sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($tag_string) . "' WHERE `gid` = " . $blogId;
        $this->db->query($sql);
    }

    function updateTag($tagStr, $blogId)
    {
     */
        $tagStr = trim($tagStr);
//vot: DO NOT TRANSLATE BELOW LINE!!
        $tagStr = str_replace('，', ',', $tagStr);

        // The old Tag Id list
        $old_tags = $this->getTagIdsFromBlogId($blogId);

        // The new Tag Id list
        $new_tags = array();

        // Establish new tag id array
        if (!empty($tagStr)) {
            // split the label string Tag array, and remove duplications
            $tagNameArray = explode(',', $tagStr);
            $tagNameArray = array_unique($tagNameArray);

            foreach ($tagNameArray as $tagName) {
                $tagName = trim($tagName);

                if (empty($tagName)) {
                    continue;
                }

                // Get from the tag name to Tag Id, If the tag does not exist, Create Tag
                $tagId = $this->getIdFromName($tagName);

                if (!$tagId) {
                    $tagId = $this->createTag($tagName);
                }

                $new_tags[] = $tagId;
            }
        }

        // If the old in a new tab Tag Id Id array does not exist, delete Tag from the list mapping
        foreach ($old_tags as $each_tag) {
            if (!in_array($each_tag, $new_tags)) {
                $this->removeBlogIdFromTag($each_tag, $blogId);
            }
        }

        // If the new Tag in the old Tag Id Id array does not exist, then establish the Tag mapping table
        foreach ($new_tags as $each_tag) {
            if (!in_array($each_tag, $old_tags)) {
                $this->addBlogIntoTag($each_tag, $blogId);
            }
        }

        // Update Article Tag Mapping
        $new_tag_string = implode(',', $new_tags);
        $sql = "UPDATE `" . DB_PREFIX . "blog` SET `tags` = '" . $this->db->escape_string($new_tag_string) . "' WHERE `gid` = " . $blogId;
        $this->db->query($sql);
    }

    function updateTagName($tagId, $tagName)
    {
        $sql = "UPDATE " . DB_PREFIX . "tag SET tagname='$tagName' WHERE tid=$tagId";
        $this->db->query($sql);
    }

    function deleteTag($tagId)
    {
        $linked_blogs = $this->getBlogIdsFromTagId($tagId);

        foreach ($linked_blogs as $blogId) {
            $this->removeTagIdFromBlog($blogId, $tagId);
        }

        $this->db->query("DELETE FROM " . DB_PREFIX . "tag where tid=$tagId");
    }

    /**
     * Find Tag ID from the tag name
     * @param string $tagName Tag name
     * @return int|bool Tag ID | FALSE (Tag not found)
     */
    function getIdFromName($tagName)
    {
        $sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag` WHERE `tagname` = '" . $this->db->escape_string($tagName) . "'";
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) === 0) {
            return FALSE;
        }

        $result = $this->db->fetch_array($query);
        return $result['tid'];
    }

    /**
     * Find Tag IDs from a bunch of Tag ID
     * @param string $tagNames Tag names (comma separated)
     * @return array Tag ID list
     */
    function getIdsFromNames($tagNames)
    {
        $result = array();
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
     * Find a bunch of Tag names from a bunch Tag ID
     * @param array $tagIds Tag ID list
     * @return array
     */
    function getNamesFromIds($tagIds = NULL)
    {
        $names = array();
/*vot*/	foreach ($tagIds AS $i => $tag) {
/*vot*/		if(empty($tag)) {
/*vot*/			unset($tagIds[$i]);
/*vot*/		}
/*vot*/	}

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
     * Create a new tag
     * @param string $tagName Tag name
     * @param string $blogId
     * @return int Tag ID
     */
    function createTag($tagName, $blogId = '')
    {
        $existTag = $this->getIdFromName($tagName);

        if (!$existTag) {
            $this->db->query("INSERT INTO `" . DB_PREFIX . "tag` (`tagname`,`gid`) VALUES('" . $this->db->escape_string($tagName) . "', '$blogId')");
            $existTag = $this->db->insert_id();
        }

        return $existTag;
    }

    /**
     * Create a bunch of new Tags
     * @param mixed $tagNames Tag names (in comma separated)
     */
    function createTags($tagNames)
    {
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
     * Get TagId list from BlogId (Get the Tag List used in the Article)
     * @param int $blogId Article ID
     * @return array Tag ID list
     */
    function getTagIdsFromBlogId($blogId = NULL)
    {
        if (empty($blogId)) {
            return $this->getAllTagIds();
        }

        $tags = array();

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

    function getAllTagIds()
    {
        $tags = array();

        $sql = "SELECT `tid` FROM `" . DB_PREFIX . "tag`";
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0) {
            while ($result = $this->db->fetch_array($query)) {
                $tags [] = $result['tid'];
            }
        }

        return $tags;
    }


    /**
     * Get BlogId list from TagId (Get all articles from a Tag ID)
     * @param int $tagId Tag ID
     * @return array Article ID list
     */
    function getBlogIdsFromTagId($tagId)
    {
        $blogs = array();

/*vot*/	if(!empty($tagId)) {

        $sql = "SELECT `gid` FROM `" . DB_PREFIX . "tag` WHERE `tid` = " . $tagId;
        $query = $this->db->query($sql);

        if ($this->db->num_rows($query) > 0) {
            $result = $this->db->fetch_array($query);

            if (!empty($result['gid'])) {
                $blogs = explode(',', $result['gid']);
            }
        }
/*vot*/	}

        return $blogs;
    }

    /**
     * Remove from Tag Tag out the article referenced table
     * @param int $tagId
     * @param int $blogId
     */
    function removeBlogIdFromTag($tagId, $blogId)
    {
        $blogs = $this->getBlogIdsFromTagId($tagId);

        if (empty($blogs)) {
            return;
        }

        // If blogId exist, then build a new does not contain this blogId array of Blog, and save to the database
        if (in_array($blogId, $blogs)) {
            $new_blogs = array();

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
     * Delete a reference to a Tag from the list of TagMap
     * @param int $blogId
     * @param int $tagId
     */
    function removeTagIdFromBlog($blogId, $tagId)
    {
        $tags = $this->getTagIdsFromBlogId($blogId);

        if (empty($tags)) {
            return;
        }

        // If tagId exist, then build a new array that does not contain this TagId of Tag, and save to the database
        if (in_array($tagId, $tags)) {
            $new_tags = array();

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
     * Insert BlogId into the Tag table
     * @param int $tagId Tag ID
     * @param int $blogId Blog ID
     */
    function addBlogIntoTag($tagId, $blogId)
    {
        $exist_blogs = $this->getBlogIdsFromTagId($tagId);

        if (!in_array($blogId, $exist_blogs)) {
            $exist_blogs[] = $blogId;

            $blog_string = implode(',', $exist_blogs);
            $sql = "UPDATE `" . DB_PREFIX . "tag` SET `gid` = '" . $this->db->escape_string($blog_string) . "' WHERE `tid` = " . $tagId;
            $this->db->query($sql);
        }
    }
}
