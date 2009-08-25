<?php
/**
 * 模型：标签管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

class emTag {

	var $db;

	function emTag($dbhandle)
	{
		$this->db = $dbhandle;
	}

	/**
	 * 获取标签
	 *
	 * @param int $gid
	 * @return array
	 */
	function getTag($blogId = '')
	{
		$tags = array();
		$condition = $blogId ? "WHERE gid LIKE '%,$blogId,%'" : '';
		$query = $this->db->query("select tagname,tid from ".DB_PREFIX."tag $condition");
		while($row = $this->db->fetch_array($query))
		{
			$row['tagname'] = htmlspecialchars($row['tagname']);
			$row['tid'] = intval($row['tid']);
			$tags[] = $row;
		}
		return $tags;
	}
	function getOneTag($tagId)
	{
		$tag = array();
		$row = $this->db->once_fetch_array("SELECT tagname,tid FROM ".DB_PREFIX."tag WHERE tid=$tagId");
		$tag['tagname'] = htmlspecialchars(trim($row['tagname']));
		$tag['tagid'] = intval($row['tid']);
		return $tag;
	}
	
	function getTagByName($tagName)
	{
		$tag = array();
		$row = $this->db->once_fetch_array("SELECT tagname,gid FROM ".DB_PREFIX."tag WHERE tagname='$tagName'");
		if(empty($row))
		{
			return false;
		}
		$blogIdStr  = substr(trim($row['gid']),1,-1);
		return $blogIdStr;
	}

	function getTagById($tagId)
	{
		$tag = array();
		$row = $this->db->once_fetch_array("SELECT tagname,gid FROM ".DB_PREFIX."tag WHERE tid=$tagId");
		if(empty($row))
		{
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
	function addTag($tagStr, $blogId)
	{
		$tag = explode(',',$tagStr);
		$tag = formatArray($tag);
		foreach ($tag as $tagName)
		{
			$result = $this->db->once_fetch_array("SELECT tagname FROM ".DB_PREFIX."tag WHERE tagname='$tagName'");
			if(empty($result)) {
				$query="INSERT INTO ".DB_PREFIX."tag (tagname,gid) VALUES('".$tagName."',',$blogId,')";
				$this->db->query($query);
			}else{
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
	function updateTag($tagStr, $blogId)
	{
		$tag = explode(',',$tagStr);
		$query = $this->db->query("SELECT tagname FROM ".DB_PREFIX."tag WHERE gid LIKE '%".$blogId."%' ");
		$old_tag = array();
		while($row = $this->db->fetch_array($query))
		{
			$old_tag[] = addslashes($row['tagname']);
		}
		if(empty($old_tag))
		{
			$old_tag = array('');
		}
		$dif_tag = findArray(formatArray($tag),$old_tag);
		for($n = 0; $n < count($dif_tag); $n++)
		{
			$a = 0;
			for($j=0 ; $j<count($old_tag);$j++)
			{
				if($dif_tag[$n] == $old_tag[$j])
				{
					$this->db->query("UPDATE ".DB_PREFIX."tag SET gid= REPLACE(gid,',$blogId,',',') WHERE tagname='".$dif_tag[$n]."' ");
					$this->db->query("DELETE FROM ".DB_PREFIX."tag WHERE gid=',' ");
					break;
				}elseif($j == count($old_tag)-1){
					$result = $this->db->once_fetch_array("SELECT tagname FROM ".DB_PREFIX."tag WHERE tagname='".trim($dif_tag[$n])."' ");
					if(empty($result))
					{
						$query="INSERT INTO ".DB_PREFIX."tag (tagname,gid) VALUES('".$dif_tag[$n]."',',$blogId,')";
						$this->db->query($query);
					}else{
						$query="UPDATE ".DB_PREFIX."tag SET gid=concat(gid,'$blogId,') where tagname = '".$dif_tag[$n]."' ";
						$this->db->query($query);
					}
				}
			}
		}
	}

	function updateTagName($tagId, $tagName)
	{
		$sql="UPDATE ".DB_PREFIX."tag SET tagname='$tagName' WHERE tid=$tagId";
		$this->db->query($sql);
	}
	
	function deleteTag($tagId)
	{
		$this->db->query("DELETE FROM ".DB_PREFIX."tag where tid=$tagId");
	}

}

?>
