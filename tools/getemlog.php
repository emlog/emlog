<?php
/**
 * emlog在线安装脚本
 * @copyright (c) Emlog All Rights Reserved
 */
if (version_compare(phpversion(), '5.2', '<')) {
	die('PHP版本必须高于5.2才能使用本安装程序.');
}
define('EMLOG_DOWNLOAD_CHINA', 'http://www.emlog.net/em_download/emlog/emlog_5.1.2.zip');
define('EMLOG_DOWNLOAD_OVERSEA', 'http://emlog.googlecode.com/files/emlog_5.1.2.zip');

define('DOC_ROOT', dirname(__FILE__));
$action = isset($_GET['action']) ? $_GET['action'] : '';
if ($action == 'go') {
	$emlog_zip = $_POST['emlog_zip'];
	if (empty($emlog_zip)) {
		die('压缩包地址为空');
	}
	$http = null;
	try {
		$http = Http::factory($emlog_zip, Http::TYPE_CURL);
	} catch (Exception $e) {
		try {
			$http = Http::factory($emlog_zip, Http::TYPE_SOCK);
		} catch (Exception $e) {
			try {
				$http = Http::factory($emlog_zip, Http::TYPE_STREAM);
			} catch (Exception $e) {
				die('您空间的PHP不支持远程下载.');
			}
		}
	}
	if (!$http) {
		die('您空间的PHP不支持远程下载.');
	}
	$data = $http->send();
	if ($data) {
		$zip_file = DOC_ROOT . '/emlog.zip';
		file_put_contents($zip_file, $data);
		$zip = new ZipArchive;
		if ($zip->open($zip_file) === TRUE) {
			$zip->extractTo(DOC_ROOT);
			$zip->close();
			rcopy(DOC_ROOT . '/emlog_5.1.2/src', DOC_ROOT);
			rrmdir(DOC_ROOT . '/emlog_5.1.2');
			unlink($zip_file);
			unlink(__FILE__);
			header('Location: install.php');
		} else {
			die('压缩包解压缩失败，请尝试重新下载安装.');
		}
	}
	exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>emlog在线安装工具</title>
		<style type="text/css">
			<!--
			body {background-color:#F7F7F7;font-family: Arial;font-size: 12px;line-height:150%;}
			.main {background-color:#FFFFFF;font-size: 12px;color: #666666;width:750px;margin:30px auto;padding:10px;list-style:none;border:#DFDFDF 1px solid; border-radius: 4px;}
			.title{text-align:center; font-size: 24px;}
			.input {border: 1px solid #CCCCCC;font-family: Arial;font-size: 18px;height:28px;background-color:#F7F7F7;color: #666666;margin:0px 0px 0px 25px;}
			.submit{cursor: pointer;font-size: 12px;padding: 4px 10px;}
			.care{color:#0066CC;}
			.title2{font-size:18px;color:#666666;border-bottom: #CCCCCC 1px solid; margin:40px 0px 20px 0px;padding:10px 0px;}
			.foot{text-align:left;}
			.main li{ margin:20px 0px;}
			-->
		</style>
	</head>
	<body>
		<form name="form1" method="post" action="?action=go">
			<div class="main">
				<p class="title">EMLOG在线安装程序</p>
				<div class="b">
					<p class="title2">EMLOG安装包下载点选择</p>
					<?php
					$can_go = true;
					if ( !is_writable(DOC_ROOT)):
						$can_go = false;
					?>
					<p style="color:red">您当前目录<?php echo DOC_ROOT?>没有写入权限，程序无法安装.</p>
					<?php
					endif;
					?>
					<?php
					if ( !class_exists('ZipArchive')):
						$can_go = false;
					?>
					<p style="color:red">PHP的Zip文件支持没有开启，程序无法安装.</p>
					<?php
					endif;
					?>
					<p>
						<select name="emlog_zip">
							<option value="<?php echo EMLOG_DOWNLOAD_CHINA?>">EMLOG 5.1.2 主站下载（适合国内及香港主机）</option>
							<option value="<?php echo EMLOG_DOWNLOAD_OVERSEA?>">EMLOG 5.1.2 美国镜像下载（适合海外主机）</option>
						</select>
					</p>
				</div>
				<div>
					<p class="foot">
						<input type="submit" class="submit" value="开始安装emlog" <?php ! $can_go AND print 'disabled'?>>
					</p>
				</div>
			</div>
		</form>
	</body>
</html>
<?php
function rcopy($src, $dst) {
	if (is_dir($src)) {
		if (!file_exists($dst))
			mkdir($dst);
		$files = scandir($src);
		foreach ($files as $file)
			if ($file != "." && $file != "..")
				rcopy("$src/$file", "$dst/$file");
	} else if (file_exists($src))
		copy($src, $dst);
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$files = scandir($dir);
		foreach ($files as $file)
			if ($file != "." && $file != "..")
				rrmdir("$dir/$file");
		rmdir($dir);
	}
	else if (file_exists($dir))
		unlink($dir);
}

class Http {
	/**
	 * @var 使用 CURL 
	 */

	const TYPE_CURL = 1;
	/**
	 * @var 使用 Socket 
	 */
	const TYPE_SOCK = 2;
	/**
	 * @var 使用 Stream 
	 */
	const TYPE_STREAM = 3;

	/**
	 * http 静态实例
	 */
	protected static $_instance = null;

	/**
	 * 保证对象不被clone 
	 */
	protected function __clone() {
		
	}

	/**
	 * 构造函数 
	 */
	protected function __construct() {
		
	}

	/**
	 * HTTP工厂操作方法 
	 * 
	 * @param string $url 需要访问的URL 
	 * @param int $type 需要使用的HTTP类 
	 * @return object 
	 */
	public static function factory($url = '', $type = self::TYPE_SOCK) {
		if (self::$_instance instanceof Http_Basic) {
			return self::$_instance;
		}
		if ($type == '') {
			$type = self::TYPE_SOCK;
		}
		switch ($type) {
			case self::TYPE_CURL :
				if (!function_exists('curl_init')) {
					throw new Exception(__CLASS__ . " PHP CURL extension not install");
				}
				self::$_instance = new Http_Curl($url);
				break;
			case self::TYPE_SOCK :
				if (!function_exists('fsockopen')) {
					throw new Exception(__CLASS__ . " PHP function fsockopen() not support");
				}
				self::$_instance = new Http_Sock($url);
				break;
			case self::TYPE_STREAM :
				if (!function_exists('stream_context_create')) {
					throw new Exception(__CLASS__ . " PHP Stream extension not install");
				}
				self::$_instance = new Http_Stream($url);
				break;
			default:
				throw new Exception("http access type $type not support");
		}
		return self::$_instance;
	}

	/**
	 * 生成一个供Cookie或HTTP GET Query的字符串 
	 * 
	 * @param array $data 需要生产的数据数组，必须是 Name => Value 结构 
	 * @param string $sep 两个变量值之间分割的字符，缺省是 &  
	 * @return string 返回生成好的Cookie 查询字符串 
	 */
	public static function makeQuery($data, $sep = '&') {
		$encoded = '';
		while (list($k, $v) = each($data)) {
			$encoded .= ($encoded ? "$sep" : "");
			$encoded .= rawurlencode($k) . "=" . rawurlencode($v);
		}
		return $encoded;
	}

}

abstract class Http_Basic {

	/**
	 * @var object 对象单例 
	 */
	static $_instance = NULL;

	/**
	 * @var string 需要发送的cookie信息 
	 */
	protected $cookies = '';

	/**
	 * @var array 需要发送的头信息 
	 */
	protected $header = array();

	/**
	 * @var string 需要访问的URL地址 
	 */
	protected $uri = '';

	/**
	 * @var array 需要发送的数据 
	 */
	protected $vars = array();

	/**
	 * 保证对象不被clone 
	 */
	protected function __clone() {
		
	}

	/**
	 * 构造函数 
	 * 
	 * @param string $configFile 配置文件路径 
	 */
	public function __construct($url) {
		$this->uri = $url;
	}

	/**
	 * 设置需要发送的HTTP头信息 
	 *  
	 * @param array/string 需要设置的头信息，可以是一个 类似 array('Host: example.com', 'Accept-Language: zh-cn') 的头信息数组 
	 *       或单一的一条类似于 'Host: example.com' 头信息字符串 
	 * @return void 
	 */
	public function setHeader($header) {
		if (empty($header)) {
			return;
		}
		if (is_array($header)) {
			foreach ($header as $k => $v) {
				$this->header[] = is_numeric($k) ? trim($v) : (trim($k) . ": " . trim($v));
			}
		} elseif (is_string($header)) {
			$this->header[] = $header;
		}
	}

	/**
	 * 设置Cookie头信息 
	 *  
	 * 注意：本函数只能调用一次，下次调用会覆盖上一次的设置 
	 * 
	 * @param string/array 需要设置的 Cookie信息，一个类似于 'name1=value1&name2=value2' 的Cookie字符串信息， 
	 *         或者是一个 array('name1'=& gt;'value1', 'name2'=>'value2') 的一维数组 
	 * @return void 
	 */
	public function setCookie($cookie) {
		if (empty($cookie)) {
			return;
		}
		if (is_array($cookie)) {
			$this->cookies = Http::makeQuery($cookie, ';');
		} elseif (is_string($cookie)) {
			$this->cookies = $cookie;
		}
	}

	/**
	 * 设置要发送的数据信息 
	 * 
	 * 注意：本函数只能调用一次，下次调用会覆盖上一次的设置 
	 * 
	 * @param array 设置需要发送的数据信息，一个类似于 array('name1'=>'value1', 'name2'=>'value2') 的一维数组 
	 * @return void 
	 */
	public function setVar($vars) {
		if (empty($vars)) {
			return;
		}
		if (is_array($vars)) {
			$this->vars = $vars;
		}
	}

	/**
	 * 设置要请求的URL地址 
	 * 
	 * @param string $url 需要设置的URL地址 
	 * @return void 
	 */
	public function setUrl($url) {
		if ($url != '') {
			$this->uri = $url;
		}
	}

	/**
	 * 发送HTTP GET请求 
	 * 
	 * @param string $url 如果初始化对象的时候没有设置或者要设置不同的访问URL，可以传本参数 
	 * @param array $vars 需要单独返送的GET变量 
	 * @param array/string 需要设置的头信息，可以是一个 类似 array('Host: example.com', 'Accept-Language: zh-cn') 的头信息数组 
	 *         或单一的一条类似于 'Host: example.com' 头信息字符串 
	 * @param string/array 需要设置的Cookie信息，一个类似于 'name1=value1&name2=value2' 的Cookie字符串信息， 
	 *         或者是一个 array('name1'=& gt;'value1', 'name2'=>'value2') 的一维数组 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return unknown 
	 */
	public function get($url = '', $vars = array(), $header = array(), $cookie = '', $timeout = 30, $options = array()) {
		$this->setUrl($url);
		$this->setHeader($header);
		$this->setCookie($cookie);
		$this->setVar($vars);
		return $this->send('GET', $timeout);
	}

	/**
	 * 发送HTTP POST请求 
	 * 
	 * @param string $url 如果初始化对象的时候没有设置或者要设置不同的访问URL，可以传本参数 
	 * @param array $vars 需要单独返送的GET变量 
	 * @param array/string 需要设置的头信息，可以是一个 类似 array('Host: example.com', 'Accept-Language: zh-cn') 的头信息数组 
	 *         或单一的一条类似于 'Host: example.com' 头信息字符串 
	 * @param string/array 需要设置的Cookie信息，一个类似于 'name1=value1&name2=value2' 的Cookie字符串信息， 
	 *         或者是一个 array('name1'=& gt;'value1', 'name2'=>'value2') 的一维数组 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return unknown 
	 */
	public function post($url = '', $vars = array(), $header = array(), $cookie = '', $timeout = 5, $options = array()) {
		$this->setUrl($url);
		$this->setHeader($header);
		$this->setCookie($cookie);
		$this->setVar($vars);
		return $this->send('POST', $timeout);
	}

	protected function unchunkHttp11($data) {
		$fp = 0;
		$outData = '';
		while ($fp < strlen($data)) {
			$rawnum = substr($data, $fp, strpos(substr($data, $fp), "\r\n") + 2);
			$num = hexdec(trim($rawnum));
			$fp += strlen($rawnum);
			$chunk = substr($data, $fp, $num);
			$outData .= $chunk;
			$fp += strlen($chunk);
		}
		return $outData;
	}

}

/**
 * 使用CURL 作为核心操作的HTTP访问类 
 * 
 * @desc CURL 以稳定、高效、移植性强作为很重要的HTTP 协议访问客户端，必须在PHP中安装 CURL 扩展才能使用本功能 
 */
class Http_Curl extends Http_Basic {

	/**
	 * 发送HTTP请求核心函数 
	 * 
	 * @param string $method 使用GET还是 POST方式访问 
	 * @param array $vars 需要另外附加发送的GET/POST数据 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return string 返回服务器端读取的返回数据 
	 */
	public function send($method = 'GET', $timeout = 30, $options = array()) {
		// 处理参数是否为空  
		if ($this->uri == '') {
			throw new Exception(__CLASS__ . ": Access url is empty");
		}

		// 初始化CURL  
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

		// 设置特殊属性  
		if (!empty($options)) {
			curl_setopt_array($ch, $options);
		}
		// 处理GET请求参数  
		if ($method == 'GET' && !empty($this->vars)) {
			$query = Http::makeQuery($this->vars);
			$parse = parse_url($this->uri);
			$sep = isset($parse['query']) ? '&' : '?';
			$this->uri .= $sep . $query;
		}
		// 处理POST请求数据  
		if ($method == 'POST') {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $this->vars);
		}

		// 设置cookie信息  
		if (!empty($this->cookies)) {
			curl_setopt($ch, CURLOPT_COOKIE, $this->cookies);
		}
		// 设置HTTP缺省头  
		if (empty($this->header)) {
			$this->header = array(
				'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)',
					//'Accept-Language: zh-cn',            
					//'Cache-Control: no-cache',  
			);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
		// 发送请求读取输数据  
		curl_setopt($ch, CURLOPT_URL, $this->uri);
		$data = curl_exec($ch);
		if ($err = curl_error($ch)) {
			curl_close($ch);
			throw new Exception(__CLASS__ . " error: " . $err);
		}
		curl_close($ch);
		return $data;
	}

}

/**
 * 使用 Socket操作(fsockopen) 作为核心操作的HTTP访问接口 
 * 
 * @desc Network/fsockopen 是PHP 内置的一个Sokcet网络访问接口，必须安装/打开 fsockopen 函数本类才能工作， 
 *    同时确保其他相关网络环境和配置是正确的 
 */
class Http_Sock extends Http_Basic {

	/**
	 * 发送HTTP请求核心函数 
	 * 
	 * @param string $method 使用GET还是 POST方式访问 
	 * @param array $vars 需要另外附加发送的GET/POST数据 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return string 返回服务器端读取的返回数据 
	 */
	public function send($method = 'GET', $timeout = 30, $options = array()) {
		//处理参数是否为空  
		if ($this->uri == '') {
			throw new Exception(__CLASS__ . ": Access url is empty");
		}

		// 处理GET请求参数  
		if ($method == 'GET' && !empty($this->vars)) {
			$query = Http::makeQuery($this->vars);
			$parse = parse_url($this->uri);
			$sep = isset($parse['query']) && ($parse['query'] != '') ? '&' : '?';
			$this->uri .= $sep . $query;
		}

		// 处理POST请求数据  
		$data = '';
		if ($method == 'POST' && !empty($this->vars)) {
			$data = Http::makeQuery($this->vars);
			$this->setHeader('Content-Type: application/x-www-form-urlencoded');
			$this->setHeader('Content-Length: ' . strlen($data));
		}

		//解析URL地址  
		$url = parse_url($this->uri);
		$host = $url['host'];
		$port = isset($url['port']) && ($url['port'] != '') ? $url['port'] : 80;
		$path = isset($url['path']) && ($url['path'] != '') ? $url['path'] : '/';
		$path .= isset($url['query']) ? "?" . $url['query'] : '';

		// 组织HTTP请求头信息  
		array_unshift($this->header, $method . " " . $path . " HTTP/1.1");
		$this->setHeader('User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; InfoPath.1)');
		if (!preg_match("/^[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}$/", $host)) {
			$this->setHeader("Host: " . $host);
		}
		if ($this->cookies != '') {
			$this->setHeader("Cookie: " . $this->cookies);
		}
		$this->setHeader("Connection: keep-alive");
		//'Accept-Language: zh-cn',  
		//'Cache-Control: no-cache',  
		// 构造请求信息  
		$header = '';
		foreach ($this->header as $h) {
			$header .= $h . "\r\n";
		}
		$header .= "\r\n";
		if ($method == 'POST' && $data != '') {
			$header .= $data . "\r\n";
		}

		// 连接服务器发送请求数据  
		$ip = gethostbyname($host);
		if (!($fp = fsockopen($ip, $port, $errno, $errstr, $timeout))) {
			throw new Exception(__CLASS__ . ": Can't connect $host:$port, errno:$errno,message:$errstr");
		}

		fputs($fp, $header);
		$lineSize = 1024;

		// 处理301,302跳转页面访问  
		$line = fgets($fp, $lineSize);
		$first = preg_split("/\s/", trim($line));
		if (isset($first[1]) && in_array($first[1], array('301', '302'))) {
			while (!feof($fp)) {
				$line = fgets($fp, $lineSize);
				$second = preg_split("/\s/", trim($line));
				if (ucfirst(trim($second[0])) == 'Location:' && $second[1] != '') {
					$this->header = array();
					return $this->get(trim($second[1]));
				}
			}
		}

		$response = '';
		while (!feof($fp)) {
			$response .= fgets($fp, 1160);
		}

		die($response);
		// 取内容
		$data = substr($response, (strpos($response, "\r\n\r\n") + 4));
		// 处理分块传输的数据
		if (strpos(strtolower($response), 'transfer-encoding: chunked') !== FALSE) {
			$data = $this->unchunkHttp11($data);
		}
		fclose($fp);
		return $data;
	}

}

/**
 * 使用文件流操作函数为核心操作的HTTP访问接口 
 * 
 * @desc stream_* 和 fopen/file_get_contents 是 PHP内置的一个流和文件操作接口，必须打开 fsockopen 函数本类才能工作， 
 *    同时确保其他相关网络环境和配置是正确的，包括 allow_url_fopen 等设置 
 */
class Http_Stream extends Http_Basic {

	/**
	 * 发送HTTP请求核心函数 
	 * 
	 * @param string $method 使用GET还是 POST方式访问 
	 * @param array $vars 需要另外附加发送的GET/POST数据 
	 * @param int $timeout 连接对方服务器访问超时时间，单位为秒 
	 * @param array $options 当前操作类一些特殊的属性设置 
	 * @return string 返回服务器端读取的返回数据 
	 */
	public function send($method = 'GET', $timeout = 30, $options = array()) {
		// 处理参数是否为空  
		if ($this->uri == '') {
			throw new Exception(__CLASS__ . ": Access url is empty");
		}
		$parse = parse_url($this->uri);
		$host = $parse['host'];

		// 处理GET请求参数  
		if ($method == 'GET' && !empty($this->vars)) {
			$query = Http::makeQuery($this->vars);
			$sep = isset($parse['query']) && ($parse['query'] != '') ? '&' : '?';
			$this->uri .= $sep . $query;
		}


		// 处理POST请求数据  
		$data = '';
		if ($method == 'POST' && !empty($this->vars)) {
			$data = Http::makeQuery($this->vars);
		}

		// 设置缺省头  
		$this->setHeader('User-Agent: Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; SV1; InfoPath.1)');
		if (!preg_match("/^[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}$/", $host)) {
			$this->setHeader("Host: " . $host);
		}
		if ($this->cookies != '') {
			$this->setHeader("Cookie: " . $this->cookies);
		}
		$this->setHeader("Connection: Close");
		//'Accept-Language: zh-cn',  
		//'Cache-Control: no-cache',          
		//构造头信息  
		$opts = array(
			'http' => array(
				'method' => $method,
				'timeout' => $timeout,
			)
		);
		if ($data != '') {
			$opts['http']['content'] = $data;
		}
		$opts['http']['header'] = '';
		foreach ($this->header as $h) {
			$opts['http']['header'] .= $h . "\r\n";
		}

		// 读取扩展设置选项  
		if (!empty($options)) {
			isset($options['proxy']) ? $opts['http']['proxy'] = $options['proxy'] : '';
			isset($options['max_redirects']) ? $opts['http']['max_redirects'] = $options['max_redirects'] : '';
			isset($options['request_fulluri']) ? $opts['http']['request_fulluri'] = $options['request_fulluri'] : '';
		}

		// 发送数据返回  
		$context = stream_context_create($opts);
		if (($buf = file_get_contents($this->uri, null, $context)) === false) {
			throw new Exception(__CLASS__ . ": file_get_contents(" . $this->uri . ") fail");
		}
		return $buf;
	}

}
?>