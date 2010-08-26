<?php
/**
 * xmlrpc博客服务接口
 *
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

ob_start();
require_once 'options.php';
require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/lib/class.cache.php';
require_once EMLOG_ROOT . '/lib/class.mysql.php';
require_once EMLOG_ROOT . '/lib/function.base.php';
require_once EMLOG_ROOT . '/lib/function.login.php';
require_once EMLOG_ROOT . '/model/class.blog.php';
require_once EMLOG_ROOT . '/model/class.sort.php';
require_once EMLOG_ROOT . '/model/class.tag.php';

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

$DB = MySql::getInstance();
$options_cache = mkcache::getInstance()->readCache('options');
// 有些基于浏览器的客户端会发送cookie，我们不需要它们
$_COOKIE = array();
// PHP 5.2.2 以下版本有一个bug, 常量 $HTTP_RAW_POST_DATA 系统不会自动生成
if (!isset($HTTP_RAW_POST_DATA)) {
	$HTTP_RAW_POST_DATA = file_get_contents('php://input');
}
// 修复mozBlog或其他个例不兼容xml标签不在第一行的情况
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
					<homePageLink>' . $options_cache['blogurl'] . '</homePageLink>
					<apis>
						<api name="MetaWeblog" blogID="1" preferred="true" apiLink="' . $options_cache['blogurl'] . 'xmlrpc.php" />
						<api name="Blogger" blogID="1" preferred="false" apiLink="' . $options_cache['blogurl'] . 'xmlrpc.php" />
					</apis>
				</service>
			</rsd>
		 ';
	exit;
}
if ($options_cache['isxmlrpcenable'] == 'n') {
	error_message(500, '提示:博客XMLRPC服务未开启.');
}
if (!$HTTP_RAW_POST_DATA) {
	error_message(500, '错误:XML-RPC服务器只能接受POST数据');
}
$data = $HTTP_RAW_POST_DATA;

$current_tag_contents = $current_tag = $message_type = $method_name = null;
$array_structs_types = $array_structs = $current_struct_name_array = $params = array();

$data = preg_replace('/<\?xml.*?\?' . '>/', '', $data);
if (trim($data) == '') {
	error_message(500, '错误:提交数据内容为空');
}
// 兼容php libxml模块2.7.0-2.7.3版本解析xml丢失html标签括号的bug
if (in_array(LIBXML_DOTTED_VERSION, array('2.7.0', '2.7.1', '2.7.2', '2.7.3'))) {
	$data = str_replace(array('&lt;', '&gt;', '&amp;'), array('&#60;', '&#62;' , '&#38;'), $data);
}

$parser = xml_parser_create();
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
xml_set_element_handler($parser, 'tag_open', 'tag_close');
xml_set_character_data_handler($parser, 'cdata');
if (!xml_parse($parser, $data)) {
	die;
}
xml_parser_free($parser);
if (!array_key_exists($method_name, $api_methods)) die('unknow request');

call_user_func($api_methods[$method_name], $params);

/**
 * 读取博客信息
 */
function blogger_getUsersBlogs() {
	global $options_cache;
	$xml = "
		<array>
			<data>
				<value>
					<struct>
						<member>
							<name>url</name>
							<value>
								<string>{$options_cache['blogurl']}</string>
							</value>
						</member>
						<member>
							<name>blogid</name>
							<value>
								<string>1</string>
							</value>
						</member>
						<member>
							<name>blogName</name>
							<value>
								<string>{$options_cache['blogname']}</string>
							</value>
						</member>
					</struct>
				</value>
			</data>
		</array>";
	response($xml);
}

/**
 * 删除日志
 */
function mw_deletePost($args) {
	escape($args);
	$id = intval($args[1]);
	$user = login($args[2], $args[3]);
	define('UID', $user['uid']);
	$emBlog = new emBlog();
	$emBlog->deleteLog($id);
	mkcache::getInstance()->updateCache();
	response('<boolean>1</boolean>');
}
/**
 * 保存新日志
 */
function mw_newPost($args) {
	global $options_cache;
	escape($args);

	$user = login($args[1], $args[2]);
	define('UID', $user['uid']);

	$id = intval($args[0]);
	$username = $args[1];
	$password = $args[2];
	$data = $args[3];
	$publish = $args[4];
	$update_data['title'] = $data['title'];
	$update_data['content'] = htmlspecialchars_decode($data['description']);
	$update_data['author'] = UID;
	$update_data['hide'] = $publish == 1 ? 'n' : 'y';
	$update_data['excerpt'] = '';
	// 只取第一个分类
	$sort_name = isset($data['categories']) && isset($data['categories'][0]) ? $data['categories'][0] : '';
	$emSort = new emSort();
	$sorts = $emSort->getSorts();

	$update_data['sortid'] = '-1';
	foreach ($sorts as $sort) {
		if ($sort_name == $sort['sortname']) {
			$update_data['sortid'] = $sort['sid'];
			break;
		}
	}
	// 发布时间
	if (isset($data['dateCreated']) && is_object($data['dateCreated'])) {
		$update_data['date'] = @gmmktime($data['dateCreated']->hour, $data['dateCreated']->minute , $data['dateCreated']->second , $data['dateCreated']->month , $data['dateCreated']->day , $data['dateCreated']->year) - $options_cache['timezone'] * 3600;
	}else {
		$update_data['date'] = time();
	}
	// 更新数据
	$emBlog = new emBlog();
	$new_id = $emBlog->addlog($update_data);
	// 更新标签
	if (isset($data['mt_keywords']) && !empty($data['mt_keywords'])) {
		$emTag = new emTag();
		$emTag->addTag($data['mt_keywords'], $new_id);
		unset($emTag);
	}
	// 更新缓存
	mkcache::getInstance()->updateCache();
	response("<i4>$new_id</i4>");
}
/**
 * 更新日志
 */
function mw_editPost($args) {
	global $options_cache;
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

	$update_data['title'] = $data['title'];
	$update_data['content'] = htmlspecialchars_decode($data['description']);
	$update_data['author'] = UID;
	$update_data['hide'] = $publish == 1 ? 'n' : 'y';
	// 根据分类名称取分类id,注意只取第一个分类
	$sort_name = isset($data['categories']) && isset($data['categories'][0]) ? $data['categories'][0] : '';
	$emSort = new emSort();
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
	if (isset($data['dateCreated']) && is_object($data['dateCreated'])) {
		$update_data['date'] = @gmmktime($data['dateCreated']->hour, $data['dateCreated']->minute , $data['dateCreated']->second , $data['dateCreated']->month , $data['dateCreated']->day , $data['dateCreated']->year) - $options_cache['timezone'] * 3600;
	}
	// 更新数据
	$emBlog = new emBlog();
	$emBlog->updateLog($update_data, $id);
	// 更新标签
	if (isset($data['mt_keywords']) && !empty($data['mt_keywords'])) {
		$emTag = new emTag();
		$emTag->updateTag($data['mt_keywords'], $id);
	}
	// 更新缓存
	mkcache::getInstance()->updateCache();
	response('<boolean>1</boolean>');
}

/**
 * 取得博客分类
 */
function mw_getCategories($args) {
	escape($args);
	$username = $args[1];
	$password = $args[2];

	login($username, $password);

	$emSort = new emSort();
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
 * 读取日志信息
 */
function mw_getPost($args) {
	global $options_cache;
	escape($args);

	$post_ID = intval($args[0]);
	$username = $args[1];
	$password = $args[2];

	$user = login($username, $password);

	$emBlog = new emBlog();
	define('UID', $user['uid']);
	$post = $emBlog->getOneLogForAdmin($post_ID);
	if (empty($post)) return error_message(404, '对不起,您访问日志不存在');
	$log_cache_tags = mkcache::getInstance()->readCache('logtags');
	$tags = '';
	if (!empty($log_cache_tags[$post['gid']])) {
		foreach ($log_cache_tags[$post['gid']] as $tag) {
			$tags[] = $tag['tagname'];
		}
		$tags = implode(',', $tags);
	}
	$emSort = new emSort();
	$sort_name = $emSort->getSortName($post['sortid']);

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
			<name>mt_keywords</name>
			<value>
				<string>$tags</string>
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
			<value>{$options_cache['blogurl']}index.php?post={$post['gid']}</value>
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
	escape($args);
	$db = MySql::getInstance();
	$username = $args[1];
	$password = $args[2];
	$num_posts = intval($args[3]);

	$num_posts == 0 && $num_posts = 1;

	$user = login($username, $password);

	$query = $db->query('SELECT gid,title,date,content,author,sortid FROM ' . DB_PREFIX . 'blog ORDER BY date DESC LIMIT 0,' . $num_posts);

	$xml = '';
	$recent_posts = array();
	$log_cache_tags = mkcache::getInstance()->readCache('logtags');
	while ($post = $db->fetch_array($query)) {
		$post['title'] = htmlspecialchars($post['title']);
		$post['content'] = htmlspecialchars($post['content']);
		$post['date'] = getIso($post['date']);

		$tags = '';
		if (!empty($log_cache_tags[$post['gid']])) {
			foreach ($log_cache_tags[$post['gid']] as $tag) {
				$tags[] = $tag['tagname'];
			}
			$tags = implode(',', $tags);
		}
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
				<member>
					<name>mt_keywords</name>
						<value>
							<string>$tags</string>
						</value>
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
	global $options_cache;
	escape($args[1]);
	escape($args[2]);
	$username = $args[1];
	$password = $args[2];
	$user = login($username, $password);
	$file = $args[3];
	if (!preg_match('/([^\/\:\*\?<>\|]+\.\w{2,6})|(\\{2}[^\/\:\*\?<>\|]+\.\w{2,6})/', $file['name'], $matches))
		error_message(500, '文件错误');
	$filename = $matches[0];

	$bits = $file['bits'];

	if (!empty($data["overwrite"]) && ($data["overwrite"] == true)) {
	}

	$att_type = array('rar', 'zip', 'gif', 'jpg', 'jpeg', 'png', 'bmp');

	if (empty($filename))
		error_message(500, '文件名错误');

	$extension = strtolower(substr(strrchr($filename, "."), 1));
	// 文件类型检测
	if (!in_array($extension, $att_type)) {
		error_message(500, '文件类型错误');
	}
	$uppath_root = substr(UPLOADFILE_PATH, 1);
	$uppath = $uppath_root . gmdate('Ym') . '/';
	$fname = md5($fileName) . gmdate('YmdHis') . '.' . $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir($uppath_root)) {
		umask(0);
		$ret = @mkdir($uppath_root, 0777);
		if ($ret === false) {
			error_message(500, '创建文件上传目录失败');
		}
	}
	if (!is_dir($uppath)) {
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
			error_message(500, '上传失败。文件上传目录(content/uploadfile)不可写');
		}
	}

	$fp = @fopen($attachpath, 'wb');
	if (!$fp)
		error_message(500, '文件无法写入');
	fwrite($fp, $bits);
	fclose($fp);

	doAction('xmlrpc_attach_upload', $attachpath);
	// resizeImage
	$imtype = array('jpg', 'png', 'jpeg');
	$thum = $uppath . 'thum-' . $fname;
	$thum_created = true;

	if (IS_THUMBNAIL && in_array($extension, $imtype) && function_exists('ImageCreate')) {
		$max_w = IMG_ATT_MAX_W;
		$max_h = IMG_ATT_MAX_H;
		$size = chImageSize($img, $max_w, $max_h);
		$newwidth = $size['w'];
		$newheight = $size['h'];
		$w = $size['rc_w'];
		$h = $size['rc_h'];
		if ($w <= $max_w && $h <= $max_h) {
			$thum_created = false;
		}

		if ($thum_created && ($imgType == 'image/pjpeg' || $imgType == 'image/jpeg')) {
			if (function_exists('imagecreatefromjpeg')) {
				$img = imagecreatefromjpeg($attachpath);
			}else {
				$thum_created = false;
			}
		}elseif ($thum_created && ($imgType == 'image/x-png' || $imgType == 'image/png')) {
			if (function_exists('imagecreatefrompng')) {
				$img = imagecreatefrompng($attachpath);
			}else {
				$thum_created = false;
			}
		}

		if ($thum_created && function_exists('imagecopyresampled')) {
			$newim = imagecreatetruecolor($newwidth, $newheight);
			imagecopyresampled($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
		}elseif ($thum_created) {
			$newim = imagecreate($newwidth, $newheight);
			imagecopyresized($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
		}

		if ($thum_created && ($imgType == 'image/pjpeg' || $imgType == 'image/jpeg')) {
			if (!imagejpeg($newim, $thumPatch)) {
				$thum_created = false;
			}
		}elseif ($thum_created && ($imgType == 'image/x-png' || $imgType == 'image/png')) {
			if (!imagepng($newim, $thumPatch)) {
				$thum_created = false;
			}
		}
		if ($thum_created)
			ImageDestroy($newim);
	}

	$img_url = $options_cache['blogurl'] . 'content/uploadfile/' . date('Ym') . '/' . $fname;
	$file_name = $thum_created ? 'thum-' . $fname : $fname;
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

function getIso($utctimestamp) {
	global $options_cache;
	$utctimestamp += $options_cache['timezone'] * 3600;
	$year = gmdate('Y', $utctimestamp);
	$month = gmdate('m', $utctimestamp);
	$day = gmdate('d', $utctimestamp);
	$hour = gmdate('H', $utctimestamp);
	$minute = gmdate('i', $utctimestamp);
	$second = gmdate('s', $utctimestamp);
	return $year . $month . $day . 'T' . $hour . ':' . $minute . ':' . $second;
}

function login($username, $password) {
	$username = addslashes($username);
	$password = addslashes($password);
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
	}else {
		foreach ((array) $array as $k => $v) {
			if (is_array($v)) {
				escape($array[$k]);
			}else if (is_object($v)) {
				// skip
			}else {
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
	$xml = '<?xml version="1.0" encoding="utf-8"?>' . "\n" . $xml;
	$length = strlen($xml);
	header('Connection: close');
	header('Content-Length: ' . $length);
	header('Content-Type: text/xml');
	header('Date: ' . gmdate('r'));
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
	switch ($tag) {
		case 'methodCall':
		case 'methodResponse':
		case 'fault':
			$message_type = $tag;
			break;
		/**
		 * Deal with stacks of arrays and structs
		 */
		case 'data': // data is to all intents and puposes more interesting than array
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
	switch ($tag) {
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
			$value = getiso(trim($current_tag_contents));
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
			$value = base64_decode(trim($current_tag_contents));
			$valueFlag = true;
			break;
		/**
		 * Deal with stacks of arrays and structs
		 */
		case 'data':
		case 'struct':
			$value = @array_pop($array_structs);
			@array_pop($array_structs_types);
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
			if ($array_structs_types[count($array_structs_types)-1] == 'struct') {
				// Add to struct
				$array_structs[count($array_structs)-1][$current_struct_name_array[count($current_struct_name_array) - 1]] = $value;
			}else {
				// Add to array
				$array_structs[count($array_structs)-1][] = $value;
			}
		}else {
			// Just add as a paramater
			$params[] = $value;
		}
	}
	$current_tag_contents = '';
}
