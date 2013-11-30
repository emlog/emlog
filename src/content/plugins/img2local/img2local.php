<?php
/*
Plugin Name: 图片本地化
Version: 1.1
Plugin URL:http://www.qiyuuu.com/for-emlog/emlog-plugin-images-to-local
Description: 保存日志时将日志中的远程图片本地化
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com/
*/
function img2local($logid) {
    global $logData,$Log_Model;
    $isImg2local = isset($_POST['img2local']) ? trim($_POST['img2local']) : '';
    if(!$isImg2local) {
    	return;
    }
	$logData['content'] = stripslashes($logData['content']);
	$logData['excerpt'] = stripslashes($logData['excerpt']);
    $logData['content'] = preg_replace_callback("/<img([^>]+)src=\"([^>\"]+)\"?([^>]*)>/i","image2local",$logData['content']);
    $logData['excerpt'] = preg_replace_callback("/<img([^>]+)src=\"([^>\"]+)\"?([^>]*)>/i","image2local",$logData['excerpt']);
    $logData['content'] = addslashes($logData['content']);
    $logData['excerpt'] = addslashes($logData['excerpt']);
    $Log_Model->updateLog($logData,$logid);
}
addAction('save_log', 'img2local');
function image2local($matches)
{
	$url = parse_url($matches[2]);
	$host = $_SERVER['HTTP_HOST'];
	if(isset($url['host']) && $url['host'] != $host) {
		global $blogid;
		$DB = MySql::getInstance();
		$imgName = md5(addslashes($matches[2])).'.jpg';
		$sql = "SELECT * FROM ".DB_PREFIX."attachment WHERE filename='$imgName' AND blogid=$blogid";
		$row = $DB->once_fetch_array($sql);
		if(!$row) {
			$path = $url['path'];
			if(!empty($url['query'])) {
				$path .= '?' . $url['query'];
			}
			$http_request = "GET $path HTTP/1.0\r\n";
  			$http_request .= "ACCEPT: */*\r\n";
  			$http_request .= "ACCEPT-LANGUAGE: zh-cn\r\n";
  			$http_request .= "USER_AGENT: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
  			$http_request .= "HOST: ".$url['host']."\r\n";
  			$http_request .= "CONNECTION: close\r\n";
  			$http_request .= "COOKIE: $_COOKIE\r\n\r\n";
  			$response = '';
			if(FALSE != ($fs = @fsockopen($url['host'], empty($url['port']) ? 80 : $url['port'], $errno, $errstr, 10))) {
				fwrite($fs, $http_request);
				while (!feof($fs)) {
					$response .= fgets($fs, 1160);
				}
				fclose($fs);
				$response = explode("\r\n\r\n", $response, 2);
				$imgData = $response[1];
				preg_match("/Content-Type: (.*)\r\n/i",$response[0],$imgType);
				$imgType = $imgType[1];
				$imgExt  = strtolower(substr(strrchr($matches[2], "."),1));
				if(empty($imgExt)) {
					if($imgType == 'image/pjpeg' || $imgType == 'image/jpeg') {
						$imgExt = 'jpg';
					} elseif ($imgType == 'image/x-png' || $imgType == 'image/png') {
						$imgExt = 'png';
					} elseif ($imgType == 'image/gif') {
						$imgExt = 'gif';
					} elseif ($imgType == 'image/bmp') {
						$imgExt = 'bmp';
					} else {
						$imgExt = 'jpg';
					}
				}
				$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
				$fname = md5($imgName) . gmdate('YmdHis') .'.'. $imgExt;
				$attachpath = $uppath . $fname;
				if (!is_dir(Option::UPLOADFILE_PATH)){
					umask(0);
					$ret = @mkdir(Option::UPLOADFILE_PATH, 0777);
					if ($ret === false){
						formMsg('创建文件上传目录失败', "javascript:history.go(-1);", 0);
					}
				}
				if (!is_dir($uppath)){
					umask(0);
					$ret = @mkdir($uppath, 0777);
					if ($ret === false){
						formMsg('上传失败。文件上传目录(content/uploadfile)不可写',"javascript:history.go(-1);",0);
					}
				}
				if($fp = @fopen($attachpath,'w')) {
					fwrite($fp,$imgData);
				} else {
					formMsg('写入文件失败',"javascript:history.go(-1);",0);
				}
				$imgLength = filesize($attachpath);
				$sql = "INSERT INTO ".DB_PREFIX."attachment (blogid,filename,filesize,filepath,addtime) values ($blogid,'".$imgName."','".$imgLength."','".$attachpath."','".time()."')";
				$DB->query($sql);
				$DB->query("UPDATE ".DB_PREFIX."blog SET attnum=attnum+1 WHERE gid=$blogid");
			} else {
				return "<img{$matches[1]}src=\"{$matches[2]}\"{$matches[3]}>";
			}
		} else {
			$attachpath = $row['filepath'];
		}
		$imgUrl = BLOG_URL.substr($attachpath,3);
		return "<img{$matches[1]}src=\"{$imgUrl}\"{$matches[3]}>";
	} else {
		return "<img{$matches[1]}src=\"{$matches[2]}\"{$matches[3]}>";
	}
}
function img2local_option()
{
?>
<input type="checkbox" value="1" name="img2local" checked="checked" />图片本地化
<?php
}
addAction('adm_writelog_head', 'img2local_option');