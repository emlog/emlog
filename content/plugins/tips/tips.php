<?php
/*
Plugin Name: Tips
Version: 2.0
Plugin URL:
Description: It is the world's first emlog plugin, it will send one cozy little tips in your administration page.
Author: emlog official
Author URL: https://www.emlog.net
*/

!defined('EMLOG_ROOT') && exit('access deined!');

/*vot: Moved to /lang/XX/lang_plugin_tips.php
$array_tips = [
//...
];
vot*/

// Load Tips from /lang/XX/lang_plugin_tips.php
/*vot*/	require_once EMLOG_ROOT . '/lang/' . EMLOG_LANGUAGE . '/lang_plugin_tips.php';

function tips() {
	global $array_tips;
	$i = mt_rand(0, count($array_tips) - 1);
	$tip = $array_tips[$i];
	echo "<div id=\"tip\"> $tip</div>";
}

addAction('adm_main_top', 'tips');

function tips_css() {
	echo "<style type='text/css'>
    #tip{
        background:url(../content/plugins/tips/icon_tips.gif) no-repeat left 3px;
        padding:3px 18px;
        margin:5px 0px;
        font-size:12px;
        color:#999999;
    }
    </style>\n";
}

addAction('adm_head', 'tips_css');
