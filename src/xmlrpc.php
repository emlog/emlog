<?php
define('EMLOG_ROOT', dirname(__FILE__));
ob_start();
require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/lib/class.cache.php';
require_once EMLOG_ROOT . '/lib/class.mysql.php';
require_once EMLOG_ROOT . '/lib/function.base.php';
require_once EMLOG_ROOT . '/lib/function.login.php';
require_once EMLOG_ROOT . '/model/class.blog.php';
require_once EMLOG_ROOT . '/model/class.sort.php';

/**
 * 需要完善
 */
define('XML_RPC_ENABLE', true);
define('UPLOADFILE_PATH', EMLOG_ROOT . '/content/uploadfile/');//附件保存目录
$api_methods = array(
	// metaWeblog 接口
	'metaWeblog.newPost' => 'mw_newPost',
	'metaWeblog.editPost' => 'mw_editPost',
	'metaWeblog.getPost' => 'mw_getPost',
	'metaWeblog.getRecentPosts' => 'mw_getRecentPosts',
	'metaWeblog.getCategories' => 'mw_getCategories',
	'metaWeblog.newMediaObject' => 'mw_newMediaObject',
	// blogger 接口
	'blogger.deletePost' => 'mw_deletePost',
	'blogger.getUsersBlogs' => 'blogger_getUsersBlogs'
);

$DB = new MySql(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
$CACHE = new mkcache($DB, DB_PREFIX);
$options_cache = $CACHE->readCache('options');

// 有些基于浏览器的客户端会发送cookie，我们不需要它们
$_COOKIE = array();
// PHP 5.2.2 以下版本有一个bug, 常量 $HTTP_RAW_POST_DATA 系统不会自动生成
if (!isset($HTTP_RAW_POST_DATA)) {
	$HTTP_RAW_POST_DATA = file_get_contents('php://input');
}
// 修复mozBlog或其他个例不兼容<?xml标签不在第一行的情况
if (isset($HTTP_RAW_POST_DATA))
	$HTTP_RAW_POST_DATA = trim($HTTP_RAW_POST_DATA);


// 向客户端发送api支持信息
if (isset($_GET['rsd'])) {
	header('Content-Type: text/xml; charset=utf-8', true);
	echo '<?xml version="1.0" encoding="utf-8"?>
			<rsd version="1.0" xmlns="http://archipelago.phrasewise.com/rsd">
				<service>
					<engineName>emlog</engineName>
					<engineLink>http://emlog.net/</engineLink>
					<homePageLink>http://emlog.net/</homePageLink>
					<apis>
						<api name="MetaWeblog" blogID="1" preferred="true" apiLink="xmlrpc2.php" />
					</apis>
				</service>
			</rsd>
		 ';
	exit;
}


if (!$HTTP_RAW_POST_DATA) {
   header( 'Content-Type: text/plain' );
   die('XML-RPC server accepts POST requests only.');
}
$data = $HTTP_RAW_POST_DATA;

$current_tag_contents = $current_tag = $message_type = $method_name = NULL;
$array_structs_types = $array_structs = $current_struct_name_array = $params = array();

$data = preg_replace('/<\?xml.*?\?'.'>/', '', $data);
if (trim($data) == '') {
	die('Empty Request Content');
}
$parser = xml_parser_create();
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, 'tag_open', 'tag_close');
xml_set_character_data_handler($parser, 'cdata');
if (!xml_parse($parser, $data)) {
	/* die(sprintf('XML error: %s at line %d',
		xml_error_string(xml_get_error_code($this->_parser)),
		xml_get_current_line_number($this->_parser))); */
	return false;
}
xml_parser_free($parser);
if (!array_key_exists($method_name, $api_methods)) die('unknow request');

call_user_func($api_methods[$method_name], $params);

/**
 *  读取博客信息
 *
 */
function blogger_getUsersBlogs() {
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
		<methodResponse>
			<params>
				<param>
					<value>
						<array>
							<data>
								<value>
									<struct>
										<member>
											<name>url</name>
											<value>
												<string>1</string>
											</value>
										</member>
										<member>
											<name>blogid</name>
											<value>
												<string>2</string>
											</value>
										</member>
										<member>
											<name>blogName</name>
											<value>
												<string>3</string>
											</value>
										</member>
									</struct>
								</value>
							</data>
						</array>
					</value>
				</param>
			</params>
		</methodResponse>";
	echo $xml;
}

/**
 *  删除日志
 *
 */
function mw_deletePost($args) {
	global $DB;
	escape($args);
	$id = intval($args[1]);
	$user = login($args[2], $args[3]);
	define('UID', $user['uid']);
	$emBlog = new emBlog($DB);
	$emBlog->deleteLog($id);
	response('<boolean>1</boolean>');
}
/**
 *  更新日志
 *
 */
function mw_editPost($args) {
	global $DB, $CACHE;
	escape($args);
	$username = $args[1];
	$password = $args[2];
	$user = login($username, $password);
	define('UID', $user['uid']);
	
	// 接受参数
	$id = intval($args[0]);
	$username = $args[1];
	$password = $args[2];
	$data = $args[3];
	$publish = $args[4];

	$update_data['title'] = addslashes($data[0]);
	$update_data['content'] = addslashes(htmlspecialchars_decode($data[1]));
	$update_data['author'] = UID;
	$update_data['hide'] = $publish == 1 ? 'n' : 'y';
	
	// 根据分类名称取分类id,注意只取第一个分类
	$sort_name = isset($data[2][0]) ? addslashes($data[2][0]) : '';
	$emSort = new emSort($DB);
	$sorts = $emSort->getSorts();
	unset($emSort);
	$update_data['sortid'] = '-1';
	foreach ($sorts as $sort) {
		if ($sort_name == $sort['sortname']) {
			$update_data['sortid'] = $sort['sid'];
			break;
		}
	}
	
	// 发布时间
	if (isset($data[3]) && is_object($data[3])) {
		$update_data['date'] = @gmmktime($data[3]->hour, $data[3]->minute , $data[3]->second , $data[3]->month , $data[3]->day , $data[3]->year);
	}
	
	// 更新数据
	$emBlog = new emBlog($DB);
	$emBlog->updateLog($update_data, $id);
	
	// 更新缓存
	$CACHE->mc_logtags();
	$CACHE->mc_logatts();
	$CACHE->mc_logsort();
	$CACHE->mc_record();
	$CACHE->mc_newlog();
	$CACHE->mc_sort();
	$CACHE->mc_tags();
	$CACHE->mc_user();
	$CACHE->mc_sta();
	response('<boolean>1</boolean>');
}

/**
 *  取得博客分类
 *
 */
function mw_getCategories($args) {
	global $DB;
	escape($args);
	$username = $args[1];
	$password = $args[2];
	
	login($username, $password);
	
	$emSort = new emSort($DB);
	$sorts = $emSort->getSorts();
	unset($emSort);
	$xml = '';
	foreach ($sorts as $sort) {
		$xml .= "
			<value>
				<struct>
					<member>
						<name>description</name>
						<value>{$sort['sortname']}</value>
					</member>
					<member>
						<name>title</name>
						<value>{$sort['sortname']}</value>
					</member>
				</struct>
			</value>
		";
	}
	$xml = "<array><data>$xml</data></array>";
	response($xml);
}


/**
 *  保存新日志
 *
 */
function mw_newPost($args) {
	global $DB, $options_cache, $CACHE;
	escape($args);
	
	$user = login($args[1], $args[2]);
	define('UID', $user['uid']);
	
	$id = intval($args[0]);
	$username = $args[1];
	$password = $args[2];
	$data = $args[3];
	$publish = $args[4];
	$update_data['title'] = addslashes($data[0]);
	$update_data['content'] = addslashes(htmlspecialchars_decode($data[1]));
	$update_data['author'] = UID;
	$update_data['hide'] = $publish == 1 ? 'n' : 'y';
	$update_data['excerpt'] = '';
	
	// 只取第一个分类
	$sort_name = isset($data[2][0]) ? addslashes($data[2][0]) : '';
	$emSort = new emSort($DB);
	$sorts = $emSort->getSorts();
	unset($emSort);
	$update_data['sortid'] = '-1';
	foreach ($sorts as $sort) {
		if ($sort_name == $sort['sortname']) {
			$update_data['sortid'] = $sort['sid'];
			break;
		}
	}
	// 发布时间
	if (isset($data[3]) && is_object($data[3])) {
		$update_data['date'] = @gmmktime($data[3]->hour, $data[3]->minute , $data[3]->second , $data[3]->month , $data[3]->day , $data[3]->year);
	} else {
		$update_data['date'] = time() - ($options_cache['timezone'] - 8) * 3600;
	}
	// 更新数据
	$emBlog = new emBlog($DB);
	$new_id = $emBlog->addlog($update_data);
	// 更新缓存
	$CACHE->mc_logtags();
	$CACHE->mc_logatts();
	$CACHE->mc_logsort();
	$CACHE->mc_record();
	$CACHE->mc_newlog();
	$CACHE->mc_sort();
	$CACHE->mc_tags();
	$CACHE->mc_user();
	$CACHE->mc_sta();
	response("<i4>$new_id</i4>");
}

/**
 *  读取日志信息
 *
 */
function mw_getPost($args) {
	global $DB, $options_cache;
	escape($args);

	$post_ID = intval($args[0]);
	$username = $args[1];
	$password = $args[2];

	$user = login($username, $password);
	
	$emBlog = new emBlog($DB);
	define('UID', $user['uid']);
	$post = $emBlog -> getOneLogForAdmin($post_ID);
	if (empty($post)) return error_message(404, '对不起,您访问日志不存在');
	$log_cache_tags = $options_cache['log_tags'];
	$tags = '';
	if (!empty($log_cache_tags[$post_ID])) {
		foreach ($log_cache_tags[$post_ID] as $tag) {
			$tags .= $value['tagname'] . ',';
		} 
	} 
	$emSort = new emSort($DB);
	$sort_name = $emSort->getSortName($post['sortid']);
	unset($emSort,$emBlog);
	
	$post['date'] = getIso($post['date']);
	$xml = "
	<struct>
		<member>
			<name>categories</name>
				<value>
					<array>
						<data>
							<value>{$sort_name}</value>
						</data>
					</array>
				</value>
		</member>
		<member>
			<name>dateCreated</name>
			<value>
				<dateTime.iso8601>{$post['date']}</dateTime.iso8601>
			</value>
		</member>
		<member>
			<name>description</name>
			<value>
				{$post['content']}
			</value>
		</member>
		<member>
			<name>link</name>
			<value>http://blogs.law.harvard.edu/lydon/2003/07/18#a187</value>
		</member>
		<member>
			<name>postid</name>
			<value>
				<string>{$post['gid']}</string>
			</value>
		</member>
		<member>
			<name>title</name>
			<value>{$post['title']}</value>
		</member>
		<member>
			<name>publish</name>
			<value>
				<boolean>1</boolean>
			</value>
		</member>
	</struct>
	";
	response($xml);
}


function mw_getRecentPosts($args) {
	global $DB;
	escape($args);
	$username = $args[1];
	$password = $args[2];
	$num_posts = intval($args[3]);

	$num_posts == 0 && $num_posts = 1;

	$user = login($username, $password);

	$query = $DB->query('SELECT gid,title,date,content,author,sortid FROM ' . DB_PREFIX . 'blog ORDER BY date DESC LIMIT 0,' . $num_posts);

	$xml = '';
	$recent_posts = array();
	while ($post = $DB -> fetch_array($query)) {
		$post['title'] = htmlspecialchars($post['title']);
		$post['content'] = htmlspecialchars($post['content']);
		$post['date'] = getIso($post['date']);
		
		$xml .= "<value>
				<struct>
				<member>
					<name>title</name>
					<value>
						<string>{$post['title']}</string>
					</value>
				</member>
				<member>
					<name>description</name>
					<value>
						<string>{$post['content']}</string>
					</value>
				</member>
				<member>
					<name>dateCreated</name>
					<value>
						<dateTime.iso8601>{$post['date']}</dateTime.iso8601>
					</value>
				</member>
				<member>
					<name>categories</name>
					<value>
						<array>
							<data>
								<value><string></string></value>
							</data>
						</array>
					</value>
				</member>
				<member>
					<name>postid</name>
					<value>
						<string>{$post['gid']}</string>
					</value>
				</member>
				<member>
					<name>userid</name>
					<value><string>1</string></value>
				</member>
				<member>
				<name>publish</name>
					<value>
						<string>1</string>
					</value>
				</member>
				<member>
					<name>link</name>
					<value><string>http://emlog.net/blog</string></value>
				</member>
			</struct></value>";
	} 

	if (empty($xml)) {
		error_massage(404, '没有日志');
	} 
	$xml = "<array><data>$xml</data></array>";
	response($xml);
}

function mw_newMediaObject($args) {
	global $DB,$options_cache;
	escape($args);
	$username = $args[1];
	$password = $args[2];
	$user = login($username, $password);
	$file = $args[3];
    if (!preg_match('/([^\/\:\*\?<>\|]+\.\w{2,6})|(\\{2}[^\/\:\*\?<>\|]+\.\w{2,6})/',$file[0],$matches))
        error_message(500,'文件错误');
    $filename = $matches[0];
	$type = $file[1];
	$bits = $file[2];
 
    if(!empty($data["overwrite"]) && ($data["overwrite"] == true)) {
	   
	}
    
    $att_type = array('rar','zip','gif', 'jpg', 'jpeg', 'png', 'bmp');
    
    if (empty($filename) )
		error_message(500,'文件名错误');

	$extension  = strtolower(substr(strrchr($filename, "."),1));
    
    // 文件类型检测
	if (!in_array($extension, $att_type)) {
		error_message(500,'文件类型错误');
	}
    $uppath = UPLOADFILE_PATH . date('Ym') . '/';
	$fname = md5($fileName) . date('YmdHis') .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(UPLOADFILE_PATH)) {
		umask(0);
		$ret = @mkdir(UPLOADFILE_PATH, 0777);
		if ($ret === false) {
			error_message(500,'创建文件上传目录失败');
		}
	}
	if (!is_dir($uppath)) {
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
			error_message(500,'上传失败。文件上传目录(content/uploadfile)不可写');
		}
	}
    Header( "Content-type: image/jpg"); 
    echo $bits;
    die;
    $fp = @fopen($attachpath, 'wb');
	if (!$fp)
		error_message(500,'文件无法写入');
	fwrite($fp, $bits);
	fclose($fp);
    
    doAction('xmlrpc_attach_upload', $attachpath);
   
	// resizeImage
	$imtype = array('jpg','png','jpeg');
	$thum = $uppath.'thum-'. $fname;
    $thum_created = true;
	if (IS_THUMBNAIL && in_array($extension, $imtype) && function_exists('ImageCreate')) {
	    $max_w = IMG_ATT_MAX_W;
		$max_h = IMG_ATT_MAX_H;
        $size = chImageSize($img,$max_w,$max_h);
    	$newwidth = $size['w'];
    	$newheight = $size['h'];
    	$w =$size['rc_w'];
    	$h = $size['rc_h'];
    	if ($w <= $max_w && $h <= $max_h) {
    		$thum_created = false;
    	}
        
    	if ($imgType == 'image/pjpeg' || $imgType == 'image/jpeg') {
    		if (function_exists('imagecreatefromjpeg')) {
    			$img = imagecreatefromjpeg($attachpath);
    		} else {
    			$thum_created = false;
    		}
    	} elseif ($imgType == 'image/x-png' || $imgType == 'image/png') {
    		if (function_exists('imagecreatefrompng')) {
    			$img = imagecreatefrompng($attachpath);
    		} else {
    			$thum_created = false;
    		}
    	}
        
    	if (function_exists('imagecopyresampled')) {
    		$newim = imagecreatetruecolor($newwidth, $newheight);
    		imagecopyresampled($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
    	} else {
    		$newim = imagecreate($newwidth, $newheight);
    		imagecopyresized($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
    	}
        
    	if ($imgType == 'image/pjpeg' || $imgType == 'image/jpeg') {
    		if(!imagejpeg($newim,$thumPatch)) {
    			$thum_created = false;
    		}
    	} elseif ($imgType == 'image/x-png' || $imgType == 'image/png') {
    		if (!imagepng($newim,$thumPatch)) {
    			$thum_created = false;
    		}
    	}
    	ImageDestroy($newim);
	}
    $img_url = $options_cache['blogurl'] . '/content/upload/' . date('Ym') . $fname;
    $file_name = $thum_created ? 'thum-'. $fname : $fname;
    $xml = "
        <struct>
            <member>
                <name>file</name>
                <value>
                    <string>$file_name</string> 
                </value>
            </member>
            <member>
                <name>url</name>
                <value>
                    <string>$img_url</string> 
                </value>
            </member>
            <member>
                <name>type</name>
                <value>
                    <string>$imgType</string> 
                </value>
            </member>
        </struct>
    ";
    response($xml);
}

function getIso($timestamp) {
	$year = date('Y', $timestamp);
	$month = date('m', $timestamp);
	$day = date('d', $timestamp);
	$hour = date('H', $timestamp);
	$minute = date('i', $timestamp);
	$second = date('s', $timestamp);
	return $year.$month.$thisday.'T'.$hour.':'.$minute.':'.$second.$timezone;
}



function login($username, $password) {
	$username = addslashes($username);
	$password = addslashes($password);
	/**
	 * 需要完善
	 */
	if (XML_RPC_ENABLE !== true) {
		error_message(405, '本博客没有开启XML-RPC服务.请登陆后台博客开启');
		return false;
	} 
	// 检查用户权限
	if (!checkUser($username, $password , '' , '')) {
		error_message(403, '用户名密码错误');
		return false;
	} 
	// 返回用户信息
	return getUserDataByLogin($username);
}

function escape(&$array) {
	if (!is_array($array)) {
		return(mysql_real_escape_string($array));
	} else {
		foreach ( (array) $array as $k => $v ) {
			if (is_array($v)) {
				escape($array[$k]);
			} else if (is_object($v)) {
				//skip
			} else {
				$array[$k] = mysql_real_escape_string($v);
			}
		}
	}
} 

function response($result_xml) {
	$xml = "
		<methodResponse>
		  <params>
			<param>
			  <value>
				$result_xml
			  </value>
			</param>
		  </params>
		</methodResponse>
	";
	output($xml);
}
 
function error_message($code, $message) {
	$message = htmlspecialchars($message);
	$xml = "<methodResponse>
			  <fault>
				<value>
				  <struct>
					<member>
					  <name>faultCode</name>
					  <value><int>{$code}</int></value>
					</member>
					<member>
					  <name>faultString</name>
					  <value><string>{$message}</string></value>
					</member>
				  </struct>
				</value>
			  </fault>
			</methodResponse>
	";
	output($xml);
}

function output($xml) {
	$xml = '<?xml version="1.0" encoding="utf-8"?>'."\n".$xml;
	$length = strlen($xml);
	header('Connection: close');
	header('Content-Length: '. $length);
	header('Content-Type: text/xml');
	header('Date: '. date('r'));
	echo $xml;
	exit;
}

function cdata($parser, $cdata) {
	global $current_tag_contents;
	$current_tag_contents .= $cdata;
}

function tag_open($parser, $tag, $attr) {
	global $current_tag_contents, $current_tag, $array_structs_types, $array_structs, $message_type, $params;
	$current_tag_contents = '';
	$current_tag = $tag;
	switch($tag) {
		case 'methodCall':
		case 'methodResponse':
		case 'fault':
			$message_type = $tag;
			break;
		/* Deal with stacks of arrays and structs */
		case 'data':    // data is to all intents and puposes more interesting than array
			$array_structs_types[] = 'array';
			$array_structs[] = array();
			break;
		case 'struct':
			$array_structs_types[] = 'struct';
			$array_structs[] = array();
			break;
	}
}

function tag_close($parser, $tag) {
	global $current_tag_contents, $current_tag, $array_structs_types, $array_structs, $message_type, $current_struct_name_array, $method_name, $params;
	$valueFlag = false;
	switch($tag) {
		case 'int':
		case 'i4':
			$value = (int) trim($current_tag_contents);
			$valueFlag = true;
			break;
		case 'double':
			$value = (double) trim($current_tag_contents);
			$valueFlag = true;
			break;
		case 'string':
			$value = $current_tag_contents;
			$valueFlag = true;
			break;
		case 'dateTime.iso8601':
			$value = new IXR_Date(trim($current_tag_contents));
			// $value = $iso->getTimestamp();
			$valueFlag = true;
			break;
		case 'value':
			// "If no type is indicated, the type is string."
			if (trim($current_tag_contents) != '') {
				$value = (string)$current_tag_contents;
				$valueFlag = true;
			}
			break;
		case 'boolean':
			$value = (boolean) trim($current_tag_contents);
			$valueFlag = true;
			break;
		case 'base64':
			$value = base64_decode(trim( $current_tag_contents ) );
			$valueFlag = true;
			break;
		/* Deal with stacks of arrays and structs */
		case 'data':
		case 'struct':
			$value = @array_pop($array_structs);
			@array_pop($array_structstypes);
			$valueFlag = true;
			break;
		case 'member':
			array_pop($current_struct_name_array);
			break;
		case 'name':
			$current_struct_name_array[] = trim($current_tag_contents);
			break;
		case 'methodName':
			$method_name = trim($current_tag_contents);
			break;
	}
	if ($valueFlag) {
		if (count($array_structs) > 0) {
			// Add value to struct or array
			if ($array_structstypes[count($array_structstypes)-1] == 'struct') {
				// Add to struct
				$array_structs[count($array_structs)-1][$current_struct_name_array[count($current_struct_name_array) - 1]] = $value;
			} else {
				// Add to array
				$array_structs[count($array_structs)-1][] = $value;
			}
		} else {
			// Just add as a paramater
			$params[] = $value;
		}
	}
	$current_tag_contents = '';
}