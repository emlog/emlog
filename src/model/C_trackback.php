<?php
/**
 * 模型：撰写日志
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.1.0
 * $Id$
 */


class emTrackback {

	var $db;

	function emTrackback($dbhandle)
	{
		$this->db = $dbhandle;
	}

	/**
	 * 发送trackback
	 *
	 * @param string $blogurl
	 * @param string $pingUrl
	 * @param int $blogId
	 * @return msg
	 */
	function postTrackback($blogurl, $pingUrl, $blogId, $title, $blogname, $content)
	{
		$url = $blogurl."index.php?action=showlog&gid=".$blogId;
		$hosts = explode("\n", $pingUrl);
		$tbmsg = '';
		foreach ($hosts as $key => $value)
		{
			$host = trim($value);
			if(strstr(strtolower($host), "http://") || strstr(strtolower($host), "https://"))
			{
				$data ="url=".rawurlencode($url)."&title=".rawurlencode($title)."&blog_name=".rawurlencode($blogname)."&excerpt=".rawurlencode($content);
				$result = strtolower($this->sendPacket($host, $data));
				if (strstr($result, "<error>0</error>") === false) {
					$tbmsg .= "(引用{$key}:发送失败)";
				} else {
					$tbmsg .= "(引用{$key}:发送成功)";
				}
			}
		}
		return $tbmsg;
	}

	function sendPacket($url, $data)
	{
		$uinfo = parse_url($url);
		if (isset($uinfo['query']))
		{
			$data .= "&".$uinfo['query'];
		}
		if (!$fp = @fsockopen($uinfo['host'], (($uinfo['port']) ? $uinfo['port'] : "80"), $errno, $errstr, 3))
		{
			return false;
		}

		$out = "POST ".$uinfo['path']." HTTP/1.1\r\n";
		$out.= "Host: ".$uinfo['host']."\r\n";
		$out.= "Content-type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-length: ".strlen($data)."\r\n";
		$out.= "Connection: close\r\n\r\n";
		$out.= $data;
		fwrite($fp, $out);

		$http_response = '';
		while(!feof($fp))
		{
			$http_response .= fgets($fp, 128);
		}
		@fclose($fp);
		return $http_response;
	}

	/**
	 * 获取trackbak
	 *
	 * @param unknown_type $page
	 * @param unknown_type $blogId
	 * @return unknown
	 */
	function getTrackbacks($page = null, $blogId = null, $spot = 0)
	{
		$andQuery = '1=1';
		$andQuery .= $blogId ? " and a.gid=$blogId" : '';
		$condition = '';
		if($page)
		{
			$startId = ($page - 1) * ADMIN_PERPAGE_NUM;
			$condition = "LIMIT $startId, ".ADMIN_PERPAGE_NUM;
		}
		if($spot == 0)
		{
			$sql = "SELECT * FROM ".DB_PREFIX."trackback as a where $andQuery ORDER BY a.tbid DESC $condition";
		}else{
			$sql = ROLE == 'admin' ?
			"SELECT * FROM ".DB_PREFIX."trackback as a where $andQuery ORDER BY a.tbid DESC $condition" :
			"SELECT *,a.title FROM ".DB_PREFIX."trackback as a, ".DB_PREFIX."blog as b where $andQuery and a.gid=b.gid and b.author=".UID." ORDER BY a.tbid DESC $condition";
		}
		$ret = $this->db->query($sql);
		$trackbacks = array();
		while($row = $this->db->fetch_array($ret))
		{
			$row['title'] = htmlspecialchars($row['title']);
			$row['blog_name'] = htmlspecialchars($row['blog_name']);
			$row['date'] = date("Y-m-d H:i",$row['date']);
			$row['url'] = htmlspecialchars($row['url']);
			$row['excerpt'] = htmlspecialchars($row['excerpt']);

			$trackbacks[] = $row;
		}
		return $trackbacks;
	}
	
	/**
	 * 获取引用的数目
	 *
	 * @return int $tbNum
	 */
	function getTbNum()
	{
		$comNum = '';
		if (ROLE == 'admin')
		{
			$sql = "SELECT tbid FROM ".DB_PREFIX."trackback";
		}else {
			$sql = "SELECT a.tbid FROM ".DB_PREFIX."trackback as a, ".DB_PREFIX."blog as b where a.gid=b.gid and b.author=".UID;
		}
		$res = $this->db->query($sql);
		$tbNum = $this->db->num_rows($res);
		return $tbNum;
	}

	function deleteTrackback($tbid)
	{
		$sql = "SELECT gid FROM ".DB_PREFIX."trackback WHERE tbid=$tbid";
		$blog = $this->db->once_fetch_array($sql);
		$this->db->query("UPDATE ".DB_PREFIX."blog SET tbcount=tbcount-1 WHERE gid=".$blog['gid']);
		$this->db->query("DELETE FROM ".DB_PREFIX."trackback where tbid=$tbid");
	}

}

?>
