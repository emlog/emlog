<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');

function plugin_setting_view() {
	$action = isset($_GET['do']) ? $_GET['do'] : 'home';
	$action_funtion = 'em_static_setting_'.$action;
	if (function_exists($action_funtion)) {
		call_user_func($action_funtion);
	}
}
	
function em_static_setting_home() {
	$db = Mysql::getInstance();
	$total = 0;
	$where = '';
	$url = './plugin.php?plugin=em_static&page=';
	if (isset($_GET['keyword'])) {
		$where = ' AND title like \'%'.mysql_real_escape_string($_GET['keyword']).'%\' ';
		$url = './plugin.php?plugin=em_static&keyword='.urlencode($_GET['keyword']).'&page=';
	}	
	$sql = 'SELECT COUNT(*) AS total  FROM '.DB_PREFIX.'blog WHERE type = \'blog\' AND hide = \'n\' '.$where;
	$data = $db->once_fetch_array($sql);
	$total = $data['total'];
	$perpage = 10;
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$limit_start = ($page - 1) * $perpage;

	$sql = 'SELECT * FROM '.DB_PREFIX.'blog WHERE type = \'blog\' AND hide = \'n\' '.$where.' ORDER BY date DESC LIMIT '.$limit_start.','.$perpage;
	$query = $db->query($sql);
	$page_html = pagination($total, $perpage, $page, $url);
	$logs = array();
	while ($row = $db->fetch_array($query)) {
		$logs[] = $row;
	}
	include em_static_template('home');
}

function em_static_setting_config() {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$GLOBALS['em_static_config_data']['enable_auto_create'] = isset($_POST['enable_auto_create']) ? intval($_POST['enable_auto_create']) : 0;
		$GLOBALS['em_static_config_data']['auto_create_performance_value'] = isset($_POST['auto_create_performance_value']) ? intval($_POST['auto_create_performance_value']) : 3;
		$data = '<?php defined(\'EMLOG_ROOT\') or die(\'本页面禁止直接访问!\');'.chr(10);
		$data .= 'return array('.chr(10);
		$data .= '	"enable_auto_create" => '.$GLOBALS['em_static_config_data']['enable_auto_create'].', '.chr(10);
		$data .= '	"auto_create_performance_value" => '.$GLOBALS['em_static_config_data']['auto_create_performance_value'].','.chr(10);
		$data .= ');';
		file_put_contents(EM_STATIC_CONFIG_DATA_FILE, $data);
	}
	include em_static_template('config');
}

function em_static_setting_create_all() {
	include em_static_template('makehtml');
}

function em_static_setting_tag_alias() {
	$db = MySql::getInstance();
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$tid = isset($_POST['tid']) ? $_POST['tid'] : NULL;
		$alias = isset($_POST['alias']) ? $_POST['alias'] : NULL;
		if ( ! $tid || ! $alias || ! is_array($tid) || ! is_array($alias) || count($tid) !=  count($alias)) {
			return;
		}
		$file_content = '<?php defined(\'EMLOG_ROOT\') or die(\'本页面禁止直接访问!\');'.chr(10);
		$file_content .= 'return array('.chr(10);
		$query = $db->query('SELECT * FROM '.DB_PREFIX.'tag');
		$tag_array = array();
		while ($row = $db->fetch_array($query)) {
			$tag_array[$row['tid']] = $row['tagname'];
		}
		
		foreach ($tid as $index => $id) {
			$file_content .= '	'.intval($id).' => "'.preg_replace('/[^\w-_]+/', '', $alias[$index]).'", '.chr(10);
			$file_content .= '	"'.$tag_array[intval($id)].'" => "'.preg_replace('/[^\w-_]+/', '', $alias[$index]).'", '.chr(10);
		}
		$file_content .= ');';
		file_put_contents(EM_STATIC_TAG_CACHE_FILE, $file_content);
	}
	$tag_alias_cache = array();
	if (is_file(EM_STATIC_TAG_CACHE_FILE))
		$tag_alias_cache = include EM_STATIC_TAG_CACHE_FILE;
	$sql = 'SELECT * FROM '.DB_PREFIX.'tag';
	$tag_array = array();
	$query = $db->query($sql);
	while ($row = $db->fetch_array($query)) {
		$tag_array[] = $row;
	}
	include em_static_template('tag');
}

function em_static_setting_url() {
	$config = include EM_STATIC_CONFIG_FILE;
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$new_config = array();
		foreach ($config as $key => $v) {
			$value = isset($_POST[$key]) ? $_POST[$key] : '';
			if (preg_match('/path$/', $key)) {
				if ( ! empty($value) 
						&& ! preg_match('/^([\w-_\.\d\/]|\{%日志id%\}|\{%日志别名%\}|\{%页码%\}|\{%分类id%\}|\{%分类别名%\}|\{%标签别名%\}|\{%日期%\}|\{%用户id%\})+$/', $value)) {
					$value = $v;
				}				
				if ( ! empty($value) && ! preg_match('#/$#', $value)) {
					$value .= '/';
				}
			} else {
				if ( ! preg_match('/^([\w-_\.\d]|\{%日志id%\}|\{%日志别名%\}|\{%页码%\}|\{%分类id%\}|\{%分类别名%\}|\{%标签别名%\}|\{%日期%\}|\{%用户id%\})+\.html$/', $value)) {
					$value = $v;
				}
			}
			$new_config[$key] = $value;
		}
		$config_content = "<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');\nreturn array(\n";
		foreach ($new_config as $key => $value) {
			$config_content .= "\t '{$key}' => '{$value}', \n";
		}
		$config_content .= ");";
		file_put_contents(EM_STATIC_CONFIG_FILE, $config_content);
		emMsg('url格式设置保存成功！', '?plugin=em_static&do=url', true);
	} else {
		include em_static_template('url');
	}
}
