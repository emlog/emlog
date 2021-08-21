<?php
/**
 * media model
 * @package EMLOG (www.emlog.net)
 */

class Media_Model {

	private $db;

	function __construct() {
		$this->db = Database::getInstance();
	}

	/**
	 * 获取资源列表
	 */
	function getMedias($page = null) {

		$condition = '';
		if ($page) {
			$perpage_num = 30;
			$startId = ($page - 1) * $perpage_num;
			$condition = "LIMIT $startId, " . $perpage_num;
		}

		$sql = "SELECT * FROM " . DB_PREFIX . "attachment WHERE thumfor = 0 order by aid desc $condition";
		$query = $this->db->query($sql);
		$medias = [];
		while ($row = $this->db->fetch_array($query)) {
			$medias[$row['aid']] = [
				'attsize'  => changeFileSize($row['filesize']),
				'filename' => htmlspecialchars($row['filename']),
				'addtime'  => date("Y-m-d H:i", $row['addtime']),
				'aid'      => $row['aid'],
				'filepath' => $row['filepath'],
				'width'    => $row['width'],
				'height'   => $row['height'],
			];
			$thum = $this->db->once_fetch_array('SELECT * FROM ' . DB_PREFIX . 'attachment WHERE thumfor = ' . $row['aid']);
			if ($thum) {
				$medias[$row['aid']]['thum_filepath'] = $thum['filepath'];
				$medias[$row['aid']]['thum_width'] = $thum['width'];
				$medias[$row['aid']]['thum_height'] = $thum['height'];
			}
		}
		return $medias;
	}

	function getMediaCount() {
		$sql = "SELECT count(*) as count FROM " . DB_PREFIX . "attachment WHERE thumfor = 0";
		$res = $this->db->once_fetch_array($sql);
		return $res['count'];
	}

	/**
	 * @param $file_info
	 * @param int $thumfor
	 * @return int|string
	 */
	function addMedia($file_info, $thumfor = 0) {

		$file_name = $file_info['file_name'];
		$file_size = $file_info['size'];
		$file_path = $file_info['file_path'];
		$file_mime_type = $file_info['mime_type'];
		$img_width = $file_info['width'];
		$img_height = $file_info['height'];
		$create_time = time();

		$query = "INSERT INTO " . DB_PREFIX . "attachment (filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')";
		$query = sprintf($query, $file_name, $file_size, $file_path, $create_time, $img_width, $img_height, $file_mime_type, $thumfor);
		$this->db->query($query);
		return $this->db->insert_id();

	}

	function deleteMedia($linkId) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "link where id=$linkId");
	}

}
