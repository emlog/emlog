<?php
/**
 * xmlrpc Blog service interface
 *
 * @copyright (c) Emlog All Rights Reserved
 */

ob_start();

define('EMLOG_ROOT', str_replace('\\', '/', dirname(__FILE__)));

require_once EMLOG_ROOT . '/config.php';
require_once EMLOG_ROOT . '/include/lib/function.base.php';

$api_methods = array(
	// metaWeblog interface
	'metaWeblog.newPost' => 'mw_newPost',
	'metaWeblog.editPost' => 'mw_editPost',
	'metaWeblog.getPost' => 'mw_getPost',
	'metaWeblog.getRecentPosts' => 'mw_getRecentPosts',
	'metaWeblog.getCategories' => 'mw_getCategories',
	'metaWeblog.newMediaObject' => 'mw_newMediaObject',
	// blogger interface
	'blogger.deletePost' => 'mw_deletePost',
	'blogger.getUsersBlogs' => 'blogger_getUsersBlogs'
	);

$DB = Database::getInstance();
$options_cache = Cache::getInstance()->readCache('options');
// Some browser-based clients will send cookies, we don't need them
$_COOKIE = array();
// PHP 5.2.2 version has the next bug: The system will not automatically generate the constant $HTTP_RAW_POST_DATA
if (!isset($HTTP_RAW_POST_DATA)) {
	$HTTP_RAW_POST_DATA = file_get_contents('php://input');
}
// Fix mozBlog or other cases where the incompatible xml tag is not in the first line
if (isset($HTTP_RAW_POST_DATA))
	$HTTP_RAW_POST_DATA = trim($HTTP_RAW_POST_DATA);
// Send api support information to the client
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
	error_message(500, $lang['xmlrpc_disabled']);
}
if (!$HTTP_RAW_POST_DATA) {
	error_message(500, $lang['xmlrpc_error_post']);
}
$data = $HTTP_RAW_POST_DATA;

$current_tag_contents = $current_tag = $message_type = $method_name = null;
$array_structs_types = $array_structs = $current_struct_name_array = $params = array();

$data = preg_replace('/<\?xml.*?\?' . '>/', '', $data);
if (trim($data) == '') {
	error_message(500, $lang['xmlrpc_empty']);
}
// Compatible with php libxml module 2.7.0-2.7.3 version parsing xml missing html tag bracket bug
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
 * Read blog information
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
 * Delete blog post
 */
function mw_deletePost($args) {
	escape($args);
	$id = intval($args[1]);
	$user = login($args[2], $args[3]);
	define('UID', $user['uid']);
	$Log_Model = new Log_Model();
	$Log_Model->deleteLog($id);
	Cache::getInstance()->updateCache();
	response('<boolean>1</boolean>');
}
/**
 * Save new blog post
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
	// Get only the first category
	$sort_name = isset($data['categories']) && isset($data['categories'][0]) ? $data['categories'][0] : '';
	$Sort_Model = new Sort_Model();
	$sorts = $Sort_Model->getSorts();

	$update_data['sortid'] = '-1';
	foreach ($sorts as $sort) {
		if ($sort_name == $sort['sortname']) {
			$update_data['sortid'] = $sort['sid'];
			break;
		}
	}
	// Publish time
	if (isset($data['dateCreated']) && is_object($data['dateCreated'])) {
		$update_data['date'] = @gmmktime($data['dateCreated']->hour, $data['dateCreated']->minute , $data['dateCreated']->second , $data['dateCreated']->month , $data['dateCreated']->day , $data['dateCreated']->year) - $options_cache['timezone'] * 3600;
	}else {
		$update_data['date'] = time();
	}
	// Update data
	$Log_Model = new Log_Model();
	$new_id = $Log_Model->addlog($update_data);
	// Update tags
	if (isset($data['mt_keywords']) && !empty($data['mt_keywords'])) {
		$Tag_Model = new Tag_Model();
		$Tag_Model->addTag($data['mt_keywords'], $new_id);
		unset($Tag_Model);
	}
	// Rrefresh cache
	Cache::getInstance()->updateCache();
	response("<i4>$new_id</i4>");
}
/**
 * Edit post
 */
function mw_editPost($args) {
	global $options_cache;
	escape($args);
	$username = $args[1];
	$password = $args[2];
	$user = login($username, $password);
	define('UID', $user['uid']);
	// Accept parameters
	$id = intval($args[0]);
	$username = $args[1];
	$password = $args[2];
	$data = $args[3];
	$publish = $args[4];

	$update_data['title'] = $data['title'];
	$update_data['content'] = htmlspecialchars_decode($data['description']);
	$update_data['author'] = UID;
	$update_data['hide'] = $publish == 1 ? 'n' : 'y';
	// Take the category id according to the category name, note that only the first category is taken
	$sort_name = isset($data['categories']) && isset($data['categories'][0]) ? $data['categories'][0] : '';
	$Sort_Model = new Sort_Model();
	$sorts = $Sort_Model->getSorts();
	unset($Sort_Model);
	$update_data['sortid'] = '-1';
	foreach ($sorts as $sort) {
		if ($sort_name == $sort['sortname']) {
			$update_data['sortid'] = $sort['sid'];
			break;
		}
	}
	// Create time
	if (isset($data['dateCreated']) && is_object($data['dateCreated'])) {
		$update_data['date'] = @gmmktime($data['dateCreated']->hour, $data['dateCreated']->minute , $data['dateCreated']->second , $data['dateCreated']->month , $data['dateCreated']->day , $data['dateCreated']->year) - $options_cache['timezone'] * 3600;
	}
	// Update data
	$Log_Model = new Log_Model();
	$Log_Model->updateLog($update_data, $id);
	// Update tags
	if (isset($data['mt_keywords']) && !empty($data['mt_keywords'])) {
		$Tag_Model = new Tag_Model();
		$Tag_Model->updateTag($data['mt_keywords'], $id);
	}
	// Refresh cache
	Cache::getInstance()->updateCache();
	response('<boolean>1</boolean>');
}

/**
 * Get blog categories
 */
function mw_getCategories($args) {
	escape($args);
	$username = $args[1];
	$password = $args[2];

	login($username, $password);

	$Sort_Model = new Sort_Model();
	$sorts = $Sort_Model->getSorts();
	unset($Sort_Model);
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
 * Read post information
 */
function mw_getPost($args) {
	global $options_cache;
	escape($args);

	$post_ID = intval($args[0]);
	$username = $args[1];
	$password = $args[2];

	$user = login($username, $password);

	$Log_Model = new Log_Model();
	define('UID', $user['uid']);
	$post = $Log_Model->getOneLogForAdmin($post_ID);
	if (empty($post)) return error_message(404, $lang['post_not_exists']);
	$log_cache_tags = Cache::getInstance()->readCache('logtags');
	$tags = '';
	if (!empty($log_cache_tags[$post['gid']])) {
		foreach ($log_cache_tags[$post['gid']] as $tag) {
			$tags[] = $tag['tagname'];
		}
		$tags = implode(',', $tags);
	}
	$Sort_Model = new Sort_Model();
	$sort_name = $Sort_Model->getSortName($post['sortid']);

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
	$db = Database::getInstance();
	$username = $args[1];
	$password = $args[2];
	$num_posts = intval($args[3]);

	$num_posts == 0 && $num_posts = 1;

	$user = login($username, $password);

	$query = $db->query('SELECT gid,title,date,content,author,sortid FROM ' . DB_PREFIX . 'blog ORDER BY date DESC LIMIT 0,' . $num_posts);

	$xml = '';
	$recent_posts = array();
	$log_cache_tags = Cache::getInstance()->readCache('logtags');
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
		error_massage(404, $lang['post_not_found']);
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
		error_message(500, $lang['file_error']);
	$filename = $matches[0];

	$bits = $file['bits'];

	if (!empty($data["overwrite"]) && ($data["overwrite"] == true)) {
	}

	$att_type = Option::getAttType();

	if (empty($filename))
		error_message(500, $lang['file_name_error']);

	$extension = strtolower(substr(strrchr($filename, "."), 1));
	// File type detection
	if (!in_array($extension, $att_type)) {
		error_message(500, $lang['file_type_error']);
	}
	$uppath_root = substr(Option::UPLOADFILE_PATH, 1);
	$uppath = $uppath_root . gmdate('Ym') . '/';
	$fname = md5($filename) . gmdate('YmdHis') . '.' . $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir($uppath_root)) {
		umask(0);
		$ret = @mkdir($uppath_root, 0777);
		if ($ret === false) {
			error_message(500, $lang['attachment_create_failed']);
		}
	}
	if (!is_dir($uppath)) {
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
			error_message(500, $lang['uploads_not_written']);
		}
	}

	$fp = @fopen($attachpath, 'wb');
	if (!$fp)
		error_message(500, $lang['file_write_error']);
	fwrite($fp, $bits);
	fclose($fp);

	doAction('xmlrpc_attach_upload', $attachpath);
	// resizeImage
	$imtype = array('jpg', 'png', 'jpeg');
	$thum = $uppath . 'thum-' . $fname;
	$thum_created = true;

	if (Option::get('isthumbnail') && in_array($extension, $imtype) && function_exists('ImageCreate')) {
		$max_w = Option::get('att_imgmaxw');
		$max_h = Option::get('att_imgmaxh');
		$size = chImageSize($attachpath, $max_w, $max_h);
		$newwidth = $size['w'];
		$newheight = $size['h'];
		$w = $size['rc_w'];
		$h = $size['rc_h'];
		if ($w <= $max_w && $h <= $max_h) {
			$thum_created = false;
		}

		if ($thum_created && ($extension == 'jpeg' || $extension == 'jpg')) {
			if (function_exists('imagecreatefromjpeg')) {
				$img = imagecreatefromjpeg($attachpath);
			}else {
				$thum_created = false;
			}
		}elseif ($thum_created && $extension == 'png') {
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

		if ($thum_created && ($extension == 'jpeg' || $extension == 'jpg')) {
			if (!imagejpeg($newim, $attachpath)) {
				$thum_created = false;
			}
		}elseif ($thum_created && ($extension == 'png')) {
			if (!imagepng($newim, $attachpath)) {
				$thum_created = false;
			}
		}
		if ($thum_created)
			ImageDestroy($newim);
	}

	$img_url = $options_cache['blogurl'] . 'content/uploadfile/' . date('Ym') . '/' . $fname;

	$xml = "
        <struct>
            <member>
                <name>file</name>
                <value>
                    <string>$fname</string>
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
                    <string></string>
                </value>
            </member>
        </struct>
    ";
	response($xml);
}

function getIso($utctimestamp) {
	$utctimestamp += Option::get('timezone') * 3600;
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
	// Check user permissions
	if (true !== LoginAuth::checkUser($username, $password , '', 'n')) {
		error_message(403, $lang['user_name_pass_wrong']);
		return false;
	}
	// Return user information
	return LoginAuth::getUserDataByLogin($username);
}

function escape(&$array) {
	if (!is_array($array)) {
		return(Database::getInstance()->escape_string($array));
	}else {
		foreach ((array) $array as $k => $v) {
			if (is_array($v)) {
				escape($array[$k]);
			}else if (is_object($v)) {
				// skip
			}else {
				$array[$k] = Database::getInstance()->escape_string($v);
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
	$length = mb_strlen($xml);
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
