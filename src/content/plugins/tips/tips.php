<?php
/*
Plugin Name: Tips
Version: 1.1
Plugin URL:
Description: This is the first emlog plug-in, it will send a page of your management tips and warm.
ForEmlog:5.2.0
Author: emlog
Author URL: http://www.emlog.net
*/

!defined('EMLOG_ROOT') && exit('access deined!');

$array_tips = array(
'You can upload multiple attachments in the log',
'emlog supports flexible tag classification functions',
'You can use the Tab key to conveniently indent content when writing a log',
'You can use the widgets function to sort the blog sidebar components and customize the sidebar components',
'You can modify the release time of the log',
'You can write a beautiful summary for your log, so that only the summary is displayed on the home page and a link to read the full text appears',
'In order to prevent log loss, emlog will automatically save them for you when you write the log',
'You can insert multimedia files in flash format in the log',
'Different moods, log emoticons will convey to you',
'emlog supports Trackback, you can notify the log you want to comment on',
'emlog can sing, try to add music components to widgets',
'You can save your unfinished log in the draft box and write it when you have time next time',
'emlog will automatically produce thumbnails for image attachments that are too large to speed up page loading speed',
'emlog is the abbreviation of every memory log, which means: a bit of memory',
'Please pay attention to the official information section of the backend homepage, here are the latest emlog trends',
'You can embed picture attachments into the content to make your log pictures and texts',
'You can set an access password for the log when you write the log, and only allow the person who you grant the password to access',
'Many people are powerful, emlog supports multi-person joint writing of blog posts',
'emlog supports self-built pages, and you can upload photos, make yourself a self-introduction page with pictures and texts for yourself',
'Create a new page that allows you to post comments, you will find that it is actually a simple message board',
'The menu on the left side of the backstage can be folded, and the folded state can be remembered',
'Check if there is an installation file in your blog directory: install.php, please delete it if you have it',
'Did you back up your data today? ',
'Did you write a few words today?',
'The weather is pretty good today :)',
'Save energy and protect the environment',
'If you have love, please cherish it before you lose it',
'Life lies in exercise, don\'t always face the computer, go for a walk',
);

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
