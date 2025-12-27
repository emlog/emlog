<?php
/*
 * Description: 模板设置插件AJAX处理。
*/

require_once '../../../../init.php';

if (!User::isAdmin()) {
    echo _langPlu('no_permission', 'tpl_options');
    exit;
}

//处理AJAX action
$action = Input::postStrVar('action', '');
if (!isset($action)) {
    echo _langPlu('op_failed', 'tpl_options');
    exit;
}

//处理AJAX传入值
$_s_type = '';
$s_key = Input::postStrVar('kywd', '');
$s_key = htmlspecialchars($s_key) ?: '';
$name = Input::postStrVar('name', '');
$type = Input::postStrVar('type', '');

//处理模板设置插件文件异常
$type_arr = [
    'post' => _langPlu('post', 'tpl_options'),
    'cate' => _langPlu('category', 'tpl_options'),
    'page' => _langPlu('page', 'tpl_options'),
];

$exit_tip = '<li class="no-results">' . _langPlu('plugin_error', 'tpl_options') . '</li>';
$is_type_exists = array_key_exists(trim($type), $type_arr);

if (!$is_type_exists) {
    echo $exit_tip;
    exit;
}
$_s_type = $type_arr[$type];

//处理AJAX请求
if ($action === 'tpl_select_search') {
    if (empty(trim($s_key))) {
        echo '<li class="no-results">请输入' . $_s_type . '标题关键字</li>';
        exit;
    }
    switch ($type) {
        case 'post':
        case 'page': {
                if (strstr($s_key, "'")) {
                    $sqlSegment = 'and title like "%{$s_key}%" order by date desc';
                } else {
                    $sqlSegment = "and title like '%{$s_key}%' order by date desc";
                }
                $html = '';
                $_this_sql_type = $type == 'post' ? 'blog' : 'page';
                $now = time();
                $DB = Database::getInstance();
                $sql = "SELECT gid,title,date FROM " . DB_PREFIX . "blog WHERE type='$_this_sql_type' and hide='n' and checked='y' and date<= $now $sqlSegment";
                $res = $DB->query($sql);
                if (mysqli_num_rows($res)) {
                    while ($row = $DB->fetch_array($res)) {
                        $_title = htmlspecialchars(trim($row['title']));
                        $html .= '<li class="active-result" data-opt="' . $type . '" data-id="' . $row['gid'] . '" data-s-name="' . $name . '">' . $_title . '</li>';
                    }
                    echo $html;
                    exit;
                } else {
                    echo '<li class="no-results">' . sprintf(_langPlu('no_related', 'tpl_options'), $_s_type) . '</li>';
                    exit;
                }
            }
        case 'cate': {
                $sorts = Cache::getInstance()->readCache('sort');
                $html = '';
                foreach ($sorts as $sort) {
                    if (strpos($sort['sortname'], $s_key) !== false) {
                        $html .= '<li class="active-result" data-opt="' . $type . '" data-id="' . $sort['sid'] . '" data-s-name="' . $name . '">' . $sort['sortname'] . '</li>';
                    }
                }
                echo $html ?: '<li class="no-results">未查询到相关' . $_s_type . '</li>';
                exit;
            }
    }
}
