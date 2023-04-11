<?php
/**
 * Widgets
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action === '') {
    $widgets = Option::get('widgets1');
    $widgetTitle = Option::get('widget_title');
    $custom_widget = Option::get('custom_widget');
    $widgetTitle = array_map('htmlspecialchars', $widgetTitle);
    $tpl_sidenum = Option::get('tpl_sidenum');

    foreach ($custom_widget as $key => $val) {
        $custom_widget[$key] = array_map('htmlspecialchars', $val);
    }

    $customWgTitle = [];
    foreach ($widgetTitle as $key => $val) {
        if (preg_match("/^.*\s\((.*)\)/", $val, $matchs)) {
            $customWgTitle[$key] = $matchs[1];
        } else {
            $customWgTitle[$key] = $val;
        }
    }

    include View::getAdmView('header');
    require_once View::getAdmView('widgets');
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'setwg') {
    $widgetTitle = Option::get('widget_title');                                             //当前所有组件标题
    $widget = isset($_GET['wg']) ? $_GET['wg'] : '';                                        //要修改的组件
    $wgTitle = isset($_POST['title']) ? $_POST['title'] : '';                               //新组件名

    preg_match("/^(.*)\s\(.*/", $widgetTitle[$widget], $matchs);
    $realWgTitle = isset($matchs[1]) ? $matchs[1] : $widgetTitle[$widget];

    $widgetTitle[$widget] = $realWgTitle != $wgTitle ? $realWgTitle . ' (' . $wgTitle . ')' : $realWgTitle;
    $widgetTitle = addslashes(serialize($widgetTitle));

    Option::updateOption('widget_title', $widgetTitle);

    switch ($widget) {
        case 'newcomm':
            $index_comnum = isset($_POST['index_comnum']) ? (int)$_POST['index_comnum'] : 10;
            $comment_subnum = isset($_POST['comment_subnum']) ? (int)$_POST['comment_subnum'] : 20;
            Option::updateOption('index_comnum', $index_comnum);
            Option::updateOption('comment_subnum', $comment_subnum);
            $CACHE->updateCache('comment');
            break;
        case 'newlog':
            $index_newlog = isset($_POST['index_newlog']) ? (int)$_POST['index_newlog'] : 5;
            Option::updateOption('index_newlognum', $index_newlog);
            $CACHE->updateCache('newlog');
            break;
        case 'hotlog':
            $index_hotlognum = isset($_POST['index_hotlognum']) ? (int)$_POST['index_hotlognum'] : 5;
            Option::updateOption('index_hotlognum', $index_hotlognum);
            break;
        case 'custom_text':
            $custom_widget = Option::get('custom_widget');
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $content = isset($_POST['content']) ? $_POST['content'] : '';
            $custom_wg_id = isset($_POST['custom_wg_id']) ? $_POST['custom_wg_id'] : '';//要修改的组件id
            $new_title = isset($_POST['new_title']) ? $_POST['new_title'] : '';
            $new_content = isset($_POST['new_content']) ? $_POST['new_content'] : '';
            $rmwg = isset($_GET['rmwg']) ? addslashes($_GET['rmwg']) : '';//要删除的组件id
            //添加新自定义组件
            if ($new_content) {
                //确定组件索引
                $i = 0;
                $maxKey = 0;
                if (is_array($custom_widget)) {
                    foreach ($custom_widget as $key => $val) {
                        preg_match("/^custom_wg_(\d+)/", $key, $matches);
                        $k = $matches[1];
                        if ($k > $i) {
                            $maxKey = $k;
                        }
                        $i = $k;
                    }
                }
                $custom_wg_index = $maxKey + 1;
                $custom_wg_index = 'custom_wg_' . $custom_wg_index;
                $custom_widget[$custom_wg_index] = array('title' => $new_title, 'content' => $new_content);
                $custom_widget_str = addslashes(serialize($custom_widget));
                Option::updateOption('custom_widget', $custom_widget_str);
            } elseif ($content) {
                $custom_widget[$custom_wg_id] = array('title' => $title, 'content' => $content);
                $custom_widget_str = addslashes(serialize($custom_widget));
                Option::updateOption('custom_widget', $custom_widget_str);
            } elseif ($rmwg) {
                $widgets = Option::get('widgets1');
                if (is_array($widgets) && !empty($widgets)) {
                    foreach ($widgets as $key => $val) {
                        if ($val == $rmwg) {
                            unset($widgets[$key]);
                        }
                    }
                    $widgets_str = addslashes(serialize($widgets));
                    Option::updateOption("widgets1", $widgets_str);
                }
                unset($custom_widget[$rmwg]);
                $custom_widget_str = addslashes(serialize($custom_widget));
                Option::updateOption('custom_widget', $custom_widget_str);
            }
            break;
    }
    $CACHE->updateCache('options');
    emDirect("./widgets.php?activated=1");
}

if ($action === 'compages') {
    $widgets = isset($_POST['widgets']) ? addslashes(serialize($_POST['widgets'])) : '';
    Option::updateOption("widgets1", $widgets);
    $CACHE->updateCache('options');
    emDirect("./widgets.php?activated=1");
}

if ($action === 'reset') {
    LoginAuth::checkToken();
    $widget_title = serialize(Option::getWidgetTitle());
    $default_widget = serialize(Option::getDefWidget());

    Option::updateOption("widget_title", $widget_title);
    Option::updateOption("custom_widget", 'a:0:{}');
    Option::updateOption("widgets1", $default_widget);

    $CACHE->updateCache('options');
    emDirect("./widgets.php?activated=1");
}
