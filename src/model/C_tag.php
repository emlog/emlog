<?php
/**
 * 模型：标签管理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: comment.php 682 2008-10-14 16:08:01Z emloog $
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
		$query = $this->dbhd->query("select tagname from $this->tagTable $condition");
		while($row = $this->dbhd->fetch_array($query))
		{
			$tags[] = $row['tagname'];
		}
		return $tags;
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
			$result = $this->dbhd->fetch_one_array("SELECT tagname FROM $this->tagTable WHERE tagname='$tagName'");
			if(empty($result)) {
				$query="INSERT INTO $this->tagTable (tagname,gid) VALUES('".$tagName."',',$blogId,')";
				$this->dbhd->query($query);
			}else{
				$query="UPDATE $this->tagTable SET usenum=usenum+1, gid=concat(gid,'$blogId,') where tagname = '$tagName'";
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
		$dif_tag = findArray(formatArray($tag),$old_tag);
		for($n=0;$n<count($dif_tag);$n++)
		{
			$a = 0;
			for($j=0 ; $j<count($old_tag);$j++)
			{
				if($dif_tag[$n] == $old_tag[$j])
				{
					$this->dbhd->query("UPDATE $this->tagTable SET usenum=usenum-1,gid= REPLACE(gid,',$blogId,',',') WHERE tagname='".$dif_tag[$n]."' ");
					$this->dbhd->query("DELETE FROM $this->tagTable WHERE usenum=0 ");
					break;
				}
				elseif($j == count($old_tag)-1)
				{
					$result = $this->dbhd->fetch_one_array("SELECT tagname FROM $this->tagTable WHERE tagname='".trim($dif_tag[$n])."' ");
					if(empty($result))
					{
						$query="INSERT INTO $this->tagTable (tagname,gid) VALUES('".$dif_tag[$n]."',',$blogId,')";
						$this->dbhd->query($query);
					}else{
						$query="UPDATE $this->tagTable SET usenum=usenum+1, gid=concat(gid,'$blogId,') where tagname = '".$dif_tag[$n]."' ";
						$this->dbhd->query($query);
					}
				}//end elseif
			}//end for2
		}//end for1
	}

}

?>
