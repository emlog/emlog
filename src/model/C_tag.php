<?php
/**
 * 模型：标签管理
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */


class emTag {

	var $dbhd;
	var $tagTable;

	function emTag($dbhandle)
	{
		$this->dbhd = $dbhandle;
		$this->tagTable = DB_PREFIX.'tag';
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
		$query = $this->dbhd->query("select tagname,tid from $this->tagTable $condition");
		while($row = $this->dbhd->fetch_array($query))
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
		$row = $this->dbhd->once_fetch_array("SELECT tagname,tid FROM $this->tagTable WHERE tid=$tagId");
		$tag['tagname'] = htmlspecialchars(trim($row['tagname']));
		$tag['tagid'] = intval($row['tid']);
		return $tag;
	}
	
	function getTagByName($tagName)
	{
		$tag = array();
		$row = $this->dbhd->once_fetch_array("SELECT tagname,gid FROM $this->tagTable WHERE tagname='$tagName'");
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
		$row = $this->dbhd->once_fetch_array("SELECT tagname,gid FROM $this->tagTable WHERE tid=$tagId");
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
			$result = $this->dbhd->once_fetch_array("SELECT tagname FROM $this->tagTable WHERE tagname='$tagName'");
			if(empty($result)) {
				$query="INSERT INTO $this->tagTable (tagname,gid) VALUES('".$tagName."',',$blogId,')";
				$this->dbhd->query($query);
			}else{
				$query="UPDATE $this->tagTable SET gid=concat(gid,'$blogId,') where tagname = '$tagName'";
				$this->dbhd->query($query);
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
		$query = $this->dbhd->query("SELECT tagname FROM $this->tagTable WHERE gid LIKE '%".$blogId."%' ");
		$old_tag = array();
		while($row = $this->dbhd->fetch_array($query))
		{
			$old_tag[] = $row['tagname'];
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
					$this->dbhd->query("UPDATE $this->tagTable SET gid= REPLACE(gid,',$blogId,',',') WHERE tagname='".$dif_tag[$n]."' ");
					$this->dbhd->query("DELETE FROM $this->tagTable WHERE gid=',' ");
					break;
				}elseif($j == count($old_tag)-1){
					$result = $this->dbhd->once_fetch_array("SELECT tagname FROM $this->tagTable WHERE tagname='".trim($dif_tag[$n])."' ");
					if(empty($result))
					{
						$query="INSERT INTO $this->tagTable (tagname,gid) VALUES('".$dif_tag[$n]."',',$blogId,')";
						$this->dbhd->query($query);
					}else{
						$query="UPDATE $this->tagTable SET gid=concat(gid,'$blogId,') where tagname = '".$dif_tag[$n]."' ";
						$this->dbhd->query($query);
					}
				}
			}
		}
	}

	function updateTagName($tagId, $tagName)
	{
		$sql="UPDATE $this->tagTable SET tagname='$tagName' WHERE tid=$tagId";
		$this->dbhd->query($sql);
	}
	
	function deleteTag($tagId)
	{
		$this->dbhd->query("DELETE FROM $this->tagTable where tid=$tagId");
	}

}

?>
