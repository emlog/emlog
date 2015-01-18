<?php
/**
 * SEO Settings
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
    $options_cache = $CACHE->readCache('options');
    extract($options_cache);

    $ex0 = $ex1 = $ex2 = $ex3 = '';
    $t = 'ex'.$isurlrewrite;
    $$t = 'checked="checked"';

    $opt0 = $opt1 = $opt2 = '';
    $t = 'opt'.$log_title_style;
    $$t = 'selected="selected"';

    $isalias = $isalias == 'y' ? 'checked="checked"' : '';
    $isalias_html = $isalias_html == 'y' ? 'checked="checked"' : '';

    include View::getView('header');
    require_once(View::getView('seo'));
    include View::getView('footer');
    View::output();
}

if ($action == 'update') {
    LoginAuth::checkToken();
    $permalink = isset($_POST['permalink']) ? addslashes($_POST['permalink']) : '0';
    $isalias = isset($_POST['isalias']) ? addslashes($_POST['isalias']) : 'n';
    $isalias_html = isset($_POST['isalias_html']) ? addslashes($_POST['isalias_html']) : 'n';
    
    $getData = array(
        'site_title' => isset($_POST['site_title']) ? addslashes($_POST['site_title'])  : '',
        'site_description' => isset($_POST['site_description']) ? addslashes($_POST['site_description']) : '',
        'site_key' => isset($_POST['site_key']) ? addslashes($_POST['site_key']) : '',
        'isurlrewrite' => isset($_POST['permalink']) ? addslashes($_POST['permalink']) : '0',
        'isalias' => isset($_POST['isalias']) ? addslashes($_POST['isalias']) : 'n',
        'isalias_html' => isset($_POST['isalias_html']) ? addslashes($_POST['isalias_html']) : 'n',
        'log_title_style' => isset($_POST['log_title_style']) ? addslashes($_POST['log_title_style']) : '0',
    );

    if ($permalink != '0' || $isalias == 'y') {
        $fp = @fopen(EMLOG_ROOT.'/.htaccess', 'w');
        $t = parse_url(BLOG_URL);
        $rw_rule = '<IfModule mod_rewrite.c>
                       RewriteEngine on
                       RewriteCond %{REQUEST_FILENAME} !-f
                       RewriteCond %{REQUEST_FILENAME} !-d
                       RewriteBase ' . $t['path'] . '
                       RewriteRule . ' . $t['path'] . 'index.php [L]
                    </IfModule>';
        if (!@fwrite($fp, $rw_rule)) {
            header('Location: ./seo.php?error=1');
            exit;
        }
        fclose($fp);
    }

    foreach ($getData as $key => $val) {
        Option::updateOption($key, $val);
    }
    $CACHE->updateCache(array('options', 'navi'));
    header('Location: ./seo.php?activated=1');
}
