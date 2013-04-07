<?php
/**
 * 应用中心
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
    $site_url_encode = rawurlencode(base64_encode(BLOG_URL));
	include View::getView('header');
	require_once(View::getView('store'));
	include View::getView('footer');
	View::output();
}
