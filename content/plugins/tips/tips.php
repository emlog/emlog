<?php
/*
Plugin Name: Tips
Version: 1.2
Plugin URL:
Description: It is the world's first emlog plugin, it will send one cozy little tips in your administration page.
Author: emlog
Author URL: http://www.emlog.net
*/

!defined('EMLOG_ROOT') && exit('access deined!');

/*vot*/ load_language('plugin_tips');

$array_tips = [
/*vot*/	lang('tag_tip'),
/*vot*/	lang('summary_tip'),
/*vot*/	lang('autosave_tip'),
/*vot*/	lang('draft_tip'),
/*vot*/	lang('thumbnail_tip'),
/*vot*/	lang('official_feed_tip'),
/*vot*/	lang('image_tip'),
/*vot*/	lang('post_password_tip'),
/*vot*/	lang('co-author_tip'),
/*vot*/	lang('intro_page_tip'),
/*vot*/	lang('message_board_tip'),
/*vot*/	lang('install_delete_tip'),
/*vot*/	lang('chrome_tip'),
/*vot*/	lang('be_happy_tip'),

/*vot*/	lang('attach_upload_tip'),
/*vot*/	lang('indent_tip'),
/*vot*/	lang('emoticon_tip'),
/*vot*/	lang('browser_upgrade_tip'),
/*vot*/	lang('create_backup_tip'),
/*vot*/	lang('tomorrow_happy_tip'),
];

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
