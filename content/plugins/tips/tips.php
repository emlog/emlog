<?php
/*
Plugin Name: 小贴士
Version: 3.0
Plugin URL:
Description: 在后台首页展示一句使用小提示，也可作为插件开发的demo。
Author: emlog
Author URL: https://www.emlog.net/profiles/cf75dc06
*/

defined('EMLOG_ROOT') || exit('access denied!');

$array_tips = _langPlu('tips_messages', 'tips');

function tips_init()
{
    global $array_tips;
    $i = em_rand(0, count($array_tips) - 1);
    $tip = $array_tips[$i];
    echo "<div id=\"tip\"> $tip</div>";
}

addAction('adm_main_top', 'tips_init');

function tips_css()
{
    echo "<style>
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
