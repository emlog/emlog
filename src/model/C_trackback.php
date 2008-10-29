<?php
/**
 * 模型：撰写日志
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id: comment.php 682 2008-10-14 16:08:01Z emloog $
 */


class emTrackback {

	var $dbhd;
	var $tbTable;

	function emTrackback($dbhandle)
	{
		$this->dbhd = $dbhandle;
		$this->tbTable = DB_PREFIX.'trackback';
	}

	function getTrackback($page = null, $blogId = null)
	{
		$andQuery = $blogId ? "where gid=$blogId" : '';
		$condition = '';
		if($page)
		{
			$startId = ($page - 1) *15;
			$condition = "LIMIT $startId, 15";
		}
		$sql = "SELECT * FROM $this->tbTable $andQuery ORDER BY tbid DESC $condition";
		$ret = $this->dbhd->query($sql);
		$trackbacks = array();
		while($row = $this->dbhd->fetch_array($ret))
		{
			$row['title'] = htmlspecialchars($row['title']);
			$row['blog_name'] = htmlspecialchars($row['blog_name']);
			$row['date'] = date("Y-m-d H:i",$row['date']);
			$row['url'] = htmlspecialchars($row['url']);
			$row['excerpt'] = htmlspecialchars($row['excerpt']);
			$s_tb['date'] = date('Y-m-d H:i',$s_tb['date']);

			$trackbacks[] = $row;
		}
		return $trackbacks;
	}

	function postTrackback($blogurl, $pingUrl, $blogId)
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

	/**
	 * 发送数据包
	 *
	 * @param string $url 发送地址
	 * @param unknown_type $data 数据信息
	 * @return unknown
	 */
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

}

?>
