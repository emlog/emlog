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

$array_tips['zh-CN'] = [
	'为防文章丢失，emlog会在你书写文章的时候为你自动保存',
	'你可以把你未写完的文章保存到草稿箱里',
	'大尺寸的图片上传时会自动生成缩略图，从而加快页面加载速度',
	'请关注后台首页的官方信息栏目，这里有最新的动态',
	'你可以把图片嵌入到内容中，让你的文章图文并茂',
	'你可以在写文章的时候为文章设置访问密码，只让你授予密码的人访问',
	'emlog支持多人联合撰写',
	'emlog支持自建页面，并且可以上传照片，为自己做一个图文并茂的自我介绍页吧',
	'新建一个允许发表评论的页面，你会发现其实它还是一个简单的留言板',
	'检查你的站点目录下是否存在安装文件：install.php，有的话请删除它',
	'使用chrome浏览器，更好的体验emlog',
	'从明天起，做一个幸福的人',
];

$array_tips['en'] = [
	'In order to prevent the article from being lost, emlog will automatically save it for you when you write the article',
	'You can save your unfinished articles in the draft box',
	'Thumbnails will be automatically generated when large-size pictures are uploaded, thereby speeding up the page loading speed',
	'Please pay attention to the official information section of the backstage homepage, here are the latest developments',
	'You can embed pictures into the content, so that your articles are both pictures and texts',
	'You can set an access password for the article when you are writing the article, and only allow the person who you grant the password to access',
	'Emlog supports multi-person co-writing',
	'Emlog supports self-built pages, and you can upload photos, make yourself a self-introduction page with pictures and texts',
	'Create a new page that allows you to post comments, you will find that it is actually a simple message board',
	'Check if there is an installation file in your site directory: install.php, if so, please delete it',
	'Use chrome browser, better experience emlog',
	'Be a happy man from tomorrow on',
];

$array_tips['ru'] = [
	'Чтобы статья не была потеряна, Emlog автоматически сохранит ее для вас, когда вы напишете статью',
	'Вы можете сохранить свои незаконченные статьи в черновике',
	'Миниатюры будут автоматически создаваться при загрузке изображений большого размера, что ускоряет скорость загрузки страницы',
	'Обратите внимание на раздел официальной информации на главной странице алмин-панели, здесь представлены последние новшества движка',
	'Вы можете вставлять изображения в контент, чтобы ваши статьи были одновременно и с текстом, и с изображениями',
	'Вы можете установить пароль доступа к статье, когда пишете статью, и разрешить доступ только тем людям, которым вы предоставили этот пароль',
	'Emlog поддерживает совместное написание статей несколькими людьми',
	'Emlog поддерживает страницы, созданные самостоятельно, и может загружать фотографии, создавать выразительные страницы с изображениями и текстами',
	'Создайте новую страницу, на которой можно публиковать комментарии, и вы обнаружите, что на самом деле это простая доска объявлений',
	'Проверьте, есть ли в каталоге вашего сайта установочный файл: install.php, и если да, то удалите его в целях безопасности',
	'Используйте браузер Chrome, чтобы лучше ознакомиться с возможностями Emlog',
	'Будьте счастливы с завтрашнего дня',
];

function tips() {
	global $array_tips;
	$i = mt_rand(0, count($array_tips) - 1);
	if (isset($array_tips[LANG])) {
		$tip = $array_tips[LANG][$i];
	} else {
		$tip = $array_tips['en'][$i];
	}
	echo "<div id=\"tip\"> $tip</div>";
}

addAction('adm_main_top', 'tips');

function tips_css() {
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
