<?php
/*
Plugin Name: picasa 网络相册
Version: 1.0
Plugin URL:
Description: 一个基于google picasa 的网络相册。
Author: dawei
Author Email: emloog@gmail.com
Author URL: http://www.emlog.net/blog/
*/

function adm_album_menu()
{
	echo '<div class="sidebarsubmenu" id="menu_picasa_album"><a href="./plugin.php?plugin=picasa_album">picasa相册</a></div>';
}

addAction('adm_sidebar_ext', 'adm_album_menu');

function index_album_menu($label_a, $label_b)
{
	echo $label_a.'<a href="./?plugin=picasa_album">相册</a>'.$label_b;
}
addAction('navbar', 'index_album_menu');





?>